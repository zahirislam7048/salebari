<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM real_estate_listings WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id      = input_int('id', 0);
        $titleEn = (string) input('title_en');
        $data    = [
            'title_en'         => $titleEn,
            'title_bn'         => input('title_bn') ?: null,
            'tag'              => input('tag', 'sale') === 'rent' ? 'rent' : 'sale',
            'price_display_en' => (string) input('price_display_en'),
            'price_display_bn' => input('price_display_bn') ?: null,
            'active'           => input('active') ? 1 : 0,
        ];
        if ($titleEn === '' || $data['price_display_en'] === '') {
            flash('error', 'Title and price are required.');
        } elseif ($id) {
            update('real_estate_listings', $data, 'id = ?', [$id]);
            flash('success', 'Listing updated.');
        } else {
            $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM real_estate_listings');
            $data['created_at'] = now();
            insert('real_estate_listings', $data);
            flash('success', 'Listing added.');
        }
        redirect('admin/real_estate.php');
    }

    if ($action === 'delete') {
        delete_from('real_estate_listings', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Listing deleted.');
        redirect('admin/real_estate.php');
    }
}

$rows = rows('SELECT * FROM real_estate_listings ORDER BY sort_order');

admin_header('Real Estate Strip');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit listing' : 'Add a listing' ?></h3>
  <form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Title (English)</span>
      <input type="text" name="title_en" required value="<?= e($editing['title_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Title (Bangla)</span>
      <input type="text" name="title_bn" value="<?= e($editing['title_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>For</span>
      <select name="tag">
        <option value="sale" <?= ($editing['tag'] ?? 'sale') === 'sale' ? 'selected' : '' ?>>Sale</option>
        <option value="rent" <?= ($editing['tag'] ?? '') === 'rent' ? 'selected' : '' ?>>Rent</option>
      </select></label>
    <label class="admin-field"><span>Price (English)</span>
      <input type="text" name="price_display_en" required value="<?= e($editing['price_display_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Price (Bangla)</span>
      <input type="text" name="price_display_bn" value="<?= e($editing['price_display_bn'] ?? '') ?>"></label>
    <label class="admin-check">
      <input type="checkbox" name="active" value="1" <?= !empty($editing['active']) || !$editing ? 'checked' : '' ?>>
      <span>Show on homepage</span>
    </label>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add listing' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/real_estate.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Title</th><th>For</th><th>Price</th><th>Active</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['title_en']) ?></td>
            <td><?= e(ucfirst($r['tag'])) ?></td>
            <td><?= e($r['price_display_en']) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['active'] ? 'yes' : 'no' ?>"><?= $r['active'] ? 'Yes' : 'No' ?></span></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/real_estate.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this listing?');" style="display:inline">
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
