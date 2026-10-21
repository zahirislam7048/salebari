<?php
require __DIR__ . '/../../app/bootstrap.php';

$q       = trim((string) input('q', ''));
$where   = "status = 'active' AND review_status = 'approved'" . ($q !== '' ? ' AND name LIKE ?' : '');
$args    = $q !== '' ? ['%' . $q . '%'] : [];
$perPage = 24;
$page    = input_int('page', 1);
$total   = (int) scalar("SELECT COUNT(*) FROM stalls WHERE $where", $args);
$p       = paginate($total, $perPage, $page);
$stalls  = rows("SELECT * FROM stalls WHERE $where ORDER BY id DESC LIMIT " . $p['per'] . ' OFFSET ' . $p['offset'], $args);
$grandTotal = (int) scalar("SELECT COUNT(*) FROM stalls WHERE status = 'active' AND review_status = 'approved'");
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stall Directory — SaleBari</title>
<meta name="description" content="Browse every verified stall on SaleBari, Bangladesh's digital bazaar.">
<link rel="icon" type="image/svg+xml" href="../../assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<!-- ============ UTILITY BAR ============ -->
<div class="utility-bar">
  <div class="wrap utility-inner">
    <div class="utility-left">
      <span data-i18n="utility.location">📍 Serving all 64 districts</span>
      <span class="sep">•</span>
      <span data-i18n="utility.helpline">☎ +8801515286327</span><span class="util-num2">+8801644842785</span>
    </div>
    <div class="utility-right">
      <a href="../../sell/" data-i18n="utility.sell">Sell on SaleBari</a>
      <span class="sep">•</span>
      <a href="../../index.html#help" data-i18n="utility.help">Help</a>
      <span class="sep">•</span>
      <button type="button" id="langToggle" class="lang-toggle">বাংলা</button>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="site-header">
  <div class="wrap header-inner">
    <a href="../../index.html" class="logo">
      <svg class="logo-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <text x="2" y="86" font-family="Fraunces, Georgia, serif" font-weight="900" font-size="80" fill="currentColor">S</text>
        <text x="44" y="98" font-family="Fraunces, Georgia, serif" font-weight="900" font-size="80" fill="currentColor">B</text>
        <line x1="90" y1="10" x2="38" y2="106" stroke="currentColor" stroke-width="5.5" stroke-linecap="round"/>
        <line x1="2" y1="110" x2="112" y2="110" stroke="currentColor" stroke-width="5.5" stroke-linecap="round"/>
      </svg>
      <span class="logo-word">Sale Bari</span>
    </a>

    <form class="search-bar" role="search">
      <select class="search-scope" aria-label="Category">
        <option data-i18n="search.scope.all">All stalls</option>
        <option data-i18n="cat.realestate">Real Estate</option>
        <option data-i18n="cat.carbike">Car &amp; Bike</option>
        <option data-i18n="cat.agro">Agro</option>
      </select>
      <input type="search" placeholder="Search for a product, brand or stall…" aria-label="Search" data-i18n-placeholder="search.placeholder">
      <button type="submit" aria-label="Search">
        <svg viewBox="0 0 24 24" width="20" height="20"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Zm6.4-1.6L21 20.5"/></svg>
      </button>
    </form>

    <div class="header-actions">
      <a href="../../account/" class="icon-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
        <span data-i18n="header.account">Account</span>
      </a>
      <a href="../../sell/" class="icon-link sell-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M4 10 5 4h14l1 6M4 10a2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0M5 10v9h14v-9"/></svg>
        <span data-i18n="header.sell">Sell</span>
      </a>
      <a href="../../index.html#cart" class="icon-link cart-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M3 4h2l2.2 11.6a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L20 8H6"/><circle cx="9.5" cy="20" r="1.4" fill="currentColor"/><circle cx="17" cy="20" r="1.4" fill="currentColor"/></svg>
        <span data-i18n="header.cart">Cart</span>
        <b class="cart-count">0</b>
      </a>
      <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <nav class="category-nav" aria-label="Categories">
    <div class="wrap cat-nav-inner">
      <ul class="cat-list">
        <li><a href="../../category.html?cat=carbike" data-i18n="cat.carbike">Car &amp; Bike</a></li>
        <li><a href="../../category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a></li>
        <li><a href="../../category.html?cat=agro" data-i18n="cat.agro">Agro</a></li>
      </ul>
      <a class="deals-tag" href="../../index.html#deals" data-i18n="deals.tag">Today's Deals</a>
    </div>
  </nav>
