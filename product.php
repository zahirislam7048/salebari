<?php
require __DIR__ . '/app/bootstrap.php';

$slug = (string) input('slug', '');
$product = $slug ? row('SELECT * FROM products WHERE slug = ? AND status = ?', [$slug, 'active']) : null;

if (!$product) {
    http_response_code(404);
}

$category = $product ? row('SELECT * FROM categories WHERE id = ?', [$product['category_id']]) : null;
$stall = $product && $product['stall_id'] ? row("SELECT * FROM stalls WHERE id = ? AND review_status = 'approved'", [$product['stall_id']]) : null;
$brand = $product && $product['brand_id'] ? row("SELECT * FROM brands WHERE id = ? AND review_status = 'approved'", [$product['brand_id']]) : null;

/* Build the breadcrumb trail up to the top-level category. */
$trail = [];
$walk = $category;
while ($walk) {
    array_unshift($trail, $walk);
    $walk = $walk['parent_id'] ? row('SELECT * FROM categories WHERE id = ?', [$walk['parent_id']]) : null;
}

$images = $product ? (json_decode((string) $product['images'], true) ?: []) : [];

$similar = $product ? rows(
    'SELECT * FROM products WHERE category_id = ? AND id <> ? AND status = ? ORDER BY id DESC LIMIT 4',
    [$product['category_id'], $product['id'], 'active']
) : [];

$pageTitle = $product ? ($product['meta_title'] ?: $product['title_en']) . ' — SaleBari' : 'Product not found — SaleBari';
$pageDesc  = $product ? ($product['meta_description'] ?: mb_substr((string) $product['description_en'], 0, 160)) : '';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>">
<link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body class="has-pp-bar">

<!-- ============ UTILITY BAR ============ -->
<div class="utility-bar">
  <div class="wrap utility-inner">
    <div class="utility-left">
      <span data-i18n="utility.location">📍 Serving all 64 districts</span>
      <span class="sep">•</span>
      <span data-i18n="utility.helpline">☎ +8801644842785</span>
    </div>
    <div class="utility-right">
      <a href="index.html#sell" data-i18n="utility.sell">Sell on SaleBari</a>
      <span class="sep">•</span>
      <a href="index.html#help" data-i18n="utility.help">Help</a>
      <span class="sep">•</span>
      <button type="button" id="langToggle" class="lang-toggle">বাংলা</button>
    </div>
  </div>
</div>

