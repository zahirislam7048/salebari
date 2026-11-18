<?php
/* "Flat / Apartment / Land for Sale in <city>" landing pages.

     /property-for-sale/               hub: every type in every city
     /flat-for-sale/                   one type, all cities
     /flat-for-sale-in-dhaka/          one type in one city      (also apartment-... and land-...)

   Listings are the real products under Real Estate -> Apartment / Land, matched to the city by the product's
   own city or its stall's city. Nothing about prices or counts is invented: with no listing the page says so
   and offers to connect the visitor with sellers. To add a city, add one entry to property_locations(). */

function property_types(): array
{
    return [
        'flat' => [
            'en' => 'Flat', 'bn' => 'ফ্ল্যাট', 'cat' => ['real-estate', 'apartment'], 'icon' => '🏢',
            'lead' => "Looking for a flat for sale in {city}? Browse flats listed by sellers on SaleBari, compare asking prices and sizes, and message the seller directly on WhatsApp or by phone.",
            'lead_bn' => "{city_in} ফ্ল্যাট কিনতে চান? SaleBari-তে বিক্রেতাদের দেওয়া ফ্ল্যাটের তালিকা দেখুন, দাম ও আকার তুলনা করুন এবং সরাসরি হোয়াটসঅ্যাপ বা ফোনে বিক্রেতার সাথে কথা বলুন।",
            'tips_title' => 'Before you buy a flat in {city}',
            'tips_title_bn' => '{city_in} ফ্ল্যাট কেনার আগে যা দেখবেন',
            'tips' => [
                "Ask for the deed (দলিল) and the ownership history of the land under the building, and check the mutation (নামজারি) and the latest land development tax receipt.",
                "Confirm the building plan is approved by {authority} and that the construction follows the approved plan.",
                "Check the size on paper. Ask whether the figure is net or super built-up area, then divide the asking price by the area to compare flats fairly.",
                "Ask about the undivided land share, parking, lift, generator, water, gas and electricity connections, and any monthly service charge.",
                "Visit in person, and put the agreed price, payment schedule and handover date in a written agreement.",
            ],
            'tips_bn' => [
                "দলিল এবং ভবনটি যে জমির ওপর তার মালিকানার ধারাবাহিক কাগজ দেখুন; নামজারি (খারিজ) ও সর্বশেষ ভূমি উন্নয়ন কর (খাজনা) রশিদ যাচাই করুন।",
                "ভবনের নকশা {authority_bn} অনুমোদিত কি না এবং নির্মাণ অনুমোদিত নকশা অনুযায়ী হয়েছে কি না নিশ্চিত হোন।",
                "ফ্ল্যাটের আকার কাগজে দেখুন। এটি নিট না সুপার বিল্ট-আপ এরিয়া জেনে নিন, তারপর দাম ÷ আকার করে বর্গফুট প্রতি দাম তুলনা করুন।",
                "জমির অবিভক্ত অংশ, পার্কিং, লিফট, জেনারেটর, পানি, গ্যাস ও বিদ্যুৎ সংযোগ এবং মাসিক সার্ভিস চার্জ সম্পর্কে জিজ্ঞাসা করুন।",
                "নিজে গিয়ে দেখুন এবং সম্মত দাম, কিস্তির সময়সূচি ও হস্তান্তরের তারিখ লিখিত চুক্তিতে রাখুন।",
            ],
            'faq' => [
                ["Which documents should I check when buying a flat in {city}?", "Check the deed and the ownership history of the land, the mutation record, recent tax receipts, the plan approval from {authority}, and the sale agreement with the handover date. It is wise to have a lawyer verify them before you pay.",
                 "{city_in} ফ্ল্যাট কেনার সময় কোন কাগজ দেখব?", "দলিল ও জমির মালিকানার ধারাবাহিকতা, নামজারি, সাম্প্রতিক কর রশিদ, {authority_bn} থেকে নকশা অনুমোদন এবং হস্তান্তরের তারিখসহ বিক্রয় চুক্তি দেখুন। টাকা দেওয়ার আগে একজন আইনজীবীকে দিয়ে যাচাই করিয়ে নেওয়া ভালো।"],
                ["How do I compare flat prices in {city}?", "Divide the asking price by the area in square feet and compare the price per square foot. Also compare the floor, the direction the flat faces, the age of the building and the facilities.",
                 "{city_in} ফ্ল্যাটের দাম কীভাবে তুলনা করব?", "দামকে বর্গফুটে ভাগ করে বর্গফুট প্রতি দাম তুলনা করুন। সাথে ফ্লোর, ফ্ল্যাটের দিক, ভবনের বয়স ও সুযোগ-সুবিধাও মিলিয়ে দেখুন।"],
            ],
        ],
        'apartment' => [
            'en' => 'Apartment', 'bn' => 'অ্যাপার্টমেন্ট', 'cat' => ['real-estate', 'apartment'], 'icon' => '🏙️',
            'lead' => "Find apartments for sale in {city}, from ready apartments to new projects. Compare listings from sellers on SaleBari and message the seller directly on WhatsApp or by phone.",
            'lead_bn' => "{city_in} বিক্রির জন্য অ্যাপার্টমেন্ট খুঁজছেন? তৈরি অ্যাপার্টমেন্ট থেকে নতুন প্রকল্প পর্যন্ত SaleBari-র বিক্রেতাদের তালিকা তুলনা করুন এবং সরাসরি হোয়াটসঅ্যাপ বা ফোনে যোগাযোগ করুন।",
            'tips_title' => 'Checklist for buying an apartment in {city}',
            'tips_title_bn' => '{city_in} অ্যাপার্টমেন্ট কেনার চেকলিস্ট',
            'tips' => [
                "Check the developer. Ask how many projects they have handed over, and visit a finished one if you can.",
                "Ready or under construction? For an under-construction apartment, get a signed agreement with the handover date and the terms if the handover is late.",
                "Ask to see the approved plan from {authority} and the structural design and soil test papers, and look at the lift, fire exit, parking and common areas.",
                "Find out how the owners' committee works: service charge, and who looks after the lift, generator and security.",
                "Get the registration cost and any other fees explained in writing before you pay, and pay by traceable bank transfer with a receipt for every instalment.",
            ],
            'tips_bn' => [
                "ডেভেলপার যাচাই করুন। তারা কয়টি প্রকল্প হস্তান্তর করেছে জিজ্ঞাসা করুন, সম্ভব হলে শেষ হওয়া একটি প্রকল্প গিয়ে দেখুন।",
                "তৈরি নাকি নির্মাণাধীন? নির্মাণাধীন হলে হস্তান্তরের তারিখ এবং দেরি হলে কী হবে—তা লেখা সই করা চুক্তি নিন।",
                "{authority_bn}-এর অনুমোদিত নকশা, স্ট্রাকচারাল ডিজাইন ও সয়েল টেস্টের কাগজ দেখতে চান, আর লিফট, জরুরি বের হওয়ার পথ, পার্কিং ও কমন এলাকা নিজে দেখুন।",
                "মালিক কমিটি কীভাবে চলে জেনে নিন: সার্ভিস চার্জ কত এবং লিফট, জেনারেটর ও নিরাপত্তা কে দেখে।",
                "টাকা দেওয়ার আগে রেজিস্ট্রেশন খরচ ও অন্যান্য ফি লিখিতভাবে বুঝে নিন, এবং প্রতিটি কিস্তি ব্যাংকের মাধ্যমে দিয়ে রশিদ রাখুন।",
            ],
            'faq' => [
                ["Should I buy a ready apartment or an under-construction one in {city}?", "A ready apartment lets you see exactly what you are buying and move in sooner. An under-construction apartment can cost less up front but carries delay risk, so check the developer's record and sign a clear agreement with a handover date.",
                 "{city_in} তৈরি নাকি নির্মাণাধীন অ্যাপার্টমেন্ট কেনা ভালো?", "তৈরি অ্যাপার্টমেন্টে কী কিনছেন সরাসরি দেখা যায় এবং দ্রুত ওঠা যায়। নির্মাণাধীনে শুরুতে খরচ কম হতে পারে কিন্তু দেরির ঝুঁকি থাকে, তাই ডেভেলপারের রেকর্ড দেখে হস্তান্তরের তারিখসহ স্পষ্ট চুক্তি করুন।"],
                ["What does an apartment owners' committee do?", "It manages the building after handover: it collects the service charge and looks after the lift, generator, security and common areas. Ask for the monthly charge before you buy.",
                 "অ্যাপার্টমেন্ট মালিক কমিটি কী করে?", "হস্তান্তরের পর ভবনটি পরিচালনা করে: সার্ভিস চার্জ তোলে এবং লিফট, জেনারেটর, নিরাপত্তা ও কমন এলাকা দেখে। কেনার আগে মাসিক চার্জ জিজ্ঞাসা করুন।"],
            ],
        ],
        'land' => [
            'en' => 'Land', 'bn' => 'জমি', 'cat' => ['real-estate', 'land'], 'icon' => '🏞️',
            'lead' => "Browse land and plots for sale in {city}. Compare listings from sellers on SaleBari, check the details, and message the seller directly on WhatsApp or by phone.",
            'lead_bn' => "{city_in} জমি ও প্লট বিক্রির তালিকা দেখুন। SaleBari-র বিক্রেতাদের বিজ্ঞাপন তুলনা করুন, বিবরণ দেখুন এবং সরাসরি হোয়াটসঅ্যাপ বা ফোনে যোগাযোগ করুন।",
            'tips_title' => 'Before you buy land in {city}',
            'tips_title_bn' => '{city_in} জমি কেনার আগে যা দেখবেন',
            'tips' => [
                "Check the khatian records and the mouza and dag numbers, and match them with the seller's deed. The government e-Porcha and e-Mutation services let you verify records online.",
                "Trace the chain of ownership and confirm the seller is the lawful owner and the mutation (নামজারি) is in their name.",
                "Visit the plot with the dag number. Check the boundary, the access road, flooding, and the land type: agricultural land, for example, can have rules about building on it.",
                "Ask a lawyer to search the deed at the sub-registry office and to check for any dispute, mortgage or court case.",
                "Have the land measured by a surveyor, pay by traceable bank transfer with receipts, register promptly and apply for mutation after you buy.",
            ],
            'tips_bn' => [
                "খতিয়ান, মৌজা ও দাগ নম্বর দেখুন এবং বিক্রেতার দলিলের সাথে মিলিয়ে নিন। সরকারের ই-পর্চা ও ই-নামজারি সেবায় অনলাইনে রেকর্ড যাচাই করা যায়।",
                "মালিকানার ধারাবাহিকতা দেখুন এবং নিশ্চিত হোন বিক্রেতাই বৈধ মালিক ও নামজারি তার নামে আছে।",
                "দাগ নম্বর নিয়ে নিজে জমি দেখুন। সীমানা, যাতায়াতের রাস্তা, জলাবদ্ধতা ও জমির শ্রেণি দেখুন: যেমন কৃষিজমিতে ভবন তৈরির নিয়ম থাকতে পারে।",
                "সাব-রেজিস্ট্রি অফিসে দলিল অনুসন্ধান এবং কোনো বিরোধ, বন্ধক বা মামলা আছে কি না তা আইনজীবীকে দিয়ে দেখিয়ে নিন।",
                "সার্ভেয়ার দিয়ে জমি মাপান, ব্যাংকের মাধ্যমে টাকা দিয়ে রশিদ রাখুন, দ্রুত রেজিস্ট্রি করুন এবং কেনার পর নামজারির আবেদন করুন।",
            ],
            'faq' => [
                ["How can I check that land in {city} has no dispute?", "Ask a lawyer to search the deed and the record history at the sub-registry office, compare the khatian with the seller's papers, and check for any mortgage or court case. Visiting the neighbours and the local land office also helps.",
                 "{city_in} জমিতে কোনো বিরোধ নেই কীভাবে নিশ্চিত হব?", "আইনজীবীকে দিয়ে সাব-রেজিস্ট্রি অফিসে দলিল ও রেকর্ডের ইতিহাস অনুসন্ধান করান, খতিয়ান বিক্রেতার কাগজের সাথে মেলান এবং কোনো বন্ধক বা মামলা আছে কি না দেখুন। প্রতিবেশী ও স্থানীয় ভূমি অফিসে খোঁজ নেওয়াও কাজে দেয়।"],
                ["What is the difference between a plot and agricultural land?", "A plot is land set aside for a house or building, usually in a planned or residential area. Agricultural land is classed for farming and can have rules about changing its use, so ask what the land is classed as before you buy.",
                 "প্লট আর কৃষিজমির পার্থক্য কী?", "প্লট সাধারণত পরিকল্পিত বা আবাসিক এলাকায় বাড়ি বা ভবন করার জন্য রাখা জমি। কৃষিজমি চাষের জন্য শ্রেণিভুক্ত এবং ব্যবহার বদলাতে নিয়ম থাকতে পারে, তাই কেনার আগে জমির শ্রেণি জিজ্ঞাসা করুন।"],
            ],
        ],
    ];
}

