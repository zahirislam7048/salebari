<?php
/* ============================================================
   Sample-data seeder. Transcribes the site's current hardcoded
   JS/HTML content into real database rows so nothing is lost when
   catalog-data.js / nav-data.js / listing-data.js / stall-data.js /
   market-data.js are eventually retired in favour of the API.
   ============================================================ */

function run_seed(): void
{
    seed_categories();
    seed_stalls();
    seed_malls();
    seed_deals();
    seed_real_estate_listings();
    seed_settings();
}

function seed_categories(): void
{
    $level1 = [
        'carbike'    => ['Car & Bike', 'গাড়ি ও বাইক', '🚗', '1,760 stalls', '১,৭৬০ স্টল'],
        'realestate' => ['Real Estate', 'রিয়েল এস্টেট', '🏢', '980 listings', '৯৮০ লিস্টিং'],
        'agro'       => ['Agro', 'এগ্রো', '🌾', '2,240 stalls', '২,২৪০ স্টল'],
    ];

    /* key => [level1 key, name_en, name_bn, icon] */
    $level2 = [
        'carAccessories'       => ['carbike', 'Car Accessories', 'কার অ্যাক্সেসরিজ', '🚘'],
        'bikeAccessories'      => ['carbike', 'Bike Accessories', 'বাইক অ্যাক্সেসরিজ', '🪖'],
        'threeWheeler'         => ['carbike', 'Three Wheeler', 'থ্রি হুইলার', '🛺'],
        'commercialVehicle'    => ['carbike', 'Commercial Vehicle', 'কমার্শিয়াল ভেহিকল', '🚛'],
        'rental'               => ['carbike', 'Rental', 'রেন্টাল', '🔑'],
        'apartment'            => ['realestate', 'Apartment', 'অ্যাপার্টমেন্ট', '🏢'],
        'land'                 => ['realestate', 'Land', 'জমি', '🗺️'],
        'commercialSpace'      => ['realestate', 'Commercial Space', 'কমার্শিয়াল স্পেস', '🏬'],
        'sanitary'             => ['realestate', 'Sanitary', 'স্যানিটারি', '🚽'],
        'constructionMaterial' => ['realestate', 'Construction Material', 'নির্মাণ সামগ্রী', '🧱'],
        'livestock'            => ['agro', 'Livestock', 'গবাদি পশু', '🐄'],
        'fish'                 => ['agro', 'Fish', 'মাছ', '🐟'],
        'poultry'              => ['agro', 'Poultry', 'পোল্ট্রি', '🐔'],
        'birds'                => ['agro', 'Birds', 'পাখি', '🕊️'],
    ];

    /* These level-2 items have no level-3 children — they are leaves
       themselves, linking straight to a listing page. */
    $level2Leaves = ['apartment', 'land', 'commercialSpace'];

    /* key => [level2 key, name_en, icon]. No Bangla source text exists yet
       for these ~35 items (SUBMENU_DATA is English-only) — name_bn stays
       NULL and the public page falls back to English until an admin fills
       it in via the dashboard. */
    $level3 = [
        'carScratchRemover'     => ['carAccessories', 'Car Scratch Remover', '🚘'],
        'engineOil'             => ['carAccessories', 'Engine Oil', '🚘'],
        'carScanner'            => ['carAccessories', 'Car Scanner', '🚘'],
        'dashcam'               => ['carAccessories', 'DashCam', '🚘'],
        'motorcycleHelmet'      => ['bikeAccessories', 'Motorcycle Helmet', '🪖'],
        'motorcycleTyre'        => ['bikeAccessories', 'Motorcycle Tyre', '🪖'],
        'cng'                   => ['threeWheeler', 'CNG', '🛺'],
        'autoRickshaw'          => ['threeWheeler', 'Auto Rickshaw', '🛺'],
        'boat'                  => ['commercialVehicle', 'Boat', '🚛'],
        'truck'                 => ['commercialVehicle', 'Truck', '🚛'],
        'tractor'               => ['commercialVehicle', 'Tractor', '🚛'],
        'bus'                   => ['commercialVehicle', 'Bus', '🚛'],
        'pickupRental'          => ['rental', 'Pickup Rental', '🚑'],
        'ambulanceService'      => ['rental', 'Ambulance Service', '🚑'],
        'commode'               => ['sanitary', 'Commode', '🚽'],
        'basin'                 => ['sanitary', 'Basin', '🚽'],
        'waterTap'              => ['sanitary', 'Water Tap', '🚽'],
        'cement'                => ['constructionMaterial', 'Cement', '🧱'],
        'sand'                  => ['constructionMaterial', 'Sand', '🧱'],
        'stone'                 => ['constructionMaterial', 'Stone', '🧱'],
        'brick'                 => ['constructionMaterial', 'Brick', '🧱'],
        'rod'                   => ['constructionMaterial', 'Rod', '🧱'],
        'constructionEquipment' => ['constructionMaterial', 'Construction Equipment', '🧱'],
        'cow'                   => ['livestock', 'Cow', '🐄'],
        'goat'                  => ['livestock', 'Goat', '🐐'],
        'buffalo'               => ['livestock', 'Buffalo', '🐃'],
        'rui'                   => ['fish', 'Rui', '🐟'],
        'katla'                 => ['fish', 'Katla', '🐟'],
        'tilapia'               => ['fish', 'Tilapia', '🐟'],
        'pangas'                => ['fish', 'Pangas', '🐟'],
        'otherFish'             => ['fish', 'Other Fish', '🐟'],
        'chicken'               => ['poultry', 'Chicken', '🐔'],
        'duck'                  => ['poultry', 'Duck', '🦆'],
        'pigeon'                => ['birds', 'Pigeon', '🕊️'],
        'otherPermittedBirds'   => ['birds', 'Other Permitted Birds', '🕊️'],
    ];

    $now = now();
    $l1Id = [];
    $order = 0;
    foreach ($level1 as $key => [$nameEn, $nameBn, $icon, $countEn, $countBn]) {
        $l1Id[$key] = insert('categories', [
            'parent_id'      => null,
            'level'          => 1,
            'slug'           => $key,
            'name_en'        => $nameEn,
            'name_bn'        => $nameBn,
            'icon'           => $icon,
            'count_label_en' => $countEn,
            'count_label_bn' => $countBn,
            'featured'       => 1,
            'sort_order'     => $order++,
            'created_at'     => $now,
        ]);
    }

    $l2Id = [];
    $order = 0;
    foreach ($level2 as $key => [$parentKey, $nameEn, $nameBn, $icon]) {
        $l2Id[$key] = insert('categories', [
            'parent_id'      => $l1Id[$parentKey],
            'level'          => 2,
            'slug'           => $key,
            'name_en'        => $nameEn,
            'name_bn'        => $nameBn,
            'icon'           => $icon,
            'count_label_en' => null,
            'count_label_bn' => null,
            'featured'       => 0,
            'sort_order'     => $order++,
            'created_at'     => $now,
        ]);
    }

    $order = 0;
    foreach ($level3 as $key => [$parentKey, $nameEn, $icon]) {
        insert('categories', [
            'parent_id'      => $l2Id[$parentKey],
            'level'          => 3,
            'slug'           => $key,
            'name_en'        => $nameEn,
            'name_bn'        => null,
            'icon'           => $icon,
            'count_label_en' => null,
            'count_label_bn' => null,
            'featured'       => 0,
            'sort_order'     => $order++,
            'created_at'     => $now,
        ]);
    }
}

