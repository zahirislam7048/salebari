<?php
/* Product feed for Facebook / Instagram Shops (Meta Commerce Manager) and Google Merchant Center (free listings).
   Address:  https://salebari.com/product-feed.xml   — an RSS 2.0 file with Google's "g:" product fields.
   Only active products that have a price and a photo are included (both are required by Meta and Google).
   Paste the address into Commerce Manager -> Catalog -> Data sources -> Data feed -> "Scheduled feed",
   or Merchant Center -> Products -> Feeds -> "Scheduled fetch". Both re-read it daily. */
require __DIR__ . '/app/bootstrap.php';

if (!installed()) {
    http_response_code(503);
    exit;
}

header('Content-Type: application/xml; charset=utf-8');
header('X-Robots-Tag: noindex');
header('Cache-Control: public, max-age=900');

function feed_x(string $s): string
{
    return htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function feed_text(?string $html, int $max): string
{
    $t = trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags(preg_replace('#</(p|li|h[1-6]|div|tr)>#i', ' ', (string) $html)), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    return mb_strlen($t) > $max ? rtrim(mb_substr($t, 0, $max - 1)) . '…' : $t;
}

$idx = category_index();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"><channel>' . "\n";
echo '<title>SaleBari</title><link>' . feed_x(abs_url(base_path() . '/')) . '</link><description>Products listed on SaleBari, Bangladesh\'s digital bazaar</description>' . "\n";

$list = rows(
    "SELECT p.*, b.name AS brand_name, s.name AS stall_name
       FROM products p
       LEFT JOIN brands b ON b.id = p.brand_id
       LEFT JOIN stalls s ON s.id = p.stall_id
      WHERE p.status = 'active' AND p.price_num IS NOT NULL AND p.price_num > 0
      ORDER BY p.id DESC LIMIT 20000"
);
foreach ($list as $p) {
    $imgs = array_values(array_filter(json_decode((string) $p['images'], true) ?: []));
    if (!$imgs) {
        continue;
    }
    $stock = stock_info($p);
    $desc  = feed_text($p['description_en'], 4900) ?: $p['title_en'];
    $type  = '';
    if (isset($idx[(int) $p['category_id']])) {
        $parts = [];
        $walk  = (int) $p['category_id'];
        for ($i = 0; $walk && isset($idx[$walk]) && $i < 5; $i++) {
            array_unshift($parts, $idx[$walk]['row']['name_en']);
            $walk = (int) ($idx[$walk]['row']['parent_id'] ?? 0);
        }
        $type = implode(' > ', $parts);
    }
    $brand = trim((string) ($p['brand_name'] ?: $p['stall_name'])) ?: 'SaleBari';

    echo "<item>\n";
    echo '<g:id>' . (int) $p['id'] . "</g:id>\n";
    echo '<g:title>' . feed_x(mb_substr((string) $p['title_en'], 0, 150)) . "</g:title>\n";
    echo '<g:description>' . feed_x($desc) . "</g:description>\n";
    echo '<g:link>' . feed_x(abs_url(product_url($p))) . "</g:link>\n";
    echo '<g:image_link>' . feed_x(abs_url($imgs[0])) . "</g:image_link>\n";
    foreach (array_slice($imgs, 1, 5) as $extra) {
        echo '<g:additional_image_link>' . feed_x(abs_url($extra)) . "</g:additional_image_link>\n";
    }
    echo '<g:availability>' . ($stock['status'] === 'out' ? 'out of stock' : 'in stock') . "</g:availability>\n";
    echo '<g:condition>' . ($p['condition_type'] === 'used' ? 'used' : 'new') . "</g:condition>\n";
    echo '<g:price>' . number_format((float) $p['price_num'], 2, '.', '') . " BDT</g:price>\n";
    echo '<g:brand>' . feed_x($brand) . "</g:brand>\n";
    if ($type !== '') {
        echo '<g:product_type>' . feed_x($type) . "</g:product_type>\n";
    }
    echo "<g:identifier_exists>no</g:identifier_exists>\n";
    echo "</item>\n";
}
echo "</channel></rss>\n";
