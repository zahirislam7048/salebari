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

$days = in_array(input_int('days', 30), [7, 30, 90], true) ? input_int('days', 30) : 30;
$perf = seller_performance((int) $me['id'], $days);

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

    <div class="acct-section-head" id="performance">
      <h2>Performance</h2>
      <div class="perf-range">
        <?php foreach ([7, 30, 90] as $d): ?><a href="?days=<?= $d ?>#performance" class="<?= $days === $d ? 'on' : '' ?>">Last <?= $d ?> days</a><?php endforeach; ?>
      </div>
    </div>
    <?php if (!$perf['count']): ?>
      <p class="listing-empty">Your numbers will show up here once products are listed under your stall or brand. Message us on WhatsApp and we will add them.</p>
    <?php else:
        $t = $perf['totals'];
        $enq = $t['wa'] + $t['call'];
        $rate = $t['views'] > 0 ? round($enq / $t['views'] * 100, 1) : 0;
        $maxV = max(1, max(array_column($perf['daily'], 'views')));
    ?>
      <div class="perf-cards">
        <div class="perf-card"><strong><?= number_format($t['views']) ?></strong><span>Product views</span></div>
        <div class="perf-card"><strong><?= number_format($t['wa']) ?></strong><span>WhatsApp taps</span></div>
        <div class="perf-card"><strong><?= number_format($t['call']) ?></strong><span>Call taps</span></div>
        <div class="perf-card"><strong><?= $rate ?>%</strong><span>Of viewers contacted you</span></div>
      </div>
      <?php if ($t['views'] > 0): ?>
        <div class="perf-chart" role="img" aria-label="Daily views over the last <?= (int) $days ?> days">
          <?php foreach ($perf['daily'] as $day => $v): $h = $v['views'] > 0 ? max(4, round($v['views'] / $maxV * 100)) : 1; $inner = $v['views'] > 0 ? min(100, round($v['enq'] / $v['views'] * 100)) : 0; ?>
            <span class="perf-bar" style="height:<?= $h ?>%" title="<?= e(date('j M', strtotime($day))) ?>: <?= (int) $v['views'] ?> views, <?= (int) $v['enq'] ?> contacts"><i style="height:<?= $inner ?>%"></i></span>
          <?php endforeach; ?>
        </div>
        <p class="perf-legend"><span class="perf-key perf-key-v"></span> Views <span class="perf-key perf-key-e"></span> Of which contacted you</p>
      <?php else: ?>
        <p class="acct-muted">No visits recorded in the last <?= (int) $days ?> days yet. Share your product links on Facebook and WhatsApp to bring buyers in.</p>
      <?php endif; ?>
      <div class="acct-list">
        <?php foreach (array_slice($perf['products'], 0, 10) as $p): ?>
          <div class="acct-item perf-row">
            <div class="acct-item-main"><a href="<?= e(product_url($p)) ?>"><strong><?= e($p['title_en']) ?></strong></a><?php if ($p['status'] !== 'active'): ?><span class="acct-muted">hidden</span><?php endif; ?></div>
            <div class="perf-nums"><span><b><?= number_format($p['views']) ?></b> views</span><span><b><?= number_format($p['wa']) ?></b> WhatsApp</span><span><b><?= number_format($p['call']) ?></b> calls</span></div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="acct-note">Counts are the number of visits (one per visitor per session) and button taps on your product pages. Search-engine bots and the SaleBari team are not counted.</p>
    <?php endif; ?>

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
