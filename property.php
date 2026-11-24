<?php
/* Property landing pages — see app/property_pages.php and app/property_data.php.
     /property-for-sale/                    hub
     /flat-for-sale/                        one type, all cities
     /flat-for-sale-in-dhaka/               one type in one city
     /flat-for-sale-in-gulshan/             one type in one Dhaka area       (also apartment-..., land-...)
   Size pages and comparison pages have their own scripts (property-size.php, property-compare.php). */
require __DIR__ . '/app/bootstrap.php';

$types = property_types();
$locs  = property_locations();
$areas = property_areas();
$tk    = strtolower((string) input('t', ''));
$ck    = strtolower((string) input('c', ''));

$area = ($ck !== '' && isset($areas[$ck])) ? $areas[$ck] : null;
if (($tk !== '' && !isset($types[$tk])) || ($ck !== '' && !isset($locs[$ck]) && !$area) || ($area && $tk !== '' && !in_array($tk, $area['types'], true))) {
    require __DIR__ . '/404.php';
    exit;
}

$type = $tk !== '' ? $types[$tk] : null;
$loc  = $ck !== '' ? ($area ? $locs['dhaka'] : $locs[$ck]) : null;
if ($area) {
    // an area page reads like a city page, with the area's own name and text
    $loc = array_merge($loc, ['name' => $area['name'], 'bn' => $area['bn'], 'bn_in' => $area['bn_in'], 'alt' => null,
                              'blurb' => $area['blurb'][0], 'blurb_bn' => $area['blurb'][1], 'areas' => []]);
}
$year = date('Y');
$nums = site_numbers();
$wa   = $nums[0]['wa'];

$bi = function (string $en, string $bn): string {
    return '<span data-lang="en">' . e($en) . '</span><span data-lang="bn">' . e($bn) . '</span>';
};

$selfPath = property_url($tk ?: null, $ck ?: null);
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && $reqPath !== $selfPath) {
    header('Location: ' . $selfPath . (isset($_GET['page']) && (int) $_GET['page'] > 1 ? '?page=' . (int) $_GET['page'] : ''), true, 301);
    exit;
}

$realEstate = find_category_by_path(['real-estate']);
$crumbs     = [['name' => 'Home', 'url' => base_path() . '/']];
if ($realEstate) {
    $crumbs[] = ['name' => 'Real Estate', 'url' => category_url($realEstate)];
}

