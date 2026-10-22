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
/* Menu + names for pages that are plain .html files: main.js swaps the menu in and merges the names. */
$top = [];
foreach (category_index() as $v) {
    if (!$v['row']['parent_id']) {
        $top[] = ['id' => (int) $v['row']['id'], 'key' => $v['row']['slug'], 'url' => base_path() . '/' . $v['path'] . '/',
                  'icon' => $v['row']['icon'], 'order' => (int) $v['row']['sort_order']];
    }
}
usort($top, function ($a, $b) { return $a['order'] <=> $b['order']; });
echo 'window.CATEGORY_NAV_HTML = ' . json_encode(category_nav_html(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';' . "
";
echo 'window.CATEGORY_I18N = ' . json_encode(category_i18n_dict(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';' . "
";
echo 'window.CATEGORY_TOP = ' . json_encode($top, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';' . "
";
echo 'window.CATEGORY_URLS = ' . json_encode($map, JSON_UNESCAPED_SLASHES) . ';' . "
";
echo 'window.CATEGORY_CHILD_URLS = ' . json_encode($byParent, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ';';
