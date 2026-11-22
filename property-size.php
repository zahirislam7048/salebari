<?php
/* Size pages:  /flat-for-sale-under-1000-sqft/   /3-bedroom-flat-for-sale/   /5-katha-plot-for-sale/
   Listings are matched on the size and bedrooms entered in Admin -> Products.  See app/property_data.php. */
require __DIR__ . '/app/bootstrap.php';

$sizes = property_sizes();
$slug  = strtolower((string) input('s', ''));
if (!isset($sizes[$slug])) {
    require __DIR__ . '/404.php';
    exit;
}
$sz    = $sizes[$slug];
$tk    = $sz['type'];
$type  = property_types()[$tk];
$isLand = $sz['kind'] === 'land';
$isBed  = $sz['kind'] === 'flat_bed';
$year  = date('Y');
$wa    = site_numbers()[0]['wa'];
$bi    = 'property_bi';

$selfPath = property_size_url($slug);
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && $reqPath !== $selfPath) {
    header('Location: ' . $selfPath . (isset($_GET['page']) && (int) $_GET['page'] > 1 ? '?page=' . (int) $_GET['page'] : ''), true, 301);
    exit;
}

function size_opts(array $s): array
{
    if ($s['kind'] === 'flat_bed') {
        return ['bed' => $s['bed'], 'bed_min' => $s['bed_min']];
    }
    return ['min' => $s['min'], 'max' => $s['max']];
}

$cat      = property_category($tk);
$result   = $cat ? property_listings($cat, null, 12, input_int('page', 1), size_opts($sz)) : ['rows' => [], 'total' => 0, 'pg' => paginate(0, 12, 1)];
$products = $result['rows'];
$total    = $result['total'];
$pg       = $result['pg'];

$h1En = $sz['h1'];
$h1Bn = $sz['h1_bn'];
$title = $h1En . " $year — SaleBari";
if ($pg['page'] > 1) {
    $title = str_replace(' — SaleBari', ' — Page ' . $pg['page'] . ' — SaleBari', $title);
}
$descr = $total > 0
    ? "Browse $total " . ($isLand ? 'land' : 'flat') . ' ' . ($total === 1 ? 'listing' : 'listings') . " of this size on SaleBari: {$sz['short']}. Compare prices and message the seller on WhatsApp. Updated $year."
    : "{$h1En}: what the size means, how to judge a fair price and what to check before you buy, with links to listings in Dhaka, Chittagong and Feni.";

$plural   = $isLand ? 'land and plots' : 'flats';
$plural_bn = $isLand ? 'জমি ও প্লট' : 'ফ্ল্যাট';
$lead   = "Browse $plural for sale in this size: {$sz['short']}. Compare asking prices, check the layout and message the seller directly on WhatsApp or by phone.";
$leadBn = "এই আকারের $plural_bn দেখুন: {$sz['short_bn']}। দাম তুলনা করুন, নকশা দেখুন এবং সরাসরি হোয়াটসঅ্যাপ বা ফোনে বিক্রেতার সাথে কথা বলুন।";

