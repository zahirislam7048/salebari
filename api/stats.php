<?php
/* Homepage hero stats — real counts from the dashboard, not hardcoded. */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'verifiedStalls' => (int) scalar("SELECT COUNT(*) FROM stalls WHERE status = 'active' AND review_status = 'approved' AND verified = 1"),
    'districts'      => (int) scalar("SELECT COUNT(DISTINCT city) FROM stalls WHERE status = 'active' AND review_status = 'approved' AND city IS NOT NULL AND city <> ''"),
    'products'       => (int) scalar("SELECT COUNT(*) FROM products WHERE status = 'active'"),
]);
