<?php
/* Small helpers shared by every page. */

function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Site root path, e.g. '' or '/salebari'. There is no single front
 * controller here (admin/*.php, api/*.php and install.php are all their
 * own entry points), so this can't be auto-detected from the currently
 * executing script's own directory — that would give '/admin' on an
 * admin page instead of the site root. Set BASE_URL in config.php if the
 * site lives in a sub-folder; otherwise it assumes the domain root.
 */
function base_path(): string
{
    return (defined('BASE_URL') && BASE_URL !== '') ? rtrim(BASE_URL, '/') : '';
}

/** Build a site URL: url('admin/stalls.php') -> /admin/stalls.php */
function url(string $path = '', array $params = []): string
{
    $u = rtrim(base_path() . '/' . ltrim($path, '/'), '/');
    if ($u === '') {
        $u = base_path() . '/';
    }
    if ($params) {
        $u .= '?' . http_build_query($params);
    }
    return $u;
}

function asset(string $path): string
{
    return base_path() . '/' . ltrim($path, '/');
}

function redirect(string $path, array $params = []): void
{
    header('Location: ' . (preg_match('~^https?://~i', $path) ? $path : url($path, $params)));
    exit;
}

/* --- Input --------------------------------------------------- */

function input(string $key, $default = null)
{
    $v = $_POST[$key] ?? $_GET[$key] ?? $default;
    return is_string($v) ? trim($v) : $v;
}

function input_int(string $key, int $default = 0): int
{
    $v = input($key);
    return is_numeric($v) ? (int) $v : $default;
}

function input_float(string $key, ?float $default = null): ?float
{
    $v = input($key);
    if ($v === null || $v === '') {
        return $default;
    }
    $v = str_replace([',', ' '], '', (string) $v);
    return is_numeric($v) ? (float) $v : $default;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/* --- Formatting ---------------------------------------------- */

function slugify(string $s): string
{
    /* Bengali titles have no reliable transliteration, so a title with no
       Latin characters gets a short hashed slug instead of an empty one. */
    $ascii = preg_replace('/[^A-Za-z0-9]+/u', '-', trim($s));
    $ascii = strtolower(trim((string) $ascii, '-'));
    return $ascii !== '' ? substr($ascii, 0, 80) : 'item-' . substr(md5($s . microtime()), 0, 8);
}

/** Make a slug unique within a table. */
function unique_slug(string $table, string $slug, ?int $ignoreId = null): string
{
    $base = $slug !== '' ? $slug : 'item';
    $i    = 1;
    while (true) {
        $sql  = "SELECT id FROM $table WHERE slug = ?";
        $args = [$slug];
        if ($ignoreId) {
            $sql   .= ' AND id <> ?';
            $args[] = $ignoreId;
        }
        if (!row($sql, $args)) {
            return $slug;
        }
        $slug = $base . '-' . (++$i);
    }
}

/**
 * Returns a safe http(s) URL or null. A bare "example.com" gets https://
 * prepended; anything with another scheme (javascript:, data: …) is dropped,
 * since these values end up in href/src attributes on public pages.
 */
function clean_url(?string $u): ?string
{
    $u = trim((string) $u);
    if ($u === '') {
        return null;
    }
    if (!preg_match('~^[a-z][a-z0-9+.-]*:~i', $u)) {
        $u = 'https://' . ltrim($u, '/');
    }
    if (!preg_match('~^https?://~i', $u) || !filter_var($u, FILTER_VALIDATE_URL)) {
        return null;
    }
    return $u;
}

/** Pull the src out of a pasted Google Maps <iframe> snippet, or pass a URL through. */
function clean_map_url(?string $raw): ?string
{
    $raw = trim((string) $raw);
    if ($raw !== '' && preg_match('~<iframe[^>]+src=["\']([^"\']+)["\']~i', $raw, $m)) {
        $raw = html_entity_decode($m[1]);
    }
    return clean_url($raw);
}

/* --- Flash messages ------------------------------------------ */

function flash(string $type, string $msg): void
{
    $_SESSION['flash'][] = ['type' => $type, 'msg' => $msg];
}

function take_flashes(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/** Page-window data for a result set. */
function paginate(int $total, int $perPage, int $page): array
{
    $pages = max(1, (int) ceil($total / max(1, $perPage)));
    $page  = min(max(1, $page), $pages);
    return [
        'total'  => $total,
        'pages'  => $pages,
        'page'   => $page,
        'offset' => ($page - 1) * $perPage,
        'per'    => $perPage,
    ];
}
