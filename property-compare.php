<?php
/* Location comparisons:  /compare-locations/   and   /compare-locations/gulshan-vs-dhanmondi/
   Side-by-side, qualitative guidance from app/property_data.php; the only numbers are live listing counts.  */
require __DIR__ . '/app/bootstrap.php';

$pairs = property_compare_pairs();
$a = strtolower((string) input('a', ''));
$b = strtolower((string) input('b', ''));
$year = date('Y');
$bi = 'property_bi';
$wa = site_numbers()[0]['wa'];
$realEstate = find_category_by_path(['real-estate']);

$crumbs = [['name' => 'Home', 'url' => base_path() . '/']];
if ($realEstate) { $crumbs[] = ['name' => 'Real Estate', 'url' => category_url($realEstate)]; }
$crumbs[] = ['name' => 'Property for Sale', 'url' => property_url()];

/* =====================  index: /compare-locations/  ===================== */
if ($a === '' && $b === '') {
    $selfPath = property_compare_url();
    $reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if ($reqPath !== $selfPath) { header('Location: ' . $selfPath, true, 301); exit; }
    $title = "Compare Dhaka Areas and Cities for Buying Property $year — SaleBari";
    $descr = "Gulshan vs Dhanmondi, Uttara vs Bashundhara, Dhaka vs Chittagong vs Feni and more: side-by-side guides to help you choose where to buy a flat or plot.";
    $head  = seo_meta(['title' => $title, 'description' => $descr, 'url' => $selfPath])
           . ld_script(ld_breadcrumb(array_merge($crumbs, [['name' => 'Compare locations']])));
    site_header(str_replace(' — SaleBari', '', $title), $head, false);
    $areaPairs = array_filter($pairs, function ($p) { return property_place($p[0])['kind'] === 'area'; });
    $cityPairs = array_filter($pairs, function ($p) { return property_place($p[0])['kind'] === 'city'; });
    ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?><a href="<?= e(property_url()) ?>">Property for Sale</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Compare locations</span></nav>
    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi('Compare locations before you buy', 'কেনার আগে জায়গা তুলনা করুন') ?></h1>
      <p><?= $bi('Pick two places and see them side by side on the feel of the area, typical homes, plots, getting around and everyday facilities. These are general guides, not valuations: compare current listings and visit before you decide.', 'দুটি জায়গা বেছে এলাকার ধরন, সাধারণ বাসা, প্লট, যাতায়াত ও দৈনন্দিন সুবিধা পাশাপাশি দেখুন। এগুলো সাধারণ নির্দেশিকা, মূল্যায়ন নয়: বর্তমান তালিকা তুলনা করুন এবং সিদ্ধান্তের আগে নিজে দেখুন।') ?></p>
    </div>
    <section class="prop-section">
      <h2><?= $bi('Dhaka areas', 'ঢাকার এলাকা') ?></h2>
      <div class="prop-grid">
        <?php foreach ($areaPairs as [$x, $y]): $px = property_place($x); $py = property_place($y); ?>
          <a class="prop-tile" href="<?= e(property_compare_url($x, $y)) ?>"><strong><?= e($px['name']) ?> vs <?= e($py['name']) ?></strong><small><?= e($px['attrs']['character'][0]) ?> · <?= e($py['attrs']['character'][0]) ?></small></a>
        <?php endforeach; ?>
      </div>
    </section>
    <section class="prop-section">
      <h2><?= $bi('Cities', 'শহর') ?></h2>
      <div class="prop-grid">
        <?php foreach ($cityPairs as [$x, $y]): $px = property_place($x); $py = property_place($y); ?>
          <a class="prop-tile" href="<?= e(property_compare_url($x, $y)) ?>"><strong><?= e($px['name']) ?> vs <?= e($py['name']) ?></strong><small>Property market and lifestyle</small></a>
        <?php endforeach; ?>
      </div>
    </section>
    <section class="catalog-seo">
      <h2 class="catalog-subheading">Browse listings</h2>
      <?= property_chip_row([[property_url('flat', 'dhaka'), 'Flat for Sale in Dhaka'], [property_url('apartment', 'dhaka'), 'Apartment for Sale in Dhaka'], [property_url('land', 'dhaka'), 'Land for Sale in Dhaka'], [property_url('flat', 'chittagong'), 'Flat for Sale in Chittagong'], [property_url('flat', 'feni'), 'Flat for Sale in Feni'], [property_url('land', 'feni'), 'Land for Sale in Feni']]) ?>
      <p class="catalog-back">← <a href="<?= e(property_url()) ?>">All property for sale</a></p>
    </section>
  </div>
</section>
<?php
    ob_start();
    echo track_page_script(['type' => 'category', 'list_name' => 'Compare locations', 'items' => []]);
    site_footer(ob_get_clean());
    exit;
}

