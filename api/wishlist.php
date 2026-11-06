<?php
/* Cards for the saved-items page. The list of saved ids lives in the visitor's browser (localStorage);
   this just turns up to 60 ids into product details.   GET ?ids=1,2,3 */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$ids = array_values(array_unique(array_filter(array_map('intval', explode(',', (string) input('ids', ''))))));
$ids = array_slice($ids, 0, 60);
$out = [];
if ($ids) {
    $in = implode(',', array_fill(0, count($ids), '?'));
    $byId = [];
    foreach (rows("SELECT id, title_en, slug, price_display, stock_status, stock_qty, images FROM products WHERE status = 'active' AND id IN ($in)", $ids) as $r) {
        $byId[(int) $r['id']] = $r;
    }
    foreach ($ids as $id) {          // keep the visitor's order
        if (!isset($byId[$id])) {
            continue;
        }
        $r      = $byId[$id];
        $images = json_decode((string) $r['images'], true) ?: [];
        $out[]  = [
            'id'    => $id,
            'title' => $r['title_en'],
            'url'   => product_url($r),
            'price' => $r['price_display'],
            'stock' => stock_info($r)['status'],
            'image' => $images ? asset($images[0]) : null,
        ];
    }
}
echo json_encode($out, JSON_UNESCAPED_UNICODE);