<!-- ============ HEADER ============ -->
<header class="site-header">
  <div class="wrap header-inner">
    <a href="index.html" class="logo">
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
      <a href="account/" class="icon-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8c0-3.9 3.1-7 7-7s7 3.1 7 7"/></svg>
        <span data-i18n="header.account">Account</span>
      </a>
      <a href="index.html#sell" class="icon-link sell-link">
        <svg viewBox="0 0 24 24" width="22" height="22"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" d="M4 10 5 4h14l1 6M4 10a2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0 2 2 0 0 0 4 0M5 10v9h14v-9"/></svg>
        <span data-i18n="header.sell">Sell</span>
      </a>
      <a href="index.html#cart" class="icon-link cart-link">
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
        <li class="has-mega">
          <a href="category.html?cat=carbike" data-i18n="cat.carbike">Car &amp; Bike</a>
          <div class="mega mega-narrow">
            <div class="mega-col">
              <span class="mega-item" data-flyout="carAccessories"><a href="category.html?sub=carAccessories" data-i18n="mega.carAccessories">Car Accessories</a></span><span class="mega-item" data-flyout="bikeAccessories"><a href="category.html?sub=bikeAccessories" data-i18n="mega.bikeAccessories">Bike Accessories</a></span><span class="mega-item" data-flyout="threeWheeler"><a href="category.html?sub=threeWheeler" data-i18n="mega.threeWheeler">Three Wheeler</a></span><span class="mega-item" data-flyout="commercialVehicle"><a href="category.html?sub=commercialVehicle" data-i18n="mega.commercialVehicle">Commercial Vehicle</a></span><span class="mega-item" data-flyout="rental"><a href="category.html?sub=rental" data-i18n="mega.rental">Rental</a></span>
            </div>
          </div>
        </li>
        <li class="has-mega">
          <a href="category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a>
          <div class="mega mega-narrow">
            <div class="mega-col">
              <a href="listing.html?item=apartment" data-i18n="mega.apartment">Apartment</a><a href="listing.html?item=land" data-i18n="mega.land">Land</a><a href="listing.html?item=commercialSpace" data-i18n="mega.commercialSpace">Commercial Space</a><span class="mega-item" data-flyout="sanitary"><a href="category.html?sub=sanitary" data-i18n="mega.sanitary">Sanitary</a></span><span class="mega-item" data-flyout="constructionMaterial"><a href="category.html?sub=constructionMaterial" data-i18n="mega.constructionMaterial">Construction Material</a></span>
            </div>
          </div>
        </li>
        <li class="has-mega">
          <a href="category.html?cat=agro" data-i18n="cat.agro">Agro</a>
          <div class="mega mega-narrow">
            <div class="mega-col">
              <span class="mega-item" data-flyout="livestock"><a href="category.html?sub=livestock" data-i18n="mega.livestock">Livestock</a></span><span class="mega-item" data-flyout="fish"><a href="category.html?sub=fish" data-i18n="mega.fish">Fish</a></span><span class="mega-item" data-flyout="poultry"><a href="category.html?sub=poultry" data-i18n="mega.poultry">Poultry</a></span><span class="mega-item" data-flyout="birds"><a href="category.html?sub=birds" data-i18n="mega.birds">Birds</a></span>
            </div>
          </div>
        </li>
      </ul>
      <a class="deals-tag" href="index.html#deals" data-i18n="deals.tag">Today's Deals</a>
    </div>
  </nav>
</header>

<?php if (!$product): ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Not found</span></nav>
    <div class="listing-page-header">
      <h1 class="listing-page-title">Product not found</h1>
      <p class="listing-page-stat">This listing may have been removed or is no longer available.</p>
    </div>
  </div>