/* =====================  one comparison  ===================== */
$canonical = null;
foreach ($pairs as [$x, $y]) {
    if (($x === $a && $y === $b) || ($x === $b && $y === $a)) { $canonical = [$x, $y]; break; }
}
if (!$canonical) {
    require __DIR__ . '/404.php';
    exit;
}
[$a, $b] = $canonical;
$selfPath = property_compare_url($a, $b);
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if ($reqPath !== $selfPath) { header('Location: ' . $selfPath, true, 301); exit; }

$A = property_place($a);
$B = property_place($b);
$cityPair = $A['kind'] === 'city';
$h1En  = "{$A['name']} vs {$B['name']}: Which Is Better for Buying " . ($cityPair ? 'Property' : 'a Flat') . '?';
$h1Bn  = "{$A['bn']} বনাম {$B['bn']}: " . ($cityPair ? 'সম্পত্তি' : 'ফ্ল্যাট') . ' কেনার জন্য কোনটি ভালো?';
$title = "{$A['name']} vs {$B['name']} for Buying " . ($cityPair ? 'Property' : 'a Flat') . " ($year) — SaleBari";
$descr = "{$A['name']} or {$B['name']}? Compare the two side by side on the feel of the area, typical homes, plots, getting around and everyday life, then browse listings in both.";

$intro   = "Choosing between {$A['name']} and {$B['name']}? This page compares them side by side on the feel of the area, typical homes, plots, getting around and everyday facilities, so you can shortlist before you look at listings.";
$introBn = "{$A['bn']} নাকি {$B['bn']}, কোনটি বেছে নেবেন? এলাকার ধরন, সাধারণ বাসা, প্লট, যাতায়াত ও দৈনন্দিন সুবিধার ভিত্তিতে দুটি পাশাপাশি তুলনা করা হয়েছে, যাতে তালিকা দেখার আগেই বাছাই করতে পারেন।";

/* price level sentence (areas only) */
$tierLine = null;
if (!$cityPair && $A['tier'] && $B['tier']) {
    $tl = property_tier_labels();
    if ($A['tier'] === $B['tier']) {
        $tierLine = ["{$A['name']} and {$B['name']} generally sit in a similar price bracket ({$tl[$A['tier']][0]}). Compare the price per square foot of current listings to see the real gap.",
                     "{$A['bn']} ও {$B['bn']} সাধারণভাবে একই দামের স্তরে ({$tl[$A['tier']][1]})। প্রকৃত ব্যবধান দেখতে বর্তমান তালিকার বর্গফুট প্রতি দাম তুলনা করুন।"];
    } else {
        [$hi, $lo] = $A['tier'] > $B['tier'] ? [$A, $B] : [$B, $A];
        $tierLine = ["{$hi['name']} generally sits in a higher price bracket than {$lo['name']} ({$tl[$hi['tier']][0]} versus {$tl[$lo['tier']][0]}). This is a general pattern, so compare the price per square foot of current listings.",
                     "{$hi['bn']} সাধারণভাবে {$lo['bn']}-এর চেয়ে উচ্চ দামের স্তরে ({$tl[$hi['tier']][1]} বনাম {$tl[$lo['tier']][1]})। এটি সাধারণ ধারা, তাই বর্তমান তালিকার বর্গফুট প্রতি দাম তুলনা করুন।"];
    }
}

/* real listing counts */
$flatCat = property_category('flat');
$landCat = property_category('land');
$count = function (array $pl, ?array $cat) {
    if (!$cat) { return 0; }
    if ($pl['kind'] === 'area') { return property_listings($cat, 'dhaka', 1, 1, ['area' => $pl['slug']])['total']; }
    return property_listings($cat, property_locations()[$pl['slug']]['district'], 1, 1)['total'];
};

