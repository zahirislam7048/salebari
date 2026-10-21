<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

/* key => [label, is_textarea] */
$fields = [
    'hero_eyebrow'       => ['Hero eyebrow', false],
    'hero_title'         => ['Hero title (HTML allowed, e.g. <em>)', false],
    'hero_sub'           => ['Hero subtext', true],
    'hero_cta_browse'    => ['Hero "browse" button text', false],
    'hero_cta_sell'      => ['Hero "sell" button text', false],
    'categories_eyebrow' => ['Categories section eyebrow', false],
    'categories_heading' => ['Categories section heading', false],
    'deals_eyebrow'      => ['Deals section eyebrow', false],
    'deals_heading'      => ['Deals section heading', false],
    'estate_eyebrow'     => ['Real-estate strip eyebrow', false],
    'estate_heading'     => ['Real-estate strip heading', false],
    'estate_sub'         => ['Real-estate strip subtext', true],
    'estate_cta'         => ['Real-estate strip button text', false],
    'newsletter_heading' => ['Newsletter heading', false],
    'newsletter_sub'     => ['Newsletter subtext', false],
    'footer_brand_desc'  => ['Footer brand description', true],
    'contact_phone'      => ['Contact phone', false],
    'contact_email'      => ['Contact email', false],
    'contact_whatsapp'   => ['WhatsApp number (with country code, e.g. 8801644842785 — no + or spaces)', false],
];

if (is_post()) {
    csrf_check();
    foreach (array_keys($fields) as $key) {
        $en = (string) input($key . '_en', '');
        $bn = (string) input($key . '_bn', '');
        $existing = row('SELECT id FROM settings WHERE k = ?', [$key]);
        if ($existing) {
            update('settings', ['v_en' => $en, 'v_bn' => $bn ?: null], 'id = ?', [$existing['id']]);
        } else {
            insert('settings', ['k' => $key, 'v_en' => $en, 'v_bn' => $bn ?: null]);
        }
    }
    flash('success', 'Settings saved.');
    redirect('admin/settings.php');
}

$current = [];
foreach (rows('SELECT k, v_en, v_bn FROM settings') as $r) {
    $current[$r['k']] = $r;
}

admin_header('Site Settings');
?>
<form method="post">
  <?= csrf_field() ?>
  <div class="admin-card">
    <?php foreach ($fields as $key => [$label, $isTextarea]): ?>
      <label class="admin-field"><span><?= e($label) ?> (English)</span>
        <?php if ($isTextarea): ?>
          <textarea name="<?= $key ?>_en"><?= e($current[$key]['v_en'] ?? '') ?></textarea>
        <?php else: ?>
          <input type="text" name="<?= $key ?>_en" value="<?= e($current[$key]['v_en'] ?? '') ?>">
        <?php endif; ?>
      </label>
      <label class="admin-field"><span><?= e($label) ?> (Bangla)</span>
        <?php if ($isTextarea): ?>
          <textarea name="<?= $key ?>_bn"><?= e($current[$key]['v_bn'] ?? '') ?></textarea>
        <?php else: ?>
          <input type="text" name="<?= $key ?>_bn" value="<?= e($current[$key]['v_bn'] ?? '') ?>">
        <?php endif; ?>
      </label>
      <hr style="border:none;border-top:1px solid var(--line);margin:16px 0">
    <?php endforeach; ?>
    <button class="admin-btn admin-btn-primary" type="submit">Save settings</button>
  </div>
</form>
<?php
admin_footer();
