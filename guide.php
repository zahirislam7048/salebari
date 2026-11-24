<?php
/* Buying guides:  /guides/   and   /guides/<slug>/   — content and links come from app/guide_data.php */
require __DIR__ . '/app/bootstrap.php';

$guides = guide_pages();
$tools  = guide_tools();
$slug   = strtolower((string) input('g', ''));
$bi     = 'property_bi';
$year   = date('Y');
$realEstate = find_category_by_path(['real-estate']);
$updated = date('j F Y', max((int) filemtime(__DIR__ . '/app/guide_data.php'), 0));
$updatedIso = date('Y-m-d', (int) filemtime(__DIR__ . '/app/guide_data.php'));

$crumbs = [['name' => 'Home', 'url' => base_path() . '/']];
if ($realEstate) { $crumbs[] = ['name' => 'Real Estate', 'url' => category_url($realEstate)]; }
$crumbs[] = ['name' => 'Buying guides', 'url' => guide_url()];

$disclaimer = ['This page is general information, not legal or financial advice. Rules, fees and rates change, so confirm the current position with the relevant authority, your bank or a lawyer.',
               'এই পেজ সাধারণ তথ্য, আইনি বা আর্থিক পরামর্শ নয়। নিয়ম, ফি ও হার বদলায়, তাই বর্তমান অবস্থা সংশ্লিষ্ট কর্তৃপক্ষ, আপনার ব্যাংক বা আইনজীবীর কাছে নিশ্চিত করুন।'];

/* =====================  hub: /guides/  ===================== */
if ($slug === '') {
    $selfPath = guide_url();
    $reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if ($reqPath !== $selfPath) { header('Location: ' . $selfPath, true, 301); exit; }
    $title = "Flat and Land Buying Guides for Bangladesh $year — SaleBari";
    $descr = 'Plain-language guides for buying a flat or land in Bangladesh: the buying steps, ready vs under-construction, land share, land records and deeds, home loans and buying from abroad, with calculators.';
    $head  = seo_meta(['title' => $title, 'description' => $descr, 'url' => $selfPath]) . ld_script(ld_breadcrumb(array_merge($crumbs, [])));
    site_header(str_replace(' — SaleBari', '', $title), $head, false);
    ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?><span class="breadcrumb-current">Buying guides</span></nav>
    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi('Flat and Land Buying Guides', 'ফ্ল্যাট ও জমি কেনার গাইড') ?></h1>
      <p><?= $bi('Short, plain-language guides on the questions buyers ask most, each focused on one topic, with calculators for land size and home-loan instalments.', 'ক্রেতারা সবচেয়ে বেশি যেসব প্রশ্ন করেন তার সংক্ষিপ্ত, সহজ ভাষার গাইড, প্রতিটি একটি বিষয়ে কেন্দ্রীভূত, সাথে জমির মাপ ও হোম লোন কিস্তির ক্যালকুলেটর।') ?></p>
    </div>
    <section class="prop-section">
      <h2><?= $bi('Guides', 'গাইড') ?></h2>
      <div class="prop-grid">
        <?php foreach ($guides as $gs => $g): ?>
          <a class="prop-tile" href="<?= e(guide_url($gs)) ?>"><strong><?= $bi($g['h1'][0], $g['h1'][1]) ?></strong><small><?= e(mb_strimwidth($g['descr'], 0, 120, '…')) ?></small></a>
        <?php endforeach; ?>
      </div>
    </section>
    <section class="prop-section">
      <h2><?= $bi('Calculators', 'ক্যালকুলেটর') ?></h2>
      <div class="prop-grid">
        <?php foreach ($tools as $ts => $t): ?>
          <a class="prop-tile" href="<?= e(tool_url($ts)) ?>"><strong><?= $bi($t['h1'][0], $t['h1'][1]) ?></strong><small><?= e(mb_strimwidth($t['descr'], 0, 120, '…')) ?></small></a>
        <?php endforeach; ?>
      </div>
    </section>
    <section class="catalog-seo">
      <h2 class="catalog-subheading">Browse property</h2>
      <?= property_chip_row(guide_links(['flat:dhaka', 'apartment:dhaka', 'land:dhaka', 'flat:chittagong', 'flat:feni', 'land:feni'])) ?>
      <p class="catalog-back">← <a href="<?= e(property_url()) ?>">All property for sale</a></p>
    </section>
  </div>
</section>
<?php
    ob_start();
    echo track_page_script(['type' => 'category', 'list_name' => 'Buying guides', 'items' => []]);
    site_footer(ob_get_clean());
    exit;
}

/* =====================  one guide  ===================== */
if (!isset($guides[$slug])) {
    require __DIR__ . '/404.php';
    exit;
}
$g = $guides[$slug];
$selfPath = guide_url($slug);
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if ($reqPath !== $selfPath) { header('Location: ' . $selfPath, true, 301); exit; }

$title = $g['title'] . " ($year) — SaleBari";
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(function ($f) {
    return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
}, $g['faq'])];
$articleLd = ['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $g['h1'][0], 'description' => $g['descr'], 'inLanguage' => 'en',
              'dateModified' => $updatedIso, 'mainEntityOfPage' => abs_url($selfPath),
              'author' => ['@type' => 'Organization', 'name' => 'SaleBari'], 'publisher' => ['@type' => 'Organization', 'name' => 'SaleBari']];