function property_locations(): array
{
    return [
        'dhaka' => [
            'name' => 'Dhaka', 'bn' => 'ঢাকা', 'bn_in' => 'ঢাকায়', 'district' => 'dhaka',
            'authority' => 'RAJUK (Rajdhani Unnayan Kartripakkha)', 'authority_bn' => 'রাজউক',
            'areas' => ['Uttara', 'Bashundhara R/A', 'Mirpur', 'Mohammadpur', 'Dhanmondi', 'Gulshan', 'Banani', 'Badda', 'Rampura', 'Purbachal', 'Savar', 'Keraniganj'],
            'blurb' => "Dhaka is Bangladesh's capital and its largest property market. Buyers look across established neighbourhoods such as Dhanmondi, Mohammadpur and Mirpur, planned residential areas such as Uttara and Bashundhara R/A, and newer or outer areas such as Purbachal, Savar and Keraniganj, which usually trade space and travel time against price.",
            'blurb_bn' => "ঢাকা দেশের রাজধানী এবং সবচেয়ে বড় সম্পত্তির বাজার। ক্রেতারা ধানমন্ডি, মোহাম্মদপুর ও মিরপুরের মতো পুরোনো এলাকা, উত্তরা ও বসুন্ধরার মতো পরিকল্পিত আবাসিক এলাকা এবং পূর্বাচল, সাভার ও কেরানীগঞ্জের মতো নতুন বা শহরতলির এলাকায় খোঁজেন, যেখানে সাধারণত দামের বিনিময়ে বেশি জায়গা পাওয়া যায় কিন্তু যাতায়াতে সময় বেশি লাগে।",
        ],
        'chittagong' => [
            'name' => 'Chittagong', 'alt' => 'Chattogram', 'bn' => 'চট্টগ্রাম', 'bn_in' => 'চট্টগ্রামে', 'district' => 'chattogram',
            'authority' => 'CDA (Chittagong Development Authority)', 'authority_bn' => 'সিডিএ (চট্টগ্রাম উন্নয়ন কর্তৃপক্ষ)',
            'areas' => ['Khulshi', 'GEC Circle', 'Panchlaish', 'Agrabad', 'Halishahar', 'Nasirabad', 'Chandgaon', 'Patenga', 'Bayezid', 'Pahartali', 'Bakalia', 'Kotwali'],
            'blurb' => "Chittagong (Chattogram) is Bangladesh's port city and its second largest city, with hills, the Karnaphuli river and the sea close to town. Popular residential areas include Khulshi, GEC Circle, Panchlaish and Nasirabad, while Agrabad is the main commercial centre and Halishahar and Patenga are favoured for more space.",
            'blurb_bn' => "চট্টগ্রাম দেশের বন্দরনগরী ও দ্বিতীয় বৃহত্তম শহর, যেখানে পাহাড়, কর্ণফুলী নদী ও সমুদ্র শহরের কাছেই। খুলশী, জিইসি সার্কেল, পাঁচলাইশ ও নাসিরাবাদ জনপ্রিয় আবাসিক এলাকা; আগ্রাবাদ প্রধান বাণিজ্যিক কেন্দ্র, আর বেশি জায়গার জন্য হালিশহর ও পতেঙ্গা পছন্দ করেন অনেকে।",
        ],
        'feni' => [
            'name' => 'Feni', 'bn' => 'ফেনী', 'bn_in' => 'ফেনীতে', 'district' => 'feni',
            'authority' => 'the local pourashava (municipality)', 'authority_bn' => 'স্থানীয় পৌরসভা',
            'areas' => ['Feni Sadar', 'Trunk Road', 'Mohipal', 'Chhagalnaiya', 'Sonagazi', 'Fulgazi', 'Daganbhuiyan', 'Parshuram'],
            'blurb' => "Feni is a district town in the south-east, on the Dhaka–Chittagong highway and railway line, which keeps both cities within easy reach. Buyers look for flats in and around Feni Sadar and the Trunk Road area, and for land and plots in upazilas such as Chhagalnaiya, Sonagazi, Fulgazi, Daganbhuiyan and Parshuram.",
            'blurb_bn' => "ফেনী দক্ষিণ-পূর্বের একটি জেলা শহর, ঢাকা–চট্টগ্রাম মহাসড়ক ও রেললাইনের ওপর, তাই দুই শহরই কাছে। ক্রেতারা ফেনী সদর ও ট্রাংক রোড এলাকায় ফ্ল্যাট এবং ছাগলনাইয়া, সোনাগাজী, ফুলগাজী, দাগনভূঞা ও পরশুরামের মতো উপজেলায় জমি ও প্লট খোঁজেন।",
        ],
    ];
}

