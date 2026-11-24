<?php
/* Calculators:  /tools/land-size-converter/   /tools/home-loan-emi-calculator/
   The sums run in the visitor's browser (nothing is sent to SaleBari). Text comes from app/guide_data.php. */
require __DIR__ . '/app/bootstrap.php';

$tools  = guide_tools();
$guides = guide_pages();
$slug   = strtolower((string) input('t', ''));
if (!isset($tools[$slug])) {
    require __DIR__ . '/404.php';
    exit;
}
$t  = $tools[$slug];
$bi = 'property_bi';
$year = date('Y');
$selfPath = tool_url($slug);
$reqPath  = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
if ($reqPath !== $selfPath) { header('Location: ' . $selfPath, true, 301); exit; }
$realEstate = find_category_by_path(['real-estate']);

$crumbs = [['name' => 'Home', 'url' => base_path() . '/']];
if ($realEstate) { $crumbs[] = ['name' => 'Real Estate', 'url' => category_url($realEstate)]; }
$crumbs[] = ['name' => 'Buying guides', 'url' => guide_url()];
$crumbs[] = ['name' => $t['short'][0]];
$faqLd = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(function ($f) {
    return ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]];
}, $t['faq'])];
$title = $t['title'] . " — SaleBari";
$head = seo_meta(['title' => $title, 'description' => $t['descr'], 'url' => $selfPath]) . ld_script(ld_breadcrumb($crumbs), $faqLd);

