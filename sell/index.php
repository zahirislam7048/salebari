<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}

$packages = [
    'growth-blueprint' => ['sell.pkg.1', 'Growth BluePrint — ৳500 / month'],
    'scale-system'     => ['sell.pkg.2', 'Scale System — ৳2,500 / month'],
    'growth-partner'   => ['sell.pkg.3', 'Growth Partner — ৳10,000 / month'],
];
$planByNumber = ['1' => 'growth-blueprint', '2' => 'scale-system', '3' => 'growth-partner'];

/* Bangladesh's 64 districts: [English, Bangla]. */
$districts = [
    ['Bagerhat', 'বাগেরহাট'], ['Bandarban', 'বান্দরবান'], ['Barguna', 'বরগুনা'], ['Barishal', 'বরিশাল'],
    ['Bhola', 'ভোলা'], ['Bogura', 'বগুড়া'], ['Brahmanbaria', 'ব্রাহ্মণবাড়িয়া'], ['Chandpur', 'চাঁদপুর'],
    ['Chapainawabganj', 'চাঁপাইনবাবগঞ্জ'], ['Chattogram', 'চট্টগ্রাম'], ['Chuadanga', 'চুয়াডাঙ্গা'], ['Cumilla', 'কুমিল্লা'],
    ['Cox\'s Bazar', 'কক্সবাজার'], ['Dhaka', 'ঢাকা'], ['Dinajpur', 'দিনাজপুর'], ['Faridpur', 'ফরিদপুর'],
    ['Feni', 'ফেনী'], ['Gaibandha', 'গাইবান্ধা'], ['Gazipur', 'গাজীপুর'], ['Gopalganj', 'গোপালগঞ্জ'],
    ['Habiganj', 'হবিগঞ্জ'], ['Jamalpur', 'জামালপুর'], ['Jashore', 'যশোর'], ['Jhalokati', 'ঝালকাঠি'],
    ['Jhenaidah', 'ঝিনাইদহ'], ['Joypurhat', 'জয়পুরহাট'], ['Khagrachhari', 'খাগড়াছড়ি'], ['Khulna', 'খুলনা'],
    ['Kishoreganj', 'কিশোরগঞ্জ'], ['Kurigram', 'কুড়িগ্রাম'], ['Kushtia', 'কুষ্টিয়া'], ['Lakshmipur', 'লক্ষ্মীপুর'],
    ['Lalmonirhat', 'লালমনিরহাট'], ['Madaripur', 'মাদারীপুর'], ['Magura', 'মাগুরা'], ['Manikganj', 'মানিকগঞ্জ'],
    ['Meherpur', 'মেহেরপুর'], ['Moulvibazar', 'মৌলভীবাজার'], ['Munshiganj', 'মুন্সীগঞ্জ'], ['Mymensingh', 'ময়মনসিংহ'],
    ['Naogaon', 'নওগাঁ'], ['Narail', 'নড়াইল'], ['Narayanganj', 'নারায়ণগঞ্জ'], ['Narsingdi', 'নরসিংদী'],
    ['Natore', 'নাটোর'], ['Netrokona', 'নেত্রকোণা'], ['Nilphamari', 'নীলফামারী'], ['Noakhali', 'নোয়াখালী'],
    ['Pabna', 'পাবনা'], ['Panchagarh', 'পঞ্চগড়'], ['Patuakhali', 'পটুয়াখালী'], ['Pirojpur', 'পিরোজপুর'],
    ['Rajbari', 'রাজবাড়ী'], ['Rajshahi', 'রাজশাহী'], ['Rangamati', 'রাঙ্গামাটি'], ['Rangpur', 'রংপুর'],
    ['Satkhira', 'সাতক্ষীরা'], ['Shariatpur', 'শরীয়তপুর'], ['Sherpur', 'শেরপুর'], ['Sirajganj', 'সিরাজগঞ্জ'],
    ['Sunamganj', 'সুনামগঞ্জ'], ['Sylhet', 'সিলেট'], ['Tangail', 'টাঙ্গাইল'], ['Thakurgaon', 'ঠাকুরগাঁও'],
];

$me     = seller();
$errors = [];
$old    = [
    'name'     => '',
    'mobile'   => '',
    'email'    => '',
    'package'  => $planByNumber[(string) input('plan', '')] ?? '',
    'district' => '',
    'area'     => '',
];

