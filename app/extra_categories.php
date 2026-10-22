<?php
/* Categories added after the first release (Travels, Jobs). One definition, used both by the
   installer for new sites and by a one-time update for sites that are already live. */

/** key => [parent key or null, English name, Bangla name, icon, optional URL name] — parents are listed before their children. */
function extra_category_definitions(): array
{
    return [
        'travels'            => [null,      'Travels',                    'ভ্রমণ',                       '✈️'],
        'airTicket'          => ['travels', 'Air Ticket',                 'এয়ার টিকেট',                  '✈️'],
        'busTicket'          => ['travels', 'Bus Ticket',                 'বাস টিকেট',                   '🚌'],
        'tourPackage'        => ['travels', 'Tour Package',               'ট্যুর প্যাকেজ',               '🧳'],
        'umrahPackage'       => ['travels', 'Umrah Package',              'ওমরাহ প্যাকেজ',               '🕋'],
        'hajjPackage'        => ['travels', 'Hajj Package',               'হজ্জ প্যাকেজ',                '🕌'],
        'hotelBooking'       => ['travels', 'Hotel Booking',              'হোটেল বুকিং',                 '🏨'],
        'visaProcessing'     => ['travels', 'Visa Processing',            'ভিসা প্রসেসিং',               '🛂'],
        'doctorAppointment'  => ['travels', 'Doctor Appointment',         'ডাক্তার অ্যাপয়েন্টমেন্ট',     '🩺'],
        'indianDoctorAppointment' => ['doctorAppointment', 'Indian Doctor Appointment', 'ভারতীয় ডাক্তার অ্যাপয়েন্টমেন্ট', '🩺'],
        'trainTicket'        => ['travels', 'Train Ticket',               'ট্রেন টিকেট',                 '🚆'],
        'saintMartinShipTicket' => ['travels', 'Saint Martin Ship Ticket', 'সেন্ট মার্টিন শিপ টিকেট',    '🚢'],
        'jobs'               => [null,      'Jobs',                       'চাকরি',                        '💼'],

        // Household
        'household'          => [null,      'Household',                  'গৃহস্থালি',                    '🏠'],
        'furniture' => ['household', 'Furniture', 'ফার্নিচার', '🛋️'],
        'furnitureBed' => ['furniture', 'Bed', 'খাট', '🛏️'],
        'furnitureBedsideTable' => ['furniture', 'Bedside Table', 'বেডসাইড টেবিল', '🛏️'],
        'furnitureAirBed' => ['furniture', 'Air Bed', 'এয়ার বেড', '🛏️'],
        'furnitureDiningTable' => ['furniture', 'Dining Table', 'ডাইনিং টেবিল', '🍽️'],
        'furnitureDiningChair' => ['furniture', 'Dining Chair', 'ডাইনিং চেয়ার', '🪑'],
        'furnitureSofaSet' => ['furniture', 'Sofa Set', 'সোফা সেট', '🛋️'],
        'furnitureCenterTable' => ['furniture', 'Center Table', 'সেন্টার টেবিল', '🪑'],
        'furnitureDivan' => ['furniture', 'Divan', 'দিওয়ান', '🛋️'],
        'furnitureDressingTable' => ['furniture', 'Dressing Table', 'ড্রেসিং টেবিল', '🪞'],
        'furnitureShowcase' => ['furniture', 'Showcase', 'শোকেস', '🗄️'],
        'furnitureShelf' => ['furniture', 'Shelf', 'শেলফ', '📚'],
        'furnitureWardrobe' => ['furniture', 'Wardrobe', 'ওয়ারড্রব', '🚪'],
        'furnitureAlmirah' => ['furniture', 'Almirah', 'আলমারি', '🗄️'],
        'furnitureTrolley' => ['furniture', 'Trolley', 'ট্রলি', '🛒'],
        'furnitureStool' => ['furniture', 'Stool', 'টুল', '🪑'],
        'furnitureFurnitureSet' => ['furniture', 'Furniture Set', 'ফার্নিচার সেট', '🛋️', 'furniture-set'],
        'furnitureKitchenFurniture' => ['furniture', 'Kitchen Furniture', 'কিচেন ফার্নিচার', '🍳'],
        'furnitureShoeRack' => ['furniture', 'Shoe Rack', 'জুতার র‍্যাক', '👟'],
        'officeFurniture' => ['household', 'Office Furniture', 'অফিস ফার্নিচার', '🏢'],
        'officeFurnitureOfficeTable' => ['officeFurniture', 'Office Table', 'অফিস টেবিল', '🪑', 'office-table'],
        'officeFurnitureChair' => ['officeFurniture', 'Chair', 'চেয়ার', '💺'],
        'officeFurnitureDisplayRack' => ['officeFurniture', 'Display Rack', 'ডিসপ্লে র‍্যাক', '🗄️'],
        'bedding' => ['household', 'Bedding', 'বিছানাপত্র', '🛏️'],
        'beddingBedSheet' => ['bedding', 'Bed Sheet', 'বেডশিট', '🛏️'],
        'beddingMosquitoNet' => ['bedding', 'Mosquito Net', 'মশারি', '🦟'],
        'beddingMattress' => ['bedding', 'Mattress', 'ম্যাট্রেস', '🛏️'],
        'beddingPillow' => ['bedding', 'Pillow', 'বালিশ', '🛌'],
        'beddingCushion' => ['bedding', 'Cushion', 'কুশন', '🛋️'],
        'beddingSofaFoam' => ['bedding', 'Sofa Foam', 'সোফা ফোম', '🛋️'],
        'beddingBlanket' => ['bedding', 'Blanket', 'কম্বল', '🧣'],
        'decoration' => ['household', 'Decoration', 'ডেকোরেশন', '🖼️'],
        'decorationCurtain' => ['decoration', 'Curtain', 'পর্দা', '🪟'],
        'decorationFloorMat' => ['decoration', 'Floor Mat', 'ফ্লোর ম্যাট', '🟫'],
        'decorationInteriorDesign' => ['decoration', 'Interior Design', 'ইন্টেরিয়র ডিজাইন', '🏠'],
        'decorationShowpiece' => ['decoration', 'Showpiece', 'শোপিস', '🏺'],
        'decorationMirror' => ['decoration', 'Mirror', 'আয়না', '🪞'],
        'decorationDoor' => ['decoration', 'Door', 'দরজা', '🚪'],
        'decorationTiles' => ['decoration', 'Tiles', 'টাইলস', '🧱'],
        'decorationDecorAccessories' => ['decoration', 'Decor Accessories', 'ডেকর অ্যাক্সেসরিজ', '🏮'],
        'decorationOrganizer' => ['decoration', 'Organizer', 'অর্গানাইজার', '🗃️'],
        'furnitureAccessories' => ['household', 'Furniture Accessories', 'ফার্নিচার অ্যাক্সেসরিজ', '🔩'],
        'householdCleaner' => ['household', 'Household Cleaner', 'গৃহস্থালি ক্লিনার', '🧹'],
        'householdCleanerMop' => ['householdCleaner', 'Mop', 'মোপ', '🧹'],
        'householdCleanerHosePipe' => ['householdCleaner', 'Hose Pipe', 'হোস পাইপ', '🚿'],
        'householdCleanerFloorCleaner' => ['householdCleaner', 'Floor Cleaner', 'ফ্লোর ক্লিনার', '🧴'],
        'householdCleanerGlassCleaner' => ['householdCleaner', 'Glass Cleaner', 'গ্লাস ক্লিনার', '🧴'],
        'householdCleanerAirFreshener' => ['householdCleaner', 'Air Freshener', 'এয়ার ফ্রেশনার', '🌸'],
        'householdCleanerBasket' => ['householdCleaner', 'Basket', 'ঝুড়ি', '🧺'],
        'pestControl' => ['household', 'Pest Control', 'পেস্ট কন্ট্রোল', '🪲'],
        'pestControlMosquitoKiller' => ['pestControl', 'Mosquito Killer', 'মশা মারার পণ্য', '🦟'],
        'pestControlPestControlService' => ['pestControl', 'Pest Control Service', 'পেস্ট কন্ট্রোল সার্ভিস', '🛠️', 'pest-control-service'],
        'kitchenware' => ['household', 'Kitchenware', 'কিচেনওয়্যার', '🍳'],
        'kitchenwareCrockeries' => ['kitchenware', 'Crockeries', 'ক্রোকারিজ', '🍽️'],
        'kitchenwareVegetableCutter' => ['kitchenware', 'Vegetable Cutter', 'সবজি কাটার যন্ত্র', '🥕'],
        'kitchenwareFryPan' => ['kitchenware', 'Fry Pan', 'ফ্রাই প্যান', '🍳'],
        'kitchenwareKorai' => ['kitchenware', 'Korai', 'কড়াই', '🍲'],
        'kitchenwarePressureCooker' => ['kitchenware', 'Pressure Cooker', 'প্রেসার কুকার', '🍲'],
        'kitchenwareCupMug' => ['kitchenware', 'Cup & Mug', 'কাপ ও মগ', '☕'],
        'kitchenwareWaterBottle' => ['kitchenware', 'Water Bottle', 'পানির বোতল', '🍶'],
        'kitchenwareKitchenKnife' => ['kitchenware', 'Kitchen Knife', 'কিচেন নাইফ', '🔪'],
        'stationeryCraft' => ['household', 'Stationery & Craft', 'স্টেশনারি ও ক্রাফট', '✏️'],
        'stationeryCraftPaperNotebook' => ['stationeryCraft', 'Paper Notebook', 'পেপার নোটবুক', '📓'],
        'stationeryCraftWrappingPaper' => ['stationeryCraft', 'Wrapping Paper', 'র‍্যাপিং পেপার', '🎁'],
        'stationeryCraftStapler' => ['stationeryCraft', 'Stapler', 'স্ট্যাপলার', '📎'],
        'stationeryCraftScotchTape' => ['stationeryCraft', 'Scotch Tape', 'স্কচ টেপ', '📼'],
        'stationeryCraftPen' => ['stationeryCraft', 'Pen', 'কলম', '🖊️'],
        'stationeryCraftMeasuringTape' => ['stationeryCraft', 'Measuring Tape', 'মাপার ফিতা', '📏'],
        'bathroomAccessories' => ['household', 'Bathroom Accessories', 'বাথরুম অ্যাক্সেসরিজ', '🚿'],
        'bathroomAccessoriesToiletSeat' => ['bathroomAccessories', 'Toilet Seat', 'টয়লেট সিট', '🚽'],
    ];
}

