<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM blog_posts WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id      = input_int('id', 0);
        $titleEn = (string) input('title_en');
        $status  = input('status', 'draft') === 'published' ? 'published' : 'draft';

        if ($titleEn === '') {
            flash('error', 'Title is required.');
            redirect('admin/blog.php', $id ? ['edit' => $id] : []);
        }

        $data = [
            'title_en'         => $titleEn,
            'title_bn'         => input('title_bn') ?: null,
            'meta_title'       => input('meta_title') ?: null,
            'meta_description' => input('meta_description') ?: null,
            'content_en'       => input('content_en') ?: null,
            'content_bn'       => input('content_bn') ?: null,
            'status'           => $status,
        ];

        try {
            $existingCover = $id ? row('SELECT cover_image FROM blog_posts WHERE id = ?', [$id])['cover_image'] : null;
            if (input('remove_cover')) {
                if ($existingCover) delete_uploaded_file($existingCover);
                $data['cover_image'] = null;
            } elseif (!empty($_FILES['cover_image']['name'])) {
                $newCover = save_blog_cover($_FILES['cover_image']);
                if ($newCover) {
                    if ($existingCover) delete_uploaded_file($existingCover);
                    $data['cover_image'] = $newCover;
                }
            }

            if ($id) {
                $wasPublished = row('SELECT status, published_at FROM blog_posts WHERE id = ?', [$id]);
                if ($status === 'published' && ($wasPublished['status'] ?? '') !== 'published') {
                    $data['published_at'] = now();
                }
                update('blog_posts', $data, 'id = ?', [$id]);
                flash('success', 'Post updated.');
            } else {
                $data['slug']         = unique_slug('blog_posts', slugify($titleEn));
                $data['created_at']   = now();
                $data['published_at'] = $status === 'published' ? now() : null;
                insert('blog_posts', $data);
                flash('success', 'Post added.');
            }
            redirect('admin/blog.php');
        } catch (Throwable $ex) {
            $msg = $ex instanceof PDOException
                ? 'Database error: ' . $ex->getMessage() . ' — if this mentions an unknown column, the database is missing a migration this update needs; check README-DEPLOY.md.'
                : $ex->getMessage();
            flash('error', $msg);
            redirect('admin/blog.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'delete') {
        $id   = input_int('id', 0);
        $post = row('SELECT cover_image FROM blog_posts WHERE id = ?', [$id]);
        if (!empty($post['cover_image'])) {
            delete_uploaded_file($post['cover_image']);
        }
        delete_from('blog_posts', 'id = ?', [$id]);
        flash('success', 'Post deleted.');
        redirect('admin/blog.php');
    }
}

$perPage = 20;
$page    = input_int('page', 1);
$total   = (int) scalar('SELECT COUNT(*) FROM blog_posts');
$p       = paginate($total, $perPage, $page);
$rows    = rows('SELECT * FROM blog_posts ORDER BY id DESC LIMIT ' . $p['per'] . ' OFFSET ' . $p['offset']);

admin_header('Blog', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit post' : 'Add a blog post' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">

    <label class="admin-field"><span>Title (English)</span>
      <input type="text" name="title_en" required value="<?= e($editing['title_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Title (Bangla)</span>
      <input type="text" name="title_bn" value="<?= e($editing['title_bn'] ?? '') ?>"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <p class="muted" style="margin-top:0">SEO</p>
    <label class="admin-field"><span>Meta title</span>
      <input type="text" name="meta_title" maxlength="200" value="<?= e($editing['meta_title'] ?? '') ?>"></label>
    <label class="admin-field"><span>Meta description</span>
      <textarea name="meta_description" maxlength="320"><?= e($editing['meta_description'] ?? '') ?></textarea></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <?php if (!empty($editing['cover_image'])): ?>
      <div class="admin-field">
        <span>Current cover image</span>
        <img src="<?= e(asset($editing['cover_image'])) ?>" alt="" style="width:160px;height:100px;object-fit:cover;border-radius:8px;border:1px solid var(--line);display:block;margin:6px 0">
        <label class="admin-check"><input type="checkbox" name="remove_cover" value="1"> Remove cover image</label>
      </div>
    <?php endif; ?>
    <label class="admin-field"><span>Cover image (jpg/png/webp/gif)</span>
      <input type="file" name="cover_image" accept="image/*"></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <div class="admin-field"><span>Content (English)</span>
      <div id="editor_content_en" class="admin-richtext"></div>
      <textarea name="content_en" id="ta_content_en" hidden><?= e($editing['content_en'] ?? '') ?></textarea></div>
    <div class="admin-field"><span>Content (Bangla)</span>
      <div id="editor_content_bn" class="admin-richtext"></div>
      <textarea name="content_bn" id="ta_content_bn" hidden><?= e($editing['content_bn'] ?? '') ?></textarea></div>

    <label class="admin-field"><span>Status</span>
      <select name="status">
        <option value="draft" <?= ($editing['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="published" <?= ($editing['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
      </select></label>

    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add post' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/blog.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-toolbar"><strong><?= $p['total'] ?></strong><span class="muted">posts total</span></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Cover</th><th>Title</th><th>Status</th><th>Published</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="5" class="muted">No posts yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php if ($r['cover_image']): ?><img src="<?= e(asset($r['cover_image'])) ?>" alt="" style="width:50px;height:36px;object-fit:cover;border-radius:6px"><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['title_en']) ?></td>
            <td><span class="admin-badge admin-badge-<?= $r['status'] === 'published' ? 'yes' : 'no' ?>"><?= e(ucfirst($r['status'])) ?></span></td>
            <td><?= e($r['published_at'] ?? '—') ?></td>
            <td class="admin-row-actions">
              <?php if ($r['status'] === 'published'): ?>
                <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('blog-post.php', ['slug' => $r['slug']]) ?>" target="_blank">View</a>
              <?php endif; ?>
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/blog.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this post?');" style="display:inline">
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
        <a href="<?= url('admin/blog.php', ['page' => $i]) ?>" class="<?= $i === $p['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="<?= asset('admin/richtext.js') ?>?v=2"></script>
<script>
  mountRichText('editor_content_en', 'ta_content_en');
  mountRichText('editor_content_bn', 'ta_content_bn');
</script>
<?php
admin_footer();
