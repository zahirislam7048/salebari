<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
$me = require_seller();

$id      = input_int('id', 0);
$editing = $id ? row('SELECT * FROM stalls WHERE id = ? AND seller_id = ?', [$id, $me['id']]) : null;
if ($id && !$editing) {
    flash('error', 'That stall was not found.');
    redirect('account/');
}

$errors = [];

if (is_post()) {
    csrf_check();
    $name = (string) input('name');
    $data = [
        'name'        => $name,
        'city'        => input('city') ?: null,
        'address'     => input('address') ?: null,
        'phone'       => input('phone') ?: null,
        'mall_id'     => input_int('mall_id', 0) ?: null,
        'description' => input('description') ?: null,
    ];
    if (mb_strlen($name) < 2) {
        $errors[] = 'Please enter the stall name.';
    }

    if (!$errors) {
        try {
            $existingLogo = $editing['logo_image'] ?? null;
            if (!empty($_FILES['logo_image']['name'])) {
                $newLogo = save_uploaded_image($_FILES['logo_image'], 'stalls');
                if ($newLogo) {
                    if ($existingLogo) delete_uploaded_file($existingLogo);
                    $data['logo_image'] = $newLogo;
                }
            }
            if ($editing) {
                if ($editing['review_status'] === 'rejected') {
                    $data['review_status'] = 'pending'; // resubmitted
                }
                $data['slug'] = slug_after_rename('stalls', (int) $editing['id'], $name, (string) $editing['slug']);
                update('stalls', $data, 'id = ? AND seller_id = ?', [$editing['id'], $me['id']]);
                flash('success', 'Stall saved.');
            } else {
                $data['slug']          = unique_slug('stalls', slugify($name));
                $data['seller_id']     = $me['id'];
                $data['review_status'] = 'pending';
                $data['status']        = 'active';
                $data['verified']      = 0;
                $data['product_count'] = 0;
                $data['sort_order']    = 0;
                $data['created_at']    = now();
                insert('stalls', $data);
                track_queue('generate_lead', ['method' => 'add_stall']);
                flash('success', 'Stall submitted. It will appear on the Stall directory once the SaleBari team approves it.');
            }
            redirect('account/');
        } catch (Throwable $ex) {
            $errors[] = $ex instanceof PDOException ? 'Could not save right now. Please try again.' : $ex->getMessage();
        }
    }
    $editing = array_merge($editing ?? [], $data);
}

$malls = rows('SELECT id, name, city_name_en FROM malls ORDER BY city_name_en, name');
site_header($id ? 'Edit stall' : 'Add a stall');
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="./">My account</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current"><?= $id ? 'Edit stall' : 'Add a stall' ?></span></nav>
    <div class="acct-card">
      <h1 class="listing-page-title"><?= $id ? 'Edit your stall' : 'Add your stall' ?></h1>
      <?php foreach ($errors as $err): ?><p class="acct-error"><?= e($err) ?></p><?php endforeach; ?>

      <form method="post" enctype="multipart/form-data" class="acct-form">
        <?= csrf_field() ?>
        <label class="acct-field"><span>Stall name *</span>
          <input type="text" name="name" required maxlength="160" value="<?= e($editing['name'] ?? '') ?>"></label>
        <label class="acct-field"><span>City / District</span>
          <input type="text" name="city" maxlength="80" placeholder="e.g. Dhaka" value="<?= e($editing['city'] ?? '') ?>"></label>
        <label class="acct-field"><span>Full address</span>
          <input type="text" name="address" maxlength="255" value="<?= e($editing['address'] ?? '') ?>"></label>
        <label class="acct-field"><span>Contact phone</span>
          <input type="text" name="phone" maxlength="30" value="<?= e($editing['phone'] ?? '') ?>"></label>
        <label class="acct-field"><span>Shopping mall (if your stall is inside one)</span>
          <select name="mall_id">
            <option value="">— Not in a mall —</option>
            <?php foreach ($malls as $m): ?>
              <option value="<?= (int) $m['id'] ?>" <?= (int) ($editing['mall_id'] ?? 0) === (int) $m['id'] ? 'selected' : '' ?>><?= e($m['name']) ?> (<?= e($m['city_name_en']) ?>)</option>
            <?php endforeach; ?>
          </select></label>
        <label class="acct-field"><span>About your stall</span>
          <textarea name="description" rows="5" maxlength="2000"><?= e($editing['description'] ?? '') ?></textarea></label>

        <?php if (!empty($editing['logo_image'])): ?>
          <div class="acct-field"><span>Current logo</span>
            <img src="<?= e(asset($editing['logo_image'])) ?>" alt="" class="acct-logo-preview"></div>
        <?php endif; ?>
        <label class="acct-field"><span>Logo / photo (jpg, png, webp or gif)</span>
          <input type="file" name="logo_image" accept="image/*"></label>

        <div class="acct-actions">
          <button class="btn btn-primary" type="submit"><?= $id ? 'Save changes' : 'Submit stall' ?></button>
          <a class="btn btn-ghost" href="./">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<?php
site_footer();