$faq = [
    ["Is {$A['name']} or {$B['name']} better for families?", "It depends on what the family needs. {$A['name']} suits: " . lcfirst($A['attrs']['best'][0]) . ". {$B['name']} suits: " . lcfirst($B['attrs']['best'][0]) . '.',
     "পরিবারের জন্য {$A['bn']} নাকি {$B['bn']} ভালো?", "পরিবারের প্রয়োজনের ওপর নির্ভর করে। {$A['bn']} উপযোগী: {$A['attrs']['best'][1]}। {$B['bn']} উপযোগী: {$B['attrs']['best'][1]}।"],
    ["Which has more plots, {$A['name']} or {$B['name']}?", "{$A['name']}: {$A['attrs']['land'][0]}. {$B['name']}: {$B['attrs']['land'][0]}.",
     "প্লট কোথায় বেশি, {$A['bn']} নাকি {$B['bn']}?", "{$A['bn']}: {$A['attrs']['land'][1]}। {$B['bn']}: {$B['attrs']['land'][1]}।"],
    ["How should I decide between {$A['name']} and {$B['name']}?", "Visit both at different times of day, test the trip to your work or school, compare the price per square foot of current listings, and verify the documents of anything you shortlist before you pay.",
     "{$A['bn']} ও {$B['bn']}-এর মধ্যে কীভাবে ঠিক করব?", "দুই জায়গাতেই দিনের আলাদা সময়ে যান, কর্মস্থল বা স্কুলে যাওয়ার পথ পরীক্ষা করুন, বর্তমান তালিকার বর্গফুট প্রতি দাম তুলনা করুন এবং টাকা দেওয়ার আগে বাছাই করা সম্পত্তির কাগজ যাচাই করুন।"],
];
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(function ($f) {
    return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
}, $faq)];

$crumbs[] = ['name' => 'Compare locations', 'url' => property_compare_url()];
$crumbs[] = ['name' => "{$A['name']} vs {$B['name']}"];
$head = seo_meta(['title' => $title, 'description' => $descr, 'url' => $selfPath]) . ld_script(ld_breadcrumb($crumbs), $faqLd);

$waLink = 'https://wa.me/' . $wa . '?text=' . urlencode("Hi SaleBari, I'm deciding between {$A['name']} and {$B['name']}. My budget is ____ and I need ____ bedrooms.");

/* other comparisons that involve either place */
$more = [];
foreach (array_merge(property_compare_pairs_for($a), property_compare_pairs_for($b)) as [$x, $y]) {
    if (!($x === $a && $y === $b)) {
        $more[$x . '|' . $y] = [property_compare_url($x, $y), property_place($x)['name'] . ' vs ' . property_place($y)['name']];
    }
}

