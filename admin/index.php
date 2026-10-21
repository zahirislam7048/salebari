<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$stats = [
    'Categories'  => (int) scalar('SELECT COUNT(*) FROM categories'),
    'Products'    => (int) scalar('SELECT COUNT(*) FROM products'),
    'Stalls'      => (int) scalar('SELECT COUNT(*) FROM stalls'),
    'Shopping Malls' => (int) scalar('SELECT COUNT(*) FROM malls'),
    'Trending Deals' => (int) scalar('SELECT COUNT(*) FROM deals'),
    'Real Estate Strip' => (int) scalar('SELECT COUNT(*) FROM real_estate_listings'),
    'Subscribers' => (int) scalar('SELECT COUNT(*) FROM subscribers'),
];

admin_header('Dashboard');
?>
<div class="admin-stats">
  <?php foreach ($stats as $label => $n): ?>
    <div class="admin-stat"><b><?= e((string) $n) ?></b><span><?= e($label) ?></span></div>
  <?php endforeach; ?>
</div>

<div class="admin-card">
  <p style="margin-top:0">Welcome to the SaleBari content dashboard. Use the sidebar to manage categories, stalls, shopping malls, the homepage's trending deals and real-estate strip, site-wide settings, and newsletter subscribers.</p>
  <p style="margin-bottom:0" class="muted">Changes here update the database; the public site's static pages read from it once the API/front-end wiring (a later phase) is in place.</p>
</div>
<?php
admin_footer();
