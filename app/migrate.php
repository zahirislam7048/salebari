<?php
/* Keeps the database in step with install/schema.sql, so an update that adds
   a column or a table never needs a hand-run SQL step in phpMyAdmin.

   It only ever ADDS missing tables and columns — it never drops, renames or
   rewrites anything. It runs once per schema.sql change: the file's hash is
   remembered in the settings table. */

/** schema.sql is written for MySQL; SQLite (local testing) needs a few type rewrites. */
function schema_translate(string $statement): string
{
    if (DB_DRIVER === 'sqlite') {
        $statement = preg_replace('/INT UNSIGNED AUTO_INCREMENT PRIMARY KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $statement);
        $statement = preg_replace('/\bINT UNSIGNED\b/i', 'INTEGER', $statement);
        $statement = preg_replace('/\bTINYINT\b/i', 'INTEGER', $statement);
        $statement = preg_replace('/\bDECIMAL\s*\([^)]*\)/i', 'REAL', $statement);
        $statement = preg_replace('/\bVARCHAR\s*\([^)]*\)/i', 'TEXT', $statement);
        $statement = preg_replace('/\bDATETIME\b/i', 'TEXT', $statement);
        $statement = preg_replace('/\bINT\b/i', 'INTEGER', $statement);
    } elseif (stripos($statement, 'CREATE TABLE') === 0) {
        $statement .= ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    }
    return $statement;
}

function existing_columns(string $table): array
{
    if (DB_DRIVER === 'sqlite') {
        return array_map('strtolower', array_column(rows("PRAGMA table_info($table)"), 'name'));
    }
    return array_map('strtolower', array_column(rows("SHOW COLUMNS FROM `$table`"), 'Field'));
}

function auto_migrate(): void
{
    try {
        $file = APP_ROOT . '/install/schema.sql';
        if (!is_file($file)) {
            return;
        }
        $hash = md5_file($file);
        if (scalar("SELECT v_en FROM settings WHERE k = 'schema_hash'") === $hash) {
            return;
        }

        $sql = preg_replace('/^\s*--.*$/m', '', (string) file_get_contents($file));
        foreach (array_filter(array_map('trim', explode(';', $sql))) as $statement) {
            if (!preg_match('/^CREATE TABLE\s+(\w+)\s*\((.*)\)\s*$/is', $statement, $m)) {
                continue;
            }
            [, $table, $body] = $m;
            try {
                if (!table_exists($table)) {
                    db()->exec(schema_translate($statement));
                    continue;
                }
                $have = existing_columns($table);
                foreach (preg_split('/\r?\n/', $body) as $line) {
                    $line = rtrim(trim($line), ',');
                    if ($line === '' || preg_match('/^(PRIMARY|UNIQUE|KEY|INDEX|CONSTRAINT)\b/i', $line) || stripos($line, 'AUTO_INCREMENT') !== false) {
                        continue;
                    }
                    $col = strtolower(strtok($line, " \t"));
                    if (!in_array($col, $have, true)) {
                        db()->exec(schema_translate("ALTER TABLE $table ADD COLUMN $line"));
                    }
                }
            } catch (Throwable $e) {
                error_log('SaleBari auto_migrate (' . $table . '): ' . $e->getMessage());
            }
        }

        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'schema_hash'")) {
            update('settings', ['v_en' => $hash], 'k = ?', ['schema_hash']);
        } else {
            insert('settings', ['k' => 'schema_hash', 'v_en' => $hash, 'v_bn' => null]);
        }
    } catch (Throwable $e) {
        error_log('SaleBari auto_migrate: ' . $e->getMessage());
    }
}