/* what to look at, and answers */
if ($isLand) {
    $tips = [
        ['Check the size on the deed and the khatian, and note which unit it uses: katha, decimal (shotok) or bigha. Katha and bigha differ from region to region, so confirm the local measure.', 'দলিল ও খতিয়ানে আকার দেখুন এবং কোন একক (কাঠা, শতক বা বিঘা) ব্যবহার হয়েছে লক্ষ করুন। কাঠা ও বিঘার মাপ অঞ্চলভেদে আলাদা, তাই স্থানীয় মাপ নিশ্চিত করুন।'],
        ['Divide the asking price by the area in one common unit (for example per katha or per decimal) to compare plots fairly.', 'দামকে একটি সাধারণ এককে (যেমন কাঠা বা শতক প্রতি) ভাগ করে প্লটগুলো সঠিকভাবে তুলনা করুন।'],
        ['Have a surveyor measure the plot, and check the boundary, the road width and the access to it.', 'সার্ভেয়ার দিয়ে প্লট মাপান এবং সীমানা, রাস্তার প্রস্থ ও যাতায়াত দেখুন।'],
        ['What you may build depends on the plot size, the road and the rules of the local authority, so ask them before you plan a building.', 'কী বানানো যাবে তা প্লটের আকার, রাস্তা ও স্থানীয় কর্তৃপক্ষের নিয়মের ওপর নির্ভর করে, তাই নকশা করার আগে তাদের জিজ্ঞাসা করুন।'],
    ];
    $faq = [
        ["How big is a {$sz['short']} plot?", "Using the common Dhaka measure (1 katha = 720 sqft), {$sz['short']} is about " . number_format($sz['katha'] * 720) . ' sqft. Katha and bigha differ by region, so check the unit and measure on the deed.',
         "{$sz['short_bn']} প্লট কত বড়?", 'ঢাকার প্রচলিত মাপে (১ কাঠা = ৭২০ বর্গফুট) ' . $sz['short_bn'] . ' প্রায় ' . number_format($sz['katha'] * 720) . ' বর্গফুট। কাঠা ও বিঘার মাপ অঞ্চলভেদে আলাদা, তাই দলিলে একক ও মাপ দেখুন।'],
        ["Can I build on any plot of this size?", "Not always. It depends on the land class, the road, and the rules of the authority (for example RAJUK in Dhaka or CDA in Chittagong). Agricultural land, for instance, can have limits on building.", "এই আকারের যেকোনো প্লটে কি বাড়ি করা যায়?", "সবসময় নয়। জমির শ্রেণি, রাস্তা ও কর্তৃপক্ষের নিয়মের (যেমন ঢাকায় রাজউক বা চট্টগ্রামে সিডিএ) ওপর নির্ভর করে। যেমন কৃষিজমিতে নির্মাণে বিধিনিষেধ থাকতে পারে।"],
    ];
} else {
    $tips = [
        ['Ask whether the area on the listing is net (carpet) or super built-up, since the same flat can be quoted either way.', 'বিজ্ঞাপনের আকার নিট (কার্পেট) না সুপার বিল্ট-আপ জিজ্ঞাসা করুন, কারণ একই ফ্ল্যাট দুভাবেই বলা হতে পারে।'],
        ['Work out the price per square foot (price ÷ area). For example, 90 lakh for 1,200 sqft is about ৳7,500 per sqft. Compare that figure across flats.', 'বর্গফুট প্রতি দাম বের করুন (দাম ÷ আকার)। যেমন ১,২০০ বর্গফুটের জন্য ৯০ লাখ টাকা হলে বর্গফুট প্রতি প্রায় ৭,৫০০ টাকা। এই অঙ্ক ধরে ফ্ল্যাটগুলো তুলনা করুন।'],
        ['Look at the layout, not just the size: room shapes, natural light, ventilation, the balcony and how the doors open.', 'শুধু আকার নয়, নকশাও দেখুন: ঘরের আকৃতি, আলো-বাতাস, বারান্দা ও দরজা কোনদিকে খোলে।'],
        ['Ask about extra costs: parking, utility connections, registration and any service charge.', 'বাড়তি খরচ জিজ্ঞাসা করুন: পার্কিং, ইউটিলিটি সংযোগ, রেজিস্ট্রেশন ও সার্ভিস চার্জ।'],
    ];
    $faq = [
        ['How do I compare flats of different sizes?', 'Divide each flat\'s price by its area to get the price per square foot, then compare that figure. Also compare the floor, the direction it faces, the age of the building and the facilities.', 'আলাদা আকারের ফ্ল্যাট কীভাবে তুলনা করব?', 'প্রতিটি ফ্ল্যাটের দামকে আকারে ভাগ করে বর্গফুট প্রতি দাম বের করে তা তুলনা করুন। সাথে ফ্লোর, দিক, ভবনের বয়স ও সুবিধাও মিলিয়ে দেখুন।'],
        ['What is the difference between net and super built-up area?', 'Net (carpet) area is the space inside the walls. Super built-up area adds a share of walls, stairs, lifts and common areas, so it is larger. Always ask which one a price is based on.', 'নিট ও সুপার বিল্ট-আপ এরিয়ার পার্থক্য কী?', 'নিট (কার্পেট) এরিয়া দেয়ালের ভেতরের জায়গা। সুপার বিল্ট-আপে দেয়াল, সিঁড়ি, লিফট ও কমন এলাকার অংশ যোগ হয়, তাই তা বড় হয়। দাম কোনটির ভিত্তিতে তা সবসময় জিজ্ঞাসা করুন।'],
    ];
}
foreach (property_common_faq() as $f) {
    $faq[] = $f;
}
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(function ($f) {
    return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
}, $faq)];

