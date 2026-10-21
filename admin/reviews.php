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
        update('product_reviews', ['status' => 'approved'], 'id = ?', [$id]);
        flash('success', 'Review approved — it is now live on the product page.');
    } elseif ($action === 'hide') {
        update('product_reviews', ['status' => 'pending'], 'id = ?', [$id]);
        flash('success', 'Review hidden from the product page.');
    } elseif ($action === 'delete') {
        delete_from('product_reviews', 'id = ?', [$id]);
        flash('success', 'Review deleted.');
    }
    redirect('admin/reviews.php');
}

$rows = rows(
    'SELECT r.*, p.title_en, p.slug
       FROM product_reviews r LEFT JOIN products p ON p.id = r.product_id
      ORDER BY (r.status = \'pending\') DESC, r.id DESC LIMIT 200'
);

admin_header('Reviews');
?>
<div class="admin-card">
  <p class="muted" style="margin-top:0">Reviews sent from product pages. New ones wait here until you approve them.</p>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Product</th><th>Name</th><th>Rating</th><th>Review</th><th>Date</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="7" class="muted">No reviews yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['slug']): ?><a href="<?= e(url('product.php', ['slug' => $r['slug']])) ?>" target="_blank"><?= e($r['title_en']) ?></a><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['name']) ?></td>
            <td><?= str_repeat('★', (int) $r['rating']) ?></td>
            <td style="max-width:320px"><?= e($r['comment']) ?></td>
            <td><?= e(substr((string) $r['created_at'], 0, 10)) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['status'] === 'approved' ? 'yes' : 'no' ?>"><?= $r['status'] === 'approved' ? 'Live' : 'Pending' ?></span></td>
            <td class="admin-row-actions">
              <form method="post" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                <?php if ($r['status'] !== 'approved'): ?>
                  <input type="hidden" name="action" value="approve">
                  <button class="admin-btn admin-btn-primary admin-btn-sm" type="submit">Approve</button>
                <?php else: ?>
                  <input type="hidden" name="action" value="hide">
                  <button class="admin-btn admin-btn-ghost admin-btn-sm" type="submit">Hide</button>
                <?php endif; ?>
              </form>
              <form method="post" style="display:inline" onsubmit="return confirm('Delete this review?');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button class="admin-btn admin-btn-danger admin-btn-sm" type="submit">Delete</button>
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
