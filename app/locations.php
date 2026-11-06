<?php
/* Districts of Bangladesh, and the helpers behind the city filter and the "category in city" pages.

   Sellers type their city freely ("Dhaka", "Mirpur, Dhaka", "Chittagong"), so a raw value is mapped to
   one of the 64 districts by name (or a common old spelling / well known area). */

function bd_districts(): array
{
    return [
        'Bagerhat', 'Bandarban', 'Barguna', 'Barishal', 'Bhola', 'Bogura', 'Brahmanbaria', 'Chandpur', 'Chapainawabganj', 'Chattogram',
        'Chuadanga', "Cox's Bazar", 'Cumilla', 'Dhaka', 'Dinajpur', 'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalganj',
        'Habiganj', 'Jamalpur', 'Jashore', 'Jhalokathi', 'Jhenaidah', 'Joypurhat', 'Khagrachhari', 'Khulna', 'Kishoreganj', 'Kurigram',
        'Kushtia', 'Lakshmipur', 'Lalmonirhat', 'Madaripur', 'Magura', 'Manikganj', 'Meherpur', 'Moulvibazar', 'Munshiganj', 'Mymensingh',
        'Naogaon', 'Narail', 'Narayanganj', 'Narsingdi', 'Natore', 'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh',
        'Patuakhali', 'Pirojpur', 'Rajbari', 'Rajshahi', 'Rangamati', 'Rangpur', 'Satkhira', 'Shariatpur', 'Sherpur', 'Sirajganj',
        'Sunamganj', 'Sylhet', 'Tangail', 'Thakurgaon',
    ];
}

function district_slug(string $name): string
{
    return trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower(str_replace("'", '', $name))), '-');
}

/** slug => district name */
function districts_by_slug(): array
{
    static $map = null;
    if ($map === null) {
        $map = [];
        foreach (bd_districts() as $d) {
            $map[district_slug($d)] = $d;
        }
    }
    return $map;
}

/** Old spellings and well known areas -> the district they belong to. */
function district_aliases(): array
{
    return [
        'chittagong' => 'Chattogram', 'ctg' => 'Chattogram', 'comilla' => 'Cumilla', 'barisal' => 'Barishal', 'bogra' => 'Bogura',
        'jessore' => 'Jashore', 'cox bazar' => "Cox's Bazar", 'coxs bazar' => "Cox's Bazar", 'coxbazar' => "Cox's Bazar",
        'narayangonj' => 'Narayanganj', 'nawabganj' => 'Chapainawabganj', 'chapai nawabganj' => 'Chapainawabganj', 'moulavibazar' => 'Moulvibazar',
        'maulvibazar' => 'Moulvibazar', 'brahmanbaria' => 'Brahmanbaria', 'jhalakathi' => 'Jhalokathi', 'khagrachari' => 'Khagrachhari',
        'netrakona' => 'Netrokona', 'laxmipur' => 'Lakshmipur', 'sirajgonj' => 'Sirajganj', 'gaibanda' => 'Gaibandha',
        // areas that are inside Dhaka district
        'uttara' => 'Dhaka', 'mirpur' => 'Dhaka', 'dhanmondi' => 'Dhaka', 'gulshan' => 'Dhaka', 'banani' => 'Dhaka', 'motijheel' => 'Dhaka',
        'mohammadpur' => 'Dhaka', 'badda' => 'Dhaka', 'rampura' => 'Dhaka', 'farmgate' => 'Dhaka', 'tejgaon' => 'Dhaka', 'savar' => 'Dhaka',
        'keraniganj' => 'Dhaka', 'old dhaka' => 'Dhaka', 'bashundhara' => 'Dhaka', 'khilgaon' => 'Dhaka', 'jatrabari' => 'Dhaka',
        'demra' => 'Dhaka', 'dohar' => 'Dhaka', 'nawabganj dhaka' => 'Dhaka',
    ];
}

