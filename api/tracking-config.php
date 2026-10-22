<?php
/* window.SB_TRACK for js/tracking.js: tracking IDs from Site Settings, the signed-in seller (as hashes only),
   and any events queued by the server (sign-ups, leads) since the last page. */
require __DIR__ . '/../app/bootstrap.php';

header('Content-Type: application/javascript; charset=utf-8');
header('Cache-Control: no-store');

$user = ['logged_in' => false];
if ($s = seller()) {
    $user = [
        'logged_in' => true,
        'id_hash'   => hash('sha256', 'salebari-seller-' . $s['id']),
        'em'        => track_hash_email($s['email'] ?? null),
        'ph'        => track_hash_phone($s['phone'] ?? null),
    ];
}

$queue = $_SESSION['track_queue'] ?? [];
unset($_SESSION['track_queue']);

echo 'window.SB_TRACK = ' . json_encode([
    'ga4'     => setting('ga4_id', 'en', 'G-9PL47HJ4XL'),
    'gtm'     => setting('gtm_id', 'en', ''),
    'pixel'   => setting('meta_pixel_id', 'en', ''),
    'consent' => setting('tracking_consent', 'en', '1') !== '0',
    'user'    => $user,
    'queue'   => $queue,
], JSON_UNESCAPED_SLASHES) . ';';
