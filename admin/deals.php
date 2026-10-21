<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM deals WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id      = input_int('id', 0);
        $titleEn = (string) input('title_en');
        $data    = [
            'stall_name'           => (string) input('stall_name'),
            'title_en'             => $titleEn,
            'title_bn'             => input('title_bn') ?: null,
            'icon'                 => input('icon') ?: null,
            'price_display_en'     => (string) input('price_display_en'),
            'price_display_bn'     => input('price_display_bn') ?: null,
            'old_price_display_en' => input('old_price_display_en') ?: null,
            'old_price_display_bn' => input('old_price_display_bn') ?: null,
            'discount_pct'         => input('discount_pct') !== '' ? input_int('discount_pct') : null,
            'gradient'             => input('gradient') ?: null,
            'active'               => input('active') ? 1 : 0,
        ];
        if ($titleEn === '' || $data['price_display_en'] === '') {
            flash('error', 'Title and price are required.');
        } elseif ($id) {
            update('deals', $data, 'id = ?', [$id]);
            flash('success', 'Deal updated.');
        } else {
            $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM deals');
            $data['created_at'] = now();
            insert('deals', $data);
            flash('success', 'Deal added.');
        }
        redirect('admin/deals.php');
    }

    if ($action === 'delete') {
        delete_from('deals', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Deal deleted.');
        redirect('admin/deals.php');
    }
}

$rows = rows('SELECT * FROM deals ORDER BY sort_order');

admin_header('Trending Deals');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit deal' : 'Add a deal' ?></h3>
  <form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Stall name</span>
      <input type="text" name="stall_name" required value="<?= e($editing['stall_name'] ?? '') ?>"></label>
    <label class="admin-field"><span>Title (English)</span>
      <input type="text" name="title_en" required value="<?= e($editing['title_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Title (Bangla)</span>
      <input type="text" name="title_bn" value="<?= e($editing['title_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>Icon (emoji)</span>
      <input type="text" name="icon" maxlength="10" value="<?= e($editing['icon'] ?? '') ?>"></label>
    <label class="admin-field"><span>Price (e.g. "৳ 42 Lakh")</span>
      <input type="text" name="price_display_en" required value="<?= e($editing['price_display_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Old price</span>
      <input type="text" name="old_price_display_en" value="<?= e($editing['old_price_display_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Discount %</span>
      <input type="number" name="discount_pct" min="0" max="99" value="<?= e((string) ($editing['discount_pct'] ?? '')) ?>"></label>
    <label class="admin-field"><span>Card gradient class</span>
      <select name="gradient">
        <?php foreach (['grad-1', 'grad-2', 'grad-3', 'grad-4', 'grad-5', 'grad-6'] as $g): ?>
          <option value="<?= $g ?>" <?= ($editing['gradient'] ?? '') === $g ? 'selected' : '' ?>><?= $g ?></option>
        <?php endforeach; ?>
      </select></label>
    <label class="admin-check">
      <input type="checkbox" name="active" value="1" <?= !empty($editing['active']) || !$editing ? 'checked' : '' ?>>
      <span>Show on homepage</span>
    </label>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add deal' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/deals.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Icon</th><th>Title</th><th>Stall</th><th>Price</th><th>Active</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['icon'] ?? '') ?></td>
            <td><?= e($r['title_en']) ?></td>
            <td><?= e($r['stall_name']) ?></td>
            <td><?= e($r['price_display_en']) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['active'] ? 'yes' : 'no' ?>"><?= $r['active'] ? 'Yes' : 'No' ?></span></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/deals.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this deal?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e((string) $r['id']) ?>">
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