/* =====================  main hub: /property-for-sale/  ===================== */
if (!$type) {
    $title = "Flat, Apartment & Land for Sale in Bangladesh $year — SaleBari";
    $descr = "Flats, apartments and land for sale in Dhaka, Chittagong and Feni, by size and by Dhaka area, with location comparisons. Browse sellers' listings and message them on WhatsApp.";
    $head  = seo_meta(['title' => $title, 'description' => $descr, 'url' => $selfPath])
           . ld_script(ld_breadcrumb(array_merge($crumbs, [['name' => 'Property for Sale']])));
    site_header(str_replace(' — SaleBari', '', $title), $head, false);
    ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?><span class="breadcrumb-current">Property for Sale</span></nav>
    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi('Flat, Apartment & Land for Sale in Bangladesh', 'বাংলাদেশে ফ্ল্যাট, অ্যাপার্টমেন্ট ও জমি বিক্রয়') ?></h1>
      <p><?= $bi('Choose what you want to buy and where, or start from the size you need. Each page has listings from sellers on SaleBari, a short buying checklist and answers to common questions. Message the seller directly on WhatsApp or by phone.', 'কী কিনতে চান এবং কোথায় বেছে নিন, অথবা প্রয়োজনীয় আকার দিয়ে শুরু করুন। প্রতিটি পেজে SaleBari-র বিক্রেতাদের তালিকা, সংক্ষিপ্ত কেনার চেকলিস্ট ও সাধারণ প্রশ্নের উত্তর আছে। সরাসরি হোয়াটসঅ্যাপ বা ফোনে বিক্রেতার সাথে কথা বলুন।') ?></p>
    </div>

    <?php foreach ($types as $k => $t): $cat = property_category($k); ?>
      <section class="prop-section">
        <h2><?= e($t['icon']) ?> <a href="<?= e(property_url($k)) ?>"><?= e($t['en']) ?> for Sale</a> <?= $bi('by city', 'শহর অনুযায়ী') ?></h2>
        <div class="prop-grid">
          <?php foreach ($locs as $c => $l): $n = $cat ? property_listings($cat, $l['district'], 1, 1)['total'] : 0; ?>
            <a class="prop-tile" href="<?= e(property_url($k, $c)) ?>">
              <strong><?= e($t['en']) ?> for Sale in <?= e($l['name']) ?></strong>
              <small><?= $n > 0 ? $n . ' ' . ($n === 1 ? 'listing' : 'listings') : 'Buying guide and seller contact' ?></small>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>

    <section class="prop-section">
      <h2><?= $bi('Flats by size', 'আকার অনুযায়ী ফ্ল্যাট') ?></h2>
      <?= property_chip_row(property_size_chips('flat')) ?>
      <h2><?= $bi('Land and plots by size', 'আকার অনুযায়ী জমি ও প্লট') ?></h2>
      <?= property_chip_row(property_size_chips('land')) ?>
    </section>

    <section class="prop-section">
      <h2><?= $bi('Flats and apartments in Dhaka areas', 'ঢাকার বিভিন্ন এলাকায় ফ্ল্যাট ও অ্যাপার্টমেন্ট') ?></h2>
      <?= property_chip_row(property_area_chips('flat')) ?>
      <p class="prop-text"><?= $bi('Plots are listed for the areas where they are common:', 'প্লট যেসব এলাকায় বেশি পাওয়া যায় সেগুলোর জন্য আলাদা পেজ আছে:') ?></p>
      <?= property_chip_row(property_area_chips('land')) ?>
    </section>

    <section class="prop-section">
      <h2><?= $bi('Compare one location with another', 'এক জায়গার সাথে আরেক জায়গার তুলনা') ?></h2>
      <?= property_chip_row(property_compare_chips()) ?>
      <p><a href="<?= e(property_compare_url()) ?>"><?= $bi('See all comparisons →', 'সব তুলনা দেখুন →') ?></a></p>
    </section>

    <section class="prop-section">
      <h2><?= $bi('Buying guides and calculators', 'কেনার গাইড ও ক্যালকুলেটর') ?></h2>
      <?= property_chip_row(guide_all_chips()) ?>
    </section>

    <p class="prop-note"><?= $bi('Looking for a different city? Message us on WhatsApp and we will help you find sellers there.', 'অন্য শহরে খুঁজছেন? হোয়াটসঅ্যাপে মেসেজ করুন, সেখানকার বিক্রেতা খুঁজে দিতে সাহায্য করব।') ?></p>
  </div>
</section>
<?php
    ob_start();
    echo track_page_script(['type' => 'category', 'list_name' => 'Property for Sale', 'items' => []]);
    site_footer(ob_get_clean());
    exit;
}

/* =====================  one type, all cities / one city / one area  ===================== */
$cat      = property_category($tk);
$page     = input_int('page', 1);
$opts     = $area ? ['area' => $ck] : [];
$result   = $cat ? property_listings($cat, $loc ? $loc['district'] : null, 12, $page, $opts) : ['rows' => [], 'total' => 0, 'pg' => paginate(0, 12, 1)];
$products = $result['rows'];
$total    = $result['total'];
$pg       = $result['pg'];

$typeEn  = $type['en'];
$typeLc  = strtolower($typeEn);
$cityEn  = $loc ? $loc['name'] : 'Bangladesh';
$cityLab = $loc ? ($loc['name'] . (!empty($loc['alt']) ? ' (' . $loc['alt'] . ')' : '')) : 'Bangladesh';

$h1En  = "$typeEn for Sale in $cityEn";
$h1Bn  = ($loc ? $loc['bn_in'] : 'বাংলাদেশে') . ' ' . $type['bn'] . ' বিক্রয়';
$title = $typeEn . ' for Sale in ' . ($loc ? $cityLab : 'Bangladesh') . " $year — SaleBari";
if ($loc && empty($loc['alt'])) {
    $title = "$typeEn for Sale in $cityEn, " . ($area ? 'Dhaka' : 'Bangladesh') . " $year — SaleBari";
}
if ($pg['page'] > 1) {
    $title = str_replace(' — SaleBari', ' — Page ' . $pg['page'] . ' — SaleBari', $title);
}
$descr = $total > 0
    ? "Browse $total $typeLc " . ($total === 1 ? 'listing' : 'listings') . " for sale in $cityEn. Compare prices, check the details and message the seller on WhatsApp. Updated $year."
    : "Looking for " . ($tk === 'land' ? 'land' : 'a ' . $typeLc) . " for sale in $cityEn? Read our buying checklist" . ($area ? ', see how the area compares' : '') . ", then tell us what you need and we will connect you with sellers on WhatsApp.";

