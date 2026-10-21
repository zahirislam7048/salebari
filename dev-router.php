<?php
/* Local testing only:  php -S 127.0.0.1:8000 dev-router.php
   Mirrors the pretty-URL rewrite rules in .htaccess for PHP's built-in server. */
$path  = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rules = [
    ['#^/details/(?:[^/]*-)?([0-9]+)/?$#',   '/product.php',      'pid'],
    ['#^/stall/(?:[^/]*-)?([0-9]{4,})/?$#',  '/stall/show.php',   'sid'],
    ['#^/market/(?:[^/]*-)?([0-9]{4,})/?$#', '/market/show.php',  'mid'],
    ['#^/brand/(?:[^/]*-)?([0-9]{4,})/?$#',  '/brand/show.php',   'bid'],
];
foreach ($rules as [$re, $target, $param]) {
    if (preg_match($re, $path, $m)) {
        $_GET[$param] = $m[1];
        $_REQUEST[$param] = $m[1];
        $_SERVER['SCRIPT_NAME'] = $target;
        $_SERVER['SCRIPT_FILENAME'] = __DIR__ . $target;
        chdir(__DIR__ . dirname($target));
        require __DIR__ . $target;
        return true;
    }
}
return false;
