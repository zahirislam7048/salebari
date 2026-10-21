<?php
/* Image upload for the rich-text editors (admin only). Returns {"url": "..."} or {"error": "..."}. */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

if (!installed() || !is_logged_in()) {
    http_response_code(403);
    exit(json_encode(['error' => 'Please log in again.']));
}
if (!is_post()) {
    http_response_code(405);
    exit(json_encode(['error' => 'POST only.']));
}

$sent   = (string) ($_POST['_token'] ?? '');
$stored = (string) ($_SESSION['csrf'] ?? '');
if ($sent === '' || $stored === '' || !hash_equals($stored, $sent)) {
    http_response_code(419);
    exit(json_encode(['error' => 'Session expired. Reload the page and try again.']));
}

try {
    $path = save_uploaded_image($_FILES['image'] ?? [], 'editor');
    if (!$path) {
        throw new RuntimeException('No image received (it may be larger than the server upload limit).');
    }
    echo json_encode(['url' => asset($path)]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