function seed_stalls(): void
{
    /* From js/stall-data.js STALL_LIST (the /stall/list/ directory). */
    $list = [
        ['Mobile Corner BD', 'Dhaka', 42, true], ['Laptop Bazaar', 'Dhaka', 118, true],
        ['SoundHouse', 'Chittagong', 27, false], ['Ghor Furniture', 'Dhaka', 64, true],
        ['GlowBari Beauty', 'Sylhet', 15, false], ['Thanda Ghor Appliances', 'Dhaka', 33, true],
        ['TimeKotha', 'Rajshahi', 9, false], ['Kaath Kaaj', 'Dhaka', 21, false],
        ['Green Valley Agro', 'Rangpur', 12, false], ['Dhaka Doctor Care', 'Dhaka', null, true],
        ['Bondhu Travels', 'Dhaka', 6, false], ['Nirapod Security Solutions', 'Chittagong', 19, true],
        ['Bikroy Motors', 'Dhaka', 8, false], ['Shohoj Kitchenware', 'Khulna', 24, false],
        ['Bishash Sofa House', 'Dhaka', 11, false], ['Padma Auto Parts', 'Rajshahi', 30, false],
        ['City Lights Electric', 'Dhaka', 17, true], ['Jamuna Textile', 'Narayanganj', 45, false],
        ['Amar Bari Decor', 'Dhaka', 14, false], ['Sundarban Organic Foods', 'Khulna', 22, false],
        ['Bogura Bike Point', 'Bogura', 7, false], ["Cox's Bazar Tour Desk", "Cox's Bazar", 4, true],
        ['Rupali Cosmetics', 'Dhaka', 33, false], ['Nilkantha Books', 'Sylhet', 16, false],
        ['Barisal Farm Supply', 'Barisal', 9, false], ['Comilla Computer Zone', 'Comilla', 28, true],
        ['Gazipur Garments House', 'Gazipur', 38, false], ['Mymensingh Medical Mart', 'Mymensingh', 20, false],
        ['Jessore Handicrafts', 'Jessore', 13, false], ['Kushtia Kitchen Store', 'Kushtia', 10, false],
        ['Tangail Tiles & Sanitary', 'Tangail', 18, true], ['Chittagong Marine Gear', 'Chittagong', 5, false],
        ['Dhaka Real Estate Point', 'Dhaka', 3, false], ['Uttara Fashion House', 'Dhaka', 26, false],
        ['Sylheti Tea Corner', 'Sylhet', 8, false], ['Rajshahi Silk Store', 'Rajshahi', 12, true],
        ['Bashundhara Baby Shop', 'Dhaka', 19, false], ['Feni Hardware Mart', 'Feni', 15, false],
        ['Noakhali Net & Cable', 'Noakhali', 9, false], ['Dinajpur Rice & Grains', 'Dinajpur', 6, false],
    ];
    /* From js/stall-detail-data.js STALL_DETAILS — a second, disjoint set
       of 4 sample stalls used only for the static detail pages. */
    $details = [
        ['Dreamway Holdings', 'Dhaka', true], ['Eco Crave Ltd', 'Chittagong', false],
        ['JBS Holdings', 'Dhaka', true], ['ABC Car', 'Gazipur', false],
    ];

    $now = now();
    foreach (array_merge($list, array_map(fn($d) => [$d[0], $d[1], null, $d[2]], $details)) as [$name, $city, $products, $verified]) {
        $slug = unique_slug('stalls', slugify($name));
        insert('stalls', [
            'slug'          => $slug,
            'name'          => $name,
            'category_id'   => null,
            'city'          => $city,
            'address'       => null,
            'phone'         => null,
            'description'   => null,
            'logo_emoji'    => null,
            'verified'      => $verified ? 1 : 0,
            'rating'        => null,
            'product_count' => $products ?? 0,
            'status'        => 'active',
            'sort_order'    => 0,
            'created_at'    => $now,
        ]);
    }
}

