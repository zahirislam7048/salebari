<?php
/* Shown by Apache (ErrorDocument 404) for any address that does not exist. */
require __DIR__ . '/app/bootstrap.php';

http_response_code(404);
site_header('Page not found', '<meta name="robots" content="noindex,follow">', false);
?>
<section class="section category-page">
  <div class="wrap not-found">
    <p class="not-found-code" aria-hidden="true">404</p>
    <h1 class="listing-page-title">We could not find that page</h1>
    <p class="acct-muted">The link may be old, or the listing may have been removed. Try a search, or pick a category below.</p>
    <form class="not-found-search" action="<?= base_path() ?>/index.html" method="get" role="search">
      <input type="search" name="q" placeholder="Search for a product, brand or stall…" aria-label="Search">
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <p><a class="btn btn-ghost" href="<?= base_path() ?>/index.html">Go to the homepage</a></p>
    <h2 class="catalog-subheading">Browse the bazaar</h2>
    <?= seo_category_chips_html(3) ?>
  </div>
</section>
<?php
site_footer();
