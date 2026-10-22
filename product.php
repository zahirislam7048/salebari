<?php
require __DIR__ . '/app/bootstrap.php';

$slug = (string) input('slug', '');
$pid  = input_int('pid', 0);
$product = $pid
    ? row('SELECT * FROM products WHERE id = ? AND status = ?', [$pid, 'active'])
    : ($slug ? row('SELECT * FROM products WHERE slug = ? AND status = ?', [$slug, 'active']) : null);

if (!$product) {
    http_response_code(404);
} else {
    $slug = $product['slug'];
    redirect_to_canonical(product_url($product));
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

/* Reviews: anyone can submit one; it goes live after the admin approves it. */
$reviewErr  = null;
$reviewOld  = ['rname' => '', 'rating' => 0, 'rcomment' => ''];
if ($product && is_post() && input('action') === 'review') {
    csrf_check();
    if ((string) input('company_url') !== '') {
        exit; // honeypot
    }
    $reviewOld = ['rname' => (string) input('rname'), 'rating' => input_int('rating', 0), 'rcomment' => (string) input('rcomment')];
    $times = array_filter($_SESSION['review_times'] ?? [], function ($t) { return time() - $t < 3600; });

    if (mb_strlen($reviewOld['rname']) < 2) {
        $reviewErr = 'Please enter your name.';
    } elseif ($reviewOld['rating'] < 1 || $reviewOld['rating'] > 5) {
        $reviewErr = 'Please choose a star rating.';
    } elseif (mb_strlen($reviewOld['rcomment']) < 5 || mb_strlen($reviewOld['rcomment']) > 1000) {
        $reviewErr = 'Please write a short review (5 to 1000 characters).';
    } elseif (count($times) >= 3) {
        $reviewErr = 'You have sent several reviews already. Please try again later.';
    } else {
        try {
            insert('product_reviews', [
                'product_id' => $product['id'],
                'name'       => mb_substr($reviewOld['rname'], 0, 80),
                'rating'     => $reviewOld['rating'],
                'comment'    => $reviewOld['rcomment'],
                'status'     => 'pending',
                'created_at' => now(),
            ]);
            $times[] = time();
            $_SESSION['review_times'] = array_values($times);
            track_queue('submit_review', ['item_id' => (string) $product['id'], 'item_name' => $product['title_en'], 'rating' => $reviewOld['rating']]);
            flash('success', 'Thank you! Your review will appear after our team approves it.');
            header('Location: ' . product_url($product) . '#pp-reviews');
            exit;
        } catch (Throwable $ex) {
            $reviewErr = 'Could not save your review right now. Please try again.';
        }
    }
}
$reviews = $product ? rows(
    "SELECT * FROM product_reviews WHERE product_id = ? AND status = 'approved' ORDER BY id DESC LIMIT 50",
    [$product['id']]
) : [];
$ratingCount = count($reviews);
$ratingAvg   = $ratingCount ? array_sum(array_column($reviews, 'rating')) / $ratingCount : 0;

/* Specifications: one "Name: Value" per line. */
$specs = [];
if ($product && trim((string) ($product['specs'] ?? '')) !== '') {
    foreach (preg_split('/\r?\n/', (string) $product['specs']) as $line) {
        $line = trim($line);
        if ($line === '') continue;
        $pos = strpos($line, ':');
        if ($pos === false) { $specs[] = [$line, '']; continue; }
        $specs[] = [trim(substr($line, 0, $pos)), trim(substr($line, $pos + 1))];
    }
}

/* Both site numbers work for calling and for WhatsApp. */
$nums      = site_numbers();
$whatsapp  = $nums[0]['wa'];
$waMessage = $product ? "Hi, I'm interested in \"" . $product['title_en'] . "\" on SaleBari." : '';
$waLink    = 'https://wa.me/' . $whatsapp . '?text=' . urlencode($waMessage);
$askMsg    = $product ? "Hi, I have a question about \"" . $product['title_en'] . "\" on SaleBari: " : '';
$askLink   = 'https://wa.me/' . $whatsapp . '?text=' . urlencode($askMsg);
$waIcon    = '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M12.04 2c-5.5 0-9.96 4.46-9.96 9.96 0 1.76.46 3.45 1.32 4.95L2 22l5.24-1.37a9.9 9.9 0 0 0 4.8 1.22h.01c5.5 0 9.96-4.46 9.96-9.96S17.54 2 12.04 2Zm0 18.2h-.01a8.24 8.24 0 0 1-4.2-1.15l-.3-.18-3.11.82.83-3.03-.2-.31a8.23 8.23 0 0 1-1.26-4.39c0-4.55 3.7-8.25 8.26-8.25 2.2 0 4.28.86 5.84 2.42a8.2 8.2 0 0 1 2.41 5.83c0 4.55-3.7 8.24-8.26 8.24Zm4.52-6.18c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.42-.14 0-.31-.01-.47-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08s.89 2.42 1.02 2.58c.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.19.2-.58.2-1.08.14-1.19-.06-.11-.23-.17-.48-.29Z"/></svg>';

$pageTitle = $product ? ($product['meta_title'] ?: $product['title_en']) . ' — SaleBari' : 'Product not found — SaleBari';
$pageDesc  = $product ? ($product['meta_description'] ?: mb_substr((string) $product['description_en'], 0, 160)) : '';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>">
<link rel="icon" type="image/svg+xml" href="<?= base_path() ?>/assets/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Noto+Sans+Bengali:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_path() ?>/css/style.css?v=12">
</head>
<body class="has-pp-bar">

<!-- ============ UTILITY BAR ============ -->
<div class="utility-bar">
  <div class="wrap utility-inner">
    <div class="utility-left">
      <span data-i18n="utility.location">📍 Serving all 64 districts</span>
      <span class="sep">•</span>
      <span data-i18n="utility.helpline">☎ +8801515286327</span><span class="util-num2">+8801644842785</span>
    </div>
    <div class="utility-right">
      <a href="<?= base_path() ?>/sell/" data-i18n="utility.sell">Sell on SaleBari</a>
      <span class="sep">•</span>
      <a href="<?= base_path() ?>/help/" data-i18n="utility.help">Help</a>
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
        <option data-i18n="cat.travels">Travels</option>
        <option data-i18n="cat.jobs">Jobs</option>
        <option data-i18n="cat.household">Household</option>
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
      <?= category_nav_html() ?>
      <a class="deals-tag" href="<?= base_path() ?>/index.html#deals" data-i18n="deals.tag">Today's Deals</a>
    </div>
  </nav>
</header>

<?php if (!$product): ?>
<section class="section category-page">
  <div class="wrap">
    <nav class="breadcrumb"><a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span><span class="breadcrumb-current">Not found</span></nav>
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
      <a href="<?= base_path() ?>/index.html" data-i18n="nav.home">Home</a><span class="breadcrumb-sep">›</span>
      <?php foreach ($trail as $i => $c): ?>
        <?php
          $crumbI18n = $c['level'] === 1 ? ('cat.' . $c['slug']) : ($c['level'] === 2 ? ('mega.' . $c['slug']) : null);
          $crumbI18nAttr = $crumbI18n ? ' data-i18n="' . e($crumbI18n) . '"' : '';
        ?>
        <?php if ($i < count($trail) - 1): ?>
          <a href="<?= e(category_url($c)) ?>"<?= $crumbI18nAttr ?>><?= e($c['name_en']) ?></a><span class="breadcrumb-sep">›</span>
        <?php else: ?>
          <a href="<?= e(category_url($c)) ?>"<?= $crumbI18nAttr ?>><?= e($c['name_en']) ?></a><span class="breadcrumb-sep">›</span>
        <?php endif; ?>
      <?php endforeach; ?>
      <span class="breadcrumb-current" data-i18n="pp.title.<?= (int) $product['id'] ?>"><?= e($product['title_en']) ?></span>
    </nav>

    <nav class="pp-tabs" id="ppTabs" aria-label="Product sections">
      <a href="#pp-seller" data-i18n="pp.tab.seller">Seller</a>
      <?php if ($specs): ?><a href="#pp-specs" data-i18n="pp.tab.specs">Specs</a><?php endif; ?>
      <?php if ($product['description_en']): ?><a href="#pp-overview" data-i18n="pp.tab.overview">Overview</a><?php endif; ?>
      <a href="#pp-reviews" data-i18n="pp.tab.reviews">Reviews</a>
      <?php if ($similar): ?><a href="#pp-related" data-i18n="pp.tab.related">Related</a><?php endif; ?>
    </nav>

    <div class="product-page-layout">
      <div class="pp-panel">
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
        <h1 data-i18n="pp.title.<?= (int) $product['id'] ?>"><?= e($product['title_en']) ?></h1>

        <div class="pp-meta">
          <span class="pp-meta-item">SKU <?= (int) $product['id'] ?></span>
          <?php if ($ratingCount): ?><a class="pp-meta-item pp-meta-rating" href="#pp-reviews">★ <?= number_format($ratingAvg, 1) ?> (<?= $ratingCount ?>)</a><?php endif; ?>
          <span class="pp-meta-item">Posted <?= e(date('j M Y', strtotime((string) $product['created_at']))) ?></span>
          <button type="button" class="pp-share" id="ppShare" data-title="<?= e($product['title_en']) ?>">↗ <span data-i18n="pp.share">Share</span></button>
        </div>

        <div class="pp-chips">
          <?php if ($category): ?><span class="pp-category-chip"><?= e($category['name_en']) ?></span><?php endif; ?>
          <?php if ($brand): ?><a class="pp-category-chip" href="<?= e(brand_url($brand)) ?>">🏷️ <?= e($brand['name']) ?></a><?php endif; ?>
        </div>

        <?php if ($product['price_display']): ?>
          <div class="pp-pricebox"><span class="pp-pricebox-label" data-i18n="pp.price">Price</span><span class="pp-pricebox-amount"><?= e($product['price_display']) ?></span></div>
          <p class="pp-blurb"><span data-i18n="pp.blurb1">The price of</span> <?= e($product['title_en']) ?> <span data-i18n="pp.blurb2">in Bangladesh is</span> <?= e($product['price_display']) ?>. <span data-i18n="pp.blurb3">Message the seller on WhatsApp to confirm the latest price and availability.</span></p>
        <?php endif; ?>

        <div class="pp-sellercard" id="pp-seller">
          <?php if ($stall): ?>
            <a class="pp-seller-head" href="<?= e(stall_url($stall)) ?>">
              <span class="pp-seller-logo">
                <?php if ($stall['logo_image']): ?><img src="<?= e(asset($stall['logo_image'])) ?>" alt=""><?php else: ?><?= e($stall['logo_emoji'] ?: '🏬') ?><?php endif; ?>
              </span>
              <span class="pp-seller-text">
                <strong><?= e($stall['name']) ?></strong>
                <small>
                  <?php if ($stall['verified']): ?><span class="pp-verified"><span data-i18n="pp.verified">Verified Seller</span></span><?php endif; ?>
                  <?php if ($stall['city']): ?>· 📍 <?= e($stall['city']) ?><?php endif; ?>
                </small>
              </span>
            </a>
          <?php else: ?>
            <div class="pp-seller-head">
              <span class="pp-seller-logo">🏬</span>
              <span class="pp-seller-text"><strong>SaleBari</strong><small data-i18n="pp.sellerGeneric">Listed on SaleBari</small></span>
            </div>
          <?php endif; ?>

          <div class="pp-contact-grid">
            <?php foreach ($nums as $n): ?>
              <a class="pp-whatsapp-btn" href="https://wa.me/<?= e($n['wa']) ?>?text=<?= urlencode($waMessage) ?>" target="_blank" rel="noopener">
                <?= $waIcon ?>
                <span class="pp-btn-text"><span data-i18n="pp.wa">WhatsApp</span><small><?= e($n['display']) ?></small></span>
              </a>
            <?php endforeach; ?>
            <?php foreach ($nums as $n): ?>
              <a class="pp-call-btn" href="tel:<?= e($n['tel']) ?>">
                <span class="pp-call-ico" aria-hidden="true">📞</span>
                <span class="pp-btn-text"><span data-i18n="pp.call">Call</span><small><?= e($n['display']) ?></small></span>
              </a>
            <?php endforeach; ?>
          </div>
          <p class="pp-seller-note" data-i18n="pp.waNote">Chat or call the seller directly — ask about price, stock, delivery or a visit.</p>
        </div>
      </div>
    </div>

    <?php if ($specs): ?>
      <section class="pp-section" id="pp-specs">
        <h2><span class="pp-sec-ico">📋</span> <?= e($category['name_en'] ?? '') ?> <span data-i18n="pp.specs">Full Specification</span></h2>
        <table class="pp-spec-table">
          <?php foreach ($specs as [$k, $v]): ?>
            <tr><th><?= e($k) ?></th><td><?= e($v) ?></td></tr>
          <?php endforeach; ?>
        </table>
      </section>
    <?php endif; ?>

    <?php if ($product['description_en']): ?>
      <section class="pp-section pp-overview" id="pp-overview">
        <h2><span class="pp-sec-ico">📖</span> <span data-i18n="pp.overview">Overview</span></h2>
        <div data-i18n-html="pp.desc.<?= (int) $product['id'] ?>"><?= $product['description_en'] ?></div>
      </section>
    <?php endif; ?>


    <section class="pp-section pp-reviews" id="pp-reviews">
      <?php foreach (take_flashes() as $f): ?><p class="acct-flash acct-flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></p><?php endforeach; ?>

      <?php if ($ratingCount): ?>
        <div class="pp-rev-summary">
          <div class="pp-rev-score"><strong><?= number_format($ratingAvg, 1) ?></strong><span class="pp-stars" aria-hidden="true"><?= str_repeat('★', (int) round($ratingAvg)) . str_repeat('☆', 5 - (int) round($ratingAvg)) ?></span><small><?= $ratingCount ?> <span data-i18n="pp.reviewsWord">reviews</span></small></div>
        </div>
        <div class="pp-rev-list">
          <?php foreach ($reviews as $rv): ?>
            <div class="pp-rev">
              <div class="pp-rev-head"><strong><?= e($rv['name']) ?></strong><span class="pp-stars" aria-hidden="true"><?= str_repeat('★', (int) $rv['rating']) . str_repeat('☆', 5 - (int) $rv['rating']) ?></span><small><?= e(date('j M Y', strtotime((string) $rv['created_at']))) ?></small></div>
              <p><?= nl2br(e($rv['comment'])) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="pp-rev-empty">
          <div class="pp-rev-star">☆</div>
          <h2 data-i18n="pp.firstReview">Be the first to review</h2>
          <p data-i18n="pp.reviewInvite">Share your experience with this product and help other buyers in Bangladesh make a better decision.</p>
          <div class="pp-rev-chips">
            <span data-i18n="pp.chip1">✓ Takes under 2 minutes</span>
            <span data-i18n="pp.chip2">✓ Help other buyers</span>
            <span data-i18n="pp.chip3">✓ Ask the seller anything</span>
          </div>
        </div>
      <?php endif; ?>

      <div class="pp-rev-actions">
        <button type="button" class="btn btn-primary" id="ppWriteReview" data-i18n="pp.writeReview">★ Write a Review</button>
        <?php if ($askLink): ?><a class="btn btn-ghost" href="<?= e($askLink) ?>" target="_blank" rel="noopener" data-i18n="pp.askQuestion">Ask a Question</a><?php endif; ?>
      </div>

      <form method="post" class="pp-rev-form acct-form" id="ppReviewForm" <?= $reviewErr ? '' : 'hidden' ?> action="<?= e(product_url($product)) ?>#pp-reviews">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="review">
        <div class="acct-hp" aria-hidden="true"><label>Company URL <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>
        <?php if ($reviewErr): ?><p class="acct-error"><?= e($reviewErr) ?></p><?php endif; ?>
        <p class="pp-rate-label" data-i18n="pp.howRate">How would you rate it?</p>
        <div class="pp-rate-input" role="radiogroup" aria-label="Rating">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" name="rating" id="rate<?= $i ?>" value="<?= $i ?>" <?= (int) $reviewOld['rating'] === $i ? 'checked' : '' ?>><label for="rate<?= $i ?>" title="<?= $i ?> star<?= $i > 1 ? 's' : '' ?>">★</label>
          <?php endfor; ?>
        </div>
        <label class="acct-field"><span data-i18n="pp.yourName">Your name</span>
          <input type="text" name="rname" maxlength="80" required value="<?= e($reviewOld['rname']) ?>"></label>
        <label class="acct-field"><span data-i18n="pp.yourReview">Your review</span>
          <textarea name="rcomment" rows="4" maxlength="1000" required><?= e($reviewOld['rcomment']) ?></textarea></label>
        <button class="btn btn-primary" type="submit" data-i18n="pp.submitReview">Submit review</button>
      </form>
    </section>

    <?php if ($similar): ?>
      <section class="pp-section pp-similar" id="pp-related">
        <h2><span class="pp-sec-ico">🔗</span> <span data-i18n="pp.similar">Similar</span> <?= e($category['name_en'] ?? '') ?></h2>
        <div class="product-grid">
          <?php foreach ($similar as $s): $simgs = json_decode((string) $s['images'], true) ?: []; ?>
            <a class="product-card" href="<?= e(product_url($s)) ?>" style="text-decoration:none;color:inherit;display:block">
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
      </section>
    <?php endif; ?>

    <section class="pp-section pp-recent" id="pp-recent" hidden>
      <h2><span class="pp-sec-ico">🕘</span> <span data-i18n="pp.recent">Recently viewed</span></h2>
      <div class="product-grid" id="ppRecentGrid"></div>
    </section>
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
        <a href="https://www.facebook.com/thesalebari" target="_blank" rel="noopener" aria-label="SaleBari on Facebook" title="Facebook">f</a>
        <a href="https://www.linkedin.com/company/sale-bari/" target="_blank" rel="noopener" aria-label="SaleBari on LinkedIn" title="LinkedIn"><b>in</b></a>
      </div>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.shop">Shop</h4>
      <a href="<?= base_path() ?>/stall/list/" data-i18n="footer.allStalls">All stalls</a>
      <a href="<?= base_path() ?>/market/list/" data-i18n="footer.shoppingMall">Shopping Mall</a>
      <a href="<?= base_path() ?>/index.html#deals" data-i18n="deals.tag">Today's Deals</a>
      <a href="<?= base_path() ?>/real-estate/" data-i18n="cat.realestate">Real Estate</a>
      <a href="#" data-i18n="footer.giftCards">Gift cards</a>
      <a href="<?= base_path() ?>/brand/list/" data-i18n="footer.brands">Brands</a>
      <a href="<?= base_path() ?>/blog.php" data-i18n="footer.blog">Blog</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.forSellers">For Sellers</h4>
      <a href="<?= base_path() ?>/sell/" data-i18n="footer.startSelling">Start selling</a>
      <a href="<?= base_path() ?>/package.html" data-i18n="footer.package">Package</a>
      <a href="/help/#how-it-works" data-i18n="footer.howItWorks">How it works</a>
      <a href="/package.html" data-i18n="footer.sellerFees">Seller fees</a>
      <a href="/success-stories/" data-i18n="footer.successStories">Success stories</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="utility.help">Help</h4>
      <a href="/help/#contact" data-i18n="footer.contactUs">Contact us</a>
      <a href="/help/#faq" data-i18n="footer.faq">FAQ</a>
      <a href="/return-and-refund-policy/" data-i18n="footer.returnPolicy">Return &amp; refund policy</a>
      <a href="/track-order/" data-i18n="footer.trackOrder">Track an order</a>
    </div>
    <div class="footer-col">
      <h4 data-i18n="footer.getInTouch">Get in touch</h4>
      <p class="footer-phone">☎ <a href="tel:+8801515286327">+880 1515-286327</a> <a class="ft-wa" href="https://wa.me/8801515286327" target="_blank" rel="noopener">WhatsApp</a></p>
      <p class="footer-phone">☎ <a href="tel:+8801644842785">+880 1644-842785</a> <a class="ft-wa" href="https://wa.me/8801644842785" target="_blank" rel="noopener">WhatsApp</a></p>
      <p>salebarirealestate@gmail.com</p>
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
      <a href="/privacy.php" data-i18n="footer.privacy">Privacy Policy</a>
      <a href="#" data-i18n="footer.terms">Terms of Service</a>
      <a href="/sitemap_index.xml" data-i18n="footer.sitemap">Sitemap</a>
    </div>
  </div>
</footer>

<button class="scroll-top" aria-label="Scroll to top">↑</button>

<script src="<?= base_path() ?>/api/category-urls.php"></script>
<script src="<?= base_path() ?>/js/nav-data.js?v=4"></script>
<script src="<?= base_path() ?>/js/catalog-data.js?v=4"></script>
<script src="<?= base_path() ?>/js/main.js?v=5"></script>
<?php if ($product): ?>
<script>
  Object.assign(window.I18N.dict, {
    'pp.title.<?= (int) $product['id'] ?>': { en: <?= json_encode($product['title_en']) ?>, bn: <?= json_encode($product['title_bn'] ?: $product['title_en']) ?> },
    'pp.desc.<?= (int) $product['id'] ?>': { en: <?= json_encode((string) $product['description_en']) ?>, bn: <?= json_encode($product['description_bn'] ?: (string) $product['description_en']) ?> },
    'pp.overview': { en: 'Overview', bn: 'বিবরণ' },
    'pp.similar': { en: 'Similar', bn: 'একই ধরনের' },
    'pp.specs': { en: 'Full Specification', bn: 'পূর্ণ স্পেসিফিকেশন' },
    'pp.tab.reviews': { en: 'Reviews', bn: 'রিভিউ' },
    'pp.reviewsWord': { en: 'reviews', bn: 'টি রিভিউ' },
    'pp.firstReview': { en: 'Be the first to review', bn: 'প্রথম রিভিউটি আপনিই দিন' },
    'pp.reviewInvite': { en: 'Share your experience with this product and help other buyers in Bangladesh make a better decision.', bn: 'পণ্যটি নিয়ে আপনার অভিজ্ঞতা জানান এবং বাংলাদেশের অন্য ক্রেতাদের সঠিক সিদ্ধান্ত নিতে সাহায্য করুন।' },
    'pp.chip1': { en: '✓ Takes under 2 minutes', bn: '✓ ২ মিনিটেরও কম সময় লাগে' },
    'pp.chip2': { en: '✓ Help other buyers', bn: '✓ অন্য ক্রেতাদের সাহায্য করুন' },
    'pp.chip3': { en: '✓ Ask the seller anything', bn: '✓ বিক্রেতাকে যেকোনো প্রশ্ন করুন' },
    'pp.writeReview': { en: '★ Write a Review', bn: '★ রিভিউ লিখুন' },
    'pp.askQuestion': { en: 'Ask a Question', bn: 'প্রশ্ন করুন' },
    'pp.howRate': { en: 'How would you rate it?', bn: 'আপনি কত রেটিং দেবেন?' },
    'pp.yourName': { en: 'Your name', bn: 'আপনার নাম' },
    'pp.yourReview': { en: 'Your review', bn: 'আপনার রিভিউ' },
    'pp.submitReview': { en: 'Submit review', bn: 'রিভিউ জমা দিন' },
    'pp.recent': { en: 'Recently viewed', bn: 'সম্প্রতি দেখা' },
    'pp.tab.seller': { en: 'Seller', bn: 'বিক্রেতা' },
    'pp.tab.specs': { en: 'Specs', bn: 'স্পেসিফিকেশন' },
    'pp.tab.overview': { en: 'Overview', bn: 'বিবরণ' },
    'pp.tab.related': { en: 'Related', bn: 'সম্পর্কিত' },
    'pp.share': { en: 'Share', bn: 'শেয়ার' },
    'pp.price': { en: 'Price', bn: 'দাম' },
    'pp.blurb1': { en: 'The price of', bn: '' },
    'pp.blurb2': { en: 'in Bangladesh is', bn: 'এর বাংলাদেশে দাম' },
    'pp.blurb3': { en: 'Message the seller on WhatsApp to confirm the latest price and availability.', bn: 'সর্বশেষ দাম ও স্টক নিশ্চিত করতে হোয়াটসঅ্যাপে বিক্রেতাকে মেসেজ করুন।' },
    'pp.verified': { en: 'Verified Seller', bn: 'ভেরিফায়েড বিক্রেতা' },
    'pp.sellerGeneric': { en: 'Listed on SaleBari', bn: 'SaleBari-তে তালিকাভুক্ত' },
    'pp.whatsapp': { en: 'WhatsApp', bn: 'হোয়াটসঅ্যাপ' },
    'pp.wa': { en: 'WhatsApp', bn: 'হোয়াটসঅ্যাপ' },
    'pp.call': { en: 'Call', bn: 'কল করুন' },
    'pp.waNote': { en: 'Chat or call the seller directly — ask about price, stock, delivery or a visit.', bn: 'সরাসরি বিক্রেতাকে কল বা মেসেজ করুন — দাম, স্টক, ডেলিভারি বা শোরুম ভিজিট সম্পর্কে জিজ্ঞেস করুন।' }
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

  /* Section tabs stick just under the site header. */
  var tabs = document.getElementById('ppTabs');
  var header = document.querySelector('.site-header');
  function placeTabs() { if (tabs && header) { var h = header.offsetHeight; tabs.style.top = h + 'px'; document.documentElement.style.setProperty('--pp-sticky', (h + 60) + 'px'); } }
  placeTabs();
  window.addEventListener('resize', placeTabs);

  /* Review form toggle; clicking a star opens it with that rating. */
  var revForm = document.getElementById('ppReviewForm');
  var revBtn = document.getElementById('ppWriteReview');
  if (revBtn && revForm) {
    revBtn.addEventListener('click', function () { revForm.hidden = !revForm.hidden; if (!revForm.hidden) revForm.scrollIntoView({ behavior: 'smooth', block: 'center' }); });
  }

  /* Recently viewed: remembered in this browser only. */
  (function () {
    var KEY = 'sb_recent', here = <?= json_encode(['slug' => $product['slug'], 'id' => (int) $product['id'], 'url' => product_url($product), 'title' => $product['title_en'], 'price' => (string) $product['price_display'], 'img' => $images ? asset($images[0]) : '']) ?>;
    var list = [];
    try { list = JSON.parse(localStorage.getItem(KEY) || '[]'); } catch (e) { list = []; }
    var others = list.filter(function (p) { return p && p.slug !== here.slug; }).slice(0, 5);
    var next = [here].concat(others).slice(0, 8);
    try { localStorage.setItem(KEY, JSON.stringify(next)); } catch (e) {}
    if (!others.length) return;
    var grid = document.getElementById('ppRecentGrid');
    others.forEach(function (p) {
      var a = document.createElement('a');
      a.className = 'product-card'; a.href = p.url || ('details/' + encodeURIComponent(p.slug) + '-' + p.id + '/');
      a.style.cssText = 'text-decoration:none;color:inherit;display:block';
      var media = document.createElement('div'); media.className = 'product-media grad-1';
      if (p.img) { var im = document.createElement('img'); im.src = p.img; im.alt = ''; media.appendChild(im); } else { media.textContent = '🛒'; }
      var body = document.createElement('div'); body.className = 'product-body';
      var h = document.createElement('h3'); h.className = 'product-title'; h.textContent = p.title;
      body.appendChild(h);
      if (p.price) { var pr = document.createElement('div'); pr.className = 'product-price'; var tag = document.createElement('span'); tag.className = 'price-tag'; tag.textContent = p.price; pr.appendChild(tag); body.appendChild(pr); }
      a.appendChild(media); a.appendChild(body); grid.appendChild(a);
    });
    document.getElementById('pp-recent').hidden = false;
  })();

  var share = document.getElementById('ppShare');
  if (share) {
    share.addEventListener('click', function () {
      var data = { title: share.getAttribute('data-title'), url: location.href };
      if (navigator.share) { navigator.share(data).catch(function () {}); return; }
      if (navigator.clipboard) {
        navigator.clipboard.writeText(location.href).then(function () {
          var label = share.querySelector('span'); var old = label.textContent;
          label.textContent = 'Link copied'; setTimeout(function () { label.textContent = old; }, 1800);
        });
      }
    });
  }
</script>
<?php endif; ?>
<?php if ($product): ?>
<?= track_page_script([
    'type'    => 'product',
    'product' => [
        'id'       => (int) $product['id'],
        'name'     => $product['title_en'],
        'category' => implode(' / ', array_column($trail, 'name_en')),
        'brand'    => $brand['name'] ?? '',
        'seller'   => $stall['name'] ?? '',
        'price'    => track_price($product['price_display']),
    ],
]) ?>
<?php endif; ?>
<script src="<?= base_path() ?>/api/tracking-config.php"></script>
<script src="<?= base_path() ?>/js/tracking.js?v=1"></script>
<?php if ($product): ?>
<div class="pp-mobile-bar">
  <a class="pp-bar-call" href="tel:<?= e($nums[0]['tel']) ?>">📞 <span data-i18n="pp.call">Call</span></a>
  <a class="pp-bar-wa" href="<?= e($waLink) ?>" target="_blank" rel="noopener"><?= $waIcon ?> <span data-i18n="pp.wa">WhatsApp</span></a>
</div>
<?php endif; ?>
</body>
</html>
