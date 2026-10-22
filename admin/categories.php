<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$parentId = input_int('parent', 0) ?: null;
$editId   = input_int('edit', 0) ?: null;
$parent   = $parentId ? row('SELECT * FROM categories WHERE id = ?', [$parentId]) : null;
$editing  = $editId ? row('SELECT * FROM categories WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id     = input_int('id', 0);
        $data   = [
            'name_en'        => (string) input('name_en'),
            'name_bn'        => input('name_bn') ?: null,
            'icon'           => input('icon') ?: null,
            'count_label_en' => input('count_label_en') ?: null,
            'count_label_bn' => input('count_label_bn') ?: null,
            'featured'       => input('featured') ? 1 : 0,
            'meta_title'       => input('meta_title') ?: null,
            'meta_description' => input('meta_description') ?: null,
        ];
        $urlInput = url_safe((string) input('url_slug'));
        if ($data['name_en'] === '') {
            flash('error', 'Name (English) is required.');
        } elseif ($id) {
            $self       = row('SELECT * FROM categories WHERE id = ?', [$id]);
            $ownParent  = $self && $self['parent_id'] ? (int) $self['parent_id'] : null;
            $parentName = $ownParent ? (string) scalar('SELECT name_en FROM categories WHERE id = ?', [$ownParent]) : null;
            $data['url_slug'] = unique_category_url_slug(
                $urlInput !== '' ? $urlInput : suggest_category_url_slug($data['name_en'], $parentName, (int) ($self['level'] ?? 1)),
                $ownParent, $id, url_safe((string) ($self['slug'] ?? ''))
            );
            update('categories', $data, 'id = ?', [$id]);
            flash('success', 'Category updated.');
        } else {
            $level = $parentId ? (int) row('SELECT level FROM categories WHERE id = ?', [$parentId])['level'] + 1 : 1;
            if ($level > 3) {
                flash('error', 'Categories only go 3 levels deep.');
            } else {
                $data['parent_id']  = $parentId;
                $data['level']      = $level;
                $data['url_slug']   = unique_category_url_slug(
                    $urlInput !== '' ? $urlInput : suggest_category_url_slug($data['name_en'], $parent['name_en'] ?? null, $level),
                    $parentId, null, url_safe($data['name_en'])
                );
                $data['slug']       = unique_slug('categories', slugify($data['name_en']));
                $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM categories WHERE ' . ($parentId ? 'parent_id = ?' : 'parent_id IS NULL'), $parentId ? [$parentId] : []);
                $data['created_at'] = now();
                insert('categories', $data);
                flash('success', 'Category added.');
            }
        }
        redirect('admin/categories.php', $parentId ? ['parent' => $parentId] : []);
    }

    if ($action === 'delete') {
        $id = input_int('id', 0);
        $childCount = (int) scalar('SELECT COUNT(*) FROM categories WHERE parent_id = ?', [$id]);
        if ($childCount > 0) {
            flash('error', "Can't delete — this category still has $childCount subcategor" . ($childCount === 1 ? 'y' : 'ies') . '. Delete those first.');
        } else {
            delete_from('categories', 'id = ?', [$id]);
            flash('success', 'Category deleted.');
        }
        redirect('admin/categories.php', $parentId ? ['parent' => $parentId] : []);
    }
}

$rows = rows(
    'SELECT * FROM categories WHERE ' . ($parentId ? 'parent_id = ?' : 'parent_id IS NULL') . ' ORDER BY sort_order, name_en',
    $parentId ? [$parentId] : []
);
$childCounts = [];
foreach ($rows as $r) {
    $childCounts[$r['id']] = (int) scalar('SELECT COUNT(*) FROM categories WHERE parent_id = ?', [$r['id']]);
}

/* Breadcrumb up to top. */
$crumbs = [];
$walk = $parent;
while ($walk) {
    array_unshift($crumbs, $walk);
    $walk = $walk['parent_id'] ? row('SELECT * FROM categories WHERE id = ?', [$walk['parent_id']]) : null;
}

