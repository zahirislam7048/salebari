<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$perPage = 30;
$page    = input_int('page', 1);
$total   = (int) scalar('SELECT COUNT(*) FROM subscribers');
$p       = paginate($total, $perPage, $page);
$rows    = rows('SELECT * FROM subscribers ORDER BY id DESC LIMIT ' . $p['per'] . ' OFFSET ' . $p['offset']);

admin_header('Subscribers');
?>
<div class="admin-card">
  <div class="admin-toolbar"><strong><?= $p['total'] ?></strong><span class="muted">newsletter subscribers</span></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Email</th><th>Subscribed</th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="2" class="muted">No subscribers yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr><td><?= e($r['email']) ?></td><td><?= e($r['created_at']) ?></td></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php if ($p['pages'] > 1): ?>
    <div class="admin-pagination">
      <?php for ($i = 1; $i <= $p['pages']; $i++): ?>
        <a href="<?= url('admin/subscribers.php', ['page' => $i]) ?>" class="<?= $i === $p['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>
<?php
admin_footer();