if (is_post()) {
    csrf_check();
    if ((string) input('company_url') !== '') {
        exit; // honeypot: real visitors never see or fill this field
    }

    foreach (['name', 'mobile', 'email', 'package', 'district', 'area'] as $k) {
        $old[$k] = (string) input($k);
    }
    $pass  = (string) ($_POST['password'] ?? '');
    $names = array_column($districts, 0);

    if (mb_strlen($old['name']) < 2) {
        $errors[] = 'Please enter your name or business name.';
    }
    if (!isset($packages[$old['package']])) {
        $errors[] = 'Please choose a package.';
    }
    if (!in_array($old['district'], $names, true)) {
        $errors[] = 'Please select your district.';
    }
    if (!input('terms')) {
        $errors[] = 'Please accept the terms and conditions to continue.';
    }

    $phone = null;
    $email = null;
    if (!$me) {
        $phone = normalize_bd_phone($old['mobile']);
        if ($phone === null) {
            $errors[] = 'Enter a valid Bangladesh mobile number (e.g. 01712345678).';
        }
        if ($old['email'] !== '') {
            if (valid_email($old['email'])) {
                $email = strtolower($old['email']);
            } else {
                $errors[] = 'That email address does not look right.';
            }
        }
        if (strlen($pass) < 8) {
            $errors[] = 'Use at least 8 characters for your password.';
        }
        if (!$errors && row('SELECT id FROM sellers WHERE phone = ?', [$phone])) {
            $errors[] = 'An account with this mobile number already exists. Please log in, then open your stall from My account.';
        }
        if (!$errors && $email && row('SELECT id FROM sellers WHERE email = ?', [$email])) {
            $errors[] = 'An account with this email already exists. Please log in instead.';
        }
    }

    if (!$errors) {
        try {
            if (!$me) {
                $sellerId = insert('sellers', [
                    'name'          => $old['name'],
                    'email'         => $email,
                    'phone'         => $phone,
                    'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
                    'status'        => 'active',
                    'created_at'    => now(),
                ]);
                login_seller(['id' => $sellerId]);
            } else {
                $sellerId = (int) $me['id'];
                $phone    = $me['phone'];
            }

            insert('stalls', [
                'name'          => $old['name'],
                'slug'          => unique_slug('stalls', slugify($old['name'])),
                'city'          => $old['district'],
                'address'       => $old['area'] !== '' ? $old['area'] : null,
                'phone'         => $phone,
                'package'       => $old['package'],
                'seller_id'     => $sellerId,
                'review_status' => 'pending',
                'status'        => 'active',
                'verified'      => 0,
                'product_count' => 0,
                'sort_order'    => 0,
                'created_at'    => now(),
            ]);
            if (!$me) {
                track_queue('sign_up', ['method' => $email ? 'email' : 'phone', 'user_data' => array_filter(['sha256_email_address' => track_hash_email($email), 'sha256_phone_number' => track_hash_phone($phone)])]);
            }
            track_queue('generate_lead', ['method' => 'open_stall', 'package' => $old['package'], 'district' => $old['district']]);
            flash('success', 'Your stall has been submitted. It will go live on SaleBari as soon as our team approves it. You can add more details from here.');
            redirect('account/');
        } catch (Throwable $ex) {
            $errors[] = 'Could not open your stall right now. Please try again in a moment.';
        }
    }
}

