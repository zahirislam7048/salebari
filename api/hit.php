<?php
/* Counts a WhatsApp or Call tap on a product page (sent by the page with navigator.sendBeacon).
   POST p=<product id> t=wa|call. Answers 204 with no body; never reveals anything. */
require __DIR__ . '/../app/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || request_is_bot()) {
    http_response_code(204);
    exit;
}

$pid  = input_int('p', 0);
$type = (string) input('t', '');
if ($pid > 0 && in_array($type, ['wa', 'call'], true) && !is_logged_in()) {
    // at most one tap of each kind per product every 20 seconds from the same visitor (guards against scripted inflation)
    $key  = $pid . ':' . $type;
    $last = (int) ($_SESSION['hit_last'][$key] ?? 0);
    if (time() - $last >= 20 && scalar("SELECT COUNT(*) FROM products WHERE id = ? AND status = 'active'", [$pid])) {
        $_SESSION['hit_last'][$key] = time();
        record_product_event($pid, $type);
    }
}
http_response_code(204);
