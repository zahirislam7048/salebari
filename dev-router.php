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

/* Sitemaps */
if (preg_match('#^/sitemap(?:_index|-([a-z]+))?\.xml$#', $path, $sm)) {
    $_GET['type'] = $sm[1] ?? 'index';
    $_SERVER['SCRIPT_NAME'] = '/sitemap.php';
    chdir(__DIR__);
    require __DIR__ . '/sitemap.php';
    return true;
}

/* Old category/listing links and clean category paths (mirrors the .htaccess rules). */
$q = $_GET;
if ($path === '/category.html' && (isset($q['cat']) || isset($q['sub']))) {
    $_GET['legacy'] = $q['cat'] ?? $q['sub'];
    $_SERVER['SCRIPT_NAME'] = '/catalog.php';
    chdir(__DIR__);
    require __DIR__ . '/catalog.php';
    return true;
}
if ($path === '/listing.html' && isset($q['item'])) {
    $_GET['legacy'] = $q['item'];
    $_SERVER['SCRIPT_NAME'] = '/catalog.php';
    chdir(__DIR__);
    require __DIR__ . '/catalog.php';
    return true;
}
if (!file_exists(__DIR__ . $path) && preg_match('#^/([a-z0-9-]+)(?:/([a-z0-9-]+))?(?:/([a-z0-9-]+))?/?$#', $path, $m)) {
    foreach ([1 => 'c1', 2 => 'c2', 3 => 'c3'] as $i => $k) {
        if (!empty($m[$i])) {
            $_GET[$k] = $m[$i];
        }
    }
    $_SERVER['SCRIPT_NAME'] = '/catalog.php';
    chdir(__DIR__);
    require __DIR__ . '/catalog.php';
    return true;
}
return false;
