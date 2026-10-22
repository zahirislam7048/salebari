<?php
/* window.CATEGORY_URLS = { categoryKey: '/car-bike/accessories/', ... } for the mega-menus on the static pages. */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/javascript; charset=utf-8');
header('Cache-Control: public, max-age=300');

$map = [];
foreach (category_index() as $v) {
    $map[$v['row']['slug']] = base_path() . '/' . $v['path'] . '/';
}
/* parent key -> { child name: url }, so the fly-out menus can link each item by its label */
$byParent = [];
foreach (category_index() as $v) {
    $r = $v['row'];
    if ($r['parent_id']) {
        $parent = category_index()[(int) $r['parent_id']]['row']['slug'] ?? null;
        if ($parent) {
            $byParent[$parent][$r['name_en']] = base_path() . '/' . $v['path'] . '/';
        }
    }
}
echo 'window.CATEGORY_URLS = ' . json_encode($map, JSON_UNESCAPED_SLASHES) . ';' . "
";
echo 'window.CATEGORY_CHILD_URLS = ' . json_encode($byParent, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';';