</section>
<?php else: ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb">
      <a href="index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php foreach ($trail as $i => $c): ?>
        <?php
          $crumbI18n = $c['level'] === 1 ? ('cat.' . $c['slug']) : ($c['level'] === 2 ? ('mega.' . $c['slug']) : null);
          $crumbI18nAttr = $crumbI18n ? ' data-i18n="' . e($crumbI18n) . '"' : '';
        ?>
        <?php if ($i < count($trail) - 1): ?>
          <a href="category.html?<?= $c['level'] === 1 ? 'cat=' . e($c['slug']) : 'sub=' . e($c['slug']) ?>"<?= $crumbI18nAttr ?>><?= e($c['name_en']) ?></a><span class="breadcrumb-sep">›</span>
        <?php else: ?>
          <a href="<?= $c['level'] === 1 ? 'category.html?cat=' . e($c['slug']) : 'listing.html?item=' . e($c['slug']) ?>"<?= $crumbI18nAttr ?>><?= e($c['name_en']) ?></a><span class="breadcrumb-sep">›</span>
        <?php endif; ?>
      <?php endforeach; ?>
      <span class="breadcrumb-current" data-i18n="pp.title.<?= (int) $product['id'] ?>"><?= e($product['title_en']) ?></span>
    </nav>

    <div class="product-page-layout">
      <div>
        <div class="pp-gallery-main" id="ppMainImage">
          <?php if ($images): ?>
            <img src="<?= e(asset($images[0])) ?>" alt="<?= e($product['title_en']) ?>" id="ppMainImg">
          <?php else: ?>
            <span>🛒</span>
          <?php endif; ?>
        </div>
        <?php if (count($images) > 1): ?>
          <div class="pp-thumbs">
            <?php foreach ($images as $i => $img): ?>
              <button type="button" class="pp-thumb <?= $i === 0 ? 'active' : '' ?>" data-src="<?= e(asset($img)) ?>">
                <img src="<?= e(asset($img)) ?>" alt="">
              </button>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="pp-info">
        <span class="pp-category-chip"><?= e($category['name_en'] ?? '') ?></span>
        <?php if ($brand): ?>
          <a class="pp-category-chip" href="brand/show.php?slug=<?= e($brand['slug']) ?>" style="margin-left:6px">🏷️ <?= e($brand['name']) ?></a>
        <?php endif; ?>
        <h1 data-i18n="pp.title.<?= (int) $product['id'] ?>"><?= e($product['title_en']) ?></h1>
        <?php if ($product['price_display']): ?>
          <p class="pp-price"><?= e($product['price_display']) ?></p>
        <?php endif; ?>

        <?php if ($stall): ?>
          <p class="muted" style="margin:0 0 14px">
            Sold by <a href="stall/show.php?slug=<?= e($stall['slug']) ?>" style="color:var(--gold-deep);font-weight:600"><?= e($stall['name']) ?></a>
            <?php if ($stall['verified']): ?><span class="vbadge" title="Verified Seller" style="display:inline-grid;vertical-align:middle">✓</span><?php endif; ?>
          </p>
        <?php endif; ?>

        <div class="pp-contact-card">
          <h3 data-i18n="pp.contactSeller">Contact seller directly</h3>
          <div class="pp-contact-actions">
            <?php
              $phone = setting('contact_phone', 'en', CONTACT_PHONE);
              $email = setting('contact_email', 'en', CONTACT_EMAIL);
              $whatsapp = preg_replace('/[^0-9]/', '', setting('contact_whatsapp', 'en', $phone));
              $waMessage = "Hi, I'm interested in \"" . $product['title_en'] . "\" on SaleBari.";
            ?>
            <a class="pp-contact-call" href="tel:<?= e($phone) ?>">☎ <?= e($phone) ?></a>
            <?php if ($whatsapp): ?>
              <a class="pp-contact-whatsapp" href="https://wa.me/<?= e($whatsapp) ?>?text=<?= urlencode($waMessage) ?>" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M12.04 2c-5.5 0-9.96 4.46-9.96 9.96 0 1.76.46 3.45 1.32 4.95L2 22l5.24-1.37a9.9 9.9 0 0 0 4.8 1.22h.01c5.5 0 9.96-4.46 9.96-9.96S17.54 2 12.04 2Zm0 18.2h-.01a8.24 8.24 0 0 1-4.2-1.15l-.3-.18-3.11.82.83-3.03-.2-.31a8.23 8.23 0 0 1-1.26-4.39c0-4.55 3.7-8.25 8.26-8.25 2.2 0 4.28.86 5.84 2.42a8.2 8.2 0 0 1 2.41 5.83c0 4.55-3.7 8.24-8.26 8.24Zm4.52-6.18c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.42-.14 0-.31-.01-.47-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.42 1.02 2.58c.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.19.2-.58.2-1.08.14-1.19-.06-.11-.23-.17-.48-.29Z"/></svg>
                WhatsApp
              </a>
            <?php endif; ?>
            <a class="pp-contact-email" href="mailto:<?= e($email) ?>">✉ Email</a>
          </div>
        </div>
      </div>
    </div>

    <?php if ($product['description_en']): ?>
      <div class="pp-overview">
        <h2 data-i18n="pp.overview">Overview</h2>
        <div data-i18n-html="pp.desc.<?= (int) $product['id'] ?>"><?= $product['description_en'] ?></div>
      </div>
    <?php endif; ?>

    <?php if ($similar): ?>
      <div class="pp-similar">
        <h2 data-i18n="pp.similar">Similar products</h2>
        <div class="product-grid">
          <?php foreach ($similar as $s): $simgs = json_decode((string) $s['images'], true) ?: []; ?>
            <a class="product-card" href="product.php?slug=<?= e($s['slug']) ?>" style="text-decoration:none;color:inherit;display:block">
              <div class="product-media grad-1">
                <?php if ($simgs): ?><img src="<?= e(asset($simgs[0])) ?>" alt=""><?php else: ?><span>🛒</span><?php endif; ?>
              </div>
              <div class="product-body">
                <p class="product-stall"><?= e($category['name_en'] ?? '') ?></p>
                <h3 class="product-title"><?= e($s['title_en']) ?></h3>
                <?php if ($s['price_display']): ?><div class="product-price"><span class="price-tag"><?= e($s['price_display']) ?></span></div><?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="wrap footer-inner">
    <div class="footer-col footer-brand">
      <a href="index.html" class="logo logo-footer">
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
      <a href="stall/list/" data-i18n="footer.allStalls">All stalls</a>
      <a href="market/list/" data-i18n="footer.shoppingMall">Shopping Mall</a>
      <a href="index.html#deals" data-i18n="deals.tag">Today's Deals</a>
      <a href="category.html?cat=realestate" data-i18n="cat.realestate">Real Estate</a>
      <a href="#" data-i18n="footer.giftCards">Gift cards</a>
      <a href="brand/list/" data-i18n="footer.brands">Brands</a>
      <a href="blog.php" data-i18n="footer.blog">Blog</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.forSellers">For Sellers</h4>
      <a href="#" data-i18n="footer.startSelling">Start selling</a>
      <a href="package.html" data-i18n="footer.package">Package</a>
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

