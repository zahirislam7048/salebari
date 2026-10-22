<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
$me = require_seller();

if (is_post()) {
    csrf_check();
    $action = input('action');
    $id     = input_int('id', 0);

    if ($action === 'delete_stall' || $action === 'delete_brand') {
        $table = $action === 'delete_stall' ? 'stalls' : 'brands';
        $r = row("SELECT id, logo_image FROM $table WHERE id = ? AND seller_id = ?", [$id, $me['id']]);
        if ($r) {
            if (!empty($r['logo_image'])) {
                delete_uploaded_file($r['logo_image']);
            }
            delete_from($table, 'id = ? AND seller_id = ?', [$id, $me['id']]);
            flash('success', 'Deleted.');
        }
    }
    redirect('account/');
}

$stalls = rows('SELECT * FROM stalls WHERE seller_id = ? ORDER BY id DESC', [$me['id']]);
$brands = rows('SELECT * FROM brands WHERE seller_id = ? ORDER BY id DESC', [$me['id']]);

function acct_badge(string $status): string
{
    $map = ['approved' => ['Live', 'ok'], 'pending' => ['Pending review', 'wait'], 'rejected' => ['Not approved', 'no']];
    [$label, $cls] = $map[$status] ?? [$status, 'wait'];
    return '<span class="acct-badge acct-badge-' . $cls . '">' . e($label) . '</span>';
}

site_header('My account');
?>
<section class="section category-page">
  <div class="wrap">
    <div class="acct-head">
      <div>
        <h1 class="listing-page-title">Hello, <?= e($me['name']) ?></h1>
        <p class="acct-muted" style="margin:0"><?= e($me['email'] ?: $me['phone']) ?></p>
      </div>
      <a class="btn btn-ghost" href="logout.php">Log out</a>
    </div>

    <?php foreach (take_flashes() as $f): ?><p class="acct-flash acct-flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></p><?php endforeach; ?>
    <div class="acct-quick">
      <a class="acct-quick-card" href="brand.php"><span class="acct-quick-ico">🏷️</span><strong>Add your brand</strong><small>Logo, contact details, map, social pages and About</small></a>
      <a class="acct-quick-card" href="stall.php"><span class="acct-quick-ico">🏬</span><strong>Add a stall</strong><small>Your shop, its address and details</small></a>
    </div>
    <p class="acct-note">New listings are reviewed by the SaleBari team before they appear on the public Stall and Brand pages — usually within a day.</p>

    <div class="acct-section-head">
      <h2>My stalls</h2>
      <a class="btn btn-primary" href="stall.php">+ Add a stall</a>
    </div>
    <?php if (!$stalls): ?>
      <p class="listing-empty">You have not added a stall yet.</p>
    <?php else: ?>
      <div class="acct-list">
        <?php foreach ($stalls as $s): ?>
          <div class="acct-item">
            <div class="acct-item-main">
              <strong><?= e($s['name']) ?></strong>
              <span class="acct-muted"><?= e($s['city'] ?: '') ?></span>
              <?= acct_badge((string) $s['review_status']) ?>
            </div>
            <div class="acct-item-actions">
              <a href="<?= e(stall_url($s)) ?>">View</a>
              <a href="stall.php?id=<?= (int) $s['id'] ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this stall?');">
                <?= csrf_field() ?><input type="hidden" name="action" value="delete_stall"><input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                <button type="submit" class="acct-link-danger">Delete</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="acct-section-head">
      <h2>My brands</h2>
      <a class="btn btn-primary" href="brand.php">+ Add a brand</a>
    </div>
    <?php if (!$brands): ?>
      <p class="listing-empty">You have not added a brand yet.</p>
    <?php else: ?>
      <div class="acct-list">
        <?php foreach ($brands as $b): ?>
          <div class="acct-item">
            <div class="acct-item-main">
              <strong><?= e($b['name']) ?></strong>
              <span class="acct-muted"><?= e($b['location'] ?: '') ?></span>
              <?= acct_badge((string) $b['review_status']) ?>
            </div>
            <div class="acct-item-actions">
              <a href="<?= e(brand_url($b)) ?>">View</a>
              <a href="brand.php?id=<?= (int) $b['id'] ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this brand?');">
                <?= csrf_field() ?><input type="hidden" name="action" value="delete_brand"><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
                <button type="submit" class="acct-link-danger">Delete</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php
site_footer();
