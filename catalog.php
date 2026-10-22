<?php
/* One page for every category level, served from clean URLs (see .htaccess):
     /car-bike/                              main category      (shows its sub categories)
     /car-bike/accessories/                  sub category       (shows its sub sub categories)
     /car-bike/accessories/scratch-remover/  sub sub category   (shows the listings)
   Old links such as category.html?cat=carbike are sent here as ?legacy=carbike and 301-redirected. */
require __DIR__ . '/app/bootstrap.php';

/* ---- old addresses -> new addresses ---- */
$legacy = (string) input('legacy', '');
if ($legacy !== '') {
    $old = row('SELECT * FROM categories WHERE slug = ?', [$legacy]);
    if ($old) {
        header('Location: ' . category_url($old), true, 301);
        exit;
    }
}

$segments = array_values(array_filter([(string) input('c1', ''), (string) input('c2', ''), (string) input('c3', '')], 'strlen'));
$cat = ($legacy === '' && $segments) ? find_category_by_path($segments) : null;

if (!$cat) {
    http_response_code(404);
    site_header('Page not found');
    ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Not found</span></nav>
    <h1 class="category-title">Category not found</h1>
    <p class="category-empty">We couldn't find that category. <a href="<?= base_path() ?>/index.html">Go to the homepage</a>.</p>
  </div>
</section>
<?php
    site_footer();
    exit;
}

/* /car-bike  ->  /car-bike/  (and fix any other non-canonical form) */
$reqPath = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && $reqPath !== category_url($cat)) {
    header('Location: ' . category_url($cat) . (isset($_GET['page']) && (int) $_GET['page'] > 1 ? '?page=' . (int) $_GET['page'] : ''), true, 301);
    exit;
}

/* ---- trail, children, products ---- */
$trail = [];
$walk  = $cat;
while ($walk) {
    array_unshift($trail, $walk);
    $walk = $walk['parent_id'] ? row('SELECT * FROM categories WHERE id = ?', [$walk['parent_id']]) : null;
}
$children = rows('SELECT * FROM categories WHERE parent_id = ? ORDER BY sort_order, name_en', [$cat['id']]);

$ids      = [(int) $cat['id']];
$frontier = $ids;
for ($d = 0; $d < 3 && $frontier; $d++) {
    $in       = implode(',', array_fill(0, count($frontier), '?'));
    $frontier = array_map('intval', array_column(rows("SELECT id FROM categories WHERE parent_id IN ($in)", $frontier), 'id'));
    $ids      = array_merge($ids, $frontier);
}
$inIds   = implode(',', array_fill(0, count($ids), '?'));
$perPage = 12;
$total   = (int) scalar("SELECT COUNT(*) FROM products WHERE status = 'active' AND category_id IN ($inIds)", $ids);
$pg      = paginate($total, $perPage, input_int('page', 1));
$products = rows(
    "SELECT * FROM products WHERE status = 'active' AND category_id IN ($inIds) ORDER BY id DESC LIMIT " . $pg['per'] . ' OFFSET ' . $pg['offset'],
    $ids
);

$name     = (string) $cat['name_en'];
$icon     = $cat['icon'] ?: '🏷️';
$isLeaf   = !$children;
$origin   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
$canon    = $origin . category_url($cat);
$descr    = $isLeaf
    ? "Browse $name listings from sellers across Bangladesh on SaleBari. Compare prices and contact the seller directly on WhatsApp."
    : "Explore $name on SaleBari, Bangladesh's digital bazaar: " . implode(', ', array_slice(array_column($children, 'name_en'), 0, 6)) . '.';

$crumbJson = [];
foreach (array_merge([['name_en' => 'Home', 'url' => $origin . base_path() . '/']], $trail) as $i => $c) {
    $crumbJson[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $c['name_en'],
        'item' => isset($c['url']) ? $c['url'] : $origin . category_url($c),
    ];
}
$head = '<meta name="description" content="' . e($descr) . '">' . "\n"
    . '<link rel="canonical" href="' . e($canon) . '">' . "\n"
    . '<script type="application/ld+json">' . json_encode(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $crumbJson], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