<script src="js/nav-data.js"></script>
<script src="js/catalog-data.js"></script>
<script src="js/main.js"></script>
<?php if ($product): ?>
<script>
  Object.assign(window.I18N.dict, {
    'pp.title.<?= (int) $product['id'] ?>': { en: <?= json_encode($product['title_en']) ?>, bn: <?= json_encode($product['title_bn'] ?: $product['title_en']) ?> },
    'pp.desc.<?= (int) $product['id'] ?>': { en: <?= json_encode((string) $product['description_en']) ?>, bn: <?= json_encode($product['description_bn'] ?: (string) $product['description_en']) ?> },
    'pp.contactSeller': { en: 'Contact seller directly', bn: 'সরাসরি বিক্রেতার সাথে যোগাযোগ করুন' },
    'pp.overview': { en: 'Overview', bn: 'বিবরণ' },
    'pp.similar': { en: 'Similar products', bn: 'একই ধরনের পণ্য' }
  });
  window.I18N.applyLanguage(window.I18N.currentLang());

  var thumbs = document.querySelectorAll('.pp-thumb');
  var mainImg = document.getElementById('ppMainImg');
  thumbs.forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (mainImg) mainImg.src = btn.getAttribute('data-src');
      thumbs.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    });
  });
</script>
<?php endif; ?>
<?php if (!empty($whatsapp) || !empty($phone)): ?>
<div class="pp-mobile-bar">
  <?php if (!empty($phone)): ?><a class="pp-bar-call" href="tel:<?= e($phone) ?>">☎ Call</a><?php endif; ?>
  <?php if (!empty($whatsapp)): ?><a class="pp-bar-wa" href="https://wa.me/<?= e($whatsapp) ?>?text=<?= urlencode($waMessage) ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12.04 2c-5.5 0-9.96 4.46-9.96 9.96 0 1.76.46 3.45 1.32 4.95L2 22l5.24-1.37a9.9 9.9 0 0 0 4.8 1.22h.01c5.5 0 9.96-4.46 9.96-9.96S17.54 2 12.04 2Zm0 18.2h-.01a8.24 8.24 0 0 1-4.2-1.15l-.3-.18-3.11.82.83-3.03-.2-.31a8.23 8.23 0 0 1-1.26-4.39c0-4.55 3.7-8.25 8.26-8.25 2.2 0 4.28.86 5.84 2.42a8.2 8.2 0 0 1 2.41 5.83c0 4.55-3.7 8.24-8.26 8.24Zm4.52-6.18c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.42-.14 0-.31-.01-.47-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.42 1.02 2.58c.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.19.2-.58.2-1.08.14-1.19-.06-.11-.23-.17-.48-.29Z"/></svg> WhatsApp</a><?php endif; ?>
</div>
<?php endif; ?>
</body>
</html>
