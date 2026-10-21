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

/* --- Seller-submitted content --------------------------------- */

/** Bangladesh mobile -> 01XXXXXXXXX, or null if it isn't one. */
function normalize_bd_phone(string $raw): ?string
{
    $d = preg_replace('/\D+/', '', $raw);
    if (strpos($d, '880') === 0) {
        $d = '0' . substr($d, 3);
    }
    return preg_match('/^01[3-9]\d{8}$/', $d) ? $d : null;
}

/**
 * Whitelist-clean HTML from the rich-text editor. Seller input is untrusted
 * (unlike the admin's), and it is printed raw on public pages, so only basic
 * formatting survives: no scripts, no inline styles/events, no images, and
 * links limited to http(s)/mailto/tel.
 */
function sanitize_html(?string $html): ?string
{
    $html = trim((string) $html);
    if ($html === '') {
        return null;
    }
    $allowed = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li', 'h2', 'h3', 'blockquote', 'a'];
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8"?><div id="sb-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    $root = $doc->getElementById('sb-root');
    if (!$root) {
        return null;
    }

    $clean = function (DOMNode $node) use (&$clean, $allowed): void {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMComment) {
                $node->removeChild($child);
                continue;
            }
            if (!($child instanceof DOMElement)) {
                continue;
            }
            $tag = strtolower($child->tagName);
            if (!in_array($tag, $allowed, true)) {
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math', 'form', 'textarea', 'select', 'img', 'video', 'audio'], true)) {
                    $node->removeChild($child);
                    continue;
                }
                // Unknown wrapper (div, span, font…): keep its text/children, drop the tag.
                $clean($child);
                while ($child->firstChild) {
                    $node->insertBefore($child->firstChild, $child);
                }
                $node->removeChild($child);
                continue;
            }
            $href = $tag === 'a' ? trim((string) $child->getAttribute('href')) : '';
            foreach (iterator_to_array($child->attributes) as $attr) {
                $child->removeAttributeNode($attr);
            }
            $clean($child);
            if ($tag === 'a') {
                if (preg_match('~^(https?://|mailto:|tel:)~i', $href)) {
                    $child->setAttribute('href', $href);
                    $child->setAttribute('rel', 'nofollow noopener');
                    $child->setAttribute('target', '_blank');
                } else {
                    // Unsafe or empty link: keep the text, drop the anchor.
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                }
            }
        }
    };

    $clean($root);

    $out = '';
    foreach ($root->childNodes as $child) {
        $out .= $doc->saveHTML($child);
    }
    $out = trim($out);
    return $out === '' ? null : $out;
}

/* --- Public URLs ----------------------------------------------- */
/* Pretty, BDStall-style addresses:
     /details/<product-slug>-<id>/        product ids are the real ids
     /stall/<name>-1001/   /market/<name>-1001/   /brand/<name>-1001/
   Stalls, malls and brands are numbered from 1001: the number in the URL is the
   database id + 1000, so existing records need no renumbering. */

const PUBLIC_ID_OFFSET = 1000;

function public_number(int $id): int
{
    return $id + PUBLIC_ID_OFFSET;
}

function public_to_id(int $number): int
{
    return $number - PUBLIC_ID_OFFSET;
}

function product_url(array $p): string
{
    return base_path() . '/details/' . $p['slug'] . '-' . (int) $p['id'] . '/';
}

function stall_url(array $s): string
{
    return base_path() . '/stall/' . $s['slug'] . '-' . public_number((int) $s['id']) . '/';
}

function mall_url(array $m): string
{
    return base_path() . '/market/' . $m['slug'] . '-' . public_number((int) $m['id']) . '/';
}

function brand_url(array $b): string
{
    return base_path() . '/brand/' . $b['slug'] . '-' . public_number((int) $b['id']) . '/';
}

/** If this page was reached by an old or non-canonical address, send the browser to the proper one. */
function redirect_to_canonical(string $canonical): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        return;
    }
    $want = rtrim((string) parse_url($canonical, PHP_URL_PATH), '/');
    $have = rtrim((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH), '/');
    if ($want !== '' && $want !== $have) {
        header('Location: ' . $canonical, true, 301);
        exit;
    }
}