/* names for the EN / বাংলা toggle */
$dict = [];
foreach (array_merge($trail, $children) as $c) {
    $dict['cn.' . $c['id']] = ['en' => $c['name_en'], 'bn' => $c['name_bn'] ?: $c['name_en']];
}

function catalog_page_url(array $cat, int $page): string
{
    return category_url($cat) . ($page > 1 ? '?page=' . $page : '');
}

site_header($name . ' in Bangladesh', $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a>
      <?php foreach ($trail as $i => $c): ?>
        <span class="breadcrumb-sep">›</span>
        <?php if ($i < count($trail) - 1): ?>
          <a href="<?= e(category_url($c)) ?>" data-i18n="cn.<?= (int) $c['id'] ?>"><?= e($c['name_en']) ?></a>
        <?php else: ?>
          <span class="breadcrumb-current" data-i18n="cn.<?= (int) $c['id'] ?>"><?= e($c['name_en']) ?></span>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>

    <div class="listing-page-header">
      <h1 class="listing-page-title" data-i18n="cn.<?= (int) $cat['id'] ?>"><?= e($name) ?></h1>
      <p class="listing-page-stat"><?= $total ?> <?= $total === 1 ? 'listing' : 'listings' ?></p>
    </div>

    <?php if ($children): ?>
      <div class="subcat-grid">
        <?php foreach ($children as $c): ?>
          <a class="subcat-card" href="<?= e(category_url($c)) ?>">
            <span class="subcat-icon"><?= e($c['icon'] ?: $icon) ?></span>
            <span class="subcat-label" data-i18n="cn.<?= (int) $c['id'] ?>"><?= e($c['name_en']) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($products): ?>
      <?php if ($children): ?><h2 class="catalog-subheading">Latest in <?= e($name) ?></h2><?php endif; ?>
      <div class="listing-grid catalog-grid">
        <?php foreach ($products as $p): $imgs = json_decode((string) $p['images'], true) ?: []; ?>
          <a class="listing-card" href="<?= e(product_url($p)) ?>">
            <div class="listing-card-media">
              <?php if ($imgs): ?><img src="<?= e(asset($imgs[0])) ?>" alt="<?= e($p['title_en']) ?>" loading="lazy"><?php else: ?><?= e($icon) ?><?php endif; ?>
            </div>
            <div class="listing-card-body">
              <h3 class="listing-card-title"><?= e($p['title_en']) ?></h3>
              <?php if ($p['price_display']): ?><div class="listing-card-price"><?= e($p['price_display']) ?></div><?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <?php if ($pg['pages'] > 1): ?>
        <nav class="stall-detail-pagination catalog-pagination" aria-label="Pagination">
          <?php if ($pg['page'] > 1): ?><a href="<?= e(catalog_page_url($cat, $pg['page'] - 1)) ?>" rel="prev">‹ Previous</a><?php endif; ?>
          <span><?= $pg['page'] ?> / <?= $pg['pages'] ?></span>
          <?php if ($pg['page'] < $pg['pages']): ?><a href="<?= e(catalog_page_url($cat, $pg['page'] + 1)) ?>" rel="next">Next ›</a><?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php elseif ($isLeaf): ?>
      <p class="listing-empty">No listings in <?= e($name) ?> yet. <a href="<?= base_path() ?>/sell/" style="color:var(--gold-deep);font-weight:600">Open your stall and be the first →</a></p>
    <?php endif; ?>
  </div>
</section>
<?php
ob_start();
?>
<script>
  (function () {
    var add = <?= json_encode($dict, JSON_UNESCAPED_UNICODE) ?>;
    Object.keys(add).forEach(function (k) { window.I18N.dict[k] = add[k]; });
    window.I18N.applyLanguage(window.I18N.currentLang());
  })();
</script>
<?php
site_footer(ob_get_clean());
