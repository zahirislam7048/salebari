<?php
/* Sessions and CSRF for the single-admin dashboard. No seller/buyer roles —
   the site owner manages everything directly (see plan's scope cuts). */

function auth_user(): ?array
{
    static $user = false;
    if ($user !== false) {
        return $user;
    }
    $id = $_SESSION['uid'] ?? null;
    if (!$id) {
        return $user = null;
    }
    $u = row('SELECT * FROM users WHERE id = ? AND status = ?', [$id, 'active']);
    if (!$u) {
        unset($_SESSION['uid']);
        return $user = null;
    }
    return $user = $u;
}

function is_logged_in(): bool
{
    return auth_user() !== null;
}

function login_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['uid'] = (int) $user['id'];
    update('users', ['last_login_at' => now()], 'id = ?', [$user['id']]);
}

function logout_user(): void
{
    $_SESSION = [];
    session_destroy();
}

function require_admin(): void
{
    if (!is_logged_in()) {
        redirect('admin/login.php');
    }
}

/* --- CSRF ---------------------------------------------------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    /* A request whose body exceeded post_max_size (most often an image
       upload) arrives with $_POST and $_FILES both silently emptied by
       PHP itself, even though real data was sent — Content-Length still
       shows it. Left uncaught this misreports as "session expired", which
       sends an admin trying to upload a normal-sized photo in circles. */
    if (empty($_POST) && empty($_FILES) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        http_response_code(413);
        $limit = ini_get('post_max_size') ?: 'the server limit';
        exit(
            'The file(s) you tried to upload are too large for this server '
            . '(post_max_size = ' . e($limit) . '). Try smaller images, or ask your '
            . 'hosting provider to raise post_max_size and upload_max_filesize in PHP, then try again.'
        );
    }

    $sent   = (string) ($_POST['_token'] ?? '');
    $stored = (string) ($_SESSION['csrf'] ?? '');

    /* Both empty would compare equal, so a session with no token must fail. */
    if ($sent === '' || $stored === '' || !hash_equals($stored, $sent)) {
        http_response_code(419);
        exit('Session expired. Please go back, reload the page and try again.');
    }
}

/* --- Misc ---------------------------------------------------- */

function now(): string
{
    return date('Y-m-d H:i:s');
}

function valid_email(string $s): bool
{
    return (bool) filter_var($s, FILTER_VALIDATE_EMAIL);
}

/* --- Seller accounts (public sign-up) ------------------------- */
/* Separate from the admin login: a seller session can never reach admin/*. */

function seller(): ?array
{
    static $s = false;
    if ($s !== false) {
        return $s;
    }
    $id = $_SESSION['seller_id'] ?? null;
    if (!$id) {
        return $s = null;
    }
    $r = row('SELECT * FROM sellers WHERE id = ? AND status = ?', [$id, 'active']);
    if (!$r) {
        unset($_SESSION['seller_id']);
        return $s = null;
    }
    return $s = $r;
}

function login_seller(array $seller): void
{
    session_regenerate_id(true);
    $_SESSION['seller_id'] = (int) $seller['id'];
    update('sellers', ['last_login_at' => now()], 'id = ?', [$seller['id']]);
}

function require_seller(): array
{
    $s = seller();
    if (!$s) {
        redirect('account/login.php');
    }
    return $s;
}

/** Find a seller by what they typed: an email or a Bangladesh mobile number. */
function find_seller_by_identifier(string $ident): ?array
{
    $ident = trim($ident);
    if (valid_email($ident)) {
        return row('SELECT * FROM sellers WHERE email = ?', [strtolower($ident)]);
    }
    $phone = normalize_bd_phone($ident);
    return $phone ? row('SELECT * FROM sellers WHERE phone = ?', [$phone]) : null;
}

/** May the current visitor see a not-yet-approved stall/brand? (its owner, or the admin) */
function can_preview(array $record): bool
{
    if (is_logged_in()) {
        return true;
    }
    $s = seller();
    return $s && !empty($record['seller_id']) && (int) $record['seller_id'] === (int) $s['id'];
}
