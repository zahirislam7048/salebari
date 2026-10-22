<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM success_stories WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id   = input_int('id', 0);
        $name = (string) input('name');
        $head = (string) input('headline');
        $data = [
            'name'        => $name,
            'business'    => input('business') ?: null,
            'location'    => input('location') ?: null,
            'headline'    => $head,
            'headline_bn' => input('headline_bn') ?: null,
            'story'       => input('story') ?: null,
            'story_bn'    => input('story_bn') ?: null,
            'quote'       => input('quote') ?: null,
            'highlight'   => input('highlight') ?: null,
            'status'      => input('status') === 'hidden' ? 'hidden' : 'published',
        ];
        if ($name === '' || $head === '') {
            flash('error', 'Name and headline are required.');
            redirect('admin/stories.php', $id ? ['edit' => $id] : []);
        }
        try {
            $existing = $id ? row('SELECT photo FROM success_stories WHERE id = ?', [$id]) : null;
            $oldPhoto = $existing['photo'] ?? null;
            if (input('remove_photo')) {
                if ($oldPhoto) delete_uploaded_file($oldPhoto);
                $data['photo'] = null;
            } elseif (!empty($_FILES['photo']['name'])) {
                $new = save_uploaded_image($_FILES['photo'], 'stories');
                if ($new) {
                    if ($oldPhoto) delete_uploaded_file($oldPhoto);
                    $data['photo'] = $new;
                }
            }
            if ($id) {
                update('success_stories', $data, 'id = ?', [$id]);
                flash('success', 'Story updated.');
            } else {
                $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM success_stories');
                $data['created_at'] = now();
                insert('success_stories', $data);
                flash('success', 'Story added.');
            }
            redirect('admin/stories.php');
        } catch (Throwable $ex) {
            flash('error', $ex instanceof PDOException ? 'Database error: ' . $ex->getMessage() : $ex->getMessage());
            redirect('admin/stories.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'delete') {
        $s = row('SELECT photo FROM success_stories WHERE id = ?', [input_int('id', 0)]);
        if (!empty($s['photo'])) {
            delete_uploaded_file($s['photo']);
        }
        delete_from('success_stories', 'id = ?', [input_int('id', 0)]);
        flash('success', 'Story deleted.');
        redirect('admin/stories.php');
    }
}

$rows = rows('SELECT * FROM success_stories ORDER BY sort_order, id DESC');

admin_header('Success Stories', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<div class="admin-card">
  <p class="muted" style="margin-top:0">Add real stories from sellers who grew with SaleBari. They appear on the public <a href="<?= e(url('success-stories/')) ?>" target="_blank">Success stories</a> page. Only publish stories the seller has agreed to share.</p>
</div>

<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit story' : 'Add a story' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Seller name *</span>
      <input type="text" name="name" required value="<?= e($editing['name'] ?? '') ?>"></label>
    <label class="admin-field"><span>Business / stall name</span>
      <input type="text" name="business" value="<?= e($editing['business'] ?? '') ?>"></label>
    <label class="admin-field"><span>Location (e.g. "Motijheel, Dhaka")</span>
      <input type="text" name="location" value="<?= e($editing['location'] ?? '') ?>"></label>
    <label class="admin-field"><span>Headline (English) *</span>
      <input type="text" name="headline" required maxlength="200" value="<?= e($editing['headline'] ?? '') ?>"></label>
    <label class="admin-field"><span>Headline (Bangla) — optional</span>
      <input type="text" name="headline_bn" maxlength="200" value="<?= e($editing['headline_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>Key result shown as a badge (optional — e.g. "Sold 40 cars in 3 months")</span>
      <input type="text" name="highlight" maxlength="160" value="<?= e($editing['highlight'] ?? '') ?>"></label>
    <label class="admin-field"><span>Short quote from the seller (optional)</span>
      <input type="text" name="quote" maxlength="400" value="<?= e($editing['quote'] ?? '') ?>"></label>

    <div class="admin-field"><span>Story (English)</span>
      <div id="editor_story" class="admin-richtext"></div>
      <textarea name="story" id="ta_story" hidden><?= e($editing['story'] ?? '') ?></textarea></div>
    <div class="admin-field"><span>Story (Bangla) — optional</span>
      <div id="editor_story_bn" class="admin-richtext"></div>
      <textarea name="story_bn" id="ta_story_bn" hidden><?= e($editing['story_bn'] ?? '') ?></textarea></div>

    <?php if (!empty($editing['photo'])): ?>
      <div class="admin-field">
        <span>Current photo</span>
        <img src="<?= e(asset($editing['photo'])) ?>" alt="" style="width:120px;height:90px;object-fit:cover;border-radius:8px;border:1px solid var(--line);display:block;margin:6px 0">
        <label class="admin-check"><input type="checkbox" name="remove_photo" value="1"> Remove photo</label>
      </div>
    <?php endif; ?>
    <label class="admin-field"><span>Photo (seller, shop or product — jpg/png/webp/gif)</span>
      <input type="file" name="photo" accept="image/*"></label>
    <label class="admin-field"><span>Status</span>
      <select name="status">
        <option value="published" <?= ($editing['status'] ?? 'published') === 'published' ? 'selected' : '' ?>>Published</option>
        <option value="hidden" <?= ($editing['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
      </select></label>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add story' ?></button>
    <?php if ($editing): ?><a class="admin-btn admin-btn-ghost" href="<?= e(url('admin/stories.php')) ?>">Cancel</a><?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Photo</th><th>Seller</th><th>Headline</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?><tr><td colspan="5" class="muted">No stories yet.</td></tr><?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['photo']): ?><img src="<?= e(asset($r['photo'])) ?>" alt="" style="width:48px;height:36px;object-fit:cover;border-radius:4px"><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['name']) ?><?= $r['business'] ? ' <span class="muted">· ' . e($r['business']) . '</span>' : '' ?></td>
            <td><?= e($r['headline']) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['status'] === 'published' ? 'yes' : 'no' ?>"><?= e($r['status']) ?></span></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= e(url('admin/stories.php', ['edit' => $r['id']])) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this story?');" style="display:inline">
                <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
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
<script src="<?= asset('admin/richtext.js') ?>?v=5"></script>
<script>mountRichText('editor_story', 'ta_story'); mountRichText('editor_story_bn', 'ta_story_bn');</script>
<?php
admin_footer();
