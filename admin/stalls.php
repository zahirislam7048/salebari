<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM stalls WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id   = input_int('id', 0);
        $name = (string) input('name');
        $data = [
            'name'          => $name,
            'city'          => input('city') ?: null,
            'address'       => input('address') ?: null,
            'phone'         => input('phone') ?: null,
            'description'   => input('description') ?: null,
            'logo_emoji'    => input('logo_emoji') ?: null,
            'verified'      => input('verified') ? 1 : 0,
            'product_count' => input_int('product_count', 0),
            'status'        => input('status', 'active'),
        ];

        if ($name === '') {
            flash('error', 'Stall name is required.');
            redirect('admin/stalls.php', $id ? ['edit' => $id] : []);
        }

        try {
            $existingLogo = $id ? row('SELECT logo_image FROM stalls WHERE id = ?', [$id])['logo_image'] : null;
            if (input('remove_logo')) {
                if ($existingLogo) delete_uploaded_file($existingLogo);
                $data['logo_image'] = null;
            } elseif (!empty($_FILES['logo_image']['name'])) {
                $newLogo = save_uploaded_image($_FILES['logo_image'], 'stalls');
                if ($newLogo) {
                    if ($existingLogo) delete_uploaded_file($existingLogo);
                    $data['logo_image'] = $newLogo;
                }
            }

            if ($id) {
                update('stalls', $data, 'id = ?', [$id]);
                flash('success', 'Stall updated.');
            } else {
                $data['slug']        = unique_slug('stalls', slugify($name));
                $data['category_id'] = null;
                $data['rating']      = null;
                $data['sort_order']  = 0;
                $data['created_at']  = now();
                insert('stalls', $data);
                flash('success', 'Stall added.');
            }
            redirect('admin/stalls.php');
        } catch (Throwable $ex) {
            $msg = $ex instanceof PDOException
                ? 'Database error: ' . $ex->getMessage() . ' — if this mentions an unknown column, the database is missing a migration this update needs; check README-DEPLOY.md.'
                : $ex->getMessage();
            flash('error', $msg);
            redirect('admin/stalls.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'delete') {
        $s = row('SELECT logo_image FROM stalls WHERE id = ?', [input_int('id', 0)]);
        if (!empty($s['logo_image'])) {
            delete_uploaded_file($s['logo_image']);
        }
        delete_from('stalls', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Stall deleted.');
        redirect('admin/stalls.php');
    }
}

$perPage = 20;
$page    = input_int('page', 1);
$total   = (int) scalar('SELECT COUNT(*) FROM stalls');
$p       = paginate($total, $perPage, $page);
$rows    = rows('SELECT * FROM stalls ORDER BY id DESC LIMIT ' . $p['per'] . ' OFFSET ' . $p['offset']);

admin_header('Stalls');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit stall' : 'Add a stall' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Name</span>
      <input type="text" name="name" required value="<?= e($editing['name'] ?? '') ?>"></label>
    <label class="admin-field"><span>City / District</span>
      <input type="text" name="city" value="<?= e($editing['city'] ?? '') ?>"></label>
    <label class="admin-field"><span>Address</span>
      <input type="text" name="address" value="<?= e($editing['address'] ?? '') ?>"></label>
    <label class="admin-field"><span>Phone</span>
      <input type="text" name="phone" value="<?= e($editing['phone'] ?? '') ?>"></label>
    <label class="admin-field"><span>Description</span>
      <textarea name="description"><?= e($editing['description'] ?? '') ?></textarea></label>

    <?php if (!empty($editing['logo_image'])): ?>
      <div class="admin-field">
        <span>Current logo</span>
        <img src="<?= e(asset($editing['logo_image'])) ?>" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--line);display:block;margin:6px 0">
        <label class="admin-check"><input type="checkbox" name="remove_logo" value="1"> Remove logo</label>
      </div>
    <?php endif; ?>
    <label class="admin-field"><span>Logo image (jpg/png/webp/gif — falls back to the emoji below if not set)</span>
      <input type="file" name="logo_image" accept="image/*"></label>
    <label class="admin-field"><span>Logo emoji (fallback)</span>
      <input type="text" name="logo_emoji" maxlength="10" value="<?= e($editing['logo_emoji'] ?? '') ?>"></label>

    <label class="admin-field"><span>Product count</span>
      <input type="number" name="product_count" min="0" value="<?= e((string) ($editing['product_count'] ?? 0)) ?>"></label>
    <label class="admin-field"><span>Status</span>
      <select name="status">
        <option value="active" <?= ($editing['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="hidden" <?= ($editing['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
      </select></label>
    <label class="admin-check">
      <input type="checkbox" name="verified" value="1" <?= !empty($editing['verified']) ? 'checked' : '' ?>>
      <span>Verified stall</span>
    </label>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add stall' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/stalls.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-toolbar"><strong><?= $p['total'] ?></strong><span class="muted">stalls total</span></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Logo</th><th>Name</th><th>City</th><th>Products</th><th>Verified</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['logo_image']): ?><img src="<?= e(asset($r['logo_image'])) ?>" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:6px"><?php else: ?><?= e($r['logo_emoji'] ?? '—') ?><?php endif; ?></td>
            <td><?= e($r['name']) ?></td>
            <td><?= e($r['city'] ?? '—') ?></td>
            <td><?= e((string) $r['product_count']) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['verified'] ? 'yes' : 'no' ?>"><?= $r['verified'] ? 'Verified' : 'No' ?></span></td>
            <td><?= e($r['status']) ?></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/stalls.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this stall?');" style="display:inline">
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
  <?php if ($p['pages'] > 1): ?>
    <div class="admin-pagination">
      <?php for ($i = 1; $i <= $p['pages']; $i++): ?>
        <a href="<?= url('admin/stalls.php', ['page' => $i]) ?>" class="<?= $i === $p['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>
<?php
admin_footer();
