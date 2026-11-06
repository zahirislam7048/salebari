<?php
/* Small brakes against guessing passwords and form spam.

   Attempts are counted per visitor address in the database, so clearing cookies does not reset the count
   (the older per-session limit could be dodged that way). Addresses are stored only as a one-way hash. */

function throttle_key(string $scope): string
{
    return hash('sha256', $scope . '|' . ($_SERVER['REMOTE_ADDR'] ?? ''));
}

/** True when this visitor has used up $max attempts in the last $window seconds. */
function throttle_blocked(string $scope, int $max, int $window): bool
{
    try {
        $r = row('SELECT fails, last_at FROM login_attempts WHERE k = ?', [throttle_key($scope)]);
        return $r && (int) $r['fails'] >= $max && (time() - (int) $r['last_at']) < $window;
    } catch (Throwable $e) {
        return false;   // never lock people out because of a counting problem
    }
}

/** Record one attempt (a wrong password, a report sent...). */
function throttle_hit(string $scope, int $window): void
{
    try {
        $k = throttle_key($scope);
        $r = row('SELECT fails, last_at FROM login_attempts WHERE k = ?', [$k]);
        if (!$r) {
            insert('login_attempts', ['k' => $k, 'fails' => 1, 'last_at' => time()]);
        } elseif (time() - (int) $r['last_at'] >= $window) {
            update('login_attempts', ['fails' => 1, 'last_at' => time()], 'k = ?', [$k]);
        } else {
            update('login_attempts', ['fails' => (int) $r['fails'] + 1, 'last_at' => time()], 'k = ?', [$k]);
        }
        if (random_int(1, 50) === 1) {
            delete_from('login_attempts', 'last_at < ?', [time() - 86400]);   // tidy old rows now and then
        }
    } catch (Throwable $e) {
        error_log('SaleBari throttle_hit: ' . $e->getMessage());
    }
}

function throttle_clear(string $scope): void
{
    try {
        delete_from('login_attempts', 'k = ?', [throttle_key($scope)]);
    } catch (Throwable $e) {
        // ignore
    }
}

/** Reasons a visitor can give when reporting a listing: key => label. */
function report_reasons(): array
{
    return [
        'spam'      => 'Spam or duplicate listing',
        'wrong'     => 'Wrong price or wrong information',
        'scam'      => 'Suspected fraud or scam',
        'sold'      => 'Already sold or not available',
        'offensive' => 'Offensive, illegal or banned item',
        'other'     => 'Something else',
    ];
}