/** Shared answers that do not depend on the property type. */
function property_common_faq(): array
{
    return [
        ["Can I contact the seller directly?", "Yes. Every listing has WhatsApp and Call buttons. SaleBari does not take payment for property, so you agree the price and payment directly with the seller. Never pay in advance to someone you have not met.",
         "আমি কি সরাসরি বিক্রেতার সাথে যোগাযোগ করতে পারি?", "হ্যাঁ। প্রতিটি বিজ্ঞাপনে হোয়াটসঅ্যাপ ও কল বাটন আছে। SaleBari সম্পত্তির জন্য কোনো টাকা নেয় না, তাই দাম ও পেমেন্ট সরাসরি বিক্রেতার সাথে ঠিক করুন। যার সাথে দেখা হয়নি তাকে অগ্রিম টাকা পাঠাবেন না।"],
        ["How can I list my property for sale?", "Open a seller account on the Sell page, or message us on WhatsApp and we will help you add your listing. New listings are reviewed by the SaleBari team before they go live.",
         "আমার সম্পত্তি বিক্রির জন্য কীভাবে দেব?", "Sell পেজে সেলার অ্যাকাউন্ট খুলুন, অথবা হোয়াটসঅ্যাপে মেসেজ করুন, আমরা বিজ্ঞাপন দিতে সাহায্য করব। নতুন বিজ্ঞাপন লাইভ হওয়ার আগে SaleBari টিম পর্যালোচনা করে।"],
    ];
}

