<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
if (seller()) {
    redirect('account/');
}

$error = null;
$ident = '';
$pendingNotice = false;

if (is_post()) {
    csrf_check();
    $ident = (string) input('ident');
    $pass  = (string) ($_POST['password'] ?? '');

    /* Simple brute-force brake: 5 misses lock this browser session for 10 minutes. */
    $fails = $_SESSION['seller_fails'] ?? ['n' => 0, 't' => 0];
    if ($fails['n'] >= 5 && time() - $fails['t'] < 600) {
        $error = 'Too many attempts. Please wait a few minutes and try again.';
    } else {
        $s = find_seller_by_identifier($ident);
        if ($s && $s['status'] === 'active' && password_verify($pass, $s['password_hash'])) {
            unset($_SESSION['seller_fails']);
            login_seller($s);
            track_queue('login', ['method' => valid_email(trim($ident)) ? 'email' : 'phone']);
            redirect('account/');
        }
        $passwordOk = $s && password_verify($pass, $s['password_hash']);
        if ($passwordOk && $s['status'] === 'pending') {
            $pendingNotice = true;     // right password, but not approved yet
        } else {
            $_SESSION['seller_fails'] = ['n' => ($fails['n'] >= 5 ? 0 : $fails['n']) + 1, 't' => time()];
            usleep(300000);
            $error = $passwordOk && $s['status'] !== 'active'
                ? 'This account has been suspended. Please contact SaleBari support.'
                : 'Wrong email/phone or password.';
        }
    }
}

site_header('Log in');
?>
<section class="section category-page">
  <div class="wrap">
    <div class="acct-card acct-card-narrow">
      <h1 class="listing-page-title">Log in</h1>
      <p class="acct-muted">Use the email or mobile number you signed up with.</p>
      <?php foreach (take_flashes() as $f): ?>
        <?php if ($f['type'] === 'pending'): ?>
          <div class="acct-pending"><span class="acct-pending-ico">⏳</span><div><strong>Waiting for approval and verification</strong><p><?= e($f['msg']) ?></p></div></div>
        <?php else: ?>
          <p class="acct-flash acct-flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></p>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php if ($pendingNotice): ?>
        <div class="acct-pending"><span class="acct-pending-ico">⏳</span><div><strong>Waiting for approval and verification</strong><p>Your account has not been approved yet. We will contact you on the number you gave to verify your details, and you can log in as soon as it is approved.</p></div></div>
      <?php endif; ?>
      <?php if ($error): ?><p class="acct-error"><?= e($error) ?></p><?php endif; ?>

      <form method="post" class="acct-form">
        <?= csrf_field() ?>
        <label class="acct-field"><span>Email or mobile number</span>
          <input type="text" name="ident" required autocomplete="username" value="<?= e($ident) ?>"></label>
        <label class="acct-field"><span>Password</span>
          <input type="password" name="password" required autocomplete="current-password"></label>
        <button class="btn btn-primary acct-submit" type="submit">Log in</button>
      </form>
      <p class="acct-muted">New to SaleBari? <a href="register.php">Create a seller account</a></p>
    </div>
  </div>
</section>
<?php
site_footer();
