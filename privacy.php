<?php
require __DIR__ . '/app/bootstrap.php';

$phones = site_numbers();
site_header('Privacy Policy', '<meta name="description" content="How SaleBari uses cookies, analytics and advertising tools, and the choices you have.">', false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Privacy Policy</span></nav>

    <article class="privacy-page">
      <div data-lang="en">
        <h1 class="listing-page-title">Privacy Policy</h1>
        <p class="acct-muted">Last updated: <?= date('j F Y') ?></p>

        <h2>What we collect</h2>
        <p>When you visit SaleBari we record how the site is used: the pages and products you view, categories you browse, what you search for, the buttons you press (for example WhatsApp or Call), how far you scroll, how long you stay, the website or ad that brought you here, your device type, screen size and language. We do not put your name, phone number or email in this activity data.</p>
        <p>If you create a seller account or open a stall, we also keep the details you type in (name, mobile number, email, address, listing details) so we can run your account and show your listing.</p>

        <h2>Analytics and advertising tools</h2>
        <p>We use <strong>Google Analytics</strong> (and optionally Google Tag Manager) to understand how people use the site, and the <strong>Meta (Facebook) Pixel</strong> to measure and improve our ads. These tools may set cookies and receive the activity described above together with a random visitor ID. If you are signed in as a seller and accept cookies, we may share a one-way <em>hashed</em> version of your email and phone number with them (a scrambled code that cannot be read back) so they can match visits to the right account.</p>

        <h2>Your choice</h2>
        <p>The first time you visit you can <strong>accept</strong> or <strong>decline</strong>. If you decline, Meta Pixel is not loaded and Google runs without cookies or advertising features. You can change your mind at any time:</p>
        <p><button type="button" class="btn btn-ghost" id="resetConsent">Change my cookie choice</button></p>

        <h2>How long we keep it</h2>
        <p>Analytics data is kept by Google and Meta under their own retention settings. Account and listing details stay until you ask us to delete them.</p>

        <h2>Contact</h2>
        <p>To see, correct or delete your data, message us on WhatsApp or call
          <?php foreach ($phones as $i => $n): ?><?= $i ? ' / ' : '' ?><a href="tel:<?= e($n['tel']) ?>"><?= e($n['display']) ?></a><?php endforeach; ?>.</p>
      </div>

      <div data-lang="bn">
        <h1 class="listing-page-title">গোপনীয়তা নীতি</h1>
        <p class="acct-muted">সর্বশেষ হালনাগাদ: <?= date('j F Y') ?></p>

        <h2>আমরা কী সংগ্রহ করি</h2>
        <p>আপনি SaleBari-তে এলে সাইটটি কীভাবে ব্যবহৃত হচ্ছে তা আমরা রেকর্ড করি: কোন পেজ ও পণ্য দেখছেন, কোন ক্যাটাগরি ঘুরছেন, কী খুঁজছেন, কোন বাটনে চাপ দিচ্ছেন (যেমন হোয়াটসঅ্যাপ বা কল), কতদূর স্ক্রল করছেন, কতক্ষণ থাকছেন, কোন ওয়েবসাইট বা বিজ্ঞাপন থেকে এসেছেন, আপনার ডিভাইসের ধরন, স্ক্রিন সাইজ ও ভাষা। এই তথ্যে আপনার নাম, ফোন নম্বর বা ইমেইল সরাসরি রাখা হয় না।</p>
        <p>আপনি সেলার অ্যাকাউন্ট খুললে বা স্টল খুললে আপনার দেওয়া তথ্য (নাম, মোবাইল নম্বর, ইমেইল, ঠিকানা, লিস্টিংয়ের তথ্য) আমরা অ্যাকাউন্ট চালাতে ও আপনার লিস্টিং দেখাতে সংরক্ষণ করি।</p>

        <h2>অ্যানালিটিক্স ও বিজ্ঞাপন টুল</h2>
        <p>সাইট ব্যবহার বুঝতে আমরা <strong>Google Analytics</strong> (এবং প্রয়োজনে Google Tag Manager) এবং বিজ্ঞাপন পরিমাপ ও উন্নত করতে <strong>Meta (Facebook) Pixel</strong> ব্যবহার করি। এই টুলগুলো কুকি ব্যবহার করতে পারে এবং উপরের তথ্য একটি এলোমেলো ভিজিটর আইডির সাথে পায়। আপনি সেলার হিসেবে লগইন করা থাকলে এবং কুকি গ্রহণ করলে, আপনার ইমেইল ও ফোন নম্বরের একটি <em>হ্যাশ করা</em> (এনকোড করা, ফিরিয়ে পড়া যায় না এমন) সংস্করণ তাদের সাথে শেয়ার হতে পারে।</p>

        <h2>আপনার পছন্দ</h2>
        <p>প্রথমবার এলে আপনি <strong>গ্রহণ</strong> বা <strong>প্রত্যাখ্যান</strong> করতে পারেন। প্রত্যাখ্যান করলে Meta Pixel লোড হয় না এবং Google কুকি ও বিজ্ঞাপন ফিচার ছাড়া চলে। যেকোনো সময় মত বদলাতে পারেন:</p>
        <p><button type="button" class="btn btn-ghost" id="resetConsentBn">আমার কুকি পছন্দ বদলান</button></p>

        <h2>যোগাযোগ</h2>
        <p>আপনার তথ্য দেখতে, ঠিক করতে বা মুছে ফেলতে হোয়াটসঅ্যাপে মেসেজ করুন বা কল করুন:
          <?php foreach ($phones as $i => $n): ?><?= $i ? ' / ' : '' ?><a href="tel:<?= e($n['tel']) ?>"><?= e($n['display']) ?></a><?php endforeach; ?>.</p>
      </div>
    </article>
  </div>
</section>
<?php ob_start(); ?>
<script>
  ['resetConsent', 'resetConsentBn'].forEach(function (id) {
    var b = document.getElementById(id);
    if (b) b.addEventListener('click', function () {
      try { localStorage.removeItem('sb_consent'); } catch (e) {}
      location.reload();
    });
  });
</script>
<?php
site_footer(ob_get_clean());
