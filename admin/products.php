<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

/** Level-1 categories, for the first dropdown. */
function product_level1(): array
{
    return rows('SELECT id, name_en FROM categories WHERE level = 1 ORDER BY sort_order');
}

/**
 * Every "attachable" leaf category — a level-2 category with no level-3
 * children (e.g. Apartment), or a level-3 category (e.g. Cow) — each
 * tagged with its level-1 ancestor id, for the cascading dropdown.
 */
function product_leaf_categories(): array
{
    $level2Leaves = rows(
        'SELECT c2.id, c2.name_en, c2.parent_id AS level1_id
         FROM categories c2
         WHERE c2.level = 2 AND NOT EXISTS (SELECT 1 FROM categories c3 WHERE c3.parent_id = c2.id)
         ORDER BY c2.sort_order'
    );
    $level3 = rows(
        'SELECT c3.id, c3.name_en, c2.parent_id AS level1_id
         FROM categories c3 JOIN categories c2 ON c3.parent_id = c2.id
         WHERE c3.level = 3
         ORDER BY c3.sort_order'
    );
    return array_merge($level2Leaves, $level3);
}

$editId  = input_int('edit', 0) ?: null;
$editing = $editId ? row('SELECT * FROM products WHERE id = ?', [$editId]) : null;
$editingImages = $editing ? (json_decode((string) $editing['images'], true) ?: []) : [];

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'save') {
        $id       = input_int('id', 0);
        $titleEn  = (string) input('title_en');
        $catId    = input_int('category_id', 0);

        if ($titleEn === '') {
            flash('error', 'Title is required.');
            redirect('admin/products.php', $id ? ['edit' => $id] : []);
        }
        if ($catId <= 0) {
            flash('error', 'Please pick a category, then a subcategory, from the two dropdowns above before saving.');
            redirect('admin/products.php', $id ? ['edit' => $id] : []);
        }

        $data = [
            'category_id'      => $catId,
            'stall_id'         => input_int('stall_id', 0) ?: null,
            'brand_id'         => input_int('brand_id', 0) ?: null,
            'title_en'         => $titleEn,
            'title_bn'         => input('title_bn') ?: null,
            'meta_title'       => input('meta_title') ?: null,
            'meta_description' => input('meta_description') ?: null,
            'description_en'   => input('description_en') ?: null,
            'description_bn'   => input('description_bn') ?: null,
            'price_display'    => input('price_display') ?: null,
            'specs'            => input('specs') ?: null,
            'status'           => input('status', 'active'),
        ];

        try {
            $existingImages = $id ? (json_decode((string) row('SELECT images FROM products WHERE id = ?', [$id])['images'], true) ?: []) : [];
            $keep = array_diff($existingImages, (array) ($_POST['remove_images'] ?? []));
            foreach (array_diff($existingImages, $keep) as $removed) {
                delete_uploaded_file($removed);
            }
            $newImages = !empty($_FILES['images']['name'][0]) ? save_product_images($_FILES['images'], count($keep)) : [];
            $data['images'] = json_encode(array_values(array_merge($keep, $newImages)));

            if ($id) {
                $data['slug'] = slug_after_rename('products', $id, $titleEn, (string) scalar('SELECT slug FROM products WHERE id = ?', [$id]));
                update('products', $data, 'id = ?', [$id]);
                flash('success', 'Product updated.');
            } else {
                $data['slug']       = unique_slug('products', slugify($titleEn));
                $data['sort_order'] = (int) scalar('SELECT COUNT(*) FROM products');
                $data['created_at'] = now();
                insert('products', $data);
                flash('success', 'Product added.');
            }
            redirect('admin/products.php');
        } catch (Throwable $ex) {
            $msg = $ex instanceof PDOException
                ? 'Database error: ' . $ex->getMessage() . ' — if this mentions an unknown column, the database is missing a migration this update needs; check README-DEPLOY.md.'
                : $ex->getMessage();
            flash('error', $msg);
            redirect('admin/products.php', $id ? ['edit' => $id] : []);
        }
    }

    if ($action === 'delete') {
        $id = input_int('id', 0);
        $p  = row('SELECT images FROM products WHERE id = ?', [$id]);
        foreach ((json_decode((string) ($p['images'] ?? ''), true) ?: []) as $img) {
            delete_uploaded_file($img);
        }
        delete_from('products', 'id = ?', [$id]);
        flash('success', 'Product deleted.');
        redirect('admin/products.php');
    }
}

$leaves = product_leaf_categories();
$leavesByLevel1 = [];
foreach ($leaves as $l) {
    $leavesByLevel1[$l['level1_id']][] = ['id' => (int) $l['id'], 'name' => $l['name_en']];
}
$leafById = [];
foreach ($leaves as $l) {
    $leafById[$l['id']] = $l;
}
$editingLevel1 = $editing ? ($leafById[$editing['category_id']]['level1_id'] ?? null) : null;

