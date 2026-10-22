<?php
require __DIR__ . '/../app/bootstrap.php';

$stories = rows("SELECT * FROM success_stories WHERE status = 'published' ORDER BY sort_order, id DESC LIMIT 60");
$nums    = site_numbers();
$wa      = $nums[0]['wa'];
$shareWa = 'https://wa.me/' . $wa . '?text=' . urlencode("Hi SaleBari, I'd like to share my success story: ");
$origin  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com');
$head = '<meta name="description" content="Success stories from sellers who grew their business on SaleBari, Bangladesh\'s digital bazaar.">' . "\n"
    . '<link rel="canonical" href="' . e($origin . base_path() . '/success-stories/') . '">';

site_header('Success Stories', $head, false);
?>
<section class="section category-page help-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current" data-i18n="ss.title">Success stories</span></nav>

    <header class="help-hero">
      <h1 class="listing-page-title" data-i18n="ss.title">Success stories</h1>
      <p class="acct-muted" data-i18n="ss.sub">Real sellers, real results — how businesses grow on SaleBari.</p>
    </header>

    <?php if ($stories): ?>
      <div class="ss-grid">
        <?php foreach ($stories as $s): ?>
          <article class="ss-card" id="story-<?= (int) $s['id'] ?>">
            <?php if ($s['photo']): ?><img class="ss-photo" src="<?= e(asset($s['photo'])) ?>" alt="<?= e($s['name']) ?>" loading="lazy"><?php else: ?><div class="ss-photo ss-photo-empty">🏪</div><?php endif; ?>
            <div class="ss-body">
              <?php if ($s['highlight']): ?><span class="ss-highlight"><?= e($s['highlight']) ?></span><?php endif; ?>
              <h2>
                <span data-lang="en"><?= e($s['headline']) ?></span>
                <span data-lang="bn"><?= e($s['headline_bn'] ?: $s['headline']) ?></span>
              </h2>
              <?php if ($s['quote']): ?><blockquote class="ss-quote">“<?= e($s['quote']) ?>”</blockquote><?php endif; ?>
              <?php if ($s['story']): ?>
                <div class="ss-text brand-about-body" data-lang="en"><?= $s['story'] ?></div>
                <div class="ss-text brand-about-body" data-lang="bn"><?= $s['story_bn'] ?: $s['story'] ?></div>
              <?php endif; ?>
              <p class="ss-who"><strong><?= e($s['name']) ?></strong><?php if ($s['business']): ?> · <?= e($s['business']) ?><?php endif; ?><?php if ($s['location']): ?> · 📍 <?= e($s['location']) ?><?php endif; ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="ss-empty">
        <div class="ss-empty-ico">🌱</div>
        <h2 data-i18n="ss.emptyTitle">Our first stories are on the way</h2>
        <p data-i18n="ss.emptyText">SaleBari is growing, and we are collecting the first stories from sellers who built their business with us. Check back soon.</p>
      </div>
    <?php endif; ?>

    <section class="ss-cta">
      <h2 data-i18n="ss.ctaTitle">Be our next success story</h2>
      <p data-i18n="ss.ctaText">Open your stall, reach buyers across Bangladesh and grow your business.</p>
      <div class="ss-cta-actions">
        <a class="btn btn-primary" href="<?= base_path() ?>/sell/" data-i18n="help.openStall">Open your stall</a>
        <a class="btn btn-ghost" href="<?= e($shareWa) ?>" target="_blank" rel="noopener" data-i18n="ss.share">Share your story</a>
      </div>
    </section>
  </div>
</section>
<?php ob_start(); ?>
<script>
  (function () {
    var add = {
      'ss.title': { en: 'Success stories', bn: 'সাফল্যের গল্প' },
      'ss.sub': { en: 'Real sellers, real results — how businesses grow on SaleBari.', bn: 'আসল বিক্রেতা, আসল ফলাফল — SaleBari-তে কীভাবে ব্যবসা বড় হয়।' },
      'ss.emptyTitle': { en: 'Our first stories are on the way', bn: 'আমাদের প্রথম গল্পগুলো আসছে' },
      'ss.emptyText': { en: 'SaleBari is growing, and we are collecting the first stories from sellers who built their business with us. Check back soon.', bn: 'SaleBari বড় হচ্ছে, আর আমাদের সাথে ব্যবসা গড়ে তোলা বিক্রেতাদের প্রথম গল্পগুলো আমরা সংগ্রহ করছি। শীঘ্রই আবার দেখুন।' },
      'ss.ctaTitle': { en: 'Be our next success story', bn: 'আপনিই হোন আমাদের পরবর্তী সাফল্যের গল্প' },
      'ss.ctaText': { en: 'Open your stall, reach buyers across Bangladesh and grow your business.', bn: 'স্টল খুলুন, সারা বাংলাদেশের ক্রেতাদের কাছে পৌঁছান এবং আপনার ব্যবসা বড় করুন।' },
      'ss.share': { en: 'Share your story', bn: 'আপনার গল্প জানান' },
      'help.openStall': { en: 'Open your stall', bn: 'আপনার স্টল খুলুন' }
    };
    Object.keys(add).forEach(function (k) { window.I18N.dict[k] = add[k]; });
    window.I18N.applyLanguage(window.I18N.currentLang());
  })();
</script>
<?php
site_footer(ob_get_clean());
