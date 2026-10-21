<?php
/* Thin PDO wrapper. Speaks MySQL in production and SQLite locally so the
   same queries can be exercised on a machine with no MySQL installed. */

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $opts = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    if (DB_DRIVER === 'sqlite') {
        $dir = dirname(DB_SQLITE_PATH);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $pdo = new PDO('sqlite:' . DB_SQLITE_PATH, null, null, $opts);
        $pdo->exec('PRAGMA foreign_keys = ON');
    } else {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
    }

    return $pdo;
}

function db_ok(): bool
{
    try {
        db()->query('SELECT 1');
        return true;
    } catch (Throwable $e) {
        return false;
    }
}

function q(string $sql, array $args = []): PDOStatement
{
    $st = db()->prepare($sql);
    $st->execute($args);
    return $st;
}

function rows(string $sql, array $args = []): array
{
    return q($sql, $args)->fetchAll();
}

function row(string $sql, array $args = []): ?array
{
    $r = q($sql, $args)->fetch();
    return $r === false ? null : $r;
}

function scalar(string $sql, array $args = [])
{
    $v = q($sql, $args)->fetchColumn();
    return $v === false ? null : $v;
}

/** INSERT from an associative array; returns the new id. */
function insert(string $table, array $data): int
{
    $cols = array_keys($data);
    $sql  = sprintf(
        'INSERT INTO %s (%s) VALUES (%s)',
        $table,
        implode(', ', $cols),
        implode(', ', array_fill(0, count($cols), '?'))
    );
    q($sql, array_values($data));
    return (int) db()->lastInsertId();
}

/** UPDATE from an associative array; returns affected row count. */
function update(string $table, array $data, string $where, array $args = []): int
{
    $sets = [];
    foreach (array_keys($data) as $c) {
        $sets[] = $c . ' = ?';
    }
    $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, implode(', ', $sets), $where);
    return q($sql, array_merge(array_values($data), $args))->rowCount();
}

function delete_from(string $table, string $where, array $args = []): int
{
    return q("DELETE FROM $table WHERE $where", $args)->rowCount();
}

/** Does a table exist? Used by the installer and the setup guard. */
function table_exists(string $table): bool
{
    try {
        db()->query("SELECT 1 FROM $table LIMIT 1");
        return true;
    } catch (Throwable $e) {
        return false;
    }
}
