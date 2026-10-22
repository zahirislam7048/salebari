<?php
require __DIR__ . '/../app/bootstrap.php';

$nums  = site_numbers();
$email = setting('contact_email', 'en', 'salebarirealestate@gmail.com');
$wa    = $nums[0]['wa'];
$waHi  = 'https://wa.me/' . $wa . '?text=' . urlencode('Hi SaleBari, I need help with: ');

/* Questions people ask. [English question, English answer, Bangla question, Bangla answer] */
$faq = [
    'Buying' => [
        ['How do I buy something on SaleBari?',
         'Browse a category or use the search box, open a product, and press WhatsApp or Call to talk to the seller directly. Ask about price, stock, delivery or a visit, and agree the deal with the seller.',
         'SaleBari-তে কীভাবে কিনব?',
         'ক্যাটাগরি ঘুরে দেখুন বা সার্চ বক্স ব্যবহার করুন, পণ্য খুলে হোয়াটসঅ্যাপ বা কল বাটনে সরাসরি বিক্রেতার সাথে কথা বলুন। দাম, স্টক, ডেলিভারি বা শোরুম ভিজিট নিয়ে জিজ্ঞেস করে বিক্রেতার সাথেই ডিল চূড়ান্ত করুন।'],
        ['Do I pay on the website?',
         'No. SaleBari connects you with sellers; it does not take payment on the site. Agree the price, payment method and delivery directly with the seller.',
         'ওয়েবসাইটে কি টাকা দিতে হয়?',
         'না। SaleBari আপনাকে বিক্রেতার সাথে যুক্ত করে, সাইটে কোনো পেমেন্ট নেয় না। দাম, পেমেন্টের পদ্ধতি ও ডেলিভারি বিক্রেতার সাথে সরাসরি ঠিক করুন।'],
        ['What does the "Verified Seller" badge mean?',
         'It means our team has checked that stall. It is still wise to inspect the item and the seller yourself before you pay.',
         '"ভেরিফায়েড বিক্রেতা" ব্যাজ মানে কী?',
         'এর মানে আমাদের টিম ওই স্টলটি যাচাই করেছে। তবুও টাকা দেওয়ার আগে পণ্য ও বিক্রেতাকে নিজে যাচাই করা বুদ্ধিমানের কাজ।'],
        ['Can I leave a review?',
         'Yes. Open the product, go to Reviews and press Write a Review. New reviews appear after our team approves them.',
         'আমি কি রিভিউ দিতে পারি?',
         'হ্যাঁ। পণ্যের পেজে Reviews অংশে গিয়ে "রিভিউ লিখুন" চাপুন। আমাদের টিম অনুমোদন করলে রিভিউ দেখা যাবে।'],
    ],
    'Selling' => [
        ['How do I open a stall?',
         'Press Sell at the top of any page, fill in your name, mobile number, package and location, then submit. We review every new stall before it goes live.',
         'কীভাবে স্টল খুলব?',
         'যেকোনো পেজের উপরে Sell চাপুন, আপনার নাম, মোবাইল নম্বর, প্যাকেজ ও অবস্থান দিয়ে সাবমিট করুন। প্রতিটি নতুন স্টল লাইভ হওয়ার আগে আমরা যাচাই করি।'],
        ['How much does it cost?',
         'There are three monthly packages: Growth BluePrint ৳500 (listing), Scale System ৳2,500 (listing + SEO for 1 product) and Growth Partner ৳10,000 (listing + SEO + paid ads). See the Package page for details.',
         'খরচ কত?',
         'মাসিক তিনটি প্যাকেজ: গ্রোথ ব্লুপ্রিন্ট ৳৫০০ (লিস্টিং), স্কেল সিস্টেম ৳২,৫০০ (লিস্টিং + ১টি পণ্যের SEO) এবং গ্রোথ পার্টনার ৳১০,০০০ (লিস্টিং + SEO + পেইড অ্যাড)। বিস্তারিত Package পেজে দেখুন।'],
        ['Why can I not see my listing on the site?',
         'New stalls and brands wait for our team to approve them, usually within a day. You can see their status (Live, Pending review or Not approved) in My account.',
         'আমার লিস্টিং সাইটে দেখা যাচ্ছে না কেন?',
         'নতুন স্টল ও ব্র্যান্ড আমাদের টিম অনুমোদন না করা পর্যন্ত অপেক্ষায় থাকে, সাধারণত এক দিনের মধ্যে। My account-এ স্ট্যাটাস (লাইভ, পেন্ডিং বা অনুমোদিত নয়) দেখতে পারবেন।'],
        ['How do I add products, or change my stall details?',
         'Log in, open My account and choose Edit next to your stall or brand. To add products or product SEO, message us on WhatsApp and we will help you.',
         'কীভাবে পণ্য যোগ করব বা স্টলের তথ্য বদলাব?',
         'লগইন করে My account-এ গিয়ে আপনার স্টল বা ব্র্যান্ডের পাশে Edit চাপুন। পণ্য যোগ বা পণ্যের SEO-র জন্য হোয়াটসঅ্যাপে আমাদের মেসেজ করুন, আমরা সাহায্য করব।'],
    ],
    'Account' => [
        ['How do I create an account?',
         'Use Sell to open a stall, or Account → Create your seller account. You can sign up with an email or a Bangladesh mobile number and a password of at least 8 characters.',
         'কীভাবে অ্যাকাউন্ট খুলব?',
         'Sell চেপে স্টল খুলুন, অথবা Account → সেলার অ্যাকাউন্ট খুলুন। ইমেইল বা বাংলাদেশি মোবাইল নম্বর এবং কমপক্ষে ৮ অক্ষরের পাসওয়ার্ড দিয়ে সাইন আপ করতে পারবেন।'],
        ['I forgot my password.',
         'Message or call us from the number you signed up with and we will help you get back in.',
         'আমি পাসওয়ার্ড ভুলে গেছি।',
         'যে নম্বর দিয়ে সাইন আপ করেছিলেন সেই নম্বর থেকে আমাদের মেসেজ বা কল করুন, আমরা আপনাকে অ্যাকাউন্টে ফিরতে সাহায্য করব।'],
        ['Can I use the site in Bangla?',
         'Yes. Press বাংলা in the top bar and the site switches to Bangla; press English to switch back.',
         'সাইটটি কি বাংলায় ব্যবহার করা যায়?',
         'হ্যাঁ। উপরের বারে "বাংলা" চাপলে সাইট বাংলায় বদলে যায়, আবার English চাপলে ইংরেজিতে ফেরে।'],
    ],
    'Safety' => [
        ['How do I stay safe when buying?',
         'Check the item in person when you can, compare prices, and be careful with prices that look too good. Do not send advance money to someone you do not know. SaleBari will never ask for your password or an OTP.',
         'কেনার সময় কীভাবে নিরাপদ থাকব?',
         'সম্ভব হলে নিজে পণ্য দেখে নিন, দাম তুলনা করুন এবং অতিরিক্ত কম দামে সতর্ক থাকুন। অচেনা কাউকে অগ্রিম টাকা পাঠাবেন না। SaleBari কখনো আপনার পাসওয়ার্ড বা OTP চাইবে না।'],
        ['What is the return and refund policy?',
         'Returns and refunds for a product are decided by the seller you buy from, so ask before you pay. Seller package fees have their own refund rules. Read the full Return and Refund Policy for details.',
         'রিটার্ন ও রিফান্ড নীতি কী?',
         'কোনো পণ্যের রিটার্ন ও রিফান্ড যে বিক্রেতার কাছ থেকে কিনছেন তিনিই ঠিক করেন, তাই টাকা দেওয়ার আগে জিজ্ঞেস করুন। সেলার প্যাকেজ ফি-র রিফান্ডের নিয়ম আলাদা। বিস্তারিত জানতে পূর্ণ রিটার্ন ও রিফান্ড নীতি পড়ুন।'],
        ['How do I report a suspicious listing or seller?',
         'Message us on WhatsApp with the page link and what looks wrong. We check every report and remove listings that break our rules.',
         'সন্দেহজনক লিস্টিং বা বিক্রেতার খবর কীভাবে দেব?',
         'পেজের লিংক ও কী সমস্যা মনে হচ্ছে তা হোয়াটসঅ্যাপে আমাদের জানান। আমরা প্রতিটি রিপোর্ট দেখি এবং নিয়ম ভাঙা লিস্টিং সরিয়ে দিই।'],
        ['How is my information used?',
         'Read our Privacy Policy to see what we collect, which tools we use, and how to change your cookie choice.',
         'আমার তথ্য কীভাবে ব্যবহার হয়?',
         'আমরা কী সংগ্রহ করি, কোন টুল ব্যবহার করি এবং কুকি পছন্দ কীভাবে বদলাবেন তা জানতে আমাদের গোপনীয়তা নীতি পড়ুন।'],
    ],
];

$ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
foreach ($faq as $items) {
    foreach ($items as [$q, $a]) {
        $ld['mainEntity'][] = ['@type' => 'Question', 'name' => $q, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]];
    }
}
$origin = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
$head = '<meta name="description" content="SaleBari Help Center: how to buy, how to open a stall, packages, account help, safety tips and how to contact us on WhatsApp or phone.">' . "\n"
    . '<link rel="canonical" href="' . e($origin . base_path() . '/help/') . '">' . "\n"
    . '<script type="application/ld+json">' . json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) . '</script>';

$groupLabels = [
    'Buying'  => ['Buying', 'কেনাকাটা'],
    'Selling' => ['Selling', 'বিক্রি করা'],
    'Account' => ['Account', 'অ্যাকাউন্ট'],
    'Safety'  => ['Safety & privacy', 'নিরাপত্তা ও গোপনীয়তা'],
];

site_header('Help Center', $head, false);
?>
<section class="section category-page help-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current" data-i18n="help.title">Help Center</span></nav>

    <header class="help-hero">
      <h1 class="listing-page-title" data-i18n="help.title">Help Center</h1>
      <p class="acct-muted" data-i18n="help.sub">Answers to common questions, and the quickest ways to reach us.</p>
    </header>

    <div class="help-cards">
      <a class="help-card" href="#how-it-works"><span class="help-ico">🧭</span><strong data-i18n="help.c1">How it works</strong><small data-i18n="help.c1d">Buy and sell in a few steps</small></a>
      <a class="help-card" href="#faq"><span class="help-ico">❓</span><strong data-i18n="help.c2">Questions &amp; answers</strong><small data-i18n="help.c2d">Buying, selling, account, safety</small></a>
      <a class="help-card" href="<?= base_path() ?>/package.html"><span class="help-ico">📦</span><strong data-i18n="help.c3">Seller packages</strong><small data-i18n="help.c3d">Plans from ৳500 a month</small></a>
      <a class="help-card" href="#contact"><span class="help-ico">💬</span><strong data-i18n="help.c4">Contact us</strong><small data-i18n="help.c4d">WhatsApp, call or email</small></a>
    </div>

    <section class="help-section" id="how-it-works">
      <h2 data-i18n="help.how">How SaleBari works</h2>
      <div class="help-columns">
        <div class="help-box">
          <h3 data-i18n="help.buyers">For buyers</h3>
          <ol>
            <li data-i18n="help.b1">Pick a category, or search for what you need.</li>
            <li data-i18n="help.b2">Open a product and read its details, photos and seller.</li>
            <li data-i18n="help.b3">Press WhatsApp or Call and talk to the seller directly.</li>
            <li data-i18n="help.b4">Agree price, payment and delivery with the seller, and check the item before you pay.</li>
          </ol>
        </div>
        <div class="help-box">
          <h3 data-i18n="help.sellers">For sellers</h3>
          <ol>
            <li data-i18n="help.s1">Press Sell, choose a package and open your stall.</li>
            <li data-i18n="help.s2">Our team reviews it, usually within a day, and your stall goes live.</li>
            <li data-i18n="help.s3">Buyers find you by category, city and brand and contact you directly.</li>
            <li data-i18n="help.s4">Manage your listing any time from My account.</li>
          </ol>
          <p><a class="btn btn-primary" href="<?= base_path() ?>/sell/" data-i18n="help.openStall">Open your stall</a></p>
        </div>
      </div>
    </section>

    <section class="help-section" id="faq">
      <h2 data-i18n="help.faq">Questions &amp; answers</h2>
      <?php foreach ($faq as $group => $items): ?>
        <h3 class="help-group"><span data-lang="en"><?= e($groupLabels[$group][0]) ?></span><span data-lang="bn"><?= e($groupLabels[$group][1]) ?></span></h3>
        <div class="faq-list">
          <?php foreach ($items as [$qEn, $aEn, $qBn, $aBn]): ?>
            <details class="faq-item">
              <summary><span data-lang="en"><?= e($qEn) ?></span><span data-lang="bn"><?= e($qBn) ?></span></summary>
              <p data-lang="en"><?= e($aEn) ?><?php if ($group === 'Safety' && strpos($qEn, 'information') !== false): ?> <a href="<?= base_path() ?>/privacy.php">Privacy Policy →</a><?php endif; ?><?php if (strpos($qEn, 'refund policy') !== false): ?> <a href="<?= base_path() ?>/return-and-refund-policy/">Return and Refund Policy →</a><?php endif; ?></p>
              <p data-lang="bn"><?= e($aBn) ?><?php if ($group === 'Safety' && strpos($qEn, 'information') !== false): ?> <a href="<?= base_path() ?>/privacy.php">গোপনীয়তা নীতি →</a><?php endif; ?><?php if (strpos($qEn, 'refund policy') !== false): ?> <a href="<?= base_path() ?>/return-and-refund-policy/">রিটার্ন ও রিফান্ড নীতি →</a><?php endif; ?></p>
            </details>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </section>

    <section class="help-section help-contact" id="contact">
      <h2 data-i18n="help.contact">Contact us</h2>
      <p class="acct-muted" data-i18n="help.contactSub">Still need help? Reach us any of these ways and we will reply as soon as we can.</p>
      <div class="help-contact-grid">
        <?php foreach ($nums as $n): ?>
          <a class="help-contact-card" href="https://wa.me/<?= e($n['wa']) ?>?text=<?= urlencode('Hi SaleBari, I need help with: ') ?>" target="_blank" rel="noopener">
            <span class="help-ico" style="background:#e8f8ee">💬</span><strong>WhatsApp</strong><small><?= e($n['display']) ?></small>
          </a>
        <?php endforeach; ?>
        <?php foreach ($nums as $n): ?>
          <a class="help-contact-card" href="tel:<?= e($n['tel']) ?>">
            <span class="help-ico">📞</span><strong data-i18n="pp.call">Call</strong><small><?= e($n['display']) ?></small>
          </a>
        <?php endforeach; ?>
        <a class="help-contact-card" href="mailto:<?= e($email) ?>">
          <span class="help-ico">✉️</span><strong>Email</strong><small><?= e($email) ?></small>
        </a>
      </div>
    </section>
  </div>
