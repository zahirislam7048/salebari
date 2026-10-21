<?php
require __DIR__ . '/../app/bootstrap.php';

$slug  = (string) input('slug', '');
$brand = $slug ? row('SELECT * FROM brands WHERE slug = ?', [$slug]) : null;

if ($brand && $brand['review_status'] !== 'approved' && !can_preview($brand)) {
    $brand = null;
}
if (!$brand) {
    http_response_code(404);
}

$products = $brand ? rows(
    "SELECT * FROM products WHERE brand_id = ? AND status = 'active' ORDER BY id DESC",
    [$brand['id']]
) : [];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $brand ? e($brand['name']) . ' — SaleBari' : 'Brand not found — SaleBari' ?></title>
<meta name="description" content="<?= $brand ? e(mb_substr(trim(strip_tags((string) $brand['description'])), 0, 160) ?: $brand['name'] . ' products on SaleBari, Bangladesh\'s digital bazaar.') : '' ?>">
<link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
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
      <a href="../sell/" data-i18n="utility.sell">Sell on SaleBari</a>
      <span class="sep">•</span>
      <a href="../index.html#help" data-i18n="utility.help">Help</a>
      <span class="sep">•</span>
      <button type="button" id="langToggle" class="lang-toggle">বাংলা</button>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="site-header">
  <div class="wrap header-inner">
    <a href="../index.html" class="logo">
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
      <a href="../account/" class="icon-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
        <span data-i18n="header.account">Account</span>
      </a>
      <a href="../sell/" class="icon-link sell-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M4 10 5 4h14l1 6M4 10a2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0M5 10v9h14v-9"/></svg>
        <span data-i18n="header.sell">Sell</span>
      </a>
      <a href="../index.html#cart" class="icon-link cart-link">
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
        <li><a href="../category.html?cat=carbike" data-i18n="cat.carbike">Car &amp; Bike</a></li>
        <li><a href="../category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a></li>
        <li><a href="../category.html?cat=agro" data-i18n="cat.agro">Agro</a></li>
      </ul>
      <a class="deals-tag" href="../index.html#deals" data-i18n="deals.tag">Today's Deals</a>
    </div>
  </nav>
</header>

<?php if (!$brand): ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="../index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><a href="list/">All Brands</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Not found</span></nav>
    <div class="listing-page-header">
      <h1 class="listing-page-title">Brand not found</h1>
    </div>
  </div>
</section>
<?php else: ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb">
      <a href="../index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <a href="list/">All Brands</a><span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-current"><?= e($brand['name']) ?></span>
    </nav>

    <div class="brand-hero">
      <?php if ($brand['logo_image']): ?>
        <img class="brand-hero-logo" src="<?= e(asset($brand['logo_image'])) ?>" alt="">
      <?php endif; ?>
      <div>
        <h1 class="listing-page-title" style="margin:0"><?= e($brand['name']) ?></h1>
        <?php if ($brand['location']): ?>
          <p class="brand-hero-location">📍 <?= e($brand['location']) ?></p>
        <?php endif; ?>
      </div>
    </div>

    <?php
      $tel = function (?string $n): string { return preg_replace('/[^0-9+]/', '', (string) $n); };
      $mapEmbed = $brand['map_url'] && stripos($brand['map_url'], '/maps/embed') !== false;
      $mapQuery = trim(($brand['address'] ?: '') . ' ' . ($brand['location'] ?: ''));
      $mapLink  = $brand['map_url'] && !$mapEmbed
          ? $brand['map_url']
          : ($mapQuery !== '' ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapQuery) : null);
      $socials = [
          'Facebook' => $brand['facebook'], 'Instagram' => $brand['instagram'], 'YouTube' => $brand['youtube'],
          'X / Twitter' => $brand['twitter'], 'LinkedIn' => $brand['linkedin'],
      ];
      $hasContact = $brand['address'] || $brand['website'] || $brand['mobile'] || $brand['phone'] || $brand['email'] || array_filter($socials) || $mapEmbed || $mapLink;
    ?>

    <?php if ($brand['description'] || $hasContact): ?>
      <div class="brand-detail">
        <div class="brand-about">
          <?php if ($brand['description']): ?>
            <h2>About <?= e($brand['name']) ?></h2>
            <div class="brand-about-body"><?= $brand['description'] ?></div>
          <?php endif; ?>
        </div>

        <?php if ($hasContact): ?>
          <aside class="brand-contact">
            <h3>Contact &amp; location</h3>
            <ul class="brand-contact-list">
              <?php if ($brand['address']): ?><li><span>📍</span><?= e($brand['address']) ?></li><?php endif; ?>
              <?php if ($brand['mobile']): ?><li><span>📱</span><a href="tel:<?= e($tel($brand['mobile'])) ?>"><?= e($brand['mobile']) ?></a></li><?php endif; ?>
              <?php if ($brand['phone']): ?><li><span>☎</span><a href="tel:<?= e($tel($brand['phone'])) ?>"><?= e($brand['phone']) ?></a></li><?php endif; ?>
              <?php if ($brand['email']): ?><li><span>✉</span><a href="mailto:<?= e($brand['email']) ?>"><?= e($brand['email']) ?></a></li><?php endif; ?>
              <?php if ($brand['website']): ?><li><span>🌐</span><a href="<?= e($brand['website']) ?>" target="_blank" rel="noopener nofollow"><?= e(preg_replace('~^https?://(www\.)?~i', '', rtrim($brand['website'], '/'))) ?></a></li><?php endif; ?>
            </ul>

            <?php if (array_filter($socials)): ?>
              <div class="brand-socials">
                <?php foreach ($socials as $label => $href): if (!$href) continue; ?>
                  <a href="<?= e($href) ?>" target="_blank" rel="noopener nofollow"><?= e($label) ?></a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <?php if ($mapEmbed): ?>
              <iframe class="brand-map" src="<?= e($brand['map_url']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="Map of <?= e($brand['name']) ?>"></iframe>
            <?php endif; ?>
            <?php if ($mapLink): ?>
              <a class="btn btn-ghost brand-map-btn" href="<?= e($mapLink) ?>" target="_blank" rel="noopener">View on Google Maps</a>
            <?php endif; ?>
          </aside>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <h2 class="brand-products-heading">Products from <?= e($brand['name']) ?></h2>
    <?php if (!$products): ?>
      <p class="listing-empty">No products from <?= e($brand['name']) ?> yet.</p>
    <?php else: ?>
      <div class="product-grid">
        <?php foreach ($products as $prod): $pimgs = json_decode((string) $prod['images'], true) ?: []; ?>
          <a class="product-card" href="../product.php?slug=<?= e($prod['slug']) ?>" style="text-decoration:none;color:inherit;display:block">
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
</section>
<?php endif; ?>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="wrap footer-inner">
    <div class="footer-col footer-brand">
      <a href="../index.html" class="logo logo-footer">
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
      <a href="../stall/list/" data-i18n="footer.allStalls">All stalls</a>
      <a href="../market/list/" data-i18n="footer.shoppingMall">Shopping Mall</a>
      <a href="../index.html#deals" data-i18n="deals.tag">Today's Deals</a>
      <a href="../category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a>
      <a href="list/" data-i18n="footer.brands">Brands</a>
      <a href="../blog.php" data-i18n="footer.blog">Blog</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.forSellers">For Sellers</h4>
      <a href="../sell/" data-i18n="footer.startSelling">Start selling</a>
      <a href="../package.html" data-i18n="footer.package">Package</a>
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

<script src="../js/nav-data.js"></script>
<script src="../js/catalog-data.js"></script>
<script src="../js/main.js"></script>
</body>
</html>