$perPage = 20;
$page    = input_int('page', 1);
$total   = (int) scalar('SELECT COUNT(*) FROM products');
$p       = paginate($total, $perPage, $page);
$rows    = rows(
    'SELECT p.*, c.name_en AS category_name, s.name AS stall_name, b.name AS brand_name FROM products p
     LEFT JOIN categories c ON c.id = p.category_id
     LEFT JOIN stalls s ON s.id = p.stall_id
     LEFT JOIN brands b ON b.id = p.brand_id
     ORDER BY p.id DESC LIMIT ' . $p['per'] . ' OFFSET ' . $p['offset']
);

admin_header('Products', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Edit product' : 'Add a product' ?></h3>
  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">

    <label class="admin-field"><span>Category</span>
      <select id="pf-level1">
        <option value="">Select a category…</option>
        <?php foreach (product_level1() as $l1): ?>
          <option value="<?= $l1['id'] ?>" <?= (string) $editingLevel1 === (string) $l1['id'] ? 'selected' : '' ?>><?= e($l1['name_en']) ?></option>
        <?php endforeach; ?>
      </select></label>

    <label class="admin-field"><span>Subcategory</span>
      <select id="pf-level2" name="category_id" required>
        <option value="">Select a category above first…</option>
      </select></label>

    <label class="admin-field"><span>Stall (optional — which seller this product belongs to)</span>
      <select name="stall_id">
        <option value="">No stall</option>
        <?php foreach (rows('SELECT id, name FROM stalls ORDER BY name') as $s): ?>
          <option value="<?= $s['id'] ?>" <?= (string) ($editing['stall_id'] ?? '') === (string) $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
        <?php endforeach; ?>
      </select></label>
    <label class="admin-field"><span>Brand (optional)</span>
      <select name="brand_id">
        <option value="">No brand</option>
        <?php foreach (rows('SELECT id, name FROM brands ORDER BY name') as $b): ?>
          <option value="<?= $b['id'] ?>" <?= (string) ($editing['brand_id'] ?? '') === (string) $b['id'] ? 'selected' : '' ?>><?= e($b['name']) ?></option>
        <?php endforeach; ?>
      </select></label>

    <label class="admin-field"><span>Title (English)</span>
      <input type="text" name="title_en" required value="<?= e($editing['title_en'] ?? '') ?>"></label>
    <label class="admin-field"><span>Title (Bangla)</span>
      <input type="text" name="title_bn" value="<?= e($editing['title_bn'] ?? '') ?>"></label>

    <label class="admin-field"><span>Price (e.g. "৳ 42 Lakh" or "৳ 1,850")</span>
      <input type="text" name="price_display" value="<?= e($editing['price_display'] ?? '') ?>"></label>
    <label class="admin-field"><span>Specifications (optional — one per line, written as "Name: Value", e.g. "Battery: 2200mAh")</span>
      <textarea name="specs" rows="6" placeholder="Camera: 4K&#10;Flight time: 24 min&#10;Weight: 300 g"><?= e($editing['specs'] ?? '') ?></textarea></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <p class="muted" style="margin-top:0">SEO</p>
    <label class="admin-field"><span>Meta title</span>
      <input type="text" name="meta_title" maxlength="200" value="<?= e($editing['meta_title'] ?? '') ?>"></label>
    <label class="admin-field"><span>Meta description</span>
      <textarea name="meta_description" maxlength="320"><?= e($editing['meta_description'] ?? '') ?></textarea></label>

    <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <div class="admin-field"><span>Description (English)</span>
      <div id="editor_description_en" class="admin-richtext"></div>
      <textarea name="description_en" id="ta_description_en" hidden><?= e($editing['description_en'] ?? '') ?></textarea></div>
    <div class="admin-field"><span>Description (Bangla)</span>
      <div id="editor_description_bn" class="admin-richtext"></div>
      <textarea name="description_bn" id="ta_description_bn" hidden><?= e($editing['description_bn'] ?? '') ?></textarea></div>

    <?php if ($editingImages): ?>
      <div class="admin-field">
        <span>Current images (check to remove)</span>
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:6px">
          <?php foreach ($editingImages as $img): ?>
            <label style="text-align:center;font-size:0.78rem">
              <img src="<?= e(asset($img)) ?>" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--line);display:block;margin-bottom:4px">
              <input type="checkbox" name="remove_images[]" value="<?= e($img) ?>"> Remove
            </label>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
    <?php
      /* Parse PHP's "2M" / "512K" / "1G" ini shorthand — plain (int) cast alone
         truncates at the digits and silently gives the wrong number of bytes. */
      $parseIniBytes = function (string $v): int {
          $v = trim($v);
          if ($v === '') return 0;
          $unit = strtolower(substr($v, -1));
          $num  = (int) $v;
          if ($unit === 'g') return $num * 1024 * 1024 * 1024;
          if ($unit === 'm') return $num * 1024 * 1024;
          if ($unit === 'k') return $num * 1024;
          return $num;
      };
      $iniUpload = $parseIniBytes((string) ini_get('upload_max_filesize'));
      $iniPost   = $parseIniBytes((string) ini_get('post_max_size'));
      $effectiveLimit = min(MAX_UPLOAD_BYTES, $iniUpload ?: PHP_INT_MAX, $iniPost ?: PHP_INT_MAX);
    ?>
    <label class="admin-field"><span>Add images (jpg/png/webp/gif, up to <?= MAX_IMAGES ?> total, <?= (int) (MAX_UPLOAD_BYTES / 1024 / 1024) ?>MB each)</span>
      <input type="file" name="images[]" accept="image/*" multiple></label>
    <p class="muted" style="margin-top:-8px">
      This server's actual limit right now is about <?= round($effectiveLimit / 1024 / 1024, 1) ?>MB per upload
      (upload_max_filesize=<?= e(ini_get('upload_max_filesize') ?: '?') ?>, post_max_size=<?= e(ini_get('post_max_size') ?: '?') ?>).
      <?php if ($iniUpload && $iniUpload < MAX_UPLOAD_BYTES): ?>
        Your host's PHP setting is more restrictive than this app's — ask your host to raise <code>upload_max_filesize</code>/<code>post_max_size</code>, or use smaller images.
      <?php endif; ?>
    </p>

    <label class="admin-field"><span>Status</span>
      <select name="status">
        <option value="active" <?= ($editing['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="hidden" <?= ($editing['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden</option>
      </select></label>

    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Add product' ?></button>
    <?php if ($editing): ?>
      <a class="admin-btn admin-btn-ghost" href="<?= url('admin/products.php') ?>">Cancel</a>
    <?php endif; ?>
  </form>
</div>

<div class="admin-card">
  <div class="admin-toolbar"><strong><?= $p['total'] ?></strong><span class="muted">products total</span></div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Image</th><th>Title</th><th>Category</th><th>Stall</th><th>Brand</th><th>Price</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="8" class="muted">No products yet.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): $imgs = json_decode((string) $r['images'], true) ?: []; ?>
          <tr>
            <td><?php if ($imgs): ?><img src="<?= e(asset($imgs[0])) ?>" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px"><?php else: ?>—<?php endif; ?></td>
            <td><?= e($r['title_en']) ?></td>
            <td><?= e($r['category_name'] ?? '—') ?></td>
            <td><?= e($r['stall_name'] ?? '—') ?></td>
            <td><?= e($r['brand_name'] ?? '—') ?></td>
            <td><?= e($r['price_display'] ?? '—') ?></td>
            <td><?= e($r['status']) ?></td>
            <td class="admin-row-actions">
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= e(product_url($r)) ?>" target="_blank">View</a>
              <a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= url('admin/products.php', ['edit' => $r['id']]) ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this product?');" style="display:inline">
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
        <a href="<?= url('admin/products.php', ['page' => $i]) ?>" class="<?= $i === $p['page'] ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>

<script>
  var LEAVES_BY_LEVEL1 = <?= json_encode($leavesByLevel1, JSON_UNESCAPED_UNICODE) ?>;
  var PRESELECT_LEAF = <?= json_encode($editing['category_id'] ?? null) ?>;
  var level1Select = document.getElementById('pf-level1');
  var level2Select = document.getElementById('pf-level2');

  function fillLevel2(level1Id, preselect) {
    level2Select.innerHTML = '';
    var leaves = LEAVES_BY_LEVEL1[level1Id] || [];
    if (!leaves.length) {
      level2Select.innerHTML = '<option value="">No categories under this yet</option>';
      return;
    }
    level2Select.innerHTML = '<option value="">Select…</option>' + leaves.map(function (l) {
      return '<option value="' + l.id + '"' + (preselect && String(preselect) === String(l.id) ? ' selected' : '') + '>' + l.name + '</option>';
    }).join('');
  }

  level1Select.addEventListener('change', function () { fillLevel2(this.value, null); });

  if (level1Select.value) {
    fillLevel2(level1Select.value, PRESELECT_LEAF);
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="<?= asset('admin/richtext.js') ?>?v=2"></script>
<script>
  mountRichText('editor_description_en', 'ta_description_en');
  mountRichText('editor_description_bn', 'ta_description_bn');
</script>
<?php
admin_footer();