site_header(str_replace(' — SaleBari', '', $title), $head, false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php if ($realEstate): ?><a href="<?= e(category_url($realEstate)) ?>">Real Estate</a><span class="breadcrumb-sep">›</span><?php endif; ?>
      <a href="<?= e(guide_url()) ?>">Buying guides</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($t['short'][0]) ?></span>
    </nav>
    <div class="prop-hero">
      <h1 class="listing-page-title"><?= $bi($t['h1'][0], $t['h1'][1]) ?></h1>
      <p><?= $bi($t['lead'][0], $t['lead'][1]) ?></p>
    </div>

<?php if ($slug === 'land-size-converter'): ?>
    <section class="calc-card" aria-label="Land size converter">
      <div class="calc-fields">
        <label><span><?= $bi('Size', 'আকার') ?></span><input type="number" id="lcVal" min="0" step="any" value="5" inputmode="decimal"></label>
        <label><span><?= $bi('Unit', 'একক') ?></span>
          <select id="lcUnit">
            <option value="katha">katha (কাঠা)</option>
            <option value="decimal">decimal / shotangsho (শতাংশ)</option>
            <option value="bigha">bigha (বিঘা)</option>
            <option value="sqft">square feet (বর্গফুট)</option>
            <option value="acre">acre (একর)</option>
            <option value="sqm">square metre (বর্গমিটার)</option>
          </select></label>
        <label><span><?= $bi('1 katha = ___ sqft', '১ কাঠা = ___ বর্গফুট') ?></span><input type="number" id="lcKatha" min="1" step="any" value="720" inputmode="decimal"></label>
      </div>
      <div class="prop-table-wrap"><table class="prop-table calc-out">
        <thead><tr><th><?= $bi('Unit', 'একক') ?></th><th><?= $bi('Equals', 'সমান') ?></th></tr></thead>
        <tbody>
          <tr><th scope="row"><?= $bi('Katha', 'কাঠা') ?></th><td data-unit="katha">–</td></tr>
          <tr><th scope="row"><?= $bi('Decimal (shotangsho)', 'শতাংশ') ?></th><td data-unit="decimal">–</td></tr>
          <tr><th scope="row"><?= $bi('Bigha', 'বিঘা') ?></th><td data-unit="bigha">–</td></tr>
          <tr><th scope="row"><?= $bi('Square feet', 'বর্গফুট') ?></th><td data-unit="sqft">–</td></tr>
          <tr><th scope="row"><?= $bi('Acre', 'একর') ?></th><td data-unit="acre">–</td></tr>
          <tr><th scope="row"><?= $bi('Square metre', 'বর্গমিটার') ?></th><td data-unit="sqm">–</td></tr>
        </tbody>
      </table></div>
      <p class="prop-note"><?= $bi('The bigha is taken as 20 katha. Katha and bigha differ by region, so always set the katha to the measure written on your deed.', 'বিঘা ২০ কাঠা ধরা হয়েছে। কাঠা ও বিঘা অঞ্চলভেদে আলাদা, তাই কাঠার মাপ সবসময় আপনার দলিলের মাপ অনুযায়ী দিন।') ?></p>
    </section>

    <section class="prop-section">
      <h2><?= $bi('Quick reference', 'দ্রুত তথ্য') ?></h2>
      <div class="prop-table-wrap"><table class="prop-table prop-table-narrow">
        <thead><tr><th><?= $bi('Unit', 'একক') ?></th><th><?= $bi('Square feet', 'বর্গফুট') ?></th></tr></thead>
        <tbody>
          <tr><td>1 <?= $bi('katha (standard Dhaka measure)', 'কাঠা (ঢাকার প্রচলিত মাপ)') ?></td><td>720</td></tr>
          <tr><td>1 <?= $bi('decimal (shotangsho)', 'শতাংশ') ?></td><td>435.6</td></tr>
          <tr><td>1 <?= $bi('bigha (20 katha)', 'বিঘা (২০ কাঠা)') ?></td><td>14,400</td></tr>
          <tr><td>1 <?= $bi('acre (100 decimal)', 'একর (১০০ শতাংশ)') ?></td><td>43,560</td></tr>
          <tr><td>1 <?= $bi('square metre', 'বর্গমিটার') ?></td><td>10.764</td></tr>
        </tbody>
      </table></div>
    </section>
    <?php ob_start(); ?>
<script>
(function () {
  var v = document.getElementById('lcVal'), u = document.getElementById('lcUnit'), k = document.getElementById('lcKatha');
  var cells = document.querySelectorAll('.calc-out [data-unit]');
  function fmt(n) { return n.toLocaleString('en-IN', { maximumFractionDigits: n < 1 ? 4 : 2 }); }
  function run() {
    var kv = parseFloat(k.value); if (!(kv > 0)) kv = 720;
    var f = { sqft: 1, katha: kv, decimal: 435.6, bigha: 20 * kv, acre: 43560, sqm: 10.7639104 };
    var x = parseFloat(v.value);
    Array.prototype.forEach.call(cells, function (c) {
      c.textContent = (x > 0 && f[u.value]) ? fmt(x * f[u.value] / f[c.getAttribute('data-unit')]) : '–';
    });
  }
  [v, u, k].forEach(function (el) { el.addEventListener('input', run); el.addEventListener('change', run); });
  run();
})();
</script>
    <?php $toolScript = ob_get_clean(); ?>

<?php else: /* home-loan-emi-calculator */ ?>
    <section class="calc-card" aria-label="Home loan EMI calculator">
      <div class="calc-fields">
        <label><span><?= $bi('Price of the flat (৳)', 'ফ্ল্যাটের দাম (৳)') ?></span><input type="number" id="emPrice" min="0" step="any" value="8000000" inputmode="numeric"></label>
        <label><span><?= $bi('Down payment (%)', 'ডাউন পেমেন্ট (%)') ?></span><input type="number" id="emDown" min="0" max="100" step="any" value="30" inputmode="decimal"></label>
        <label><span><?= $bi('Yearly rate (%) from your bank', 'ব্যাংকের বার্ষিক হার (%)') ?></span><input type="number" id="emRate" min="0" max="60" step="any" value="12" inputmode="decimal"></label>
        <label><span><?= $bi('Years', 'বছর') ?></span><input type="number" id="emYears" min="1" max="40" step="1" value="15" inputmode="numeric"></label>
        <label><span><?= $bi('Monthly income (৳, optional)', 'মাসিক আয় (৳, ঐচ্ছিক)') ?></span><input type="number" id="emIncome" min="0" step="any" placeholder="e.g. 150000" inputmode="numeric"></label>
      </div>
      <p class="prop-note"><?= $bi('The starting values are only examples. Replace them with your own and use the rate your bank quotes.', 'শুরুর মানগুলো শুধু উদাহরণ। নিজের মান দিন এবং ব্যাংকের বলা হার ব্যবহার করুন।') ?></p>
      <div class="calc-results" id="emResults" aria-live="polite">
        <div class="calc-big"><span><?= $bi('Monthly instalment (EMI)', 'মাসিক কিস্তি (ইএমআই)') ?></span><strong id="emEmi">–</strong></div>
        <div class="calc-row"><span><?= $bi('Down payment', 'ডাউন পেমেন্ট') ?></span><b id="emDownAmt">–</b></div>
        <div class="calc-row"><span><?= $bi('Loan amount', 'ঋণের পরিমাণ') ?></span><b id="emLoan">–</b></div>
        <div class="calc-row"><span><?= $bi('Total paid to the bank', 'ব্যাংককে মোট পরিশোধ') ?></span><b id="emTotal">–</b></div>
        <div class="calc-row"><span><?= $bi('Total interest', 'মোট সুদ') ?></span><b id="emInterest">–</b></div>
        <div class="calc-row" id="emShareRow" hidden><span><?= $bi('EMI as a share of income', 'আয়ের কত অংশ ইএমআই') ?></span><b id="emShare">–</b></div>
      </div>
      <p class="calc-error" id="emError" hidden></p>
      <h2 class="calc-sub"><?= $bi('Year by year', 'বছরে বছরে') ?></h2>
      <div class="prop-table-wrap"><table class="prop-table calc-year">
        <thead><tr><th><?= $bi('Year', 'বছর') ?></th><th><?= $bi('Interest paid', 'সুদ') ?></th><th><?= $bi('Principal paid', 'আসল') ?></th><th><?= $bi('Balance left', 'বাকি ঋণ') ?></th></tr></thead>
        <tbody id="emYearRows"></tbody>
      </table></div>
    </section>

    <section class="prop-section">
      <h2><?= $bi('How the EMI is worked out', 'ইএমআই কীভাবে হিসাব হয়') ?></h2>
      <p class="prop-text"><?= $bi('EMI = P × r × (1 + r)^n ÷ ((1 + r)^n − 1). P is the loan amount, r is the monthly rate (the yearly rate ÷ 12 ÷ 100) and n is the number of months. The loan amount is the price minus the down payment. Interest each month is charged on the balance still owed, so early instalments are mostly interest and later ones mostly principal.', 'ইএমআই = P × r × (1 + r)^n ÷ ((1 + r)^n − 1)। P ঋণের পরিমাণ, r মাসিক হার (বার্ষিক হার ÷ ১২ ÷ ১০০) এবং n মাসের সংখ্যা। ঋণের পরিমাণ হলো দাম বিয়োগ ডাউন পেমেন্ট। প্রতি মাসের সুদ বাকি থাকা ঋণের ওপর ধরা হয়, তাই শুরুর কিস্তিতে সুদ বেশি আর পরের কিস্তিতে আসল বেশি।') ?></p>
      <p class="prop-note"><?= $bi('This is an estimate using the standard reducing-balance method. It leaves out bank fees, insurance and any change in the rate. Ask your bank for its own schedule.', 'এটি প্রচলিত হ্রাসমান স্থিতি পদ্ধতিতে একটি আনুমানিক হিসাব। এতে ব্যাংকের ফি, বিমা ও হারের পরিবর্তন ধরা হয়নি। ব্যাংকের নিজস্ব সূচি চান।') ?></p>
    </section>
    <?php ob_start(); ?>
<script>
(function () {
  var $ = function (id) { return document.getElementById(id); };
  function money(n) { return '৳ ' + Math.round(n).toLocaleString('en-IN'); }
  function run() {
    var price = parseFloat($('emPrice').value), downPct = parseFloat($('emDown').value) || 0,
        rate = parseFloat($('emRate').value) || 0, years = parseInt($('emYears').value, 10),
        income = parseFloat($('emIncome').value), err = $('emError');
    var fields = ['emEmi', 'emDownAmt', 'emLoan', 'emTotal', 'emInterest'];
    function blank(msg) {
      fields.forEach(function (id) { $(id).textContent = '–'; });
      $('emYearRows').innerHTML = ''; $('emShareRow').hidden = true;
      err.hidden = !msg; err.textContent = msg || '';
    }
    if (!(price > 0)) return blank('Enter the price of the flat.');
    if (!(years >= 1 && years <= 40)) return blank('Enter the number of years (1 to 40).');
    if (downPct < 0 || downPct >= 100) return blank('The down payment must be between 0 and 99 percent.');
    var down = price * downPct / 100, loan = price - down, n = years * 12, r = rate / 12 / 100, emi;
    if (r === 0) { emi = loan / n; }
    else { var p = Math.pow(1 + r, n); emi = loan * r * p / (p - 1); }
    var total = emi * n, interest = total - loan;
    err.hidden = true;
    $('emEmi').textContent = money(emi); $('emDownAmt').textContent = money(down); $('emLoan').textContent = money(loan);
    $('emTotal').textContent = money(total); $('emInterest').textContent = money(interest);
    if (income > 0) { $('emShare').textContent = (emi / income * 100).toFixed(1) + '%'; $('emShareRow').hidden = false; } else { $('emShareRow').hidden = true; }
    var bal = loan, rows = '';
    for (var y = 1; y <= years; y++) {
      var iPaid = 0, pPaid = 0;
      for (var m = 0; m < 12; m++) { var i = bal * r, pr = emi - i; iPaid += i; pPaid += pr; bal -= pr; }
      rows += '<tr><td>' + y + '</td><td>' + money(iPaid) + '</td><td>' + money(pPaid) + '</td><td>' + money(Math.max(bal, 0)) + '</td></tr>';
    }
    $('emYearRows').innerHTML = rows;
  }
  ['emPrice', 'emDown', 'emRate', 'emYears', 'emIncome'].forEach(function (id) { $(id).addEventListener('input', run); });
  run();
})();
</script>
    <?php $toolScript = ob_get_clean(); ?>
<?php endif; ?>

    <section class="prop-section prop-faq">
      <h2><?= $bi('Frequently asked questions', 'সাধারণ প্রশ্ন ও উত্তর') ?></h2>
      <?php foreach ($t['faq'] as $f): ?>
        <details><summary><?= $bi($f[0], $f[2]) ?></summary><p><?= $bi($f[1], $f[3]) ?></p></details>
      <?php endforeach; ?>
    </section>

    <section class="catalog-seo">
      <h2 class="catalog-subheading">Related guides</h2>
      <?php $rel = []; foreach ($t['related'] as $rs) { $rel[] = [guide_url($rs), $guides[$rs]['h1'][0]]; } ?>
      <?= property_chip_row($rel) ?>
      <h2 class="catalog-subheading">Browse listings</h2>
      <?= property_chip_row(guide_links($t['links'])) ?>
      <h2 class="catalog-subheading">More tools</h2>
      <?= property_chip_row(array_values(array_filter(guide_all_chips($slug), function ($c) use ($tools) { return strpos($c[0], '/tools/') !== false; }))) ?>
      <p class="catalog-back">← <a href="<?= e(guide_url()) ?>">All buying guides</a> · <a href="<?= e(property_url()) ?>">All property for sale</a></p>
    </section>
  </div>
</section>
<?php
site_footer(($toolScript ?? '') . track_page_script(['type' => 'category', 'list_name' => 'Tool / ' . $t['short'][0], 'items' => []]));
