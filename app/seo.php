<?php
/* On-page SEO helpers: canonical + Open Graph + Twitter tags, JSON-LD, breadcrumbs, and the
   internal-link blocks (related categories, "more from this seller", footer category links). */

function site_origin(): string
{
    $host   = (string) ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || !preg_match('/^(localhost|127\.|\[::1\])/', $host);
    return ($secure ? 'https' : 'http') . '://' . $host;
}

/** '/car-bike/' -> 'https://salebari.com/car-bike/'; full URLs pass through. */
function abs_url(string $pathOrUrl): string
{
    return preg_match('~^https?://~i', $pathOrUrl) ? $pathOrUrl : site_origin() . '/' . ltrim($pathOrUrl, '/');
}

/** Plain text for a meta description: tags stripped, spaces collapsed, cut on a word boundary. */
function seo_clean(?string $html, int $max = 155): string
{
    $t = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $html), ENT_QUOTES, 'UTF-8')));
    return trim_words($t, $max);
}

/**
 * <head> tags that every indexable page should have.
 * keys: title, description, url (canonical path or URL), image (path or URL), type (website|article|product),
 *       noindex (bool), prev, next (URLs)
 */
function seo_meta(array $o): string
{
    $title = (string) ($o['title'] ?? 'SaleBari');
    $desc  = seo_clean((string) ($o['description'] ?? ''), 160);
    $url   = abs_url((string) ($o['url'] ?? ($_SERVER['REQUEST_URI'] ?? '/')));
    $image = abs_url((string) ($o['image'] ?? '/assets/og-default.png'));
    $type  = (string) ($o['type'] ?? 'website');

    $h  = '';
    if ($desc !== '') {
        $h .= '<meta name="description" content="' . e($desc) . '">' . "\n";
    }
    $h .= '<meta name="robots" content="' . (!empty($o['noindex']) ? 'noindex,follow' : 'index,follow,max-image-preview:large') . '">' . "\n";
    $h .= '<link rel="canonical" href="' . e($url) . '">' . "\n";
    if (!empty($o['prev'])) $h .= '<link rel="prev" href="' . e(abs_url($o['prev'])) . '">' . "\n";
    if (!empty($o['next'])) $h .= '<link rel="next" href="' . e(abs_url($o['next'])) . '">' . "\n";
    $h .= '<meta name="theme-color" content="#0F2A24">' . "\n";
    $h .= '<meta property="og:site_name" content="SaleBari">' . "\n";
    $h .= '<meta property="og:type" content="' . e($type) . '">' . "\n";
    $h .= '<meta property="og:title" content="' . e($title) . '">' . "\n";
    if ($desc !== '') $h .= '<meta property="og:description" content="' . e($desc) . '">' . "\n";
    $h .= '<meta property="og:url" content="' . e($url) . '">' . "\n";
    $h .= '<meta property="og:image" content="' . e($image) . '">' . "\n";
    $h .= '<meta property="og:locale" content="en_US">' . "\n" . '<meta property="og:locale:alternate" content="bn_BD">' . "\n";
    $h .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $h .= '<meta name="twitter:title" content="' . e($title) . '">' . "\n";
    if ($desc !== '') $h .= '<meta name="twitter:description" content="' . e($desc) . '">' . "\n";
    $h .= '<meta name="twitter:image" content="' . e($image) . '">' . "\n";
    return $h;
}

/** <script type="application/ld+json"> for one or several schema.org objects. */
function ld_script(array ...$objects): string
{
    $out = '';
    foreach ($objects as $d) {
        if ($d) {
            $out .= '<script type="application/ld+json">' . json_encode($d, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) . '</script>' . "\n";
        }
    }
    return $out;
}

/** BreadcrumbList from [['name' => 'Home', 'url' => '/'], ...] (the last item may omit url). */
function ld_breadcrumb(array $items): array
{
    $list = [];
    foreach (array_values($items) as $i => $it) {
        $row = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $it['name']];
        if (!empty($it['url'])) {
            $row['item'] = abs_url($it['url']);
        }
        $list[] = $row;
    }
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list];
}

/** Organization + WebSite markup used on the homepage. */
function ld_organization(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => 'SaleBari',
        'url'      => abs_url(base_path() . '/'),
        'logo'     => abs_url('/assets/og-default.png'),
        'sameAs'   => ['https://www.facebook.com/thesalebari', 'https://www.linkedin.com/company/sale-bari/'],
        'contactPoint' => array_map(function ($n) {
            return ['@type' => 'ContactPoint', 'telephone' => $n['tel'], 'contactType' => 'customer support', 'areaServed' => 'BD', 'availableLanguage' => ['en', 'bn']];
        }, site_numbers()),
    ];
}

/* ---------------- internal linking ---------------- */

