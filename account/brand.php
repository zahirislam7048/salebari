<?php
require __DIR__ . '/../app/bootstrap.php';

if (!installed()) {
    redirect('install.php');
}
$me = require_seller();

$id      = input_int('id', 0);
$editing = $id ? row('SELECT * FROM brands WHERE id = ? AND seller_id = ?', [$id, $me['id']]) : null;
if ($id && !$editing) {
    flash('error', 'That brand was not found.');
    redirect('account/');
}

$errors = [];

if (is_post()) {
    csrf_check();
    $name = (string) input('name');
    $data = [
        'name'        => $name,
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
        'description' => sanitize_html(input('description')),
    ];
    if (mb_strlen($name) < 2) {
        $errors[] = 'Please enter the brand name.';
    }

    if (!$errors) {
        try {
            $existingLogo = $editing['logo_image'] ?? null;
            if (!empty($_FILES['logo_image']['name'])) {
                $newLogo = save_uploaded_image($_FILES['logo_image'], 'brands');
                if ($newLogo) {
                    if ($existingLogo) delete_uploaded_file($existingLogo);
                    $data['logo_image'] = $newLogo;
                }
            }
            if ($editing) {
                if ($editing['review_status'] === 'rejected') {
                    $data['review_status'] = 'pending'; // resubmitted
                }
                update('brands', $data, 'id = ? AND seller_id = ?', [$editing['id'], $me['id']]);
                flash('success', 'Brand saved.');
            } else {
                $data['slug']          = unique_slug('brands', slugify($name));
                $data['seller_id']     = $me['id'];
                $data['review_status'] = 'pending';
                $data['sort_order']    = (int) scalar('SELECT COUNT(*) FROM brands');
                $data['created_at']    = now();
                insert('brands', $data);
                flash('success', 'Brand submitted. It will appear on the Brand directory once the SaleBari team approves it.');
            }
            redirect('account/');
        } catch (Throwable $ex) {
            $errors[] = $ex instanceof PDOException ? 'Could not save right now. Please try again.' : $ex->getMessage();
        }
    }
    $editing = array_merge($editing ?? [], $data);
}

site_header($id ? 'Edit brand' : 'Add a brand', '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">');
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="./">My account</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current"><?= $id ? 'Edit brand' : 'Add a brand' ?></span></nav>
    <div class="acct-card">
      <h1 class="listing-page-title"><?= $id ? 'Edit your brand' : 'Add your brand' ?></h1>
      <?php foreach ($errors as $err): ?><p class="acct-error"><?= e($err) ?></p><?php endforeach; ?>

      <form method="post" enctype="multipart/form-data" class="acct-form">
        <?= csrf_field() ?>
        <label class="acct-field"><span>Brand name *</span>
          <input type="text" name="name" required maxlength="120" value="<?= e($editing['name'] ?? '') ?>"></label>
        <label class="acct-field"><span>Location (shown at the top, e.g. "Motijheel, Dhaka")</span>
          <input type="text" name="location" maxlength="200" value="<?= e($editing['location'] ?? '') ?>"></label>
        <label class="acct-field"><span>Full address</span>
          <input type="text" name="address" maxlength="255" value="<?= e($editing['address'] ?? '') ?>"></label>

        <h3 class="acct-sub">Contact</h3>
        <label class="acct-field"><span>Website</span>
          <input type="text" name="website" placeholder="https://example.com" value="<?= e($editing['website'] ?? '') ?>"></label>
        <label class="acct-field"><span>Mobile number</span>
          <input type="text" name="mobile" maxlength="40" value="<?= e($editing['mobile'] ?? '') ?>"></label>
        <label class="acct-field"><span>Phone number</span>
          <input type="text" name="phone" maxlength="40" value="<?= e($editing['phone'] ?? '') ?>"></label>
        <label class="acct-field"><span>Email</span>
          <input type="email" name="email" maxlength="190" value="<?= e($editing['email'] ?? '') ?>"></label>
        <label class="acct-field"><span>Google Maps link (Share → copy link, or the &lt;iframe&gt; from Embed a map)</span>
          <input type="text" name="map_url" value="<?= e($editing['map_url'] ?? '') ?>"></label>

        <h3 class="acct-sub">Social media pages</h3>
        <label class="acct-field"><span>Facebook</span><input type="text" name="facebook" value="<?= e($editing['facebook'] ?? '') ?>"></label>
        <label class="acct-field"><span>Instagram</span><input type="text" name="instagram" value="<?= e($editing['instagram'] ?? '') ?>"></label>
        <label class="acct-field"><span>YouTube</span><input type="text" name="youtube" value="<?= e($editing['youtube'] ?? '') ?>"></label>
        <label class="acct-field"><span>X / Twitter</span><input type="text" name="twitter" value="<?= e($editing['twitter'] ?? '') ?>"></label>
        <label class="acct-field"><span>LinkedIn</span><input type="text" name="linkedin" value="<?= e($editing['linkedin'] ?? '') ?>"></label>

        <h3 class="acct-sub">About the company</h3>
        <div class="acct-field">
          <div id="editor_description" class="acct-richtext"></div>
          <textarea name="description" id="ta_description" hidden><?= e($editing['description'] ?? '') ?></textarea>
        </div>

        <?php if (!empty($editing['logo_image'])): ?>
          <div class="acct-field"><span>Current logo</span>
            <img src="<?= e(asset($editing['logo_image'])) ?>" alt="" class="acct-logo-preview"></div>
        <?php endif; ?>
        <label class="acct-field"><span>Logo (jpg, png, webp or gif)</span>
          <input type="file" name="logo_image" accept="image/*"></label>

        <div class="acct-actions">
          <button class="btn btn-primary" type="submit"><?= $id ? 'Save changes' : 'Submit brand' ?></button>
          <a class="btn btn-ghost" href="./">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script src="../admin/richtext.js"></script>
<script>mountRichText('editor_description', 'ta_description');</script>
<?php
site_footer();