/** Insert any of the above that are missing. Safe to run more than once. */
function add_extra_categories(): void
{
    $ids = [];
    foreach (extra_category_definitions() as $key => $def) {
        [$parentKey, $nameEn, $nameBn, $icon] = $def;
        $urlName = $def[4] ?? null;
        $existing = row('SELECT id FROM categories WHERE slug = ?', [$key]);
        if ($existing) {
            $ids[$key] = (int) $existing['id'];
            continue;
        }
        $parentId = $parentKey ? ($ids[$parentKey] ?? null) : null;
        if ($parentKey && !$parentId) {
            continue;
        }
        $level = $parentKey ? ((int) scalar('SELECT level FROM categories WHERE id = ?', [$parentId]) + 1) : 1;
        $order = (int) scalar('SELECT COUNT(*) FROM categories WHERE ' . ($parentId ? 'parent_id = ?' : 'parent_id IS NULL'), $parentId ? [$parentId] : []);
        $ids[$key] = insert('categories', [
            'parent_id'      => $parentId,
            'level'          => $level,
            'slug'           => $key,
            'name_en'        => $nameEn,
            'name_bn'        => $nameBn,
            'icon'           => $icon,
            'count_label_en' => null,
            'count_label_bn' => null,
            'featured'       => $level === 1 ? 1 : 0,
            'sort_order'     => $order,
            'url_slug'       => $urlName,   // null = made automatically from the name
            'created_at'     => now(),
        ]);
    }
}

