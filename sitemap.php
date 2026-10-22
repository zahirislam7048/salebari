<?php
/* XML sitemaps, built from the database so new categories, products, stalls, brands, malls and
   blog posts appear automatically.
     /sitemap_index.xml   (also /sitemap.xml)   -> lists the sitemaps below
     /sitemap-pages.xml, -categories.xml, -products.xml, -stalls.xml, -brands.xml, -malls.xml, -blog.xml */
require __DIR__ . '/app/bootstrap.php';

$host   = (string) ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
    || !preg_match('/^(localhost|127\.|\[::1\])/', $host);   // anything but a local test server is https
$origin = ($secure ? 'https' : 'http') . '://' . $host;

function sm_date(?string $d): ?string
{
    $t = $d ? strtotime($d) : false;
    return $t ? date('Y-m-d', $t) : null;
}

function sm_urlset(array $items): void
{
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($items as [$loc, $lastmod, $freq, $prio]) {
        echo "  <url><loc>" . htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>";
        if ($lastmod) echo "<lastmod>$lastmod</lastmod>";
        if ($freq)    echo "<changefreq>$freq</changefreq>";
        if ($prio)    echo "<priority>$prio</priority>";
        echo "</url>\n";
    }
    echo "</urlset>\n";
}

$type  = (string) input('type', 'index');
$types = ['pages', 'categories', 'products', 'stalls', 'brands', 'malls', 'blog'];

if (!installed()) {
    http_response_code(503);
    exit;
}

/* ---- the index ---- */
if ($type === 'index') {
    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($types as $t) {
        echo "  <sitemap><loc>" . htmlspecialchars("$origin/sitemap-$t.xml", ENT_XML1) . "</loc><lastmod>" . date('Y-m-d') . "</lastmod></sitemap>\n";
    }
    echo "</sitemapindex>\n";
    exit;
}

if (!in_array($type, $types, true)) {
    http_response_code(404);
    exit;
}

$items = [];
$abs   = function (string $path) use ($origin) {
    // helper URLs already carry base_path(); make them absolute
    return $origin . $path;
};

switch ($type) {
    case 'pages':
        $b = base_path();
        $items[] = [$origin . $b . '/', date('Y-m-d'), 'daily', '1.0'];
        foreach (['/stall/list/' => '0.7', '/market/list/' => '0.7', '/brand/list/' => '0.7', '/blog.php' => '0.6', '/package.html' => '0.6', '/sell/' => '0.6', '/help/' => '0.6', '/success-stories/' => '0.5', '/track-order/' => '0.4', '/return-and-refund-policy/' => '0.4', '/privacy.php' => '0.3'] as $path => $prio) {
            $items[] = [$origin . $b . $path, null, 'weekly', $prio];
        }
        break;

    case 'categories':
        foreach (category_index() as $v) {
            $level = (int) $v['row']['level'];
            $items[] = [$abs(category_url($v['row'])), sm_date($v['row']['created_at'] ?? null), $level === 1 ? 'daily' : 'weekly', $level === 1 ? '0.9' : ($level === 2 ? '0.8' : '0.7')];
        }
        break;

    case 'products':
        foreach (rows("SELECT id, slug, created_at FROM products WHERE status = 'active' ORDER BY id DESC LIMIT 45000") as $r) {
            $items[] = [$abs(product_url($r)), sm_date($r['created_at']), 'weekly', '0.8'];
        }
        break;

    case 'stalls':
        foreach (rows("SELECT id, slug, created_at FROM stalls WHERE status = 'active' AND review_status = 'approved' ORDER BY id DESC LIMIT 45000") as $r) {
            $items[] = [$abs(stall_url($r)), sm_date($r['created_at']), 'weekly', '0.6'];
        }
        break;

    case 'brands':
        foreach (rows("SELECT id, slug, created_at FROM brands WHERE review_status = 'approved' ORDER BY id DESC LIMIT 45000") as $r) {
            $items[] = [$abs(brand_url($r)), sm_date($r['created_at']), 'weekly', '0.6'];
        }
        break;

    case 'malls':
        foreach (rows('SELECT id, slug, created_at FROM malls ORDER BY id DESC LIMIT 45000') as $r) {
            $items[] = [$abs(mall_url($r)), sm_date($r['created_at']), 'monthly', '0.6'];
        }
        break;

    case 'blog':
        foreach (rows("SELECT slug, published_at, created_at FROM blog_posts WHERE status = 'published' ORDER BY id DESC LIMIT 45000") as $r) {
            $items[] = [$origin . base_path() . '/blog-post.php?slug=' . rawurlencode($r['slug']), sm_date($r['published_at'] ?: $r['created_at']), 'monthly', '0.6'];
        }
        break;
}

sm_urlset($items);
