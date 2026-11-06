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

$segments = array_values(array_filter([(string) input('c1', ''), (string) input('c2', ''), (string) input('c3', ''), (string) input('c4', '')], 'strlen'));
$cat      = ($legacy === '' && $segments) ? find_category_by_path($segments) : null;
$cityPage = null;   // /electronics/laptop/dhaka/  ->  ['slug' => 'dhaka', 'name' => 'Dhaka']
if (!$cat && $legacy === '' && count($segments) >= 2) {
    $districts = districts_by_slug();
    $lastSeg   = end($segments);
    if (isset($districts[$lastSeg])) {
        $cat = find_category_by_path(array_slice($segments, 0, -1));
        if ($cat) {
            $cityPage = ['slug' => $lastSeg, 'name' => $districts[$lastSeg]];
        }
    }
}

if (!$cat) {
    http_response_code(404);
    site_header('Page not found', '<meta name="robots" content="noindex,follow">');
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

/* The filter form sends ?city=dhaka: send the visitor to the clean city page, keeping the other filters. */
$filterKeep = array_diff_key($_GET, array_flip(['c1', 'c2', 'c3', 'c4', 'legacy', 'city', 'page']));
$filterKeep = array_filter($filterKeep, function ($v) { return $v !== '' && $v !== null; });
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && array_key_exists('city', $_GET)) {
    $wanted = strtolower((string) $_GET['city']);
    $target = isset(districts_by_slug()[$wanted]) ? category_city_url($cat, $wanted) : category_url($cat);
    header('Location: ' . $target . ($filterKeep ? '?' . http_build_query($filterKeep) : ''), true, 302);
    exit;
}

