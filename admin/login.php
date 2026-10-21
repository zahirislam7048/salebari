<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
if (is_logged_in()) {
    redirect('admin/index.php');
}

$errors = [];
$email  = '';

if (is_post()) {
    csrf_check();
    $email = (string) input('email');
    $pass  = (string) input('password');

    $user = row('SELECT * FROM users WHERE email = ? AND status = ?', [$email, 'active']);
    if (!$user || !password_verify($pass, $user['password_hash'])) {
        $errors[] = 'Incorrect email or password.';
    } else {
        login_user($user);
        redirect('admin/index.php');
    }
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in — SaleBari Admin</title>
<link rel="stylesheet" href="<?= asset('admin/admin.css') ?>">
</head>
<body class="admin-auth-body">
<div class="admin-auth-wrap">
  <div class="admin-auth-card">
    <h1>SaleBari Admin</h1>
    <p class="muted">Log in to manage the site's content.</p>
    <?php foreach ($errors as $err): ?><p class="admin-error-text"><?= e($err) ?></p><?php endforeach; ?>
    <form method="post">
      <?= csrf_field() ?>
      <label class="admin-field"><span>Email</span>
        <input type="email" name="email" required value="<?= e($email) ?>" autofocus></label>
      <label class="admin-field"><span>Password</span>
        <input type="password" name="password" required></label>
      <button class="admin-btn admin-btn-primary admin-btn-block" type="submit">Log in</button>
    </form>
  </div>
</div>
</body>
</html>
