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
    $rep    = row('SELECT * FROM ad_reports WHERE id = ?', [$id]);

    if ($rep && $action === 'resolve') {
        update('ad_reports', ['status' => 'resolved'], 'id = ?', [$id]);
        flash('success', 'Marked as resolved.');
    } elseif ($rep && $action === 'reopen') {
        update('ad_reports', ['status' => 'new'], 'id = ?', [$id]);
    } elseif ($rep && $action === 'hide_product') {
        update('products', ['status' => 'hidden'], 'id = ?', [(int) $rep['product_id']]);
        update('ad_reports', ['status' => 'resolved'], 'product_id = ? AND status = ?', [(int) $rep['product_id'], 'new']);
        flash('success', 'The listing is now hidden from the site and its reports are resolved.');
    } elseif ($rep && $action === 'delete') {
        delete_from('ad_reports', 'id = ?', [$id]);
        flash('success', 'Report deleted.');
    }
    redirect('admin/reports.php');
}

$rows = rows(
    'SELECT r.*, p.title_en, p.slug, p.status AS pstatus, p.id AS pid
       FROM ad_reports r LEFT JOIN products p ON p.id = r.product_id
      ORDER BY (r.status = \'new\') DESC, r.id DESC LIMIT 300'
);
$labels = report_reasons();

admin_header('Reports');
?>
<div class="admin-card">
  <p class="muted" style="margin-top:0">Listings that visitors reported from the product page ("Report this ad"). Open the listing, then hide it if the report is right.</p>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Listing</th><th>Reason</th><th>Details</th><th>Reporter</th><th>Date</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?><tr><td colspan="7" class="muted">No reports. That is good news.</td></tr><?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['slug']): ?><a href="<?= e(product_url(['slug' => $r['slug'], 'id' => $r['pid']])) ?>" target="_blank"><?= e($r['title_en']) ?></a><?php if ($r['pstatus'] !== 'active'): ?> <span class="muted">(hidden)</span><?php endif; ?><?php else: ?>— deleted —<?php endif; ?></td>
            <td><?= e($labels[$r['reason']] ?? $r['reason']) ?></td>
            <td style="max-width:300px"><?= e((string) $r['message']) ?></td>
            <td><?= e((string) $r['contact']) ?: '<span class="muted">—</span>' ?></td>
            <td><?= e(substr((string) $r['created_at'], 0, 16)) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['status'] === 'new' ? 'no' : 'yes' ?>"><?= $r['status'] === 'new' ? 'New' : 'Resolved' ?></span></td>
            <td class="admin-row-actions">
              <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                <?php if ($r['status'] === 'new'): ?>
                  <input type="hidden" name="action" value="resolve"><button class="admin-btn admin-btn-ghost admin-btn-sm" type="submit">Resolve</button>
                <?php else: ?>
                  <input type="hidden" name="action" value="reopen"><button class="admin-btn admin-btn-ghost admin-btn-sm" type="submit">Reopen</button>
                <?php endif; ?>
              </form>
              <?php if ($r['slug'] && $r['pstatus'] === 'active'): ?>
                <form method="post" style="display:inline" onsubmit="return confirm('Hide this listing from the site?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><input type="hidden" name="action" value="hide_product"><button class="admin-btn admin-btn-primary admin-btn-sm" type="submit">Hide listing</button></form>
              <?php endif; ?>
              <form method="post" style="display:inline" onsubmit="return confirm('Delete this report?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><input type="hidden" name="action" value="delete"><button class="admin-btn admin-btn-danger admin-btn-sm" type="submit">Delete</button></form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
admin_footer();