function seed_malls(): void
{
    /* From js/market-data.js MARKET_CITIES, flattened to one row per mall.
       [name, address, closed day or null] */
    $cities = [
        'Dhaka' => [
            ['Alpona Plaza', 'New Elephant Road, Dhaka', 'Tuesday'],
            ['Eastern Plaza', 'Hatirpool, Dhaka', null],
            ['Shah Ali Plaza', 'Mirpur 10 Golchokkor, Dhaka', 'Sunday'],
            ['Suvastu Arcade', '46,48 New Elephant Road, Dhaka', null],
            ['Jamuna Future Park', 'Ka-244, Progati Sarani, Kuril, Baridhara, Dhaka', 'Wednesday'],
            ['Bashundhara City', 'Panthapath, Dhaka', 'Tuesday'],
            ['Nahar Plaza', 'Hatirpool, Opposite of Eastern Plaza Market, Dhaka', 'Tuesday'],
            ['Motalib Plaza', 'Hatirpool, Dhaka', 'Tuesday'],
            ['Computer City Center', '69-71 New Elephant Road, Dhaka', null],
        ],
        'Other' => [
            ['Karnaphuli Garden City', 'Shantinagar, Other', null],
            ['Fortune Shopping Mall', 'Mouchak, Other', 'Thursday'],
        ],
    ];

    $now = now();
    $order = 0;
    foreach ($cities as $city => $malls) {
        foreach ($malls as [$name, $address, $closedDay]) {
            insert('malls', [
                'slug'           => unique_slug('malls', slugify($name)),
                'name'           => $name,
                'city_name_en'   => $city,
                'city_name_bn'   => null,
                'closed_day'     => $closedDay,
                'stall_count'    => 0,
                'description_en' => $address,
                'description_bn' => null,
                'sort_order'     => $order++,
                'created_at'     => $now,
            ]);
        }
    }
}

