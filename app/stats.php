<?php
/* Per-product performance counters for the seller dashboard.

   One row per product per day: page views, WhatsApp taps and Call taps. Only counts are stored —
   no visitor identity, IP address or phone number — so this is separate from (and lighter than) the
   Google / Meta tracking, and it works even when a visitor declines cookies. */

function request_is_bot(): bool
{
    $ua = strtolower((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
    return $ua === '' || (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|monitor|uptime|curl|wget|python|httpclient|headless|lighthouse|pingdom|scrapy/', $ua);
}

/** type: 'view' | 'wa' | 'call'. Never throws — a counting problem must not break a page. */
function record_product_event(int $productId, string $type): void
{
    $col = ['view' => 'views', 'wa' => 'wa_clicks', 'call' => 'call_clicks'][$type] ?? null;
    if (!$col || $productId <= 0) {
        return;
    }
    try {
        $day  = date('Y-m-d');
        $bump = "UPDATE product_stats SET $col = $col + 1 WHERE product_id = ? AND stat_date = ?";
        if (q($bump, [$productId, $day])->rowCount() === 0) {
            try {
                insert('product_stats', [
                    'product_id' => $productId, 'stat_date' => $day,
                    'views' => $type === 'view' ? 1 : 0, 'wa_clicks' => $type === 'wa' ? 1 : 0, 'call_clicks' => $type === 'call' ? 1 : 0,
                ]);
            } catch (Throwable $race) {
                q($bump, [$productId, $day]);   // another request created today's row first
            }
        }
    } catch (Throwable $e) {
        error_log('SaleBari record_product_event: ' . $e->getMessage());
    }
}

/** Count one product page view per visitor session; skips search bots and the signed-in admin. */
function count_product_view(int $productId): void
{
    if (request_is_bot() || is_logged_in()) {
        return;
    }
    if (!empty($_SESSION['pv'][$productId])) {
        return;
    }
    $_SESSION['pv'][$productId] = 1;
    record_product_event($productId, 'view');
}

/**
 * Numbers for one seller's listings over the last $days days (products in their stalls or under their brands).
 * Returns ['totals' => [views, wa, call], 'products' => [...], 'daily' => [date => [views, enquiries]], 'count' => n]
 */
function seller_performance(int $sellerId, int $days): array
{
    $days  = max(1, min(365, $days));
    $since = date('Y-m-d', strtotime('-' . ($days - 1) . ' days'));
    $out   = ['totals' => ['views' => 0, 'wa' => 0, 'call' => 0], 'products' => [], 'daily' => [], 'count' => 0];
    for ($i = $days - 1; $i >= 0; $i--) {
        $out['daily'][date('Y-m-d', strtotime("-$i days"))] = ['views' => 0, 'enq' => 0];
    }

    $prods = rows(
        "SELECT p.id, p.title_en, p.slug, p.status FROM products p
         LEFT JOIN stalls s ON s.id = p.stall_id
         LEFT JOIN brands b ON b.id = p.brand_id
         WHERE s.seller_id = ? OR b.seller_id = ?",
        [$sellerId, $sellerId]
    );
    $out['count'] = count($prods);
    if (!$prods) {
        return $out;
    }
    $ids = array_map('intval', array_column($prods, 'id'));
    $in  = implode(',', array_fill(0, count($ids), '?'));

    $per = [];
    foreach (rows("SELECT product_id, SUM(views) v, SUM(wa_clicks) w, SUM(call_clicks) c FROM product_stats WHERE product_id IN ($in) AND stat_date >= ? GROUP BY product_id", array_merge($ids, [$since])) as $r) {
        $per[(int) $r['product_id']] = ['views' => (int) $r['v'], 'wa' => (int) $r['w'], 'call' => (int) $r['c']];
    }
    foreach ($prods as $p) {
        $s = $per[(int) $p['id']] ?? ['views' => 0, 'wa' => 0, 'call' => 0];
        $out['products'][] = $p + $s;
        $out['totals']['views'] += $s['views'];
        $out['totals']['wa']    += $s['wa'];
        $out['totals']['call']  += $s['call'];
    }
    usort($out['products'], function ($a, $b) {
        return [$b['views'], $b['wa'] + $b['call']] <=> [$a['views'], $a['wa'] + $a['call']];
    });

    foreach (rows("SELECT stat_date d, SUM(views) v, SUM(wa_clicks) + SUM(call_clicks) e FROM product_stats WHERE product_id IN ($in) AND stat_date >= ? GROUP BY stat_date", array_merge($ids, [$since])) as $r) {
        $day = substr((string) $r['d'], 0, 10);
        if (isset($out['daily'][$day])) {
            $out['daily'][$day] = ['views' => (int) $r['v'], 'enq' => (int) $r['e']];
        }
    }
    return $out;
}
