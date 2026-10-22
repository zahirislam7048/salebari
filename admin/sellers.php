<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

if (is_post()) {
    csrf_check();
    $id     = input_int('id', 0);
    $action = input('action');

    if ($action === 'approve') {
        update('sellers', ['status' => 'active'], 'id = ?', [$id]);
        update('stalls', ['review_status' => 'approved'], "seller_id = ? AND review_status = 'pending'", [$id]);
        update('brands', ['review_status' => 'approved'], "seller_id = ? AND review_status = 'pending'", [$id]);
        flash('success', 'Approved — the seller can now log in, and their pending stall and brand are live.');
    } elseif ($action === 'suspend' || $action === 'activate') {
        update('sellers', ['status' => $action === 'suspend' ? 'suspended' : 'active'], 'id = ?', [$id]);
        flash('success', $action === 'suspend' ? 'Seller suspended — they can no longer log in.' : 'Seller re-activated.');
    }
    redirect('admin/sellers.php');
}

$rows = rows(
    'SELECT s.*,
            (SELECT COUNT(*) FROM stalls  WHERE seller_id = s.id) AS stall_n,
            (SELECT COUNT(*) FROM brands  WHERE seller_id = s.id) AS brand_n
       FROM sellers s ORDER BY (s.status = \'pending\') DESC, s.id DESC LIMIT 200'
);

admin_header('Sellers');
?>
<div class="admin-card">
  <p class="muted" style="margin-top:0">People who signed up on the public site with an email or mobile number. Their stalls and brands appear under Stalls / Brands marked "Pending approval" until you approve them.</p>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Name</th><th>Email / Phone</th><th>Stalls</th><th>Brands</th><th>Joined</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="7" class="muted">No seller accounts yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['name']) ?></td>
            <td><?= e($r['email'] ?: $r['phone']) ?></td>
            <td><?= (int) $r['stall_n'] ?></td>
            <td><?= (int) $r['brand_n'] ?></td>
            <td><?= e(substr((string) $r['created_at'], 0, 10)) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['status'] === 'active' ? 'yes' : 'no' ?>"><?= $r['status'] === 'pending' ? 'Waiting for approval' : e($r['status']) ?></span></td>
            <td class="admin-row-actions">
              <form method="post" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                <?php if ($r['status'] === 'pending'): ?>
                  <input type="hidden" name="action" value="approve">
                  <button class="admin-btn admin-btn-primary admin-btn-sm" type="submit">Approve</button>
                <?php elseif ($r['status'] === 'active'): ?>
                  <input type="hidden" name="action" value="suspend">
                  <button class="admin-btn admin-btn-danger admin-btn-sm" type="submit" onclick="return confirm('Suspend this seller?');">Suspend</button>
                <?php else: ?>
                  <input type="hidden" name="action" value="activate">
                  <button class="admin-btn admin-btn-primary admin-btn-sm" type="submit">Activate</button>
                <?php endif; ?>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
admin_footer();