/* /car-bike  ->  /car-bike/  (and fix any other non-canonical form) */
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
$selfPath = category_url($cat) . ($cityPage ? $cityPage['slug'] . '/' : '');
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && $reqPath !== $selfPath) {
    header('Location: ' . $selfPath . (isset($_GET['page']) && (int) $_GET['page'] > 1 ? '?page=' . (int) $_GET['page'] : ''), true, 301);
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

/* Filters (price, condition, sort). The city comes from the URL (/dhaka/) — see above. */
$fMin  = trim((string) input('min', '')) !== '' ? price_to_number((string) input('min')) : null;
$fMax  = trim((string) input('max', '')) !== '' ? price_to_number((string) input('max')) : null;
$fCond = in_array((string) input('cond', ''), ['new', 'used'], true) ? (string) input('cond') : '';
$fSort = in_array((string) input('sort', ''), ['price_asc', 'price_desc'], true) ? (string) input('sort') : 'new';
$isFiltered = $fMin !== null || $fMax !== null || $fCond !== '' || $fSort !== 'new';

/* Which cities have listings in this category (drives the city filter and the "browse by city" links). */
$cityExpr = "COALESCE(NULLIF(p.city, ''), s.city)";
$from     = "FROM products p LEFT JOIN stalls s ON s.id = p.stall_id WHERE p.status = 'active' AND p.category_id IN ($inIds)";
$cityCounts = [];
foreach (rows("SELECT $cityExpr AS c, COUNT(*) AS n $from GROUP BY $cityExpr", $ids) as $cr) {
    $d = district_for($cr['c']);
    if (!$d) {
        continue;
    }
    $cityCounts[$d['slug']] = $cityCounts[$d['slug']] ?? ['name' => $d['name'], 'n' => 0, 'raw' => []];
    $cityCounts[$d['slug']]['n'] += (int) $cr['n'];
    $cityCounts[$d['slug']]['raw'][] = $cr['c'];
}
uasort($cityCounts, function ($x, $y) { return $y['n'] <=> $x['n'] ?: strcmp($x['name'], $y['name']); });

$where  = $from;
$params = $ids;
if ($cityPage) {
    $raw = $cityCounts[$cityPage['slug']]['raw'] ?? [];
    if ($raw) {
        $where .= " AND $cityExpr IN (" . implode(',', array_fill(0, count($raw), '?')) . ')';
        $params = array_merge($params, $raw);
    } else {
        $where .= ' AND 1 = 0';
    }
}
$scopeTotal = $cityPage ? (int) ($cityCounts[$cityPage['slug']]['n'] ?? 0) : (int) scalar("SELECT COUNT(*) $from", $ids);
if ($fMin !== null)  { $where .= ' AND p.price_num >= ?'; $params[] = $fMin; }
if ($fMax !== null)  { $where .= ' AND p.price_num <= ?'; $params[] = $fMax; }
if ($fCond !== '')   { $where .= ' AND p.condition_type = ?'; $params[] = $fCond; }
$order = ['new' => 'p.id DESC', 'price_asc' => 'p.price_num IS NULL, p.price_num ASC, p.id DESC', 'price_desc' => 'p.price_num IS NULL, p.price_num DESC, p.id DESC'][$fSort];

$total = (int) scalar("SELECT COUNT(*) $where", $params);
$pg    = paginate($total, $perPage, input_int('page', 1));
$products = rows("SELECT p.* $where ORDER BY $order LIMIT " . $pg['per'] . ' OFFSET ' . $pg['offset'], $params);

$name     = (string) $cat['name_en'];
$icon     = $cat['icon'] ?: '🏷️';
$isLeaf   = !$children;
$canonPath = $selfPath . ($pg['page'] > 1 ? '?page=' . $pg['page'] : '');
$descr     = $cityPage ? category_city_description($cat, $cityPage['name'], $scopeTotal) : category_seo_description($cat, $children, $total);
$seoTitle  = $cityPage ? category_city_title($cat, $cityPage['name']) : category_seo_title($cat);
$headingName = $cityPage ? $name . ' in ' . $cityPage['name'] : $name;
// filtered / sorted views and empty city pages stay out of search results
$noindex   = $isFiltered || ($cityPage && $scopeTotal === 0);
if ($pg['page'] > 1) {
    $seoTitle .= ' — Page ' . $pg['page'];
}
$firstImg = null;
foreach ($products as $p0) {
    $im0 = json_decode((string) $p0['images'], true) ?: [];
    if ($im0) { $firstImg = asset($im0[0]); break; }
}

$ldItems = [];
foreach ($products as $i => $p0) {
    $ldItems[] = ['@type' => 'ListItem', 'position' => $pg['offset'] + $i + 1, 'url' => abs_url(product_url($p0)), 'name' => $p0['title_en']];
}
$crumbs = [['name' => 'Home', 'url' => base_path() . '/']];
foreach ($trail as $c0) {
    $crumbs[] = ['name' => $c0['name_en'], 'url' => category_url($c0)];
}
if ($cityPage) {
    $crumbs[] = ['name' => $cityPage['name']];
}
$head = seo_meta([
        'title'       => $seoTitle . ' — SaleBari',
        'description' => $descr,
        'url'         => $canonPath,
        'image'       => $firstImg ?: '/assets/og-default.png',
        'noindex'     => $noindex,
        'prev'        => $pg['page'] > 1 ? $selfPath . ($pg['page'] > 2 ? '?page=' . ($pg['page'] - 1) : '') : null,
        'next'        => $pg['page'] < $pg['pages'] ? $selfPath . '?page=' . ($pg['page'] + 1) : null,
    ])
    . ld_script(
        ld_breadcrumb($crumbs),
        ['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => $seoTitle, 'url' => abs_url($canonPath), 'description' => $descr,
         'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $total, 'itemListElement' => $ldItems]]
    );

/* names for the EN / বাংলা toggle */
$dict = [];
$related = related_categories($cat);
foreach (array_merge($trail, $children, $related) as $c) {
    $dict['cn.' . $c['id']] = ['en' => $c['name_en'], 'bn' => $c['name_bn'] ?: $c['name_en']];
}

/** Link to page N of the current view, keeping the active filters. */
function catalog_page_url(string $base, int $page): string
{
    global $fMin, $fMax, $fCond, $fSort;
    $q = [];
    if ($fMin !== null) { $q['min'] = $fMin; }
    if ($fMax !== null) { $q['max'] = $fMax; }
    if ($fCond !== '')  { $q['cond'] = $fCond; }
    if ($fSort !== 'new') { $q['sort'] = $fSort; }
    if ($page > 1) { $q['page'] = $page; }
    return $base . ($q ? '?' . http_build_query($q) : '');
}

site_header($seoTitle, $head, false);
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
          <?php if ($cityPage): ?><a href="<?= e(category_url($c)) ?>" data-i18n="cn.<?= (int) $c['id'] ?>"><?= e($c['name_en']) ?></a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current"><?= e($cityPage['name']) ?></span>
          <?php else: ?><span class="breadcrumb-current" data-i18n="cn.<?= (int) $c['id'] ?>"><?= e($c['name_en']) ?></span><?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>

    <div class="listing-page-header">
      <h1 class="listing-page-title"<?= $cityPage ? '' : ' data-i18n="cn.' . (int) $cat['id'] . '"' ?>><?= e($headingName) ?></h1>
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

    <?php if ($scopeTotal > 0 || $isFiltered): ?>
      <form class="catalog-filter" method="get" action="<?= e(category_url($cat)) ?>">
        <label><span>City</span>
          <select name="city">
            <option value="">All Bangladesh</option>
            <?php foreach ($cityCounts as $slug => $cc): ?><option value="<?= e($slug) ?>"<?= $cityPage && $cityPage['slug'] === $slug ? ' selected' : '' ?>><?= e($cc['name']) ?> (<?= (int) $cc['n'] ?>)</option><?php endforeach; ?>
          </select></label>
        <label><span>Condition</span>
          <select name="cond">
            <option value="">Any</option>
            <option value="new"<?= $fCond === 'new' ? ' selected' : '' ?>>New</option>
            <option value="used"<?= $fCond === 'used' ? ' selected' : '' ?>>Used</option>
          </select></label>
        <label><span>Min price (৳)</span><input type="text" inputmode="numeric" name="min" value="<?= $fMin !== null ? e((string) $fMin) : '' ?>" placeholder="e.g. 5000"></label>
        <label><span>Max price (৳)</span><input type="text" inputmode="numeric" name="max" value="<?= $fMax !== null ? e((string) $fMax) : '' ?>" placeholder="e.g. 5 lakh"></label>
        <label><span>Sort</span>
          <select name="sort">
            <option value="new">Newest first</option>
            <option value="price_asc"<?= $fSort === 'price_asc' ? ' selected' : '' ?>>Price: low to high</option>
            <option value="price_desc"<?= $fSort === 'price_desc' ? ' selected' : '' ?>>Price: high to low</option>
          </select></label>
        <div class="catalog-filter-actions">
          <button type="submit" class="btn btn-primary">Apply</button>
          <?php if ($isFiltered || $cityPage): ?><a class="btn btn-ghost" href="<?= e(category_url($cat)) ?>">Reset</a><?php endif; ?>
        </div>
      </form>
    <?php endif; ?>

    <?php if ($products): ?>
      <?php if ($children): ?><h2 class="catalog-subheading">Latest in <?= e($headingName) ?></h2><?php endif; ?>
      <div class="listing-grid catalog-grid">
        <?php foreach ($products as $p): $imgs = json_decode((string) $p['images'], true) ?: []; ?>
          <div class="card-wrap">
          <a class="listing-card" href="<?= e(product_url($p)) ?>">
            <div class="listing-card-media">
              <?= stock_card_badge($p) ?>
              <?php if ($imgs): ?><img src="<?= e(asset($imgs[0])) ?>" alt="<?= e($p['title_en']) ?>" loading="lazy"><?php else: ?><?= e($icon) ?><?php endif; ?>
            </div>
            <div class="listing-card-body">
              <h3 class="listing-card-title"><?= e($p['title_en']) ?></h3>
              <?php if ($p['price_display']): ?><div class="listing-card-price"><?= e($p['price_display']) ?></div><?php endif; ?>
            </div>
          </a>
          <button type="button" class="wish-btn" data-wish="<?= (int) $p['id'] ?>" aria-pressed="false" aria-label="Save this listing"><span class="wish-ico">♡</span></button>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($pg['pages'] > 1): ?>
        <nav class="stall-detail-pagination catalog-pagination" aria-label="Pagination">
          <?php if ($pg['page'] > 1): ?><a href="<?= e(catalog_page_url($selfPath, $pg['page'] - 1)) ?>" rel="prev">‹ Previous</a><?php endif; ?>
          <span><?= $pg['page'] ?> / <?= $pg['pages'] ?></span>
          <?php if ($pg['page'] < $pg['pages']): ?><a href="<?= e(catalog_page_url($selfPath, $pg['page'] + 1)) ?>" rel="next">Next ›</a><?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php elseif ($isFiltered): ?>
      <p class="listing-empty">No listings match these filters. <a href="<?= e($selfPath) ?>" style="color:var(--gold-deep);font-weight:600">Clear filters</a></p>
    <?php elseif ($cityPage): ?>
      <p class="listing-empty">No <?= e($name) ?> listings in <?= e($cityPage['name']) ?> yet. <a href="<?= e(category_url($cat)) ?>" style="color:var(--gold-deep);font-weight:600">See <?= e($name) ?> across Bangladesh →</a></p>
    <?php elseif ($isLeaf): ?>
      <p class="listing-empty">No listings in <?= e($name) ?> yet. <a href="<?= base_path() ?>/sell/" style="color:var(--gold-deep);font-weight:600">Open your stall and be the first →</a></p>
    <?php endif; ?>
    <section class="catalog-seo">
      <?php if ($cityPage): ?>
        <div class="catalog-intro"><p>These are <?= e($name) ?> listings from sellers in <?= e($cityPage['name']) ?>. Open any listing to see photos, price and details, then message the seller directly on WhatsApp or by phone. Looking elsewhere? Pick another city below, or <a href="<?= e(category_url($cat)) ?>">see all <?= e($name) ?> in Bangladesh</a>.</p></div>
      <?php else: ?>
        <div class="catalog-intro"><?= category_intro_html($cat, $children, $trail) ?></div>
      <?php endif; ?>
      <?php $cityLinks = array_filter($cityCounts, function ($cc, $slug) use ($cityPage) { return !$cityPage || $cityPage['slug'] !== $slug; }, ARRAY_FILTER_USE_BOTH); ?>
      <?php if ($cityLinks): ?>
        <h2 class="catalog-subheading"><?= $cityPage ? 'Other cities' : 'Browse ' . e($name) . ' by city' ?></h2>
        <div class="chip-row">
          <?php foreach (array_slice($cityLinks, 0, 24, true) as $slug => $cc): ?><a class="chip" href="<?= e(category_city_url($cat, $slug)) ?>"><?= e($name) ?> in <?= e($cc['name']) ?> <small>(<?= (int) $cc['n'] ?>)</small></a><?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if ($related): ?>
        <h2 class="catalog-subheading"><?= count($trail) > 1 ? 'More in ' . e($trail[count($trail) - 2]['name_en']) : 'Explore more categories' ?></h2>
        <div class="chip-row">
          <?php foreach ($related as $rc): ?><a class="chip" href="<?= e(category_url($rc)) ?>" data-i18n="cn.<?= (int) $rc['id'] ?>"><?= e($rc['name_en']) ?></a><?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if (count($trail) > 1): $up = $trail[count($trail) - 2]; ?>
        <p class="catalog-back">← <a href="<?= e(category_url($up)) ?>">All <?= e($up['name_en']) ?></a></p>
      <?php endif; ?>
    </section>
  </div>
</section>
<?php
$trackItems = [];
foreach ($products as $i => $p) {
    $trackItems[] = ['item_id' => (string) $p['id'], 'item_name' => $p['title_en'], 'item_category' => $name, 'price' => track_price($p['price_display']), 'index' => $i + 1];
}
ob_start();
echo track_page_script(['type' => $isLeaf ? 'category_leaf' : 'category', 'list_name' => implode(' / ', array_column($trail, 'name_en')), 'items' => $trackItems]);
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