/** Main categories with a few of their sub categories, as link columns for the footer. */
function footer_categories_html(): string
{
    $idx = category_index();
    $by  = [];
    foreach ($idx as $v) {
        $by[(int) ($v['row']['parent_id'] ?? 0)][] = $v;
    }
    foreach ($by as &$list) {
        usort($list, function ($a, $b) {
            return [(int) $a['row']['sort_order'], $a['row']['name_en']] <=> [(int) $b['row']['sort_order'], $b['row']['name_en']];
        });
    }
    unset($list);

    $h = '<div class="footer-cats"><h4 data-i18n="footer.browseCats">Browse categories</h4><div class="footer-cats-grid">';
    foreach ($by[0] ?? [] as $top) {
        $h .= '<div class="footer-cat-col"><a class="footer-cat-head" href="' . e(base_path() . '/' . $top['path'] . '/') . '" data-i18n="cn.' . (int) $top['row']['id'] . '">' . e($top['row']['name_en']) . '</a>';
        foreach (array_slice($by[(int) $top['row']['id']] ?? [], 0, 6) as $sub) {
            $h .= '<a href="' . e(base_path() . '/' . $sub['path'] . '/') . '" data-i18n="cn.' . (int) $sub['row']['id'] . '">' . e($sub['row']['name_en']) . '</a>';
        }
        $h .= '</div>';
    }
    return $h . '</div></div>';
}

/** Sibling categories (same parent), or the other main categories for a main category. */
function related_categories(array $cat, int $limit = 12): array
{
    $params = [(int) $cat['id']];
    $sql    = 'SELECT * FROM categories WHERE id <> ? AND ' . ($cat['parent_id'] ? 'parent_id = ?' : 'parent_id IS NULL');
    if ($cat['parent_id']) {
        $params[] = (int) $cat['parent_id'];
    }
    return rows($sql . ' ORDER BY sort_order, name_en LIMIT ' . (int) $limit, $params);
}

/** Short, natural paragraph about a category; sub categories inside it are links. Admin text wins. */
function category_intro_html(array $cat, array $children, array $trail): string
{
    $custom = trim((string) ($cat['seo_text'] ?? ''));
    if ($custom !== '') {
        return nl2br(e($custom));
    }
    $name   = e($cat['name_en']);
    $parent = count($trail) > 1 ? $trail[count($trail) - 2] : null;
    $links  = [];
    foreach (array_slice($children, 0, 8) as $c) {
        $links[] = '<a href="' . e(category_url($c)) . '">' . e($c['name_en']) . '</a>';
    }
    $list = $links ? natural_list($links) : '';
    $tail = 'Compare prices from sellers across Bangladesh, open any listing to see photos and details, and message the seller directly on WhatsApp or by phone.';
    if ($children) {
        return "<p>Looking for $name in Bangladesh? SaleBari brings together sellers of $list. $tail</p>";
    }
    $in = $parent ? ' under <a href="' . e(category_url($parent)) . '">' . e($parent['name_en']) . '</a>' : '';
    return "<p>Find $name$in on SaleBari, Bangladesh's digital bazaar. Browse the latest listings, check availability and price, and contact the seller directly. $tail</p>";
}

/** Main categories (and their first few sub categories) as chips: internal links for directory pages. */
function seo_category_chips_html(int $subsPer = 3): string
{
    $idx = category_index();
    $by  = [];
    foreach ($idx as $v) {
        $by[(int) ($v['row']['parent_id'] ?? 0)][] = $v;
    }
    foreach ($by as &$list) {
        usort($list, function ($a, $b) {
            return [(int) $a['row']['sort_order'], $a['row']['name_en']] <=> [(int) $b['row']['sort_order'], $b['row']['name_en']];
        });
    }
    unset($list);
    $h = '<div class="chip-row">';
    foreach ($by[0] ?? [] as $top) {
        $h .= '<a class="chip" href="' . e(base_path() . '/' . $top['path'] . '/') . '"><strong>' . e($top['row']['name_en']) . '</strong></a>';
        foreach (array_slice($by[(int) $top['row']['id']] ?? [], 0, $subsPer) as $sub) {
            $h .= '<a class="chip" href="' . e(base_path() . '/' . $sub['path'] . '/') . '">' . e($sub['row']['name_en']) . '</a>';
        }
    }
    return $h . '</div>';
}

/** Distinct categories used by a set of products (for "this seller sells in …" links). */
function categories_of_products(string $where, array $args, int $limit = 10): array
{
    return rows(
        "SELECT DISTINCT c.* FROM products p JOIN categories c ON c.id = p.category_id WHERE p.status = 'active' AND $where ORDER BY c.name_en LIMIT " . (int) $limit,
        $args
    );
}