/** Once, on sites that were installed before these categories existed. */
function ensure_extra_categories(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'extra_cats_v2'")) {
            return;
        }
        if ((int) scalar('SELECT COUNT(*) FROM categories') === 0) {
            return; // fresh install: the seeder adds them
        }
        add_extra_categories();
        insert('settings', ['k' => 'extra_cats_v2', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_extra_categories: ' . $e->getMessage());
    }
}

/** One relevant icon per sub category and sub sub category (slug => emoji). */
function category_icon_map(): array
{
    return [
        // --- Car & Bike
        'carAccessories' => '🚘', 'bikeAccessories' => '🏍️', 'threeWheeler' => '🛺', 'commercialVehicle' => '🚛', 'rental' => '🔑',
        'carScratchRemover' => '🧽', 'engineOil' => '🛢️', 'carScanner' => '📟', 'dashcam' => '📹',
        'motorcycleHelmet' => '⛑️', 'motorcycleTyre' => '⭕',
        'cng' => '⛽', 'autoRickshaw' => '🛺',
        'boat' => '🚤', 'truck' => '🚚', 'tractor' => '🚜', 'bus' => '🚌',
        'pickupRental' => '🚙', 'ambulanceService' => '🚑',
        // --- Real Estate
        'apartment' => '🏢', 'land' => '🏞️', 'commercialSpace' => '🏬', 'sanitary' => '🚽', 'constructionMaterial' => '🧱',
        'commode' => '🚽', 'basin' => '🚰', 'waterTap' => '💧',
        'cement' => '📦', 'sand' => '🏖️', 'stone' => '⛰️', 'brick' => '🧱', 'rod' => '📏', 'constructionEquipment' => '🏗️',
        // --- Agro
        'livestock' => '🐄', 'fish' => '🐟', 'poultry' => '🐔', 'birds' => '🕊️',
        'cow' => '🐄', 'goat' => '🐐', 'buffalo' => '🐃',
        'rui' => '🐟', 'katla' => '🐠', 'tilapia' => '🐡', 'pangas' => '🐟', 'otherFish' => '🦐',
        'chicken' => '🐔', 'duck' => '🦆', 'pigeon' => '🕊️', 'otherPermittedBirds' => '🦜',
        // --- Travels
        'airTicket' => '✈️', 'busTicket' => '🚌', 'tourPackage' => '🧳', 'umrahPackage' => '🕋', 'hajjPackage' => '🕌',
        'hotelBooking' => '🏨', 'visaProcessing' => '🛂', 'doctorAppointment' => '🩺', 'trainTicket' => '🚆', 'saintMartinShipTicket' => '🚢',
        'indianDoctorAppointment' => '👨‍⚕️',
        // --- Household
        'furniture' => '🛋️', 'officeFurniture' => '🗄️', 'bedding' => '🛏️', 'decoration' => '🖼️', 'furnitureAccessories' => '🔩',
        'householdCleaner' => '🧹', 'pestControl' => '🐜', 'kitchenware' => '🍳', 'stationeryCraft' => '✏️', 'bathroomAccessories' => '🚿',
        'furnitureBed' => '🛏️', 'furnitureBedsideTable' => '🕯️', 'furnitureAirBed' => '🎈', 'furnitureDiningTable' => '🍽️',
        'furnitureDiningChair' => '🪑', 'furnitureSofaSet' => '🛋️', 'furnitureCenterTable' => '☕', 'furnitureDivan' => '🛌',
        'furnitureDressingTable' => '💄', 'furnitureShowcase' => '🏺', 'furnitureShelf' => '📚', 'furnitureWardrobe' => '👗',
        'furnitureAlmirah' => '🗄️', 'furnitureTrolley' => '🛒', 'furnitureStool' => '🪑', 'furnitureFurnitureSet' => '🏡',
        'furnitureKitchenFurniture' => '🍴', 'furnitureShoeRack' => '👟',
        'officeFurnitureOfficeTable' => '🖥️', 'officeFurnitureChair' => '💺', 'officeFurnitureDisplayRack' => '🛍️',
        'beddingBedSheet' => '🛏️', 'beddingMosquitoNet' => '🦟', 'beddingMattress' => '🛌', 'beddingPillow' => '💤',
        'beddingCushion' => '🟦', 'beddingSofaFoam' => '🧽', 'beddingBlanket' => '🧣',
        'decorationCurtain' => '🎭', 'decorationFloorMat' => '🟫', 'decorationInteriorDesign' => '📐', 'decorationShowpiece' => '🏺',
        'decorationMirror' => '🪞', 'decorationDoor' => '🚪', 'decorationTiles' => '⬜', 'decorationDecorAccessories' => '🏮',
        'decorationOrganizer' => '🗃️',
        'householdCleanerMop' => '🧹', 'householdCleanerHosePipe' => '🚿', 'householdCleanerFloorCleaner' => '🧴',
        'householdCleanerGlassCleaner' => '🧼', 'householdCleanerAirFreshener' => '🌸', 'householdCleanerBasket' => '🧺',
        'pestControlMosquitoKiller' => '🦟', 'pestControlPestControlService' => '🛠️',
        'kitchenwareCrockeries' => '🍽️', 'kitchenwareVegetableCutter' => '🥕', 'kitchenwareFryPan' => '🍳', 'kitchenwareKorai' => '🥘',
        'kitchenwarePressureCooker' => '🍲', 'kitchenwareCupMug' => '☕', 'kitchenwareWaterBottle' => '🥤', 'kitchenwareKitchenKnife' => '🔪',
        'stationeryCraftPaperNotebook' => '📓', 'stationeryCraftWrappingPaper' => '🎁', 'stationeryCraftStapler' => '📎',
        'stationeryCraftScotchTape' => '🩹', 'stationeryCraftPen' => '🖊️', 'stationeryCraftMeasuringTape' => '📏',
        'bathroomAccessoriesToiletSeat' => '🚽',
    ];
}

/** Give every sub / sub sub category its own relevant icon (once; edit icons in Admin afterwards). */
function ensure_category_icons(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'cat_icons_v2'")) {
            return;
        }
        if ((int) scalar('SELECT COUNT(*) FROM categories') === 0) {
            return;
        }
        foreach (category_icon_map() as $slug => $icon) {
            update('categories', ['icon' => $icon], 'slug = ?', [$slug]);
        }
        insert('settings', ['k' => 'cat_icons_v2', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_category_icons: ' . $e->getMessage());
    }
}