/* ---------- URLs ---------- */

function property_url(?string $type = null, ?string $city = null): string
{
    $b = base_path();
    if (!$type) {
        return $b . '/property-for-sale/';
    }
    return $b . '/' . $type . '-for-sale' . ($city ? '-in-' . $city : '') . '/';
}

/** {city}, {city_in}, {authority} ... filled in. */
function property_fill(string $text, ?array $loc, bool $bn = false): string
{
    if ($loc) {
        return strtr($text, [
            '{city}' => $loc['name'], '{city_in}' => $loc['bn_in'],
            '{authority}' => $loc['authority'], '{authority_bn}' => $loc['authority_bn'],
        ]);
    }
    return strtr($text, [
        '{city}' => 'Bangladesh', '{city_in}' => 'বাংলাদেশে',
        '{authority}' => 'the relevant authority (RAJUK in Dhaka, CDA in Chittagong, the local pourashava elsewhere)',
        '{authority_bn}' => 'সংশ্লিষ্ট কর্তৃপক্ষ (ঢাকায় রাজউক, চট্টগ্রামে সিডিএ, অন্য জায়গায় স্থানীয় পৌরসভা)',
    ]);
}

/* ---------- listings ---------- */

function property_category(string $type): ?array
{
    $t = property_types()[$type] ?? null;
    return $t ? find_category_by_path($t['cat']) : null;
}

