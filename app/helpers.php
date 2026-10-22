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
    $allowed = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'blockquote', 'a'];
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

/* --- Site contact numbers ---------------------------------------- */
/* Two numbers, and each one is both a phone number and a WhatsApp number.
   They live in Site Settings (contact_phone, contact_whatsapp). */

const DEFAULT_CONTACT_NUMBERS = ['+8801515286327', '+8801644842785'];

/** [['display' => '+880 1515-286327', 'tel' => '+8801515286327', 'wa' => '8801515286327'], ...] */
function site_numbers(): array
{
    $raw = [setting('contact_phone', 'en', DEFAULT_CONTACT_NUMBERS[0]), setting('contact_whatsapp', 'en', DEFAULT_CONTACT_NUMBERS[1])];
    $out = [];
    foreach ($raw as $r) {
        $bd = normalize_bd_phone((string) $r);
        if ($bd !== null) {
            $item = ['display' => '+880 ' . substr($bd, 1, 4) . '-' . substr($bd, 5), 'tel' => '+880' . substr($bd, 1), 'wa' => '880' . substr($bd, 1)];
        } else {
            $digits = preg_replace('/\D+/', '', (string) $r);
            if ($digits === '') {
                continue;
            }
            $item = ['display' => '+' . $digits, 'tel' => '+' . $digits, 'wa' => $digits];
        }
        $out[$item['wa']] = $item; // de-duplicate
    }
    return array_values($out ?: array_map(function ($n) {
        $d = preg_replace('/\D+/', '', $n);
        return ['display' => $n, 'tel' => $n, 'wa' => $d];
    }, DEFAULT_CONTACT_NUMBERS));
}

/** Once: bring existing brands/stalls/malls/products URLs in line with their current names. */
function ensure_name_slugs(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'slugs_v2'")) {
            return;
        }
        foreach ([['brands', 'name'], ['stalls', 'name'], ['malls', 'name'], ['products', 'title_en']] as [$table, $col]) {
            foreach (rows("SELECT id, slug, $col AS label FROM $table") as $r) {
                $new = slug_after_rename($table, (int) $r['id'], (string) $r['label'], (string) $r['slug']);
                if ($new !== $r['slug']) {
                    update($table, ['slug' => $new], 'id = ?', [$r['id']]);
                }
            }
        }
        insert('settings', ['k' => 'slugs_v2', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_name_slugs: ' . $e->getMessage());
    }
}

/** Once: make the live database hold the two real numbers instead of one repeated number. */
function ensure_contact_numbers(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'contacts_v2'")) {
            return;
        }
        $digits = function ($k) {
            return preg_replace('/\D+/', '', (string) scalar('SELECT v_en FROM settings WHERE k = ?', [$k]));
        };
        $phone = $digits('contact_phone');
        $wa    = $digits('contact_whatsapp');
        $set   = function ($k, $v) {
            if (scalar('SELECT COUNT(*) FROM settings WHERE k = ?', [$k])) {
                update('settings', ['v_en' => $v, 'v_bn' => $v], 'k = ?', [$k]);
            } else {
                insert('settings', ['k' => $k, 'v_en' => $v, 'v_bn' => $v]);
            }
        };
        // Only replace values that are empty or still the old single placeholder number.
        if ($phone === '' || $phone === '8801644842785') {
            $set('contact_phone', DEFAULT_CONTACT_NUMBERS[0]);
        }
        if ($wa === '' || $wa === '8801644842785' || $wa === $phone) {
            $set('contact_whatsapp', DEFAULT_CONTACT_NUMBERS[1]);
        }
        insert('settings', ['k' => 'contacts_v2', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_contact_numbers: ' . $e->getMessage());
    }
}

/**
 * Slug to use when a record is renamed, so its page URL always follows its current name.
 * Old URLs keep working (the id in the URL still finds the record and 301-redirects).
 * Bangla-only names can't be turned into a readable slug, so they keep the current one.
 */
function slug_after_rename(string $table, int $id, string $name, string $currentSlug): string
{
    $base = strtolower(trim((string) preg_replace('/[^A-Za-z0-9]+/u', '-', trim($name)), '-'));
    if ($base === '') {
        return $currentSlug;
    }
    $base = substr($base, 0, 80);
    if ($currentSlug === $base || preg_match('/^' . preg_quote($base, '/') . '-\d+$/', $currentSlug)) {
        return $currentSlug;
    }
    return unique_slug($table, $base, $id);
}

/* --- Category URLs ------------------------------------------------ */
/* Clean, hierarchical addresses:
     /car-bike/                                   main category
     /car-bike/accessories/                       sub category
     /car-bike/accessories/scratch-remover/       sub sub category
   Each level has its own URL name (categories.url_slug). It starts from the category
   name; a leading word that repeats the parent's first word is dropped ("Car
   Accessories" under "Car & Bike" becomes "accessories"). It can be edited in Admin. */