site_header('Open your stall');
?>
<section class="section category-page">
  <div class="wrap">
    <div class="sell-intro">
      <h1 class="sell-title" data-i18n="sell.title">Open your stall — list your business on SaleBari</h1>
      <p class="acct-muted" data-i18n="sell.sub">Create your stall in a minute and start reaching buyers across Bangladesh.</p>
    </div>

    <div class="sell-layout">
      <div class="sell-benefits">
        <div class="sell-benefit"><span class="sell-ico">🏷️</span><div><h3 data-i18n="sell.b1.t">List your showroom products</h3><p data-i18n="sell.b1.d">Show your products to buyers with photos, prices and a WhatsApp button.</p></div></div>
        <div class="sell-benefit"><span class="sell-ico">🏬</span><div><h3 data-i18n="sell.b2.t">Your own stall page</h3><p data-i18n="sell.b2.d">Get a public page with your address, map, contact details and products.</p></div></div>
        <div class="sell-benefit"><span class="sell-ico">⚡</span><div><h3 data-i18n="sell.b3.t">Reach buyers faster</h3><p data-i18n="sell.b3.d">Buyers browse SaleBari by category, city and brand to find sellers like you.</p></div></div>
        <div class="sell-benefit"><span class="sell-ico">🇧🇩</span><div><h3 data-i18n="sell.b4.t">Built for Bangladesh</h3><p data-i18n="sell.b4.d">Works in Bangla and English, and on any phone.</p></div></div>
      </div>

      <div class="acct-card sell-form-card">
        <h2 class="sell-form-title" data-i18n="sell.form.t">Set up your stall</h2>
        <p class="acct-muted" data-i18n="sell.form.d">Fill in the details below. Our team reviews every new stall before it goes live.</p>

        <?php foreach ($errors as $err): ?><p class="acct-error"><?= e($err) ?></p><?php endforeach; ?>

        <form method="post" class="acct-form">
          <?= csrf_field() ?>
          <div class="acct-hp" aria-hidden="true"><label>Company URL <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>

          <?php if ($me): ?>
            <p class="acct-note" style="margin:0">Logged in as <strong><?= e($me['name']) ?></strong> (<?= e($me['email'] ?: $me['phone']) ?>)</p>
          <?php endif; ?>

          <label class="acct-field"><span data-i18n="sell.f.name">Your name / business name *</span>
            <input type="text" name="name" required maxlength="160" autocomplete="organization" value="<?= e($old['name']) ?>"></label>

          <?php if (!$me): ?>
            <label class="acct-field"><span data-i18n="sell.f.mobile">Mobile number *</span>
              <input type="tel" name="mobile" required maxlength="20" inputmode="tel" autocomplete="tel" placeholder="01712345678" value="<?= e($old['mobile']) ?>"></label>
            <label class="acct-field"><span data-i18n="sell.f.email">Email (optional)</span>
              <input type="email" name="email" maxlength="190" autocomplete="email" value="<?= e($old['email']) ?>"></label>
            <label class="acct-field"><span data-i18n="sell.f.password">Create a password (min. 8 characters) *</span>
              <input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
          <?php endif; ?>

          <label class="acct-field"><span data-i18n="sell.f.package">Package *</span>
            <select name="package" required>
              <option value="" data-i18n="sell.f.packagePick">Choose a package</option>
              <?php foreach ($packages as $slug => [$key, $label]): ?>
                <option value="<?= e($slug) ?>" data-i18n="<?= e($key) ?>" <?= $old['package'] === $slug ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select></label>

          <label class="acct-field"><span data-i18n="sell.f.district">Location *</span>
            <select name="district" id="sellDistrict" required>
              <option value="" data-i18n="sell.f.districtPick">Select your district</option>
              <?php foreach ($districts as [$en, $bn]): ?>
                <option value="<?= e($en) ?>" data-bn="<?= e($bn) ?>" <?= $old['district'] === $en ? 'selected' : '' ?>><?= e($en) ?></option>
              <?php endforeach; ?>
            </select></label>

          <label class="acct-field"><span data-i18n="sell.f.area">Area / full address (optional)</span>
            <input type="text" name="area" maxlength="255" value="<?= e($old['area']) ?>">
            <small class="acct-muted" data-i18n="sell.f.areaHint">Can't find your area? Type it here.</small></label>

          <label class="acct-check"><input type="checkbox" name="terms" value="1" required <?= input('terms') ? 'checked' : '' ?>>
            <span data-i18n="sell.f.terms">I agree to the terms and conditions</span></label>

          <button class="btn btn-primary acct-submit" type="submit" data-i18n="sell.f.submit">Open my stall</button>
        </form>
        <?php if (!$me): ?>
          <p class="acct-muted"><span data-i18n="sell.haveAccount">Already have an account?</span> <a href="../account/login.php" data-i18n="sell.login">Log in</a></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php ob_start(); ?>