admin_header('Categories');
?>
<p class="muted" style="margin-top:-10px">
  <a href="<?= url('admin/categories.php') ?>">All categories</a>
  <?php foreach ($crumbs as $c): ?>
    &rsaquo; <a href="<?= url('admin/categories.php', ['parent' => $c['id']]) ?>"><?= e($c['name_en']) ?></a>
  <?php endforeach; ?>
</p>

<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit category' : 'Add ' . ($parent ? 'a subcategory under ' . e($parent['name_en']) : 'a top-level category') ?></h3>
  <form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Name (English)</span>
      <input type="text" name="name_en" required value="<?= e($editing['name_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>URL name — the part used in the page address, e.g. <code>accessories</code> (leave empty to make it from the name)</span>
      <input type="text" name="url_slug" maxlength="90" placeholder="auto" value="<?= e($editing['url_slug'] ?? '') ?>"></label>
    <?php if ($editing): ?><p class="muted" style="margin-top:-6px">Address: <code><?= e(category_url($editing)) ?></code></p><?php endif; ?>
    <label class="admin-field"><span>Page title for Google (optional) — leave empty for the automatic "Best … in Bangladesh {year}". <code>{year}</code> becomes the current year.</span>
      <input type="text" name="meta_title" maxlength="200" placeholder="Best <?= e($editing['name_en'] ?? 'Category') ?> in Bangladesh {year}" value="<?= e($editing['meta_title'] ?? '') ?>"></label>
    <label class="admin-field"><span>Meta description for Google (optional) — leave empty for an automatic one, about 150 characters.</span>
      <textarea name="meta_description" maxlength="320" rows="3"><?= e($editing['meta_description'] ?? '') ?></textarea></label>
    <label class="admin-field"><span>Name (Bangla) — optional</span>
      <input type="text" name="name_bn" value="<?= e($editing['name_bn'] ?? '') ?>"></label>
    <label class="admin-field"><span>Icon (emoji)</span>
      <input type="text" name="icon" maxlength="10" value="<?= e($editing['icon'] ?? '') ?>"></label>
    <?php if (!$parentId && !($editing['parent_id'] ?? $parentId)): ?>
      <label class="admin-field"><span>Count label (English) — e.g. "980 listings"</span>
        <input type="text" name="count_label_en" value="<?= e($editing['count_label_en'] ?? '') ?>"></label>
      <label class="admin-field"><span>Count label (Bangla)</span>
        <input type="text" name="count_label_bn" value="<?= e($editing['count_label_bn'] ?? '') ?>"></label>
      <label class="admin-check">
        <input type="checkbox" name="featured" value="1" <?= !empty($editing['featured']) || !$editing ? 'checked' : '' ?>>
        <span>Featured on homepage</span>
      </label>
    <?php endif; ?>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add category' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/categories.php', $parentId ? ['parent' => $parentId] : []) ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Icon</th><th>Name</th><th>Page address</th><th>Bangla</th><th>Subcategories</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="6" class="muted">No categories here yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['icon'] ?? '') ?></td>
            <td><?= e($r['name_en']) ?></td>
            <td><a href="<?= e(category_url($r)) ?>" target="_blank"><code><?= e(category_url($r)) ?></code></a></td>
            <td><?= e($r['name_bn'] ?? '—') ?></td>
            <td>
              <?php if ($r['level'] < 3): ?>
                <a href="<?= url('admin/categories.php', ['parent' => $r['id']]) ?>"><?= $childCounts[$r['id']] ?> subcategories</a>
              <?php else: ?>
                <span class="muted">—</span>
              <?php endif; ?>
            </td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/categories.php', ['edit' => $r['id']] + ($parentId ? ['parent' => $parentId] : [])) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this category?');" style="display:inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e((string) $r['id']) ?>">
                <button class="admin-btn admin-btn-danger admin-btn-sm" type="submit" <?= $childCounts[$r['id']] > 0 ? 'disabled title="Delete subcategories first"' : '' ?>>Delete</button>
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