$crumbsHere = array_merge($crumbs, [['name' => $g['short'][0]]]);
$head = seo_meta(['title' => $title, 'description' => $g['descr'], 'url' => $selfPath, 'type' => 'article'])
      . ld_script(ld_breadcrumb($crumbsHere), $articleLd, $faqLd);

site_header(str_replace(' — SaleBari', '', $title), $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?>
      <a href="<?= e(guide_url()) ?>">Buying guides</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($g['short'][0]) ?></span>
    </nav>

    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi($g['h1'][0], $g['h1'][1]) ?></h1>
      <p><?= $bi($g['lead'][0], $g['lead'][1]) ?></p>
      <p class="prop-updated"><?= $bi('Last updated: ' . $updated, 'সর্বশেষ হালনাগাদ: ' . $updated) ?></p>
    </div>

    <nav class="guide-toc" aria-label="On this page">
      <strong><?= $bi('On this page', 'এই পেজে') ?></strong>
      <?php foreach ($g['sections'] as $s): ?><a href="#<?= e($s['id']) ?>"><?= $bi($s['h'][0], $s['h'][1]) ?></a><?php endforeach; ?>
      <a href="#faq"><?= $bi('Questions', 'প্রশ্ন') ?></a>
    </nav>

    <?php foreach ($g['sections'] as $s): ?>
      <section class="prop-section guide-section" id="<?= e($s['id']) ?>">
        <h2><?= $bi($s['h'][0], $s['h'][1]) ?></h2>
        <?php if ($s['kind'] === 'text'): foreach ($s['items'] as $it): ?>
          <p class="prop-text"><?= $bi($it[0], $it[1]) ?></p>
        <?php endforeach; elseif ($s['kind'] === 'list' || $s['kind'] === 'steps'): ?>
          <<?= $s['kind'] === 'steps' ? 'ol' : 'ul' ?> class="prop-tips">
            <?php foreach ($s['items'] as $it): ?><li><?= $bi($it[0], $it[1]) ?></li><?php endforeach; ?>
          </<?= $s['kind'] === 'steps' ? 'ol' : 'ul' ?>>
        <?php elseif ($s['kind'] === 'table'):
            // hide a column whose header and cells are all empty
            $keep = [];
            foreach ($s['cols'] as $ci => $col) {
                $any = $col[0] !== '';
                foreach ($s['rows'] as $row) { if (($row[$ci][0] ?? '') !== '') { $any = true; } }
                if ($any || $ci === 0) { $keep[] = $ci; }
            } ?>
          <div class="prop-table-wrap"><table class="prop-table">
            <thead><tr><?php foreach ($keep as $ci): ?><th><?= $s['cols'][$ci][0] !== '' ? $bi($s['cols'][$ci][0], $s['cols'][$ci][1]) : '' ?></th><?php endforeach; ?></tr></thead>
            <tbody>
              <?php foreach ($s['rows'] as $row): ?><tr>
                <?php foreach ($keep as $k => $ci): ?><<?= $k === 0 ? 'th scope="row"' : 'td' ?>><?= $bi($row[$ci][0], $row[$ci][1]) ?></<?= $k === 0 ? 'th' : 'td' ?>><?php endforeach; ?>
              </tr><?php endforeach; ?>
            </tbody>
          </table></div>
        <?php endif; ?>
      </section>
    <?php endforeach; ?>

    <?php if (!empty($g['tools'])): ?>
      <section class="prop-section">
        <h2><?= $bi('Useful calculators', 'কাজের ক্যালকুলেটর') ?></h2>
        <div class="prop-grid prop-grid-2">
          <?php foreach ($g['tools'] as $ts): $t = $tools[$ts]; ?>
            <a class="prop-tile" href="<?= e(tool_url($ts)) ?>"><strong><?= $bi($t['h1'][0], $t['h1'][1]) ?></strong><small><?= e(mb_strimwidth($t['descr'], 0, 110, '…')) ?></small></a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <section class="prop-section prop-faq" id="faq">
      <h2><?= $bi('Frequently asked questions', 'সাধারণ প্রশ্ন ও উত্তর') ?></h2>
      <?php foreach ($g['faq'] as $f): ?>
        <details><summary><?= $bi($f[0], $f[2]) ?></summary><p><?= $bi($f[1], $f[3]) ?></p></details>
      <?php endforeach; ?>
    </section>

    <p class="prop-note"><?= $bi($disclaimer[0], $disclaimer[1]) ?></p>

    <section class="catalog-seo">
      <h2 class="catalog-subheading">Related guides</h2>
      <?php $rel = []; foreach ($g['related'] as $rs) { $rel[] = [guide_url($rs), $guides[$rs]['h1'][0]]; } ?>
      <?= property_chip_row($rel) ?>
      <h2 class="catalog-subheading">Browse listings</h2>
      <?= property_chip_row(guide_links($g['links'])) ?>
      <p class="catalog-back">← <a href="<?= e(guide_url()) ?>">All buying guides</a> · <a href="<?= e(property_url()) ?>">All property for sale</a></p>
    </section>
  </div>
</section>
<?php
ob_start();
echo track_page_script(['type' => 'category', 'list_name' => 'Guide / ' . $g['short'][0], 'items' => []]);
site_footer(ob_get_clean());
