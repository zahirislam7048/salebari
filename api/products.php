<?php
/* Real products, fetched client-side by:
   - js/listing.js  — ?slug=<leaf category slug>, for that category's page
   - js/home.js     — ?recent=<N>, for the homepage's "Trending" section
*/
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

$slug   = (string) input('slug', '');
$recent = input_int('recent', 0);

if ($recent > 0) {
    $rows = rows(
        'SELECT p.id, p.title_en, p.title_bn, p.slug, p.price_display, p.images, c.name_en AS category_name
         FROM products p LEFT JOIN categories c ON c.id = p.category_id
         WHERE p.status = ? ORDER BY p.id DESC LIMIT ' . min($recent, 24),
        ['active']
    );
} else {
    $category = $slug ? row('SELECT id FROM categories WHERE slug = ?', [$slug]) : null;
    $rows = $category ? rows(
        'SELECT p.id, p.title_en, p.title_bn, p.slug, p.price_display, p.images, c.name_en AS category_name
         FROM products p LEFT JOIN categories c ON c.id = p.category_id
         WHERE p.category_id = ? AND p.status = ? ORDER BY p.id DESC',
        [$category['id'], 'active']
    ) : [];
}

$out = [];
foreach ($rows as $r) {
    $images = json_decode((string) $r['images'], true) ?: [];
    $out[] = [
        'id'       => (int) $r['id'],
        'title'    => $r['title_en'],
        'titleBn'  => $r['title_bn'],
        'slug'     => $r['slug'],
        'price'    => $r['price_display'],
        'image'    => $images ? asset($images[0]) : null,
        'category' => $r['category_name'],
    ];
}

echo json_encode($out);