</section>
<?php ob_start(); ?>
<script>
  Object.assign(window.I18N.dict, {
    'help.title': { en: 'Help Center', bn: 'হেল্প সেন্টার' },
    'help.sub': { en: 'Answers to common questions, and the quickest ways to reach us.', bn: 'সাধারণ প্রশ্নের উত্তর এবং আমাদের কাছে পৌঁছানোর দ্রুততম উপায়।' },
    'help.c1': { en: 'How it works', bn: 'কীভাবে কাজ করে' },
    'help.c1d': { en: 'Buy and sell in a few steps', bn: 'কয়েক ধাপেই কেনা ও বেচা' },
    'help.c2': { en: 'Questions & answers', bn: 'প্রশ্ন ও উত্তর' },
    'help.c2d': { en: 'Buying, selling, account, safety', bn: 'কেনা, বেচা, অ্যাকাউন্ট, নিরাপত্তা' },
    'help.c3': { en: 'Seller packages', bn: 'সেলার প্যাকেজ' },
    'help.c3d': { en: 'Plans from ৳500 a month', bn: 'মাসে ৳৫০০ থেকে শুরু' },
    'help.c4': { en: 'Contact us', bn: 'যোগাযোগ করুন' },
    'help.c4d': { en: 'WhatsApp, call or email', bn: 'হোয়াটসঅ্যাপ, কল বা ইমেইল' },
    'help.how': { en: 'How SaleBari works', bn: 'SaleBari কীভাবে কাজ করে' },
    'help.buyers': { en: 'For buyers', bn: 'ক্রেতাদের জন্য' },
    'help.b1': { en: 'Pick a category, or search for what you need.', bn: 'একটি ক্যাটাগরি বেছে নিন, বা যা দরকার তা খুঁজুন।' },
    'help.b2': { en: 'Open a product and read its details, photos and seller.', bn: 'পণ্য খুলে তার বিবরণ, ছবি ও বিক্রেতার তথ্য দেখুন।' },
    'help.b3': { en: 'Press WhatsApp or Call and talk to the seller directly.', bn: 'হোয়াটসঅ্যাপ বা কল চেপে সরাসরি বিক্রেতার সাথে কথা বলুন।' },
    'help.b4': { en: 'Agree price, payment and delivery with the seller, and check the item before you pay.', bn: 'বিক্রেতার সাথে দাম, পেমেন্ট ও ডেলিভারি ঠিক করুন এবং টাকা দেওয়ার আগে পণ্য দেখে নিন।' },
    'help.sellers': { en: 'For sellers', bn: 'বিক্রেতাদের জন্য' },
    'help.s1': { en: 'Press Sell, choose a package and open your stall.', bn: 'Sell চাপুন, একটি প্যাকেজ বেছে স্টল খুলুন।' },
    'help.s2': { en: 'Our team reviews it, usually within a day, and your stall goes live.', bn: 'আমাদের টিম সাধারণত এক দিনের মধ্যে যাচাই করে, তারপর আপনার স্টল লাইভ হয়।' },
    'help.s3': { en: 'Buyers find you by category, city and brand and contact you directly.', bn: 'ক্রেতারা ক্যাটাগরি, শহর ও ব্র্যান্ড দিয়ে আপনাকে খুঁজে সরাসরি যোগাযোগ করেন।' },
    'help.s4': { en: 'Manage your listing any time from My account.', bn: 'যেকোনো সময় My account থেকে আপনার লিস্টিং পরিচালনা করুন।' },
    'help.openStall': { en: 'Open your stall', bn: 'আপনার স্টল খুলুন' },
    'help.faq': { en: 'Questions & answers', bn: 'প্রশ্ন ও উত্তর' },
    'help.contact': { en: 'Contact us', bn: 'যোগাযোগ করুন' },
    'help.contactSub': { en: 'Still need help? Reach us any of these ways and we will reply as soon as we can.', bn: 'আরও সাহায্য লাগলে এর যেকোনো উপায়ে যোগাযোগ করুন, আমরা যত দ্রুত সম্ভব উত্তর দেব।' }
  });
  window.I18N.applyLanguage(window.I18N.currentLang());
</script>
<?php
site_footer(ob_get_clean());