function seed_deals(): void
{
    /* From index.html's "Trending in the bazaar" grid. */
    $deals = [
        ['City Homes', 'product.1', '2 Bed Apartment, 1050 sqft — Mirpur', '২ বেড অ্যাপার্টমেন্ট, ১০৫০ বর্গফুট — মিরপুর', '🏢', '৳ 42 Lakh', '৳ 48 Lakh', 13, 'grad-1'],
        ['BuildMart BD', 'product.2', 'Premium Cement, 50kg Bag', 'প্রিমিয়াম সিমেন্ট, ৫০ কেজি ব্যাগ', '🧱', '৳ 520', '৳ 560', 7, 'grad-2'],
        ['Sanitary House', 'product.3', 'Deluxe One-Piece Commode', 'ডিলাক্স ওয়ান-পিস কমোড', '🚽', '৳ 4,200', '৳ 5,000', 16, 'grad-3'],
        ['AutoCare BD', 'product.4', 'Engine Oil, Full Synthetic 4L', 'ইঞ্জিন অয়েল, ফুল সিন্থেটিক ৪ লিটার', '🛢️', '৳ 1,850', '৳ 2,200', 16, 'grad-4'],
        ['RideGear BD', 'product.5', 'Heavy Duty Motorcycle Helmet', 'হেভি ডিউটি মোটরসাইকেল হেলমেট', '🪖', '৳ 3,200', '৳ 3,900', 18, 'grad-5'],
        ['Auto Bazaar', 'product.6', 'Bajaj CNG Auto Rickshaw', 'বাজাজ সিএনজি অটো রিকশা', '🛺', '৳ 3.2 Lakh', '৳ 3.6 Lakh', 11, 'grad-6'],
        ['Cattle Corner', 'product.7', 'Sahiwal Cross Cow, 220kg', 'সাহিওয়াল ক্রস গরু, ২২০ কেজি', '🐄', '৳ 85,000', '৳ 98,000', 13, 'grad-1'],
        ['FreshCatch BD', 'product.8', 'Rui Fish, Fresh Catch (per kg)', 'রুই মাছ, তাজা ধরা (প্রতি কেজি)', '🐟', '৳ 320', '৳ 380', 16, 'grad-2'],
    ];

    $now = now();
    $order = 0;
    foreach ($deals as [$stall, , $titleEn, $titleBn, $icon, $price, $oldPrice, $pct, $grad]) {
        insert('deals', [
            'stall_name'           => $stall,
            'title_en'             => $titleEn,
            'title_bn'             => $titleBn,
            'icon'                 => $icon,
            'price_display_en'     => $price,
            'price_display_bn'     => null,
            'old_price_display_en' => $oldPrice,
            'old_price_display_bn' => null,
            'discount_pct'         => $pct,
            'gradient'             => $grad,
            'sort_order'           => $order++,
            'active'               => 1,
            'created_at'           => $now,
        ]);
    }
}

function seed_real_estate_listings(): void
{
    $listings = [
        ['1,450 sqft Apartment — Bashundhara R/A', '১,৪৫০ বর্গফুট অ্যাপার্টমেন্ট — বসুন্ধরা আর/এ', 'sale', '৳ 1.35 Crore', '৳ ১.৩৫ কোটি'],
        ['3 Bed Flat — Dhanmondi, Dhaka', '৩ বেড ফ্ল্যাট — ধানমন্ডি, ঢাকা', 'rent', '৳ 32,000 / month', '৳ ৩২,০০০ / মাস'],
    ];

    $now = now();
    $order = 0;
    foreach ($listings as [$titleEn, $titleBn, $tag, $priceEn, $priceBn]) {
        insert('real_estate_listings', [
            'title_en'         => $titleEn,
            'title_bn'         => $titleBn,
            'tag'              => $tag,
            'price_display_en' => $priceEn,
            'price_display_bn' => $priceBn,
            'sort_order'       => $order++,
            'active'           => 1,
            'created_at'       => $now,
        ]);
    }
}

