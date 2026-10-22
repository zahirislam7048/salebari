<?php
require __DIR__ . '/../app/bootstrap.php';

$statuses = order_statuses();
$phoneIn  = '';
$orders   = null;   // null = nothing searched yet
$error    = null;

if (is_post()) {
    csrf_check();
    $phoneIn = (string) input('phone');

    /* Light brake on guessing numbers: 10 lookups per 10 minutes per browser session. */
    $hits = array_filter($_SESSION['track_hits'] ?? [], function ($t) { return time() - $t < 600; });
    if (count($hits) >= 10) {
        $error = 'Too many searches. Please wait a few minutes and try again.';
    } else {
        $hits[] = time();
        $_SESSION['track_hits'] = array_values($hits);
        $phone = normalize_bd_phone($phoneIn);
        if ($phone === null) {
            $error = 'Enter the mobile number you gave when you ordered (e.g. 01712345678).';
        } else {
            $orders = rows(
                'SELECT o.*, s.name AS stall_name FROM orders o LEFT JOIN stalls s ON s.id = o.stall_id WHERE o.phone = ? ORDER BY o.id DESC LIMIT 10',
                [$phone]
            );
            foreach ($orders as &$o) {
                $o['events'] = rows('SELECT * FROM order_events WHERE order_id = ? ORDER BY id DESC', [$o['id']]);
            }
            unset($o);
        }
    }
}

/* names for the EN / বাংলা toggle */
$dict = [];
foreach ($statuses as $k => $s) {
    $dict['os.' . $k]  = ['en' => $s[0], 'bn' => $s[1]];
    $dict['osm.' . $k] = ['en' => $s[3], 'bn' => $s[4]];
}

$phones = site_numbers();
$origin = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
site_header('Track your order', '<meta name="description" content="Track your SaleBari order with just your mobile number.">' . "\n" . '<link rel="canonical" href="' . e($origin . base_path() . '/track-order/') . '">', false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current" data-i18n="trk.title">Track your order</span></nav>

    <div class="acct-card acct-card-narrow trk-card">
      <h1 class="listing-page-title" data-i18n="trk.title">Track your order</h1>
      <p class="acct-muted" data-i18n="trk.sub">Enter the mobile number you used when you ordered and see where your order is.</p>
      <?php if ($error): ?><p class="acct-error"><?= e($error) ?></p><?php endif; ?>
      <form method="post" class="acct-form">
        <?= csrf_field() ?>
        <label class="acct-field"><span data-i18n="trk.phone">Mobile number</span>
          <input type="tel" name="phone" required inputmode="tel" autocomplete="tel" placeholder="01712345678" value="<?= e($phoneIn) ?>"></label>
        <button class="btn btn-primary acct-submit" type="submit" data-i18n="trk.btn">Track order</button>
      </form>
    </div>

    <?php if ($orders !== null): ?>
      <div class="trk-results">
        <?php if (!$orders): ?>
          <p class="listing-empty"><span data-i18n="trk.none">We could not find an order for this number. Check the number, or contact us and we will help.</span>
            <a href="<?= base_path() ?>/help/#contact" style="color:var(--gold-deep);font-weight:600" data-i18n="trk.contact">Contact us →</a></p>
        <?php endif; ?>
        <?php foreach ($orders as $o): $st = $statuses[$o['status']] ?? $statuses['placed']; ?>
          <article class="trk-order">
            <header class="trk-head">
              <div>
                <strong class="trk-no"><?= e(order_number((int) $o['id'])) ?></strong>
                <span class="trk-date"><?= e(date('j M Y', strtotime((string) $o['created_at']))) ?></span>
              </div>
              <span class="trk-badge trk-<?= e($o['status']) ?>"><?= e($st[2]) ?> <span data-i18n="os.<?= e($o['status']) ?>"><?= e($st[0]) ?></span></span>
            </header>
            <p class="trk-item"><?= e($o['item_title']) ?><?= (int) $o['quantity'] > 1 ? ' × ' . (int) $o['quantity'] : '' ?><?php if ($o['stall_name']): ?> <span class="trk-seller">· <?= e($o['stall_name']) ?></span><?php endif; ?></p>
            <p class="trk-message" data-i18n="osm.<?= e($o['status']) ?>"><?= e($st[3]) ?></p>
            <?php if (!empty($o['status_note'])): ?><p class="trk-note">ℹ️ <?= e($o['status_note']) ?></p><?php endif; ?>

            <ol class="trk-timeline">
              <?php foreach ($o['events'] as $i => $ev): $es = $statuses[$ev['status']] ?? $statuses['placed']; ?>
                <li class="<?= $i === 0 ? 'is-current' : '' ?>">
                  <span class="trk-dot"><?= e($es[2]) ?></span>
                  <div>
                    <strong data-i18n="os.<?= e($ev['status']) ?>"><?= e($es[0]) ?></strong>
                    <small><?= e(date('j M Y, g:i a', strtotime((string) $ev['created_at']))) ?></small>
                    <?php if (!empty($ev['note'])): ?><small class="trk-evnote"><?= e($ev['note']) ?></small><?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ol>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p class="acct-muted trk-help"><span data-i18n="trk.help">Need help with an order?</span>
      <?php foreach ($phones as $i => $n): ?><?= $i ? ' / ' : ' ' ?><a href="https://wa.me/<?= e($n['wa']) ?>" target="_blank" rel="noopener">WhatsApp <?= e($n['display']) ?></a><?php endforeach; ?></p>
  </div>
</section>
<?php ob_start(); ?>
<script>
  (function () {
    var add = <?= json_encode($dict, JSON_UNESCAPED_UNICODE) ?>;
    Object.assign(add, {
      'trk.title': { en: 'Track your order', bn: 'আপনার অর্ডার ট্র্যাক করুন' },
      'trk.sub': { en: 'Enter the mobile number you used when you ordered and see where your order is.', bn: 'অর্ডারের সময় যে মোবাইল নম্বর দিয়েছিলেন সেটি লিখুন এবং দেখুন আপনার অর্ডার কোথায় আছে।' },
      'trk.phone': { en: 'Mobile number', bn: 'মোবাইল নম্বর' },
      'trk.btn': { en: 'Track order', bn: 'অর্ডার ট্র্যাক করুন' },
      'trk.none': { en: 'We could not find an order for this number. Check the number, or contact us and we will help.', bn: 'এই নম্বরে কোনো অর্ডার পাওয়া যায়নি। নম্বরটি আবার দেখুন, অথবা আমাদের জানান, আমরা সাহায্য করব।' },
      'trk.contact': { en: 'Contact us →', bn: 'যোগাযোগ করুন →' },
      'trk.help': { en: 'Need help with an order?', bn: 'অর্ডার নিয়ে সাহায্য লাগবে?' }
    });
    Object.keys(add).forEach(function (k) { window.I18N.dict[k] = add[k]; });
    window.I18N.applyLanguage(window.I18N.currentLang());
  })();
</script>
<?php
site_footer(ob_get_clean());
