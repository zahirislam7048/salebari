<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM malls WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id   = input_int('id', 0);
        $name = (string) input('name');
        $data = [
            'name'           => $name,
            'city_name_en'   => (string) input('city_name_en'),
            'city_name_bn'   => input('city_name_bn') ?: null,
            'closed_day'     => input('closed_day') ?: null,
            'description_en' => input('description_en') ?: null,
            'description_bn' => input('description_bn') ?: null,
            'stall_count'    => input_int('stall_count', 0),
            'address'        => input('address') ?: null,
            'opening_hours'  => input('opening_hours') ?: null,
            'website'        => clean_url(input('website')),
            'mobile'         => input('mobile') ?: null,
            'phone'          => input('phone') ?: null,
            'email'          => valid_email((string) input('email')) ? input('email') : null,
            'map_url'        => clean_map_url(input('map_url')),
            'facebook'       => clean_url(input('facebook')),
            'instagram'      => clean_url(input('instagram')),
            'about'          => input('about') ?: null,
        ];

        if ($name === '' || $data['city_name_en'] === '') {
            flash('error', 'Mall name and city are required.');
            redirect('admin/malls.php', $id ? ['edit' => $id] : []);
        }

        try {
            $existingLogo = $id ? row('SELECT logo_image FROM malls WHERE id = ?', [$id])['logo_image'] : null;
            if (input('remove_logo')) {
                if ($existingLogo) delete_uploaded_file($existingLogo);
                $data['logo_image'] = null;
            } elseif (!empty($_FILES['logo_image']['name'])) {
                $newLogo = save_uploaded_image($_FILES['logo_image'], 'malls');
                if ($newLogo) {
                    if ($existingLogo) delete_uploaded_file($existingLogo);
                    $data['logo_image'] = $newLogo;
                }
            }

            if ($id) {
                update('malls', $data, 'id = ?', [$id]);
                flash('success', 'Mall updated.');
            } else {
                $data['slug']       = unique_slug('malls', slugify($name));
                $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM malls');
                $data['created_at'] = now();
                insert('malls', $data);
                flash('success', 'Mall added.');
            }
            redirect('admin/malls.php');
        } catch (Throwable $ex) {
            $msg = $ex instanceof PDOException
                ? 'Database error: ' . $ex->getMessage() . ' — if this mentions an unknown column, the database is missing a migration this update needs; check README-DEPLOY.md.'
                : $ex->getMessage();
            flash('error', $msg);
            redirect('admin/malls.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'delete') {
        $m = row('SELECT logo_image FROM malls WHERE id = ?', [input_int('id', 0)]);
        if (!empty($m['logo_image'])) {
            delete_uploaded_file($m['logo_image']);
        }
        delete_from('malls', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Mall deleted.');
        redirect('admin/malls.php');
    }
}

$rows = rows('SELECT * FROM malls ORDER BY city_name_en, sort_order');

admin_header('Shopping Malls', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit mall' : 'Add a mall' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Mall name</span>
      <input type="text" name="name" required value="<?= e($editing['name'] ?? '') ?>"></label>
    <label class="admin-field"><span>City (English) — malls are grouped by this on the public page</span>
      <input type="text" name="city_name_en" required value="<?= e($editing['city_name_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>City (Bangla)</span>
      <input type="text" name="city_name_bn" value="<?= e($editing['city_name_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>Short address (English) — shown on the mall's card in the list</span>
      <input type="text" name="description_en" value="<?= e($editing['description_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Short address (Bangla)</span>
      <input type="text" name="description_bn" value="<?= e($editing['description_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>Closed day (optional, e.g. "Tuesday")</span>
      <input type="text" name="closed_day" value="<?= e($editing['closed_day'] ?? '') ?>"></label>
    <label class="admin-field"><span>Stall count (shown on this mall's card, optional)</span>
      <input type="number" name="stall_count" min="0" value="<?= e((string) ($editing['stall_count'] ?? 0)) ?>"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <p class="muted" style="margin-top:0">Details shown on the mall's own page</p>
    <label class="admin-field"><span>Full address</span>
      <input type="text" name="address" value="<?= e($editing['address'] ?? '') ?>"></label>
    <label class="admin-field"><span>Opening hours (e.g. "10:00 AM – 9:00 PM")</span>
      <input type="text" name="opening_hours" value="<?= e($editing['opening_hours'] ?? '') ?>"></label>
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
    <label class="admin-field"><span>Facebook page</span>
      <input type="text" name="facebook" value="<?= e($editing['facebook'] ?? '') ?>"></label>
    <label class="admin-field"><span>Instagram</span>
      <input type="text" name="instagram" value="<?= e($editing['instagram'] ?? '') ?>"></label>
    <div class="admin-field"><span>About the mall</span>
      <div id="editor_about" class="admin-richtext"></div>
      <textarea name="about" id="ta_about" hidden><?= e($editing['about'] ?? '') ?></textarea></div>
    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">

    <?php if (!empty($editing['logo_image'])): ?>
      <div class="admin-field">
        <span>Current logo/photo</span>
        <img src="<?= e(asset($editing['logo_image'])) ?>" alt="" style="width:120px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--line);display:block;margin:6px 0">
        <label class="admin-check"><input type="checkbox" name="remove_logo" value="1"> Remove logo/photo</label>
      </div>
    <?php endif; ?>
    <label class="admin-field"><span>Logo / photo (jpg/png/webp/gif)</span>
      <input type="file" name="logo_image" accept="image/*"></label>

    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add mall' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/malls.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Logo</th><th>Name</th><th>City</th><th>Address</th><th>Closed</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="6" class="muted">No malls yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['logo_image']): ?><img src="<?= e(asset($r['logo_image'])) ?>" alt="" style="width:40px;height:28px;object-fit:cover;border-radius:4px"><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['name']) ?></td>
            <td><?= e($r['city_name_en']) ?></td>
            <td><?= e($r['description_en'] ?? '—') ?></td>
            <td><?= e($r['closed_day'] ?? '—') ?></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/malls.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this mall?');" style="display:inline">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="<?= asset('admin/richtext.js') ?>?v=2"></script>
<script>mountRichText('editor_about', 'ta_about');</script>
<?php
admin_footer();
