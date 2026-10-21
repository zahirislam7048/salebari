<?php
/* SaleBari's public pages stay English-only server-side; the existing
   client-side window.I18N engine (js/main.js) swaps to Bangla instantly
   via localStorage, with no reload and no cookie/?lang= mechanism. This
   file only helps pick a bilingual DB column for a given language — used
   to render the English fallback text AND to build the window.I18N_EXTRA
   dict (both languages) that partials/header.php emits before main.js loads. */

/**
 * Pick one language's value from a bilingual row: field('name', $row, 'bn')
 * returns name_bn when it is filled, else falls back to name_en.
 */
function field(string $base, ?array $row, string $lang = 'en'): string
{
    if (!$row) {
        return '';
    }
    if ($lang === 'bn') {
        $bn = $row[$base . '_bn'] ?? '';
        if (is_string($bn) && trim($bn) !== '') {
            return $bn;
        }
    }
    $en = $row[$base . '_en'] ?? ($row[$base] ?? '');
    return (string) $en;
}
