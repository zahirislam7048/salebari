<?php
require __DIR__ . '/../app/bootstrap.php';

$slug  = (string) input('slug', '');
$sid   = input_int('sid', 0);
$stall = $sid
    ? row("SELECT * FROM stalls WHERE id = ? AND status = 'active'", [public_to_id($sid)])
    : ($slug ? row("SELECT * FROM stalls WHERE slug = ? AND status = 'active'", [$slug]) : null);

if ($stall && $stall['review_status'] !== 'approved' && !can_preview($stall)) {
    $stall = null;
}
if (!$stall) {
    http_response_code(404);
} else {
    redirect_to_canonical(stall_url($stall));
}

$products = $stall ? rows(
    "SELECT * FROM products WHERE stall_id = ? AND status = 'active' ORDER BY id DESC",
    [$stall['id']]
) : [];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $stall ? e($stall['name']) . ' — SaleBari' : 'Stall not found — SaleBari' ?></title>
<meta name="description" content="<?= $stall ? e($stall['name'] . ' on SaleBari, Bangladesh\'s digital bazaar.') : '' ?>">
<link rel="icon" type="image/svg+xml" href="<?= base_path() ?>/assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_path() ?>/css/style.css">
</head>
<body>

<!-- ============ UTILITY BAR ============ -->
<div class="utility-bar">
  <div class="wrap utility-inner">
    <div class="utility-left">
      <span data-i18n="utility.location">📍 Serving all 64 districts</span>
      <span class="sep">•</span>
      <span data-i18n="utility.helpline">☎ +8801644842785</span>
    </div>
    <div class="utility-right">
      <a href="<?= base_path() ?>/sell/" data-i18n="utility.sell">Sell on SaleBari</a>
      <span class="sep">•</span>
      <a href="<?= base_path() ?>/index.html#help" data-i18n="utility.help">Help</a>
      <span class="sep">•</span>
      <button type="button" id="langToggle" class="lang-toggle">বাংলা</button>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="site-header">
  <div class="wrap header-inner">
    <a href="<?= base_path() ?>/index.html" class="logo">
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
      <a href="<?= base_path() ?>/account/" class="icon-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
        <span data-i18n="header.account">Account</span>
      </a>
      <a href="<?= base_path() ?>/sell/" class="icon-link sell-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M4 10 5 4h14l1 6M4 10a2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0M5 10v9h14v-9"/></svg>
        <span data-i18n="header.sell">Sell</span>
      </a>
      <a href="<?= base_path() ?>/index.html#cart" class="icon-link cart-link">
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
        <li><a href="<?= base_path() ?>/category.html?cat=carbike" data-i18n="cat.carbike">Car &amp; Bike</a></li>
        <li><a href="<?= base_path() ?>/category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a></li>
        <li><a href="<?= base_path() ?>/category.html?cat=agro" data-i18n="cat.agro">Agro</a></li>
      </ul>
      <a class="deals-tag" href="<?= base_path() ?>/index.html#deals" data-i18n="deals.tag">Today's Deals</a>
    </div>
  </nav>
</header>

<?php if (!$stall): ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><a href="<?= base_path() ?>/stall/list/">Stall Directory</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Not found</span></nav>
    <div class="listing-page-header">
      <h1 class="listing-page-title">Stall not found</h1>
      <p class="listing-page-stat">This stall may have been removed.</p>
    </div>
  </div>
</section>
<?php else: ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb">
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <a href="<?= base_path() ?>/stall/list/">Stall Directory</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($stall['name']) ?></span>
    </nav>

    <section class="stall-detail-identity">
      <div class="wrap stall-identity-card">
        <div class="stall-logo stall-identity-logo c1<?= $stall['logo_image'] || $stall['logo_emoji'] ? '' : ' generic' ?>">
          <?php if ($stall['logo_image']): ?>
            <img src="<?= e(asset($stall['logo_image'])) ?>" alt="">
          <?php elseif ($stall['logo_emoji']): ?>
            <?= e($stall['logo_emoji']) ?>
          <?php else: ?>
            🏬
          <?php endif; ?>
        </div>
        <div class="stall-identity-info">
          <div class="stall-identity-name-row">
            <h1 class="stall-identity-name"><?= e($stall['name']) ?></h1>
            <?php if ($stall['verified']): ?><span class="vbadge-lg" title="Verified Seller">✓</span><?php endif; ?>
          </div>
          <div class="stall-identity-meta">
            <?php if ($stall['city']): ?><span class="stall-identity-meta-item">📍 <?= e($stall['city']) ?></span><?php endif; ?>
            <?php if ($stall['phone']): ?><span class="stall-identity-meta-item">☎ <?= e($stall['phone']) ?></span><?php endif; ?>
          </div>
          <?php if ($stall['description']): ?><p class="stall-page-lede"><?= e($stall['description']) ?></p><?php endif; ?>
        </div>
      </div>
    </section>

    <div class="stall-detail-body">
      <h2 class="stall-section-title" style="margin:0 0 18px">Products from this stall</h2>
      <?php if (!$products): ?>
        <p class="listing-empty">No products from this stall yet.</p>
      <?php else: ?>
        <div class="product-grid">
          <?php foreach ($products as $prod): $pimgs = json_decode((string) $prod['images'], true) ?: []; ?>
            <a class="product-card" href="<?= e(product_url($prod)) ?>" style="text-decoration:none;color:inherit;display:block">
              <div class="product-media grad-1">
                <?php if ($pimgs): ?><img src="<?= e(asset($pimgs[0])) ?>" alt=""><?php else: ?><span>🛒</span><?php endif; ?>
              </div>
              <div class="product-body">
                <h3 class="product-title"><?= e($prod['title_en']) ?></h3>
                <?php if ($prod['price_display']): ?><div class="product-price"><span class="price-tag"><?= e($prod['price_display']) ?></span></div><?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="wrap footer-inner">
    <div class="footer-col footer-brand">
      <a href="<?= base_path() ?>/index.html" class="logo logo-footer">
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
      <a href="<?= base_path() ?>/stall/list/" data-i18n="footer.allStalls">All stalls</a>
      <a href="<?= base_path() ?>/market/list/" data-i18n="footer.shoppingMall">Shopping Mall</a>
      <a href="<?= base_path() ?>/index.html#deals" data-i18n="deals.tag">Today's Deals</a>
      <a href="<?= base_path() ?>/category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a>
      <a href="<?= base_path() ?>/brand/list/" data-i18n="footer.brands">Brands</a>
      <a href="<?= base_path() ?>/blog.php" data-i18n="footer.blog">Blog</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.forSellers">For Sellers</h4>
      <a href="<?= base_path() ?>/sell/" data-i18n="footer.startSelling">Start selling</a>
      <a href="<?= base_path() ?>/package.html" data-i18n="footer.package">Package</a>
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
      <p class="footer-phone">☎ +880 1644-842785</p>
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

<script src="<?= base_path() ?>/js/nav-data.js"></script>
<script src="<?= base_path() ?>/js/catalog-data.js"></script>
<script src="<?= base_path() ?>/js/main.js"></script>
</body>
</html>
