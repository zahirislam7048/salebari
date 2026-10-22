<?php
require __DIR__ . '/../app/bootstrap.php';

$nums  = site_numbers();
$email = setting('contact_email', 'en', 'salebarirealestate@gmail.com');
$origin = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
$head = '<meta name="description" content="SaleBari Return and Refund Policy: how returns and refunds work when you buy from a seller, and how refunds work for seller package fees.">' . "\n"
    . '<link rel="canonical" href="' . e($origin . base_path() . '/return-and-refund-policy/') . '">';

$contact = function () use ($nums, $email) {
    $parts = [];
    foreach ($nums as $n) {
        $parts[] = '<a href="tel:' . e($n['tel']) . '">' . e($n['display']) . '</a>';
    }
    return implode(' / ', $parts) . ' · <a href="mailto:' . e($email) . '">' . e($email) . '</a>';
};

site_header('Return and Refund Policy', $head, false);
?>
<section class="section category-page help-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><a href="<?= base_path() ?>/help/" data-i18n="help.title">Help Center</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Return &amp; Refund Policy</span></nav>

    <article class="privacy-page">
      <div data-lang="en">
        <h1 class="listing-page-title">Return and Refund Policy</h1>
        <p class="acct-muted">Last updated: <?= date('j F Y') ?></p>

        <h2>1. How SaleBari works</h2>
        <p>SaleBari is an online marketplace where independent sellers list their stalls and products. SaleBari does not sell these products itself and does not take payment for them on the website. You agree the price, payment and delivery directly with the seller. Because of this, <strong>returns, exchanges and refunds for a product are decided by the seller you buy from</strong>, not by SaleBari.</p>

        <h2>2. Before you buy</h2>
        <ul>
          <li>Ask the seller about their return, exchange and refund terms <em>before</em> you pay.</li>
          <li>Get the important details in writing, for example in your WhatsApp chat: price, condition, warranty, delivery time and return period.</li>
          <li>Check the item in person when you can, and keep any receipt or message as proof of the deal.</li>
          <li>Do not send advance money to a seller you do not know.</li>
        </ul>

        <h2>3. If something is wrong with your order</h2>
        <ol>
          <li>Contact the seller straight away, and no later than the period you agreed. Tell them what is wrong and share photos if it helps.</li>
          <li>The seller decides whether to accept a return, offer an exchange, repair the item or give a refund, according to what was agreed.</li>
          <li>If the seller does not respond or the listing was misleading, message us the page link and the chat or receipt. We will look into it, and we may contact the seller, remove the listing or suspend the stall. SaleBari cannot promise a refund of money that was paid to a seller.</li>
        </ol>

        <h2>4. Seller package fees</h2>
        <p>Sellers can choose a monthly package (Growth BluePrint, Scale System or Growth Partner). For these fees paid to SaleBari:</p>
        <ul>
          <li><strong>Full refund</strong> if we reject your stall, or if we are unable to provide the package you paid for.</li>
          <li><strong>Cancel any time.</strong> Tell us before the next month starts and you will not be charged again.</li>
          <li><strong>No refund</strong> for a month that has already started once your stall is live, or once SEO or advertising work for you has begun, unless we agree otherwise in writing.</li>
        </ul>
        <p>Refunds, when approved, are paid back the same way you paid, as soon as we can.</p>

        <h2>5. Things that are not covered</h2>
        <p>SaleBari is not responsible for payments made outside the website, for items that a buyer and seller agree to trade in a way that breaks the law, or for damage after delivery caused by the buyer.</p>

        <h2>6. Contact us</h2>
        <p><?= $contact() ?></p>
        <p>See also: <a href="<?= base_path() ?>/help/">Help Center</a> · <a href="<?= base_path() ?>/privacy.php">Privacy Policy</a></p>
      </div>

      <div data-lang="bn">
        <h1 class="listing-page-title">রিটার্ন ও রিফান্ড নীতি</h1>
        <p class="acct-muted">সর্বশেষ হালনাগাদ: <?= date('j F Y') ?></p>

        <h2>১. SaleBari কীভাবে কাজ করে</h2>
        <p>SaleBari একটি অনলাইন মার্কেটপ্লেস, যেখানে স্বাধীন বিক্রেতারা তাদের স্টল ও পণ্য তালিকাভুক্ত করেন। SaleBari নিজে এসব পণ্য বিক্রি করে না এবং ওয়েবসাইটে এসবের জন্য কোনো টাকা নেয় না। দাম, পেমেন্ট ও ডেলিভারি আপনি সরাসরি বিক্রেতার সাথে ঠিক করেন। তাই <strong>কোনো পণ্যের রিটার্ন, এক্সচেঞ্জ ও রিফান্ড যে বিক্রেতার কাছ থেকে কিনেছেন তিনিই ঠিক করেন</strong>, SaleBari নয়।</p>

        <h2>২. কেনার আগে</h2>
        <ul>
          <li>টাকা দেওয়ার <em>আগেই</em> বিক্রেতার রিটার্ন, এক্সচেঞ্জ ও রিফান্ডের শর্ত জেনে নিন।</li>
          <li>গুরুত্বপূর্ণ বিষয়গুলো লিখিত রাখুন, যেমন হোয়াটসঅ্যাপ চ্যাটে: দাম, পণ্যের অবস্থা, ওয়ারেন্টি, ডেলিভারির সময় ও রিটার্নের সময়সীমা।</li>
          <li>সম্ভব হলে নিজে পণ্য দেখে নিন এবং রশিদ বা মেসেজ প্রমাণ হিসেবে রেখে দিন।</li>
          <li>অচেনা বিক্রেতাকে অগ্রিম টাকা পাঠাবেন না।</li>
        </ul>

        <h2>৩. অর্ডারে সমস্যা হলে</h2>
        <ol>
          <li>সাথে সাথে বিক্রেতার সাথে যোগাযোগ করুন, এবং ঠিক করা সময়সীমার মধ্যে। কী সমস্যা তা জানান, দরকারে ছবি পাঠান।</li>
          <li>যা ঠিক হয়েছিল সে অনুযায়ী রিটার্ন নেবেন, এক্সচেঞ্জ দেবেন, মেরামত করবেন নাকি রিফান্ড দেবেন, তা বিক্রেতা ঠিক করেন।</li>
          <li>বিক্রেতা সাড়া না দিলে বা লিস্টিং বিভ্রান্তিকর হলে পেজের লিংক এবং চ্যাট বা রশিদ আমাদের পাঠান। আমরা বিষয়টি দেখব এবং বিক্রেতার সাথে যোগাযোগ, লিস্টিং সরানো বা স্টল স্থগিত করতে পারি। বিক্রেতাকে দেওয়া টাকা ফেরত পাওয়ার নিশ্চয়তা SaleBari দিতে পারে না।</li>
        </ol>

        <h2>৪. সেলার প্যাকেজের ফি</h2>
        <p>বিক্রেতারা মাসিক প্যাকেজ (গ্রোথ ব্লুপ্রিন্ট, স্কেল সিস্টেম বা গ্রোথ পার্টনার) নিতে পারেন। SaleBari-কে দেওয়া এই ফি-র ক্ষেত্রে:</p>
        <ul>
          <li><strong>সম্পূর্ণ রিফান্ড</strong>: আমরা আপনার স্টল প্রত্যাখ্যান করলে, অথবা আপনার নেওয়া প্যাকেজ দিতে না পারলে।</li>
          <li><strong>যেকোনো সময় বাতিল</strong>: পরের মাস শুরুর আগে জানালে আর চার্জ করা হবে না।</li>
          <li><strong>রিফান্ড নেই</strong>: যে মাস শুরু হয়ে গেছে এবং আপনার স্টল লাইভ হয়েছে বা আপনার জন্য SEO/বিজ্ঞাপনের কাজ শুরু হয়েছে, লিখিতভাবে অন্যরকম সম্মত না হলে।</li>
        </ul>
        <p>রিফান্ড অনুমোদিত হলে যে মাধ্যমে দিয়েছিলেন সেই মাধ্যমেই যত দ্রুত সম্ভব ফেরত দেওয়া হয়।</p>

        <h2>৫. যা এই নীতির আওতায় নয়</h2>
        <p>ওয়েবসাইটের বাইরে করা পেমেন্ট, আইনবিরোধী কোনো লেনদেন, বা ডেলিভারির পর ক্রেতার কারণে হওয়া ক্ষতির দায় SaleBari-র নয়।</p>

        <h2>৬. যোগাযোগ</h2>
        <p><?= $contact() ?></p>
        <p>আরও দেখুন: <a href="<?= base_path() ?>/help/">হেল্প সেন্টার</a> · <a href="<?= base_path() ?>/privacy.php">গোপনীয়তা নীতি</a></p>
      </div>
    </article>
  </div>
</section>
<?php
site_footer();