const RESERVED_TOP_PATHS = ['admin', 'account', 'sell', 'stall', 'market', 'brand', 'details', 'api', 'app', 'js', 'css', 'assets',
    'uploads', 'install', 'data', 'blog', 'package', 'sitemap', 'index', 'category', 'listing', 'product', 'catalog', 'partials'];

function url_safe(string $s): string
{
    return strtolower(trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', $s), '-'));
}

/** Suggested URL name for a category, given its name and its parent's name. */
function suggest_category_url_slug(string $name, ?string $parentName, int $level): string
{
    $s = url_safe($name);
    if ($s === '') {
        return '';
    }
    if ($parentName !== null && $parentName !== '') {
        $first = strtok(url_safe($parentName), '-');
        if ($first && strpos($s, $first . '-') === 0 && strlen($s) > strlen($first) + 1) {
            $s = substr($s, strlen($first) + 1);
        }
    }
    if ($level === 1 && in_array($s, RESERVED_TOP_PATHS, true)) {
        $s .= '-category';
    }
    return substr($s, 0, 90);
}

/** A URL name that no sibling category already uses. */
function unique_category_url_slug(string $base, ?int $parentId, ?int $ignoreId, string $fallback): string
{
    $base = $base !== '' ? $base : ($fallback !== '' ? $fallback : 'category');
    $slug = $base;
    $i    = 1;
    while (true) {
        $sql  = 'SELECT id FROM categories WHERE url_slug = ? AND ' . ($parentId ? 'parent_id = ?' : 'parent_id IS NULL');
        $args = $parentId ? [$slug, $parentId] : [$slug];
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

/** id => ['row' => category, 'path' => 'car-bike/accessories'] for every category (built once per request). */
function category_index(): array
{
    static $idx = null;
    if ($idx !== null) {
        return $idx;
    }
    $all = [];
    foreach (rows('SELECT * FROM categories') as $r) {
        $all[(int) $r['id']] = $r;
    }
    $idx = [];
    foreach ($all as $id => $r) {
        $parts = [];
        $walk  = $r;
        $guard = 0;
        while ($walk && $guard++ < 5) {
            array_unshift($parts, $walk['url_slug'] ?: url_safe((string) $walk['name_en']));
            $walk = $walk['parent_id'] ? ($all[(int) $walk['parent_id']] ?? null) : null;
        }
        $idx[$id] = ['row' => $r, 'path' => implode('/', $parts)];
    }
    return $idx;
}

function category_url(array $cat): string
{
    $idx = category_index();
    $id  = (int) $cat['id'];
    return base_path() . '/' . ($idx[$id]['path'] ?? url_safe((string) $cat['name_en'])) . '/';
}

/** Find the category at /a/b/c ($segments = ['a','b','c']), or null. */
function find_category_by_path(array $segments): ?array
{
    $parent = null;
    $cat    = null;
    foreach ($segments as $seg) {
        $cat = row(
            'SELECT * FROM categories WHERE url_slug = ? AND ' . ($parent ? 'parent_id = ?' : 'parent_id IS NULL'),
            $parent ? [$seg, $parent['id']] : [$seg]
        );
        if (!$cat) {
            return null;
        }
        $parent = $cat;
    }
    return $cat;
}

/** Once, and whenever categories without a URL name show up: fill them in, parents first. */
function ensure_category_url_slugs(): void
{
    try {
        if ((int) scalar("SELECT COUNT(*) FROM categories WHERE url_slug IS NULL OR url_slug = ''") === 0) {
            return;
        }
        $names = [];
        foreach (rows('SELECT id, name_en FROM categories') as $r) {
            $names[(int) $r['id']] = $r['name_en'];
        }
        for ($level = 1; $level <= 3; $level++) {
            foreach (rows("SELECT * FROM categories WHERE level = ? AND (url_slug IS NULL OR url_slug = '') ORDER BY sort_order, id", [$level]) as $r) {
                $parentName = $r['parent_id'] ? ($names[(int) $r['parent_id']] ?? null) : null;
                $slug = unique_category_url_slug(
                    suggest_category_url_slug((string) $r['name_en'], $parentName, $level),
                    $r['parent_id'] ? (int) $r['parent_id'] : null,
                    (int) $r['id'],
                    url_safe((string) $r['slug'])
                );
                update('categories', ['url_slug' => $slug], 'id = ?', [$r['id']]);
            }
        }
    } catch (Throwable $e) {
        error_log('SaleBari ensure_category_url_slugs: ' . $e->getMessage());
    }
}