function property_category_ids(array $cat): array
{
    $ids      = [(int) $cat['id']];
    $frontier = $ids;
    for ($d = 0; $d < 3 && $frontier; $d++) {
        $in       = implode(',', array_fill(0, count($frontier), '?'));
        $frontier = array_map('intval', array_column(rows("SELECT id FROM categories WHERE parent_id IN ($in)", $frontier), 'id'));
        $ids      = array_merge($ids, $frontier);
    }
    return $ids;
}

/**
 * Active products for sale (not rent) in a category, optionally in one district.
 * Returns ['rows' => [...], 'total' => n, 'pg' => paginate()].
 */
function property_listings(array $cat, ?string $districtSlug, int $perPage = 12, int $page = 1): array
{
    $ids  = property_category_ids($cat);
    $in   = implode(',', array_fill(0, count($ids), '?'));
    $expr = "COALESCE(NULLIF(p.city, ''), s.city)";
    $from = "FROM products p LEFT JOIN stalls s ON s.id = p.stall_id WHERE p.status = 'active' AND p.category_id IN ($in) AND (p.deal_type IS NULL OR p.deal_type <> 'rent')";
    $params = $ids;
    if ($districtSlug) {
        $raw = [];
        foreach (rows("SELECT DISTINCT $expr AS c $from", $ids) as $r) {
            $d = district_for($r['c']);
            if ($d && $d['slug'] === $districtSlug) {
                $raw[] = $r['c'];
            }
        }
        if (!$raw) {
            return ['rows' => [], 'total' => 0, 'pg' => paginate(0, $perPage, 1)];
        }
        $from  .= " AND $expr IN (" . implode(',', array_fill(0, count($raw), '?')) . ')';
        $params = array_merge($params, $raw);
    }
    $total = (int) scalar("SELECT COUNT(*) $from", $params);
    $pg    = paginate($total, $perPage, $page);
    $rows  = rows("SELECT p.* $from ORDER BY p.id DESC LIMIT " . $pg['per'] . ' OFFSET ' . $pg['offset'], $params);
    return ['rows' => $rows, 'total' => $total, 'pg' => $pg];
}

