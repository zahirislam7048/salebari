<?php
/* Loaded first by every PHP entry point (admin pages, api/*.php, install.php). */

define('APP_ROOT', dirname(__DIR__));
define('SB_VERSION', '1.0.0');

require APP_ROOT . '/config.php';

if (SHOW_ERRORS) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}

mb_internal_encoding('UTF-8');
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Asia/Dhaka');
}

require APP_ROOT . '/app/db.php';
require APP_ROOT . '/app/i18n.php';
require APP_ROOT . '/app/helpers.php';
require APP_ROOT . '/app/auth.php';
require APP_ROOT . '/app/upload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'path'     => base_path() . '/',
    ]);
    session_name('salebari');
    session_start();
}

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

/* Before the database exists, admin pages redirect to the installer. */
function installed(): bool
{
    static $ok = null;
    if ($ok !== null) {
        return $ok;
    }
    return $ok = (db_ok() && table_exists('settings'));
}

/** setting('hero_sub', 'en') / setting('hero_sub', 'bn') */
function setting(string $key, string $lang = 'en', string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        if (installed()) {
            foreach (rows('SELECT k, v_en, v_bn FROM settings') as $r) {
                $cache[$r['k']] = $r;
            }
        }
    }
    if (!isset($cache[$key])) {
        return $default;
    }
    $v = field('v', $cache[$key], $lang);
    return $v === '' ? $default : $v;
}
