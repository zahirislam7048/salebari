<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM brands WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id   = input_int('id', 0);
        $name = (string) input('name');

        if ($name === '') {
            flash('error', 'Brand name is required.');
            redirect('admin/brands.php', $id ? ['edit' => $id] : []);
        }

        $data = [
            'location'    => input('location') ?: null,
            'address'     => input('address') ?: null,
            'website'     => clean_url(input('website')),
            'mobile'      => input('mobile') ?: null,
            'phone'       => input('phone') ?: null,
            'email'       => valid_email((string) input('email')) ? input('email') : null,
            'map_url'     => clean_map_url(input('map_url')),
            'facebook'    => clean_url(input('facebook')),
            'instagram'   => clean_url(input('instagram')),
            'youtube'     => clean_url(input('youtube')),
            'twitter'     => clean_url(input('twitter')),
            'linkedin'    => clean_url(input('linkedin')),
            'description' => input('description') ?: null,
        ];
        try {
            $existingLogo = $id ? row('SELECT logo_image FROM brands WHERE id = ?', [$id])['logo_image'] : null;
            if (input('remove_logo')) {
                if ($existingLogo) delete_uploaded_file($existingLogo);
                $data['logo_image'] = null;
            } elseif (!empty($_FILES['logo_image']['name'])) {
                $newLogo = save_uploaded_image($_FILES['logo_image'], 'brands');
                if ($newLogo) {
                    if ($existingLogo) delete_uploaded_file($existingLogo);
                    $data['logo_image'] = $newLogo;
                }
            }

            if ($id) {
                $data['name'] = $name;
                $data['slug'] = slug_after_rename('brands', $id, $name, (string) scalar('SELECT slug FROM brands WHERE id = ?', [$id]));
                update('brands', $data, 'id = ?', [$id]);
                flash('success', 'Brand updated.');
            } else {
                $data['name']       = $name;
                $data['slug']       = unique_slug('brands', slugify($name));
                $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM brands');
                $data['created_at'] = now();
                insert('brands', $data);
                flash('success', 'Brand added.');
            }
            redirect('admin/brands.php');
        } catch (Throwable $ex) {
            $msg = $ex instanceof PDOException
                ? 'Database error: ' . $ex->getMessage() . ' — if this mentions an unknown column, the database is missing a migration this update needs; check README-DEPLOY.md.'
                : $ex->getMessage();
            flash('error', $msg);
            redirect('admin/brands.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'approve' || $action === 'reject') {
        update('brands', ['review_status' => $action === 'approve' ? 'approved' : 'rejected'], 'id = ?', [input_int('id', 0)]);
        flash('success', $action === 'approve' ? 'Approved — it is now live on the public site.' : 'Marked as not approved.');
        redirect('admin/brands.php');
    }

    if ($action === 'delete') {
        $b = row('SELECT logo_image FROM brands WHERE id = ?', [input_int('id', 0)]);
        if (!empty($b['logo_image'])) {
            delete_uploaded_file($b['logo_image']);
        }
        delete_from('brands', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Brand deleted.');
        redirect('admin/brands.php');
    }
}

$perPage = 40;
$page    = input_int('page', 1);
$total   = (int) scalar('SELECT COUNT(*) FROM brands');
$p       = paginate($total, $perPage, $page);
$rows    = rows('SELECT * FROM brands ORDER BY (review_status = \'pending\') DESC, name LIMIT ' . $p['per'] . ' OFFSET ' . $p['offset']);

admin_header('Brands', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit brand' : 'Add a brand' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Brand name</span>
      <input type="text" name="name" required value="<?= e($editing['name'] ?? '') ?>"></label>
    <label class="admin-field"><span>Location (shown at the top of the brand page, e.g. "Motijheel, Dhaka")</span>
      <input type="text" name="location" value="<?= e($editing['location'] ?? '') ?>"></label>
    <label class="admin-field"><span>Full address</span>
      <input type="text" name="address" value="<?= e($editing['address'] ?? '') ?>"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <p class="muted" style="margin-top:0">Contact</p>
    <label class="admin-field"><span>Website</span>
      <input type="text" name="website" placeholder="https://example.com" value="<?= e($editing['website'] ?? '') ?>"></label>
    <label class="admin-field"><span>Mobile number</span>
      <input type="text" name="mobile" value="<?= e($editing['mobile'] ?? '') ?>"></label>
    <label class="admin-field"><span>Phone number</span>
      <input type="text" name="phone" value="<?= e($editing['phone'] ?? '') ?>"></label>
    <label class="admin-field"><span>Email</span>
      <input type="email" name="email" value="<?= e($editing['email'] ?? '') ?>"></label>
    <label class="admin-field"><span>Google Maps link or embed code (paste the share link, or the full &lt;iframe&gt; from Share → Embed a map)</span>
      <input type="text" name="map_url" value="<?= e($editing['map_url'] ?? '') ?>"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <p class="muted" style="margin-top:0">Social media pages</p>
    <label class="admin-field"><span>Facebook</span>
      <input type="text" name="facebook" value="<?= e($editing['facebook'] ?? '') ?>"></label>
    <label class="admin-field"><span>Instagram</span>
      <input type="text" name="instagram" value="<?= e($editing['instagram'] ?? '') ?>"></label>
    <label class="admin-field"><span>YouTube</span>
      <input type="text" name="youtube" value="<?= e($editing['youtube'] ?? '') ?>"></label>
    <label class="admin-field"><span>X / Twitter</span>
      <input type="text" name="twitter" value="<?= e($editing['twitter'] ?? '') ?>"></label>
    <label class="admin-field"><span>LinkedIn</span>
      <input type="text" name="linkedin" value="<?= e($editing['linkedin'] ?? '') ?>"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <div class="admin-field"><span>About the company</span>
      <div id="editor_description" class="admin-richtext"></div>
      <textarea name="description" id="ta_description" hidden><?= e($editing['description'] ?? '') ?></textarea></div>

    <?php if (!empty($editing['logo_image'])): ?>
      <div class="admin-field">
        <span>Current logo</span>
        <img src="<?= e(asset($editing['logo_image'])) ?>" alt="" style="width:80px;height:80px;object-fit:contain;border-radius:8px;border:1px solid var(--line);display:block;margin:6px 0;background:#fff">
        <label class="admin-check"><input type="checkbox" name="remove_logo" value="1"> Remove logo</label>
      </div>
    <?php endif; ?>
    <label class="admin-field"><span>Logo (jpg/png/webp/gif, optional)</span>
      <input type="file" name="logo_image" accept="image/*"></label>

    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add brand' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/brands.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-toolbar"><strong><?= $p['total'] ?></strong><span class="muted">brands total</span></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Logo</th><th>Name</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="3" class="muted">No brands yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['logo_image']): ?><img src="<?= e(asset($r['logo_image'])) ?>" alt="" style="width:32px;height:32px;object-fit:contain"><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['name']) ?> <?php $rs = $r['review_status'] ?? 'approved'; if ($rs !== 'approved'): ?><span class="admin-badge admin-badge-no"><?= $rs === 'pending' ? 'Pending approval' : 'Rejected' ?></span> <?php endif; ?><?php if (!empty($r['seller_id'])): ?><span class="muted" style="font-size:.78rem">seller</span><?php endif; ?></td>
            <td class="admin-row-actions">
              <?php if (($r['review_status'] ?? 'approved') !== 'approved'): ?>
                <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="action" value="approve"><input type="hidden" name="id" value="<?= e((string) $r['id']) ?>"><button class="admin-btn admin-btn-primary admin-btn-sm" type="submit">Approve</button></form>
              <?php endif; ?>
              <?php if (($r['review_status'] ?? 'approved') === 'pending'): ?>
                <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="action" value="reject"><input type="hidden" name="id" value="<?= e((string) $r['id']) ?>"><button class="admin-btn admin-btn-ghost admin-btn-sm" type="submit">Reject</button></form>
              <?php endif; ?>
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/brands.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this brand?');" style="display:inline">
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
        <a href="<?= url('admin/brands.php', ['page' => $i]) ?>" class="<?= $i === $p['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="<?= asset('admin/richtext.js') ?>?v=5"></script>
<script>mountRichText('editor_description', 'ta_description');</script>
<?php
admin_footer();
