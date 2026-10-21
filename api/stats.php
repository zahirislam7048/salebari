<?php
/* Homepage hero stats — real counts from the dashboard, not hardcoded. */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

/** Active products anywhere under a top-level category (its sub-categories and their items). */
function products_under_category(string $slug): int
{
    $top = row('SELECT id FROM categories WHERE slug = ? AND level = 1', [$slug]);
    if (!$top) {
        return 0;
    }
    $ids      = [(int) $top['id']];
    $frontier = $ids;
    for ($depth = 0; $depth < 3 && $frontier; $depth++) {
        $in       = implode(',', array_fill(0, count($frontier), '?'));
        $frontier = array_map('intval', array_column(rows("SELECT id FROM categories WHERE parent_id IN ($in)", $frontier), 'id'));
        $ids      = array_merge($ids, $frontier);
    }
    $in = implode(',', array_fill(0, count($ids), '?'));
    return (int) scalar("SELECT COUNT(*) FROM products WHERE status = 'active' AND category_id IN ($in)", $ids);
}

echo json_encode([
    'verifiedStalls' => (int) scalar("SELECT COUNT(*) FROM stalls WHERE status = 'active' AND review_status = 'approved' AND verified = 1"),
    'districts'      => (int) scalar("SELECT COUNT(DISTINCT city) FROM stalls WHERE status = 'active' AND review_status = 'approved' AND city IS NOT NULL AND city <> ''"),
    'products'       => (int) scalar("SELECT COUNT(*) FROM products WHERE status = 'active'"),
    'categories'     => [
        'realestate' => products_under_category('realestate'),
        'carbike'    => products_under_category('carbike'),
        'agro'       => products_under_category('agro'),
    ],
]);
