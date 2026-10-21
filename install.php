<?php
/* ============================================================
   One-time installer. Creates the tables, an admin account, and
   loads the site's current content (categories, stalls, malls,
   deals, real-estate strip, settings) into the database.
   Delete this file afterwards.
   ============================================================ */

require __DIR__ . '/app/bootstrap.php';
require __DIR__ . '/install/seed.php';

$done   = false;
$errors = [];
$old    = ['name' => 'Administrator', 'email' => ''];

/* Refuse to run again once there is an admin — this file writes tables. */
$already = db_ok() && table_exists('users') && scalar('SELECT COUNT(*) FROM users') > 0;

if (!db_ok()) {
    $errors[] = 'Cannot connect to the database. Check DB_HOST, DB_NAME, DB_USER and DB_PASS in config.php.';
}

if (!$already && is_post() && !$errors) {
    $old['name']  = (string) input('name', 'Administrator');
    $old['email'] = (string) input('email');
    $pass         = (string) input('password');

    if (!valid_email($old['email'])) { $errors[] = 'Enter a valid admin email address.'; }
    if (strlen($pass) < 8)           { $errors[] = 'Use at least 8 characters for the admin password.'; }

    if (!$errors) {
        try {
            create_schema();

            insert('users', [
                'name'          => $old['name'],
                'email'         => $old['email'],
                'password_hash' => password_hash($pass, PASSWORD_DEFAULT),
                'role'          => 'admin',
                'status'        => 'active',
                'created_at'    => now(),
            ]);

            run_seed();

            $done = true;
        } catch (Throwable $ex) {
            $errors[] = 'Install failed: ' . $ex->getMessage();
        }
    }
}

/**
 * Run install/schema.sql. The file is written for MySQL; for SQLite the
 * few type differences are rewritten on the way through so one schema
 * file stays the single source of truth.
 */
function create_schema(): void
{
    $sql = file_get_contents(APP_ROOT . '/install/schema.sql');
    if ($sql === false) {
        throw new RuntimeException('install/schema.sql is missing.');
    }

    $sql = preg_replace('/^\s*--.*$/m', '', $sql);

    foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
        if (DB_DRIVER === 'sqlite') {
            $statement = preg_replace('/INT UNSIGNED AUTO_INCREMENT PRIMARY KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $statement);
            $statement = preg_replace('/\bINT UNSIGNED\b/i', 'INTEGER', $statement);
            $statement = preg_replace('/\bTINYINT\b/i', 'INTEGER', $statement);
            $statement = preg_replace('/\bDECIMAL\s*\([^)]*\)/i', 'REAL', $statement);
            $statement = preg_replace('/\bVARCHAR\s*\([^)]*\)/i', 'TEXT', $statement);
            $statement = preg_replace('/\bDATETIME\b/i', 'TEXT', $statement);
            $statement = preg_replace('/\bINT\b/i', 'INTEGER', $statement);
        } elseif (stripos($statement, 'CREATE TABLE') === 0) {
            $statement .= ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
        }
        db()->exec($statement);
    }
}

$tables = db_ok() && table_exists('settings');
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Install SaleBari</title>
<link rel="stylesheet" href="<?= asset('admin/admin.css') ?>">
</head>
<body class="admin-auth-body">
<div class="admin-auth-wrap">
  <div class="admin-auth-card">
    <h1>Install SaleBari</h1>
    <p class="muted">Admin dashboard setup · driver: <code><?= e(DB_DRIVER) ?></code></p>

    <?php if ($done): ?>
      <div class="admin-flash admin-flash-success">Installed. Log in with the admin account you just created.</div>
      <p class="muted" style="font-size:.9rem">
        <b>Delete <code>install.php</code> from the server now</b> — while it exists, anyone who reaches it can see this page.
      </p>
      <p style="margin-top:18px">
        <a class="admin-btn admin-btn-primary" href="<?= url('admin/login.php') ?>">Log in</a>
        <a class="admin-btn admin-btn-ghost" href="<?= url('index.html') ?>">View the site</a>
      </p>

    <?php elseif ($already): ?>
      <div class="admin-flash admin-flash-info">SaleBari is already installed. Delete <code>install.php</code> from the server.</div>
      <p style="margin-top:18px"><a class="admin-btn admin-btn-primary" href="<?= url('admin/login.php') ?>">Log in</a></p>

    <?php else: ?>
      <?php foreach ($errors as $err): ?><p class="admin-error-text"><?= e($err) ?></p><?php endforeach; ?>

      <?php if ($tables): ?>
        <div class="admin-flash admin-flash-info">Tables already exist — running the installer again will fail. Drop the database tables first if you want a clean start.</div>
      <?php endif; ?>

      <form method="post">
        <label class="admin-field"><span>Admin name</span>
          <input type="text" name="name" required value="<?= e($old['name']) ?>"></label>
        <label class="admin-field"><span>Admin email</span>
          <input type="email" name="email" required value="<?= e($old['email']) ?>"></label>
        <label class="admin-field"><span>Admin password</span>
          <input type="password" name="password" required minlength="8"></label>
        <button class="admin-btn admin-btn-primary admin-btn-block" type="submit" style="margin-top:10px">Install</button>
      </form>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