function seed_settings(): void
{
    $settings = [
        'hero_eyebrow'       => ["Bangladesh's digital bazaar", 'বাংলাদেশের ডিজিটাল বাজার'],
        'hero_title'         => ['Every stall.<br>One <em>address</em>.', 'সব স্টল।<br>এক <em>ঠিকানা</em>।'],
        'hero_sub'           => [
            'Compare prices across thousands of verified stalls before you spend a single taka — land and flats, cars and bikes, livestock and fish, all under one roof.',
            'একটি টাকাও খরচ করার আগে হাজারো ভেরিফায়েড স্টলের দাম তুলনা করুন — জমি ও ফ্ল্যাট, গাড়ি ও বাইক, গবাদি পশু ও মাছ, সব এক ছাদের নিচে।',
        ],
        'hero_cta_browse'    => ['Browse the bazaar', 'বাজার ঘুরে দেখুন'],
        'hero_cta_sell'      => ['Open your stall →', 'আপনার স্টল খুলুন →'],
        'categories_eyebrow' => ['Walk the aisles', 'আইল ঘুরে দেখুন'],
        'categories_heading' => ['Shop by category', 'ক্যাটাগরি অনুযায়ী কিনুন'],
        'deals_eyebrow'      => ['Fresh off the shelf', 'তাজা মজুদ'],
        'deals_heading'      => ['Trending in the bazaar', 'বাজারে এখন জনপ্রিয়'],
        'estate_eyebrow'     => ['Looking for a new bari?', 'নতুন বাড়ি খুঁজছেন?'],
        'estate_heading'     => ['Flats, land & commercial space, listed by real owners.', 'ফ্ল্যাট, জমি ও বাণিজ্যিক স্পেস, প্রকৃত মালিকদের তালিকাভুক্ত।'],
        'estate_sub'         => [
            'Every listing is verified by our field agents before it goes live — no ghost listings, no middleman markup.',
            'প্রতিটি লিস্টিং প্রকাশের আগে আমাদের ফিল্ড এজেন্ট যাচাই করেন — কোনো ভুয়া লিস্টিং নেই, কোনো মধ্যস্বত্বভোগীর বাড়তি দাম নেই।',
        ],
        'estate_cta'         => ['Browse listings', 'লিস্টিং দেখুন'],
        'newsletter_heading' => ['Never miss bazaar day', 'বাজারের দিন মিস করবেন না'],
        'newsletter_sub'     => ['Price-drop alerts and weekly deals, straight to your inbox.', 'প্রাইস-ড্রপ অ্যালার্ট ও সাপ্তাহিক অফার, সরাসরি আপনার ইনবক্সে।'],
        'footer_brand_desc'  => [
            "Bangladesh's digital bazaar — verified stalls, instant price comparison, one address for everything you need.",
            'বাংলাদেশের ডিজিটাল বাজার — ভেরিফায়েড স্টল, তাৎক্ষণিক দাম তুলনা, আপনার সব প্রয়োজনের এক ঠিকানা।',
        ],
        'contact_phone'      => ['+8801515286327', '+8801515286327'],
        'contact_email'      => [CONTACT_EMAIL, CONTACT_EMAIL],
        'contact_whatsapp'   => ['+8801644842785', '+8801644842785'],
    ];

    foreach ($settings as $k => [$en, $bn]) {
        $existing = row('SELECT id FROM settings WHERE k = ?', [$k]);
        if ($existing) {
            update('settings', ['v_en' => $en, 'v_bn' => $bn], 'id = ?', [$existing['id']]);
        } else {
            insert('settings', ['k' => $k, 'v_en' => $en, 'v_bn' => $bn]);
        }
    }
}