</header>

<!-- ============ STALL DIRECTORY ============ -->
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="../../index.html" data-i18n="nav.home">Home</a>
      <span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current" data-i18n="stall.directory">Stall Directory</span>
    </nav>

    <div class="stall-page-title-row">
      <h1 class="stall-page-title" data-i18n="stall.title">Stall Directory — SaleBari Seller</h1>
      <div class="stall-page-stat"><strong><?= number_format($grandTotal) ?></strong> <span data-i18n="stall.countLabel">stalls listed</span></div>
    </div>
    <p class="stall-page-lede" data-i18n="stall.lede">Discover verified sellers across real estate, car &amp; bike, and agro.</p>

    <form method="get" class="search-bar" style="max-width:520px;margin-bottom:28px">
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search stalls by name…" aria-label="Search stalls by name">
      <button type="submit" aria-label="Search">
        <svg viewBox="0 0 24 24" width="20" height="20"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Zm6.4-1.6L21 20.5"/></svg>
      </button>
    </form>

    <?php if (!$stalls): ?>
      <p class="listing-empty">No stalls found<?= $q !== '' ? ' for "' . e($q) . '"' : ' yet' ?>.</p>
    <?php else: ?>
      <div class="stall-grid">
        <?php foreach ($stalls as $i => $s): ?>
          <a class="stalldir-card" href="<?= e(stall_url($s)) ?>">
            <div class="stall-logo c<?= ($i % 8) + 1 ?><?= $s['logo_image'] || $s['logo_emoji'] ? '' : ' generic' ?>">
              <?php if ($s['logo_image']): ?>
                <img src="<?= e(asset($s['logo_image'])) ?>" alt="">
              <?php elseif ($s['logo_emoji']): ?>
                <?= e($s['logo_emoji']) ?>
              <?php else: ?>
                🏬
              <?php endif; ?>
            </div>
            <div class="stall-card-body">
              <p class="stall-card-name">
                <span class="stall-card-name-text"><?= e($s['name']) ?></span>
                <?php if ($s['verified']): ?><span class="vbadge" title="Verified Seller">✓</span><?php endif; ?>
              </p>
              <div class="stall-card-meta">
                <?php if ($s['city']): ?><span class="stall-card-meta-item">📍 <?= e($s['city']) ?></span><?php endif; ?>
                <?php if ($s['product_count'] > 0): ?>
                  <span class="stall-card-meta-item stall-card-meta-sep">📦 <?= (int) $s['product_count'] ?> <?= $s['product_count'] == 1 ? 'product' : 'products' ?></span>
                <?php endif; ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <?php if ($p['pages'] > 1): ?>
        <nav class="stall-detail-pagination" aria-label="Stall directory pagination">
          <?php if ($p['page'] > 1): ?>
            <a href="?<?= http_build_query(array_filter(['q' => $q, 'page' => $p['page'] - 1])) ?>">‹ Previous</a>
          <?php else: ?>
            <span class="disabled">‹ Previous</span>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $p['pages']; $i++): ?>
            <?php if ($i === $p['page']): ?>
              <span class="active"><?= $i ?></span>
            <?php else: ?>
              <a href="?<?= http_build_query(array_filter(['q' => $q, 'page' => $i])) ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
          <?php if ($p['page'] < $p['pages']): ?>
            <a href="?<?= http_build_query(array_filter(['q' => $q, 'page' => $p['page'] + 1])) ?>">Next ›</a>
            <a href="?<?= http_build_query(array_filter(['q' => $q, 'page' => $p['pages']])) ?>">Last ›</a>
          <?php else: ?>
            <span class="disabled">Next ›</span>
            <span class="disabled">Last ›</span>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="wrap footer-inner">
    <div class="footer-col footer-brand">
      <a href="../../index.html" class="logo logo-footer">
        <svg class="logo-icon" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <text x="2" y="86" font-family="Fraunces, Georgia, serif" font-weight="900" font-size="80" fill="currentColor">S</text>
          <text x="44" y="98" font-family="Fraunces, Georgia, serif" font-weight="900" font-size="80" fill="currentColor">B</text>
          <line x1="90" y1="10" x2="38" y2="106" stroke="currentColor" stroke-width="5.5" stroke-linecap="round"/>
          <line x1="2" y1="110" x2="112" y2="110" stroke="currentColor" stroke-width="5.5" stroke-linecap="round"/>
        </svg>
        <span class="logo-word">Sale Bari</span>
      </a>
      <p data-i18n="footer.brandDesc">Bangladesh's digital bazaar — verified stalls, instant price comparison, one address for everything you need.</p>
      <div class="social-row">
        <a href="#" aria-label="Facebook">f</a>
        <a href="#" aria-label="X / Twitter">𝕏</a>
        <a href="#" aria-label="Instagram">◎</a>
        <a href="#" aria-label="YouTube">▶</a>
      </div>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.shop">Shop</h4>
      <a href="./" data-i18n="footer.allStalls">All stalls</a>
      <a href="../../market/list/" data-i18n="footer.shoppingMall">Shopping Mall</a>
      <a href="../../index.html#deals" data-i18n="deals.tag">Today's Deals</a>
      <a href="../../category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a>
      <a href="../../brand/list/" data-i18n="footer.brands">Brands</a>
      <a href="../../blog.php" data-i18n="footer.blog">Blog</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.forSellers">For Sellers</h4>
      <a href="../../sell/" data-i18n="footer.startSelling">Start selling</a>
      <a href="../../package.html" data-i18n="footer.package">Package</a>
      <a href="#" data-i18n="footer.howItWorks">How it works</a>
      <a href="#" data-i18n="footer.sellerFees">Seller fees</a>
      <a href="#" data-i18n="footer.successStories">Success stories</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="utility.help">Help</h4>
      <a href="#" data-i18n="footer.contactUs">Contact us</a>
      <a href="#" data-i18n="footer.faq">FAQ</a>
      <a href="#" data-i18n="footer.returnPolicy">Return &amp; refund policy</a>
      <a href="#" data-i18n="footer.trackOrder">Track an order</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.getInTouch">Get in touch</h4>
      <p class="footer-phone">☎ <a href="tel:+8801515286327">+880 1515-286327</a> <a class="ft-wa" href="https://wa.me/8801515286327" target="_blank" rel="noopener">WhatsApp</a></p>
      <p class="footer-phone">☎ <a href="tel:+8801644842785">+880 1644-842785</a> <a class="ft-wa" href="https://wa.me/8801644842785" target="_blank" rel="noopener">WhatsApp</a></p>
      <p>islamzahirul7048@gmail.com</p>
    </div>
  </div>

  <div class="wrap footer-bottom">
    <div class="footer-badges">
      <span data-i18n="footer.badgeSsl">✓ SSL Secured</span>
      <span data-i18n="footer.badgeVerified">✓ Verified Sellers</span>
      <span data-i18n="footer.badgeBuyer">✓ Buyer Protection</span>
    </div>
    <div class="footer-pay">bKash · Nagad · Rocket · Visa · Mastercard · COD</div>
  </div>
  <div class="wrap footer-legal">
    <p data-i18n="footer.copyright">© 2026 SaleBari.com — All rights reserved.</p>
    <div class="legal-links">
      <a href="#" data-i18n="footer.privacy">Privacy Policy</a>
      <a href="#" data-i18n="footer.terms">Terms of Service</a>
      <a href="#" data-i18n="footer.sitemap">Sitemap</a>
    </div>
  </div>
</footer>

<button class="scroll-top" aria-label="Scroll to top">↑</button>

<script src="../../js/nav-data.js"></script>
<script src="../../js/catalog-data.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>
