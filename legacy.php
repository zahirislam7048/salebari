<?php
/* Old addresses from the previous WordPress/WooCommerce site that Google still has indexed.
   .htaccess sends them here:
     /product-category/<path>   -> the closest matching category on the new site (301)
     /product/<slug>            -> the same product if its slug exists, otherwise 410 Gone
     /shop /cart /checkout /my-account /category /tag ...  -> sensible new pages (301)
   A 301 to the right page keeps visitors and ranking; a 410 for products that no longer exist
   tells Google to drop them quickly instead of retrying a 404. */
require __DIR__ . '/app/bootstrap.php';

function legacy_redirect(string $to): void
{
    header('Location: ' . $to, true, 301);
    exit;
}

$type = (string) input('t', '');
$path = trim((string) input('p', ''), '/');
$segs = array_values(array_filter(explode('/', strtolower($path)), 'strlen'));

/* words the old shop used for the new main categories */
$alias = [
    'car' => 'car-bike', 'cars' => 'car-bike', 'bike' => 'car-bike', 'bikes' => 'car-bike', 'vehicle' => 'car-bike', 'vehicles' => 'car-bike',
    'property' => 'real-estate', 'properties' => 'real-estate', 'realestate' => 'real-estate', 'land' => 'real-estate',
    'farm' => 'agro', 'farming' => 'agro', 'agriculture' => 'agro',
    'travel' => 'travels', 'tour' => 'travels', 'tours' => 'travels', 'job' => 'jobs',
    'home' => 'household', 'home-and-living' => 'household', 'household-items' => 'household',
    'electronic' => 'electronics', 'gadgets' => 'electronics', 'computer' => 'electronics',
];

switch ($type) {
    case 'cat':
        // deepest segment that names a category wins; try the old word, then its alias
        for ($i = count($segs) - 1; $i >= 0; $i--) {
            foreach (array_unique([$segs[$i], $alias[$segs[$i]] ?? null]) as $slug) {
                if (!$slug) continue;
                $hit = row('SELECT * FROM categories WHERE url_slug = ? ORDER BY level DESC LIMIT 1', [$slug]);
                if ($hit) {
                    legacy_redirect(category_url($hit));
                }
            }
        }
        legacy_redirect(base_path() . '/');

    case 'product':
        $slug = $segs ? end($segs) : '';
        $hit  = $slug !== '' ? row("SELECT * FROM products WHERE slug = ? AND status = 'active'", [$slug]) : null;
        if ($hit) {
            legacy_redirect(product_url($hit));
        }
        break;   // gone

    case 'shop':
    case 'cart':
    case 'checkout':
    case 'wishlist':
    case 'compare':
        legacy_redirect(base_path() . '/');

    case 'my-account':
        legacy_redirect(base_path() . '/account/');

    case 'blog':
        legacy_redirect(base_path() . '/blog.php');
}

/* 410 Gone, with a friendly page */
http_response_code(410);
site_header('This page is no longer available', '<meta name="robots" content="noindex,follow">');
?>
<section class="section category-page">
  <div class="wrap">
    <h1 class="listing-page-title">This product is no longer available</h1>
    <p class="acct-muted">SaleBari has a new look and a new catalog, so this old page is gone. Find what you need below.</p>
    <p><a class="btn btn-primary" href="<?= base_path() ?>/index.html">Go to the homepage</a></p>
    <h2 class="catalog-subheading">Browse the bazaar</h2>
    <?= seo_category_chips_html(3) ?>
  </div>
</section>
<?php
site_footer();
