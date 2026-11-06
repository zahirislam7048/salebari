<?php
require __DIR__ . '/../app/bootstrap.php';

site_header('Saved items', '<meta name="robots" content="noindex,follow">', false);
?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current" data-i18n="wish.title">Saved items</span></nav>
    <div class="listing-page-header">
      <h1 class="listing-page-title" data-i18n="wish.title">Saved items</h1>
      <p class="listing-page-stat" id="wishStat"></p>
    </div>
    <div class="listing-grid catalog-grid" id="wishGrid"></div>
    <p class="listing-empty" id="wishEmpty" hidden><span data-i18n="wish.empty">You have not saved anything yet. Tap the heart on any listing to keep it here.</span> <a href="<?= base_path() ?>/index.html" style="color:var(--gold-deep);font-weight:600" data-i18n="wish.browse">Browse listings →</a></p>
    <p class="acct-muted" data-i18n="wish.note">Saved items are kept on this phone or computer only. They are not sent to SaleBari.</p>
  </div>
</section>
<?php ob_start(); ?>
<script>
  (function () {
    var add = {
      'wish.title': { en: 'Saved items', bn: 'সেভ করা পণ্য' },
      'wish.empty': { en: 'You have not saved anything yet. Tap the heart on any listing to keep it here.', bn: 'আপনি এখনো কিছু সেভ করেননি। যেকোনো লিস্টিংয়ের হার্টে চাপ দিলে এখানে জমা থাকবে।' },
      'wish.browse': { en: 'Browse listings →', bn: 'লিস্টিং দেখুন →' },
      'wish.note': { en: 'Saved items are kept on this phone or computer only. They are not sent to SaleBari.', bn: 'সেভ করা পণ্য শুধু এই ফোন বা কম্পিউটারে থাকে। SaleBari-তে পাঠানো হয় না।' },
      'wish.remove': { en: 'Remove', bn: 'সরান' }
    };
    Object.keys(add).forEach(function (k) { window.I18N.dict[k] = add[k]; });
    window.I18N.applyLanguage(window.I18N.currentLang());

    var grid = document.getElementById('wishGrid'), empty = document.getElementById('wishEmpty'), stat = document.getElementById('wishStat');
    function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : s; return d.innerHTML; }
    function render() {
      var ids = window.SBWish ? window.SBWish.list() : [];
      if (!ids.length) { grid.innerHTML = ''; empty.hidden = false; stat.textContent = ''; return; }
      fetch('<?= base_path() ?>/api/wishlist.php?ids=' + ids.join(','), { cache: 'no-store' }).then(function (r) { return r.json(); }).then(function (items) {
        empty.hidden = items.length > 0;
        stat.textContent = items.length + (items.length === 1 ? ' item' : ' items');
        grid.innerHTML = items.map(function (p) {
          return '<div class="card-wrap"><a class="listing-card" href="' + esc(p.url) + '"><div class="listing-card-media">' +
            (p.image ? '<img src="' + esc(p.image) + '" alt="' + esc(p.title) + '" loading="lazy">' : '🛒') +
            '</div><div class="listing-card-body"><h3 class="listing-card-title">' + esc(p.title) + '</h3>' +
            (p.price ? '<div class="listing-card-price">' + esc(p.price) + '</div>' : '') + '</div></a>' +
            '<button type="button" class="wish-btn is-on" data-wish="' + p.id + '" aria-pressed="true" aria-label="Remove from saved"><span class="wish-ico">♥</span></button></div>';
        }).join('');
        /* ids that no longer exist are dropped from the saved list */
        var live = items.map(function (p) { return p.id; });
        ids.forEach(function (id) { if (live.indexOf(id) === -1) window.SBWish.remove(id, true); });
      }).catch(function () { empty.hidden = false; });
    }
    document.addEventListener('sb:wish', render);
    render();
  })();
</script>
<?php
site_footer(ob_get_clean());