site_header(str_replace(' — SaleBari', '', $title), $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?>
      <a href="<?= e(property_url()) ?>">Property for Sale</a><span class="breadcrumb-sep">›</span>
      <a href="<?= e(property_compare_url()) ?>">Compare locations</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($A['name']) ?> vs <?= e($B['name']) ?></span>
    </nav>

    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi($h1En, $h1Bn) ?></h1>
      <p><?= $bi($intro, $introBn) ?></p>
      <div class="prop-hero-actions">
        <a class="btn btn-primary" href="<?= e($waLink) ?>" target="_blank" rel="noopener"><?= $bi('Ask us to help you choose', 'বেছে নিতে আমাদের সাহায্য নিন') ?></a>
      </div>
    </div>

    <section class="prop-section prop-wide">
      <h2><?= $bi('Side by side', 'পাশাপাশি তুলনা') ?></h2>
      <?= property_attr_table_html([$A, $B]) ?>
      <?php if ($tierLine): ?><p class="prop-text"><?= $bi($tierLine[0], $tierLine[1]) ?></p><?php endif; ?>
      <p class="prop-note"><?= $bi('This is a general guide, not a valuation. Prices and conditions change, so compare current listings and visit before you decide.', 'এটি সাধারণ নির্দেশিকা, মূল্যায়ন নয়। দাম ও পরিস্থিতি বদলায়, তাই বর্তমান তালিকা তুলনা করুন এবং সিদ্ধান্তের আগে নিজে দেখুন।') ?></p>
    </section>

    <section class="prop-section">
      <h2><?= $bi('Which one suits you?', 'কোনটি আপনার জন্য?') ?></h2>
      <div class="prop-grid prop-grid-2">
        <?php foreach ([$A, $B] as $pl): ?>
          <div class="prop-tile prop-tile-static">
            <strong><?= $bi($pl['name'] . ' suits', $pl['bn'] . ' উপযোগী') ?></strong>
            <span><?= $bi($pl['attrs']['best'][0], $pl['attrs']['best'][1]) ?></span>
            <small><?= $bi('Keep in mind: ' . $pl['attrs']['watch'][0], 'মনে রাখুন: ' . $pl['attrs']['watch'][1]) ?></small>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="prop-section">
      <h2><?= $bi('On SaleBari right now', 'এখন SaleBari-তে') ?></h2>
      <div class="prop-table-wrap"><table class="prop-table">
        <thead><tr><th></th><th><?= $bi('Flats and apartments', 'ফ্ল্যাট ও অ্যাপার্টমেন্ট') ?></th><th><?= $bi('Land and plots', 'জমি ও প্লট') ?></th></tr></thead>
        <tbody>
          <?php foreach ([$A, $B] as $pl): $nf = $count($pl, $flatCat); $nl = $count($pl, $landCat);
              $landOk = $pl['kind'] === 'city' || in_array('land', $pl['types'] ?? [], true); ?>
            <tr>
              <th scope="row"><?= e($pl['name']) ?></th>
              <td><a href="<?= e(property_url('flat', $pl['slug'])) ?>"><?= $nf > 0 ? $nf . ($nf === 1 ? ' listing' : ' listings') : 'View guide' ?></a></td>
              <td><?php if ($landOk): ?><a href="<?= e(property_url('land', $pl['slug'])) ?>"><?= $nl > 0 ? $nl . ($nl === 1 ? ' listing' : ' listings') : 'View guide' ?></a><?php else: ?>—<?php endif; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table></div>
    </section>

    <section class="prop-section prop-faq">
      <h2><?= $bi('Frequently asked questions', 'সাধারণ প্রশ্ন ও উত্তর') ?></h2>
      <?php foreach ($faq as $f): ?>
        <details><summary><?= $bi($f[0], $f[2]) ?></summary><p><?= $bi($f[1], $f[3]) ?></p></details>
      <?php endforeach; ?>
    </section>

    <section class="catalog-seo">
      <?php foreach ([$A, $B] as $pl):
          $chips = [];
          foreach (property_types() as $tk => $t) {
              if ($pl['kind'] === 'city' || in_array($tk, $pl['types'], true)) { $chips[] = [property_url($tk, $pl['slug']), $t['en'] . ' for Sale in ' . $pl['name']]; }
          } ?>
        <h2 class="catalog-subheading">Browse <?= e($pl['name']) ?></h2>
        <?= property_chip_row($chips) ?>
      <?php endforeach; ?>
      <?php if (!$cityPair): ?>
        <h2 class="catalog-subheading">Both are in Dhaka</h2>
        <?= property_chip_row([[property_url('flat', 'dhaka'), 'Flat for Sale in Dhaka'], [property_url('apartment', 'dhaka'), 'Apartment for Sale in Dhaka'], [property_url('land', 'dhaka'), 'Land for Sale in Dhaka']]) ?>
      <?php endif; ?>
      <h2 class="catalog-subheading">Other comparisons</h2>
      <?= property_chip_row(array_values($more)) ?>
      <h2 class="catalog-subheading">Flats by size</h2>
      <?= property_chip_row(property_size_chips('flat')) ?>
      <h2 class="catalog-subheading">Buying guides and tools</h2>
      <?= property_chip_row(guide_all_chips()) ?>
      <p class="catalog-back">← <a href="<?= e(property_compare_url()) ?>">All comparisons</a> · <a href="<?= e(property_url()) ?>">All property for sale</a></p>
    </section>
  </div>
</section>
<?php
ob_start();
echo track_page_script(['type' => 'category', 'list_name' => "{$A['name']} vs {$B['name']}", 'items' => []]);
site_footer(ob_get_clean());
