<?php
/* Shared sidebar/topbar chrome for every admin/*.php page. Not a templating
   system — just two functions each page calls at the top and bottom,
   matching the "plain one-.php-file-per-page" convention (no router). */

function admin_nav_items(): array
{
    return [
        'index.php'       => 'Dashboard',
        'categories.php'  => 'Categories',
        'products.php'    => 'Products',
        'blog.php'        => 'Blog',
        'stalls.php'      => 'Stalls',
        'malls.php'       => 'Shopping Malls',
        'brands.php'      => 'Brands',
        'deals.php'       => 'Trending Deals',
        'real_estate.php' => 'Real Estate Strip',
        'settings.php'    => 'Site Settings',
        'subscribers.php' => 'Subscribers',
        'account.php'     => 'My Account',
    ];
}

function admin_header(string $title, string $extraHead = ''): void
{
    $current = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $user    = auth_user();
    ?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> — SaleBari Admin</title>
<link rel="stylesheet" href="<?= asset('admin/admin.css') ?>">
<?= $extraHead ?>
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <div class="admin-brand">SB Admin</div>
    <nav class="admin-nav">
      <?php foreach (admin_nav_items() as $file => $label): ?>
        <a href="<?= url('admin/' . $file) ?>" class="<?= $current === $file ? 'active' : '' ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <h1><?= e($title) ?></h1>
      <div class="admin-user">
        <?= e($user['name'] ?? '') ?>
        <a href="<?= url('admin/logout.php') ?>">Log out</a>
      </div>
    </div>
    <?php foreach (take_flashes() as $f): ?>
      <div class="admin-flash admin-flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
    <?php endforeach; ?>
    <?php
}

function admin_footer(): void
{
    ?>
  </main>
</div>
</body>
</html>
<?php
}