$lead   = property_fill($type['lead'], $loc);
$leadBn = property_fill($type['lead_bn'], $loc);

$faq = [];
foreach (array_merge($type['faq'], property_common_faq()) as [$qe, $ae, $qb, $ab]) {
    $faq[] = [property_fill($qe, $loc), property_fill($ae, $loc), property_fill($qb, $loc), property_fill($ab, $loc)];
}
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(function ($f) {
    return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
}, $faq)];

$ldItems = [];
foreach ($products as $i => $p0) {
    $ldItems[] = ['@type' => 'ListItem', 'position' => $pg['offset'] + $i + 1, 'url' => abs_url(product_url($p0)), 'name' => $p0['title_en']];
}
$crumbs[] = ['name' => 'Property for Sale', 'url' => property_url()];
if ($loc) {
    $crumbs[] = ['name' => "$typeEn for Sale", 'url' => property_url($tk)];
    if ($area) {
        $crumbs[] = ['name' => 'Dhaka', 'url' => property_url($tk, 'dhaka')];
    }
    $crumbs[] = ['name' => $cityEn];
} else {
    $crumbs[] = ['name' => "$typeEn for Sale"];
}
$firstImg = null;
foreach ($products as $p0) {
    $im0 = json_decode((string) $p0['images'], true) ?: [];
    if ($im0) { $firstImg = asset($im0[0]); break; }
}
$canon = $selfPath . ($pg['page'] > 1 ? '?page=' . $pg['page'] : '');
$head  = seo_meta([
        'title' => $title, 'description' => $descr, 'url' => $canon, 'image' => $firstImg ?: '/assets/og-default.png',
        'prev' => $pg['page'] > 1 ? $selfPath . ($pg['page'] > 2 ? '?page=' . ($pg['page'] - 1) : '') : null,
        'next' => $pg['page'] < $pg['pages'] ? $selfPath . '?page=' . ($pg['page'] + 1) : null,
    ])
    . ld_script(
        ld_breadcrumb($crumbs),
        ['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => $h1En, 'url' => abs_url($canon), 'description' => $descr,
         'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $total, 'itemListElement' => $ldItems]],
        $faqLd
    );

$waText = "Hi SaleBari, I'm looking for " . ($tk === 'land' ? 'land' : 'a ' . $typeLc) . " for sale in $cityEn. My budget is ____ and my preferred size is ____.";
$waLink = 'https://wa.me/' . $wa . '?text=' . urlencode($waText);

site_header(str_replace(' — SaleBari', '', $title), $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?>
      <a href="<?= e(property_url()) ?>">Property for Sale</a><span class="breadcrumb-sep">›</span>
      <?php if ($loc): ?><a href="<?= e(property_url($tk)) ?>"><?= e($typeEn) ?> for Sale</a><span class="breadcrumb-sep">›</span>
        <?php if ($area): ?><a href="<?= e(property_url($tk, 'dhaka')) ?>">Dhaka</a><span class="breadcrumb-sep">›</span><?php endif; ?>
        <span class="breadcrumb-current"><?= e($cityEn) ?></span>
      <?php else: ?><span class="breadcrumb-current"><?= e($typeEn) ?> for Sale</span><?php endif; ?>
    </nav>

    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi($h1En, $h1Bn) ?></h1>
      <p><?= $bi($lead, $leadBn) ?></p>
      <div class="prop-hero-actions">
        <a class="btn btn-primary" href="<?= e($waLink) ?>" target="_blank" rel="noopener"><?= $bi('Tell us what you need', 'আপনার চাহিদা জানান') ?></a>
        <a class="btn btn-ghost" href="<?= base_path() ?>/sell/"><?= $bi('List your property', 'আপনার সম্পত্তি দিন') ?></a>
      </div>
    </div>

    <?php if ($products): ?>
      <p class="listing-page-stat"><?= $total ?> <?= $total === 1 ? 'listing' : 'listings' ?></p>
      <div class="listing-grid catalog-grid">
        <?php foreach ($products as $p) { echo property_card_html($p, $type['icon']); } ?>
      </div>
      <?php if ($pg['pages'] > 1): ?>
        <nav class="stall-detail-pagination catalog-pagination" aria-label="Pagination">
          <?php if ($pg['page'] > 1): ?><a href="<?= e($selfPath . ($pg['page'] > 2 ? '?page=' . ($pg['page'] - 1) : '')) ?>" rel="prev">‹ Previous</a><?php endif; ?>
          <span><?= $pg['page'] ?> / <?= $pg['pages'] ?></span>
          <?php if ($pg['page'] < $pg['pages']): ?><a href="<?= e($selfPath . '?page=' . ($pg['page'] + 1)) ?>" rel="next">Next ›</a><?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php else: ?>
      <div class="prop-empty">
        <p><strong><?= $bi("No $typeLc listings in $cityEn right now.", ($loc ? $loc['bn_in'] : 'বাংলাদেশে') . ' এই মুহূর্তে কোনো ' . $type['bn'] . ' বিজ্ঞাপন নেই।') ?></strong></p>
        <p><?= $bi('Tell us your budget and preferred size on WhatsApp and we will connect you with sellers, or have a look at the other pages below.', 'হোয়াটসঅ্যাপে আপনার বাজেট ও পছন্দের আকার জানান, আমরা বিক্রেতার সাথে যোগাযোগ করিয়ে দেব। অথবা নিচের অন্য পেজগুলো দেখুন।') ?></p>
        <a class="btn btn-primary" href="<?= e($waLink) ?>" target="_blank" rel="noopener"><?= $bi('Message us on WhatsApp', 'হোয়াটসঅ্যাপে মেসেজ করুন') ?></a>
      </div>
    <?php endif; ?>

    <?php if ($area): ?>
      <section class="prop-section">
        <h2><?= $bi("$cityEn at a glance", $area['bn'] . ' এক নজরে') ?></h2>
        <p class="prop-text"><?= $bi($area['blurb'][0], $area['blurb'][1]) ?></p>
        <?= property_attr_table_html([property_place($ck)]) ?>
        <p class="prop-note"><?= $bi('This is a general guide, not a valuation. Prices vary by road, building and time, so compare current listings and visit before you decide.', 'এটি সাধারণ নির্দেশিকা, মূল্যায়ন নয়। রাস্তা, ভবন ও সময়ভেদে দাম বদলায়, তাই বর্তমান তালিকা তুলনা করুন এবং সিদ্ধান্তের আগে নিজে দেখুন।') ?></p>
      </section>
    <?php endif; ?>

    <section class="prop-section">
      <h2><?= $bi(property_fill($type['tips_title'], $loc), property_fill($type['tips_title_bn'], $loc)) ?></h2>
      <ol class="prop-tips">
        <?php foreach ($type['tips'] as $i => $tip): ?>
          <li><?= $bi(property_fill($tip, $loc), property_fill($type['tips_bn'][$i], $loc)) ?></li>
        <?php endforeach; ?>
      </ol>
    </section>

    <?php if ($loc && !$area): ?>
      <section class="prop-section">
        <h2><?= $bi("About $typeLc buying in $cityEn", $loc['bn_in'] . ' ' . $type['bn'] . ' কেনা') ?></h2>
        <p class="prop-text"><?= $bi($loc['blurb'], $loc['blurb_bn']) ?></p>
        <?php if ($ck === 'dhaka'): ?>
          <p class="prop-areas-title"><strong><?= $bi("$typeEn for sale in Dhaka areas", 'ঢাকার এলাকা অনুযায়ী ' . $type['bn'] . ' বিক্রয়') ?></strong></p>
          <?= property_chip_row(property_area_chips($tk)) ?>
        <?php else: ?>
          <p class="prop-areas-title"><strong><?= $bi("Popular areas in $cityEn", $loc['bn'] . '-র জনপ্রিয় এলাকা') ?></strong></p>
          <div class="chip-row"><?php foreach ($loc['areas'] as $a1): ?><span class="chip chip-static"><?= e($a1) ?></span><?php endforeach; ?></div>
        <?php endif; ?>
      </section>
    <?php elseif (!$loc): ?>
      <section class="prop-section">
        <h2><?= $bi("$typeEn for sale by city", 'শহর অনুযায়ী ' . $type['bn'] . ' বিক্রয়') ?></h2>
        <div class="prop-grid">
          <?php foreach ($locs as $c => $l): $n = $cat ? property_listings($cat, $l['district'], 1, 1)['total'] : 0; ?>
            <a class="prop-tile" href="<?= e(property_url($tk, $c)) ?>">
              <strong><?= e($typeEn) ?> for Sale in <?= e($l['name']) ?></strong>
              <small><?= $n > 0 ? $n . ' ' . ($n === 1 ? 'listing' : 'listings') : 'Buying guide and seller contact' ?></small>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <section class="prop-section prop-faq">
      <h2><?= $bi('Frequently asked questions', 'সাধারণ প্রশ্ন ও উত্তর') ?></h2>
      <?php foreach ($faq as $f): ?>
        <details>
          <summary><?= $bi($f[0], $f[2]) ?></summary>
          <p><?= $bi($f[1], $f[3]) ?></p>
        </details>
      <?php endforeach; ?>
    </section>

    <?php /* ---- internal links: sideways (other places), down (areas, sizes), across (compare) ---- */ ?>
    <section class="catalog-seo">
      <?php if ($area): ?>
        <h2 class="catalog-subheading"><?= e($area['name']) ?> compared with other areas</h2>
        <?= property_chip_row(property_compare_chips($ck)) ?>
        <h2 class="catalog-subheading">Also in <?= e($area['name']) ?></h2>
        <?php
          $same = [];
          foreach ($types as $k => $t) { if ($k !== $tk && in_array($k, $area['types'], true)) { $same[] = [property_url($k, $ck), $t['en'] . ' for Sale in ' . $area['name']]; } }
          $same[] = [property_url($tk, 'dhaka'), $typeEn . ' for Sale in Dhaka (all areas)'];
        ?>
        <?= property_chip_row($same) ?>
        <h2 class="catalog-subheading">Nearby areas</h2>
        <?php $near = []; foreach ($area['neighbors'] as $nb) { if (isset($areas[$nb]) && in_array($tk, $areas[$nb]['types'], true)) { $near[] = [property_url($tk, $nb), $typeEn . ' for Sale in ' . $areas[$nb]['name']]; } } ?>
        <?= property_chip_row($near) ?>
      <?php else: ?>
        <?php if ($loc): ?>
          <h2 class="catalog-subheading"><?= e($typeEn) ?> for sale in other cities</h2>
          <div class="chip-row">
            <?php foreach ($locs as $c => $l): if ($c === $ck) continue; ?><a class="chip" href="<?= e(property_url($tk, $c)) ?>"><?= e($typeEn) ?> for Sale in <?= e($l['name']) ?></a><?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if (!$loc || $ck === 'dhaka'): ?>
          <h2 class="catalog-subheading"><?= e($typeEn) ?> for sale in Dhaka areas</h2>
          <?= property_chip_row(property_area_chips($tk)) ?>
        <?php endif; ?>
        <?php if ($ck === 'dhaka' || $ck === 'chittagong' || $ck === 'feni'): ?>
          <h2 class="catalog-subheading">Compare <?= e($cityEn) ?> with other places</h2>
          <?= property_chip_row(property_compare_chips($ck)) ?>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ($tk === 'flat' || $tk === 'apartment'): ?>
        <h2 class="catalog-subheading">Flats by size</h2>
        <?= property_chip_row(property_size_chips('flat')) ?>
      <?php else: ?>
        <h2 class="catalog-subheading">Land and plots by size</h2>
        <?= property_chip_row(property_size_chips('land')) ?>
      <?php endif; ?>

      <h2 class="catalog-subheading">Buying guides and tools</h2>
      <?= property_chip_row(guide_all_chips()) ?>
      <h2 class="catalog-subheading">More property<?= $loc ? ' in ' . e($cityEn) : '' ?></h2>
      <div class="chip-row">
        <?php foreach ($types as $k => $t): if ($k === $tk || ($area && !in_array($k, $area['types'], true))) continue; ?><a class="chip" href="<?= e(property_url($k, $ck ?: null)) ?>"><?= e($t['en']) ?> for Sale<?= $loc ? ' in ' . e($cityEn) : '' ?></a><?php endforeach; ?>
        <a class="chip" href="<?= e(property_url()) ?>">All property for sale</a>
        <?php if ($realEstate): ?><a class="chip" href="<?= e(category_url($realEstate)) ?>">All Real Estate</a><?php endif; ?>
      </div>
    </section>
  </div>
</section>
<?php
$trackItems = [];
foreach ($products as $i => $p) {
    $trackItems[] = ['item_id' => (string) $p['id'], 'item_name' => $p['title_en'], 'item_category' => $typeEn, 'price' => track_price($p['price_display']), 'index' => $i + 1];
}
ob_start();
echo track_page_script(['type' => 'category', 'list_name' => "$typeEn for Sale" . ($loc ? " / $cityEn" : ''), 'items' => $trackItems]);
site_footer(ob_get_clean());
