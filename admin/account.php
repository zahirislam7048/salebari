<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$user = auth_user();

if (is_post()) {
    csrf_check();
    $name        = (string) input('name');
    $email       = (string) input('email');
    $newPassword = (string) input('new_password');

    if ($name === '' || !valid_email($email)) {
        flash('error', 'Enter a valid name and email.');
    } else {
        $data = ['name' => $name, 'email' => $email];
        if ($newPassword !== '') {
            if (strlen($newPassword) < 8) {
                flash('error', 'New password must be at least 8 characters.');
                redirect('admin/account.php');
            }
            $data['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        update('users', $data, 'id = ?', [$user['id']]);
        flash('success', 'Account updated.');
        redirect('admin/account.php');
    }
}

admin_header('My Account');
?>
<div class="admin-card" style="max-width:440px">
  <form method="post">
    <?= csrf_field() ?>
    <label class="admin-field"><span>Name</span>
      <input type="text" name="name" required value="<?= e($user['name']) ?>"></label>
    <label class="admin-field"><span>Email</span>
      <input type="email" name="email" required value="<?= e($user['email']) ?>"></label>
    <label class="admin-field"><span>New password (leave blank to keep current)</span>
      <input type="password" name="new_password" minlength="8"></label>
    <button class="admin-btn admin-btn-primary" type="submit">Save changes</button>
  </form>
</div>
<?php
admin_footer();