function property_card_html(array $p, string $icon): string
{
    $imgs = json_decode((string) $p['images'], true) ?: [];
    $h  = '<div class="card-wrap"><a class="listing-card" href="' . e(product_url($p)) . '"><div class="listing-card-media">' . stock_card_badge($p);
    $h .= $imgs ? '<img src="' . e(asset($imgs[0])) . '" alt="' . e($p['title_en']) . '" loading="lazy">' : e($icon);
    $h .= '</div><div class="listing-card-body"><h3 class="listing-card-title">' . e($p['title_en']) . '</h3>';
    if ($p['price_display']) {
        $h .= '<div class="listing-card-price">' . e($p['price_display']) . '</div>';
    }
    $h .= '</div></a><button type="button" class="wish-btn" data-wish="' . (int) $p['id'] . '" aria-pressed="false" aria-label="Save this listing"><span class="wish-ico">♡</span></button></div>';
    return $h;
}

/** Links to every property page, for the footer, the Real Estate category pages and the hub. */
function property_links_html(string $class = 'chip-row'): string
{
    $h = '<div class="' . e($class) . '">';
    foreach (property_types() as $tk => $t) {
        foreach (property_locations() as $ck => $c) {
            $h .= '<a class="chip" href="' . e(property_url($tk, $ck)) . '">' . e($t['en'] . ' for Sale in ' . $c['name']) . '</a>';
        }
    }
    return $h . '</div>';
}

/** Every property page's address, for the sitemap. */
function property_all_paths(): array
{
    $paths = [property_url()];
    foreach (property_types() as $tk => $t) {
        $paths[] = property_url($tk);
        foreach (property_locations() as $ck => $c) {
            $paths[] = property_url($tk, $ck);
        }
    }
    return $paths;
}
