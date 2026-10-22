<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
if (seller()) {
    redirect('account/');
}

$errors = [];
$old    = ['name' => '', 'ident' => ''];

if (is_post()) {
    csrf_check();
    if (input('company_url') !== '' && input('company_url') !== null) {
        exit; // honeypot: real visitors never see or fill this field
    }

    $old['name']  = (string) input('name');
    $old['ident'] = (string) input('ident');
    $pass         = (string) ($_POST['password'] ?? '');
    $pass2        = (string) ($_POST['password2'] ?? '');

    if (mb_strlen($old['name']) < 2) {
        $errors[] = 'Please enter your name.';
    }

    $email = null;
    $phone = null;
    if (valid_email($old['ident'])) {
        $email = strtolower($old['ident']);
    } elseif (($phone = normalize_bd_phone($old['ident'])) === null) {
        $errors[] = 'Enter a valid email address or a Bangladesh mobile number (e.g. 01712345678).';
    }
    if (strlen($pass) < 8) {
        $errors[] = 'Use at least 8 characters for your password.';
    }
    if ($pass !== $pass2) {
        $errors[] = 'The two passwords do not match.';
    }
    if (!$errors && find_seller_by_identifier($old['ident'])) {
        $errors[] = 'An account with this ' . ($email ? 'email' : 'phone number') . ' already exists. Try logging in instead.';
    }

    if (!$errors) {
        try {
            $id = insert('sellers', [
                'name'          => $old['name'],
                'email'         => $email,
                'phone'         => $phone,
                'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
                'status'        => 'pending',   // waits for admin approval and verification
                'created_at'    => now(),
            ]);
            track_queue('sign_up', ['method' => $email ? 'email' : 'phone', 'user_data' => array_filter(['sha256_email_address' => track_hash_email($email), 'sha256_phone_number' => track_hash_phone($phone)])]);
            flash('pending', 'Thank you! Your details have been submitted. Your account is now waiting for approval and verification by our team. You will be able to log in as soon as it is approved.');
            redirect('account/login.php');
        } catch (Throwable $ex) {
            $errors[] = 'Could not create your account right now. Please try again in a moment.';
        }
    }
}

site_header('Create your account');
?>
<section class="section category-page">
  <div class="wrap">
    <div class="acct-card acct-card-narrow">
      <h1 class="listing-page-title">Create your seller account</h1>
      <p class="acct-muted">Sign up with your email or mobile number, then list your own stall or brand on SaleBari.</p>

      <?php foreach ($errors as $err): ?><p class="acct-error"><?= e($err) ?></p><?php endforeach; ?>

      <form method="post" class="acct-form" autocomplete="on">
        <?= csrf_field() ?>
        <div class="acct-hp" aria-hidden="true"><label>Company URL <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>
        <label class="acct-field"><span>Your name</span>
          <input type="text" name="name" required maxlength="120" autocomplete="name" value="<?= e($old['name']) ?>"></label>
        <label class="acct-field"><span>Email or mobile number</span>
          <input type="text" name="ident" required maxlength="190" autocomplete="username" placeholder="you@example.com or 01712345678" value="<?= e($old['ident']) ?>"></label>
        <label class="acct-field"><span>Password (min. 8 characters)</span>
          <input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
        <label class="acct-field"><span>Confirm password</span>
          <input type="password" name="password2" required minlength="8" autocomplete="new-password"></label>
        <button class="btn btn-primary acct-submit" type="submit">Create account</button>
      </form>
      <p class="acct-muted">Already have an account? <a href="login.php">Log in</a></p>
    </div>
  </div>
</section>
<?php
site_footer();