<script>
  /* Bilingual copy for this page, merged into the shared EN/বাংলা dictionary. */
  (function () {
    var add = {
      'sell.title':  { en: 'Open your stall — list your business on SaleBari', bn: 'আপনার স্টল খুলুন — SaleBari-তে আপনার ব্যবসা তুলে ধরুন' },
      'sell.sub':    { en: 'Create your stall in a minute and start reaching buyers across Bangladesh.', bn: 'এক মিনিটেই স্টল তৈরি করুন এবং সারা বাংলাদেশের ক্রেতাদের কাছে পৌঁছান।' },
      'sell.b1.t':   { en: 'List your showroom products', bn: 'আপনার শোরুমের পণ্য তালিকাভুক্ত করুন' },
      'sell.b1.d':   { en: 'Show your products to buyers with photos, prices and a WhatsApp button.', bn: 'ছবি, দাম ও হোয়াটসঅ্যাপ বাটনসহ ক্রেতাদের কাছে পণ্য দেখান।' },
      'sell.b2.t':   { en: 'Your own stall page', bn: 'আপনার নিজস্ব স্টল পেজ' },
      'sell.b2.d':   { en: 'Get a public page with your address, map, contact details and products.', bn: 'ঠিকানা, ম্যাপ, যোগাযোগ ও পণ্যসহ একটি পাবলিক পেজ পান।' },
      'sell.b3.t':   { en: 'Reach buyers faster', bn: 'দ্রুত ক্রেতার কাছে পৌঁছান' },
      'sell.b3.d':   { en: 'Buyers browse SaleBari by category, city and brand to find sellers like you.', bn: 'ক্রেতারা ক্যাটাগরি, শহর ও ব্র্যান্ড অনুযায়ী আপনার মতো বিক্রেতা খুঁজে নেন।' },
      'sell.b4.t':   { en: 'Built for Bangladesh', bn: 'বাংলাদেশের জন্য তৈরি' },
      'sell.b4.d':   { en: 'Works in Bangla and English, and on any phone.', bn: 'বাংলা ও ইংরেজিতে, যেকোনো ফোনে ব্যবহারযোগ্য।' },
      'sell.form.t': { en: 'Set up your stall', bn: 'আপনার স্টল সেট আপ করুন' },
      'sell.form.d': { en: 'Fill in the details below. Our team reviews every new stall before it goes live.', bn: 'নিচের তথ্য পূরণ করুন। প্রতিটি নতুন স্টল লাইভ হওয়ার আগে আমাদের টিম যাচাই করে।' },
      'sell.f.name':     { en: 'Your name / business name *', bn: 'আপনার নাম / ব্যবসার নাম *' },
      'sell.f.mobile':   { en: 'Mobile number *', bn: 'মোবাইল নম্বর *' },
      'sell.f.email':    { en: 'Email (optional)', bn: 'ইমেইল (ঐচ্ছিক)' },
      'sell.f.password': { en: 'Create a password (min. 8 characters) *', bn: 'পাসওয়ার্ড তৈরি করুন (কমপক্ষে ৮ অক্ষর) *' },
      'sell.f.package':  { en: 'Package *', bn: 'প্যাকেজ *' },
      'sell.f.packagePick': { en: 'Choose a package', bn: 'একটি প্যাকেজ বেছে নিন' },
      'sell.pkg.1': { en: 'Growth BluePrint — ৳500 / month', bn: 'গ্রোথ ব্লুপ্রিন্ট — ৳৫০০ / মাস' },
      'sell.pkg.2': { en: 'Scale System — ৳2,500 / month', bn: 'স্কেল সিস্টেম — ৳২,৫০০ / মাস' },
      'sell.pkg.3': { en: 'Growth Partner — ৳10,000 / month', bn: 'গ্রোথ পার্টনার — ৳১০,০০০ / মাস' },
      'sell.f.district':     { en: 'Location *', bn: 'অবস্থান *' },
      'sell.f.districtPick': { en: 'Select your district', bn: 'আপনার জেলা বেছে নিন' },
      'sell.f.area':     { en: 'Area / full address (optional)', bn: 'এলাকা / পূর্ণ ঠিকানা (ঐচ্ছিক)' },
      'sell.f.areaHint': { en: "Can't find your area? Type it here.", bn: 'আপনার এলাকা খুঁজে পাচ্ছেন না? এখানে লিখুন।' },
      'sell.f.terms':    { en: 'I agree to the terms and conditions', bn: 'আমি শর্তাবলী মেনে নিচ্ছি' },
      'sell.f.submit':   { en: 'Open my stall', bn: 'আমার স্টল খুলুন' },
      'sell.haveAccount': { en: 'Already have an account?', bn: 'আগে থেকেই অ্যাকাউন্ট আছে?' },
      'sell.login':      { en: 'Log in', bn: 'লগইন করুন' }
    };
    Object.keys(add).forEach(function (k) { window.I18N.dict[k] = add[k]; });

    /* District names are plain <option> text; relabel them when the language flips. */
    var districtSel = document.getElementById('sellDistrict');
    function relabel() {
      var bn = document.documentElement.lang === 'bn';
      if (!districtSel) return;
      Array.prototype.forEach.call(districtSel.options, function (o) {
        if (o.getAttribute('data-bn')) o.textContent = bn ? o.getAttribute('data-bn') : o.value;
      });
    }
    new MutationObserver(relabel).observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });
    window.I18N.applyLanguage(window.I18N.currentLang());
    relabel();
  })();
</script>
<?php
site_footer(ob_get_clean());