/** The district a free-typed city/area belongs to: ['slug' => 'dhaka', 'name' => 'Dhaka'], or null. */
function district_for(?string $raw): ?array
{
    static $cache = [];
    $text = strtolower(trim((string) $raw));
    if ($text === '') {
        return null;
    }
    if (array_key_exists($text, $cache)) {
        return $cache[$text];
    }
    $norm = ' ' . trim((string) preg_replace('/[^a-z]+/', ' ', str_replace("'", '', $text))) . ' ';
    $hit  = null;
    $best = 0;
    $cands = [];
    foreach (bd_districts() as $d) {
        $cands[strtolower(str_replace("'", '', $d))] = $d;
    }
    foreach (district_aliases() as $alias => $d) {
        $cands[$alias] = $d;
    }
    foreach ($cands as $needle => $d) {
        if (strpos($norm, ' ' . $needle . ' ') !== false && strlen($needle) > $best) {
            $hit  = $d;
            $best = strlen($needle);
        }
    }
    return $cache[$text] = ($hit ? ['slug' => district_slug($hit), 'name' => $hit] : null);
}

/** URL of a category page limited to one city:  /electronics/laptop/dhaka/ */
function category_city_url(array $cat, string $citySlug): string
{
    return category_url($cat) . $citySlug . '/';
}

/* ---- prices ---- */

/** "৳ 42 Lakh" -> 4200000, "৳ 1,850" -> 1850, "2.5 crore" -> 25000000. null when there is no number. */
function price_to_number(?string $text): ?float
{
    $t = strtr(mb_strtolower((string) $text), ['০' => '0', '১' => '1', '২' => '2', '৩' => '3', '৪' => '4', '৫' => '5', '৬' => '6', '৭' => '7', '৮' => '8', '৯' => '9', ',' => '']);
    if (!preg_match('/(\d+(?:\.\d+)?)(.*)$/su', $t, $m)) {
        return null;
    }
    $n    = (float) $m[1];
    $tail = ltrim($m[2]);
    if (preg_match('/^(crore|cr\b|কোটি)/u', $tail)) {
        $n *= 10000000;
    } elseif (preg_match('/^(lakhs?\b|lacs?\b|lac\b|লাখ|লক্ষ)/u', $tail)) {
        $n *= 100000;
    } elseif (preg_match('/^(thousand\b|k\b|হাজার)/u', $tail)) {
        $n *= 1000;
    }
    return $n > 0 ? $n : null;
}

/** Short price for the filter boxes: 4200000 -> "42 Lakh". */
function price_short(float $n): string
{
    if ($n >= 10000000) { return rtrim(rtrim(number_format($n / 10000000, 2), '0'), '.') . ' Crore'; }
    if ($n >= 100000)   { return rtrim(rtrim(number_format($n / 100000, 2), '0'), '.') . ' Lakh'; }
    return number_format($n);
}

/** Once: work out price_num for products that were saved before the column existed. */
function ensure_price_numbers(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'price_num_v1'")) {
            return;
        }
        foreach (rows("SELECT id, price_display FROM products WHERE price_num IS NULL AND price_display IS NOT NULL AND price_display <> ''") as $r) {
            $n = price_to_number($r['price_display']);
            if ($n !== null) {
                update('products', ['price_num' => $n], 'id = ?', [(int) $r['id']]);
            }
        }
        insert('settings', ['k' => 'price_num_v1', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_price_numbers: ' . $e->getMessage());
    }
}

/* ---- text for city pages ---- */

function category_city_title(array $cat, string $cityName): string
{
    $name = (string) $cat['name_en'];
    $year = date('Y');
    return stripos($name, 'other ') === 0 ? "$name in $cityName, Bangladesh $year" : "Best $name in $cityName, Bangladesh $year";
}

function category_city_description(array $cat, string $cityName, int $count): string
{
    $name = (string) $cat['name_en'];
    $year = date('Y');
    $text = $count > 0
        ? "Browse $count $name " . ($count === 1 ? 'listing' : 'listings') . " in $cityName for $year. Compare prices and message the seller on WhatsApp."
        : "Looking for $name in $cityName? Compare prices from sellers across Bangladesh and message them on WhatsApp.";
    return trim_words($text, 160);
}