$realEstate = find_category_by_path(['real-estate']);
$crumbs = [['name' => 'Home', 'url' => base_path() . '/']];
if ($realEstate) { $crumbs[] = ['name' => 'Real Estate', 'url' => category_url($realEstate)]; }
$crumbs[] = ['name' => 'Property for Sale', 'url' => property_url()];
$crumbs[] = ['name' => $type['en'] . ' for Sale', 'url' => property_url($tk)];
$crumbs[] = ['name' => $sz['short']];

$ldItems = [];
foreach ($products as $i => $p0) {
    $ldItems[] = ['@type' => 'ListItem', 'position' => $pg['offset'] + $i + 1, 'url' => abs_url(product_url($p0)), 'name' => $p0['title_en']];
}
$canon = $selfPath . ($pg['page'] > 1 ? '?page=' . $pg['page'] : '');
$head = seo_meta([
        'title' => $title, 'description' => $descr, 'url' => $canon,
        'prev' => $pg['page'] > 1 ? $selfPath . ($pg['page'] > 2 ? '?page=' . ($pg['page'] - 1) : '') : null,
        'next' => $pg['page'] < $pg['pages'] ? $selfPath . '?page=' . ($pg['page'] + 1) : null,
    ])
    . ld_script(ld_breadcrumb($crumbs),
        ['@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => $h1En, 'url' => abs_url($canon), 'description' => $descr,
         'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => $total, 'itemListElement' => $ldItems]],
        $faqLd);

$waLink = 'https://wa.me/' . $wa . '?text=' . urlencode("Hi SaleBari, I'm looking for " . strtolower($h1En) . ". My budget is ____ and my preferred area is ____.");
$group = property_sizes_of($tk);

site_header(str_replace(' — SaleBari', '', $title), $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?>
      <a href="<?= e(property_url()) ?>">Property for Sale</a><span class="breadcrumb-sep">›</span>
      <a href="<?= e(property_url($tk)) ?>"><?= e($type['en']) ?> for Sale</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($sz['short']) ?></span>
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
        <p><strong><?= $bi("No listings in this size right now.", 'এই আকারে এই মুহূর্তে কোনো বিজ্ঞাপন নেই।') ?></strong></p>
        <p><?= $bi('Tell us your budget and preferred area on WhatsApp and we will connect you with sellers, or look at the other sizes and places below.', 'হোয়াটসঅ্যাপে আপনার বাজেট ও পছন্দের এলাকা জানান, আমরা বিক্রেতার সাথে যোগাযোগ করিয়ে দেব। অথবা নিচের অন্য আকার ও জায়গা দেখুন।') ?></p>
        <a class="btn btn-primary" href="<?= e($waLink) ?>" target="_blank" rel="noopener"><?= $bi('Message us on WhatsApp', 'হোয়াটসঅ্যাপে মেসেজ করুন') ?></a>
      </div>
    <?php endif; ?>

    <section class="prop-section">
      <h2><?= $bi('Who this size suits', 'এই আকার কাদের জন্য') ?></h2>
      <p class="prop-text"><?= $bi($sz['fit'][0], $sz['fit'][1]) ?></p>
      <p class="prop-text"><strong><?= $bi('Typical size:', 'সাধারণ আকার:') ?></strong> <?= $bi($sz['typical'][0], $sz['typical'][1]) ?>. <?= $bi('These are rough guides, not rules. Layouts and measuring methods vary from building to building.', 'এগুলো মোটামুটি ধারণা, নিয়ম নয়। ভবনভেদে নকশা ও মাপার পদ্ধতি আলাদা হয়।') ?></p>
    </section>

    <section class="prop-section">
      <h2><?= $bi('How to judge this size', 'এই আকার কীভাবে যাচাই করবেন') ?></h2>
      <ol class="prop-tips">
        <?php foreach ($tips as $t): ?><li><?= $bi($t[0], $t[1]) ?></li><?php endforeach; ?>
      </ol>
    </section>

    <?php if ($isLand): ?>
      <section class="prop-section">
        <h2><?= $bi('Land size converter', 'জমির মাপ রূপান্তর') ?></h2>
        <div class="prop-table-wrap"><table class="prop-table prop-table-narrow">
          <thead><tr><th><?= $bi('Unit', 'একক') ?></th><th><?= $bi('In square feet', 'বর্গফুটে') ?></th><th><?= $bi('In katha', 'কাঠায়') ?></th></tr></thead>
          <tbody>
            <tr><td>1 <?= $bi('katha', 'কাঠা') ?></td><td>720</td><td>1</td></tr>
            <tr><td>1 <?= $bi('decimal (shotok)', 'শতক') ?></td><td>435.6</td><td>≈ 0.6</td></tr>
            <tr><td>1 <?= $bi('bigha', 'বিঘা') ?></td><td>14,400</td><td>20</td></tr>
            <tr><td>1 <?= $bi('acre', 'একর') ?> (100 <?= $bi('decimal', 'শতক') ?>)</td><td>43,560</td><td>≈ 60.5</td></tr>
          </tbody>
        </table></div>
        <p class="prop-note"><?= $bi('These are the standard measures used in Dhaka. Katha and bigha can differ in other regions, so always confirm the measure written on the deed.', 'এগুলো ঢাকায় প্রচলিত মাপ। অন্য অঞ্চলে কাঠা ও বিঘার মাপ আলাদা হতে পারে, তাই দলিলে লেখা মাপ সবসময় নিশ্চিত করুন।') ?></p>
      </section>
    <?php endif; ?>

    <section class="prop-section">
      <h2><?= $bi('Compare with other sizes', 'অন্য আকারের সাথে তুলনা') ?></h2>
      <div class="prop-table-wrap"><table class="prop-table">
        <thead><tr><th><?= $bi('Size', 'আকার') ?></th><th><?= $bi('Usually fits', 'সাধারণত মানায়') ?></th><th><?= $bi('Listings', 'বিজ্ঞাপন') ?></th></tr></thead>
        <tbody>
          <?php foreach ($group as $gs => $g): $n = $cat ? property_listings($cat, null, 1, 1, size_opts($g))['total'] : 0; ?>
            <tr<?= $gs === $slug ? ' class="is-current"' : '' ?>>
              <td><a href="<?= e(property_size_url($gs)) ?>"><?= e($g['h1']) ?></a></td>
              <td><?= $bi($g['typical'][0], $g['typical'][1]) ?></td>
              <td><?= $n > 0 ? $n : '—' ?></td>
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
      <h2 class="catalog-subheading"><?= e($type['en']) ?> for sale by city</h2>
      <?php $cc = []; foreach (property_locations() as $c => $l) { $cc[] = [property_url($tk, $c), $type['en'] . ' for Sale in ' . $l['name']]; } ?>
      <?= property_chip_row($cc) ?>
      <h2 class="catalog-subheading"><?= e($type['en']) ?> for sale in Dhaka areas</h2>
      <?= property_chip_row(property_area_chips($tk)) ?>
      <h2 class="catalog-subheading">Other <?= $isLand ? 'plot' : 'flat' ?> sizes</h2>
      <?= property_chip_row(property_size_chips($tk, $slug)) ?>
      <?php if (!$isLand): ?>
        <h2 class="catalog-subheading">Not sure where? Compare locations</h2>
        <?= property_chip_row(property_compare_chips(null, 8)) ?>
      <?php endif; ?>
      <p class="catalog-back">← <a href="<?= e(property_url()) ?>">All property for sale</a><?php if ($realEstate): ?> · <a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><?php endif; ?></p>
    </section>
  </div>
</section>
<?php
ob_start();
$trackItems = [];
foreach ($products as $i => $p) {
    $trackItems[] = ['item_id' => (string) $p['id'], 'item_name' => $p['title_en'], 'item_category' => $type['en'], 'price' => track_price($p['price_display']), 'index' => $i + 1];
}
echo track_page_script(['type' => 'category', 'list_name' => $h1En, 'items' => $trackItems]);
site_footer(ob_get_clean());
