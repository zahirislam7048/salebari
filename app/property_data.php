<?php
/* Content and structure for the extra property pages:
     size pages      /flat-for-sale-under-1000-sqft/   /3-bedroom-flat-for-sale/   /5-katha-plot-for-sale/
     Dhaka areas     /flat-for-sale-in-gulshan/   /apartment-for-sale-in-dhanmondi/   /land-for-sale-in-purbachal/
     comparisons     /compare-locations/gulshan-vs-dhanmondi/   /compare-locations/dhaka-vs-feni/

   Everything here is general, qualitative guidance. There are no prices, no price-per-sqft figures and no
   statistics: those change every month and would go stale or be wrong. Real numbers on the pages (listing
   counts, listing prices) come from the live database. Each text is [English, Bangla]. */

/* ===================================================================================== */
/*  Dhaka areas                                                                          */
/* ===================================================================================== */

function property_attr_labels(): array
{
    return [
        'tier'      => ['Price level (general)', 'দামের স্তর (সাধারণ)'],
        'character' => ['Feel of the area', 'এলাকার ধরন'],
        'homes'     => ['Typical homes', 'সাধারণ বাসা'],
        'land'      => ['Plots and land', 'প্লট ও জমি'],
        'access'    => ['Getting around', 'যাতায়াত'],
        'life'      => ['Everyday facilities', 'দৈনন্দিন সুবিধা'],
        'best'      => ['Best suited to', 'যাদের জন্য ভালো'],
        'watch'     => ['Keep in mind', 'মনে রাখুন'],
    ];
}

function property_tier_labels(): array
{
    return [
        4 => ['Among the highest in Dhaka', 'ঢাকার সর্বোচ্চ দামের মধ্যে'],
        3 => ['Upper-mid to high', 'মধ্য-উচ্চ থেকে উচ্চ'],
        2 => ['Mid-range', 'মধ্যম'],
        1 => ['Lower, still developing', 'তুলনামূলক কম, এখনো গড়ে উঠছে'],
    ];
}

function property_areas(): array
{
    return [
        'gulshan' => [
            'name' => 'Gulshan', 'bn' => 'গুলশান', 'bn_in' => 'গুলশানে', 'match' => ['gulshan'], 'tier' => 4,
            'types' => ['flat', 'apartment'], 'neighbors' => ['banani', 'baridhara', 'badda'],
            'blurb' => ["Gulshan is one of Dhaka's best-known upscale neighbourhoods, split into Gulshan 1 and Gulshan 2 around the Gulshan Avenue commercial strip and Gulshan Lake. It has many embassies, offices, restaurants and clubs, and most homes are premium apartments.",
                        "গুলশান ঢাকার সবচেয়ে পরিচিত অভিজাত এলাকাগুলোর একটি; গুলশান অ্যাভিনিউ ও গুলশান লেককে ঘিরে গুলশান-১ ও গুলশান-২। এখানে অনেক দূতাবাস, অফিস, রেস্তোরাঁ ও ক্লাব আছে এবং বেশিরভাগ বাসাই প্রিমিয়াম অ্যাপার্টমেন্ট।"],
            'attrs' => [
                'character' => ['Upscale, commercial and diplomatic', 'অভিজাত, বাণিজ্যিক ও কূটনৈতিক'],
                'homes'     => ['Mostly premium apartments, plus some older houses', 'বেশিরভাগ প্রিমিয়াম অ্যাপার্টমেন্ট, সাথে কিছু পুরোনো বাড়ি'],
                'land'      => ['Plots are rare and usually very costly', 'প্লট কম পাওয়া যায় এবং সাধারণত অনেক ব্যয়বহুল'],
                'access'    => ['Gulshan Avenue and Progoti Sarani; close to Banani and the airport road', 'গুলশান অ্যাভিনিউ ও প্রগতি সরণি; বনানী ও বিমানবন্দর সড়কের কাছে'],
                'life'      => ['Embassies, offices, hospitals, malls, restaurants and clubs close by', 'দূতাবাস, অফিস, হাসপাতাল, মল, রেস্তোরাঁ ও ক্লাব কাছেই'],
                'best'      => ['Buyers who want a prestigious address in north-central Dhaka and can pay a premium', 'যারা উত্তর-মধ্য ঢাকায় মর্যাদাপূর্ণ ঠিকানা চান এবং বেশি দাম দিতে পারেন'],
                'watch'     => ['Higher prices and service charges, and heavy traffic around the main roads', 'দাম ও সার্ভিস চার্জ বেশি, আর প্রধান সড়কে যানজট'],
            ],
        ],
        'banani' => [
            'name' => 'Banani', 'bn' => 'বনানী', 'bn_in' => 'বনানীতে', 'match' => ['banani'], 'tier' => 4,
            'types' => ['flat', 'apartment'], 'neighbors' => ['gulshan', 'baridhara', 'badda'],
            'blurb' => ["Banani is an upscale area next to Gulshan, around Kemal Ataturk Avenue. It mixes apartments with many offices, restaurants and shops, so it feels busier and more commercial than a purely residential area.",
                        "বনানী গুলশানের পাশে কামাল আতাতুর্ক অ্যাভিনিউকে ঘিরে একটি অভিজাত এলাকা। এখানে অ্যাপার্টমেন্টের পাশাপাশি অনেক অফিস, রেস্তোরাঁ ও দোকান আছে, তাই এটি শুধু আবাসিক এলাকার চেয়ে ব্যস্ত ও বাণিজ্যিক।"],
            'attrs' => [
                'character' => ['Upscale and commercial', 'অভিজাত ও বাণিজ্যিক'],
                'homes'     => ['Apartments among offices and restaurants', 'অফিস ও রেস্তোরাঁর মাঝে অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are rare and costly', 'প্লট কম এবং ব্যয়বহুল'],
                'access'    => ['Kemal Ataturk Avenue; close to Gulshan, Mohakhali and the airport road', 'কামাল আতাতুর্ক অ্যাভিনিউ; গুলশান, মহাখালী ও বিমানবন্দর সড়কের কাছে'],
                'life'      => ['Restaurants, offices, schools and hospitals nearby', 'রেস্তোরাঁ, অফিস, স্কুল ও হাসপাতাল কাছেই'],
                'best'      => ['Professionals who want to live close to offices and dining', 'যারা অফিস ও খাবারের জায়গার কাছে থাকতে চান'],
                'watch'     => ['Noise and traffic, and many buildings mix homes with offices', 'শব্দ ও যানজট, আর অনেক ভবনে বাসা ও অফিস মিশে আছে'],
            ],
        ],
        'baridhara' => [
            'name' => 'Baridhara', 'bn' => 'বারিধারা', 'bn_in' => 'বারিধারায়', 'match' => ['baridhara'], 'tier' => 4,
            'types' => ['flat', 'apartment'], 'neighbors' => ['gulshan', 'banani', 'badda'],
            'blurb' => ["Baridhara is a quieter, greener upscale area beside Gulshan, known as Dhaka's diplomatic zone, with many embassies and residences, wide roads and the Baridhara Lake.",
                        "বারিধারা গুলশানের পাশে শান্ত ও সবুজ অভিজাত এলাকা, ঢাকার কূটনৈতিক এলাকা হিসেবে পরিচিত। এখানে অনেক দূতাবাস ও বাসভবন, চওড়া সড়ক এবং বারিধারা লেক আছে।"],
            'attrs' => [
                'character' => ['Quiet, green and diplomatic', 'শান্ত, সবুজ ও কূটনৈতিক'],
                'homes'     => ['Larger apartments and individual houses', 'বড় অ্যাপার্টমেন্ট ও আলাদা বাড়ি'],
                'land'      => ['Plots exist but are rare and very costly', 'প্লট আছে কিন্তু কম এবং অনেক ব্যয়বহুল'],
                'access'    => ['Close to Gulshan; reached via Progoti Sarani and Madani Avenue', 'গুলশানের কাছে; প্রগতি সরণি ও মদানী অ্যাভিনিউ দিয়ে যাওয়া যায়'],
                'life'      => ['Embassies, schools, parks and clubs', 'দূতাবাস, স্কুল, পার্ক ও ক্লাব'],
                'best'      => ['Families who want space and quiet close to north-central Dhaka', 'যারা উত্তর-মধ্য ঢাকার কাছে জায়গা ও শান্তি চান'],
                'watch'     => ['Among the highest prices, and fewer everyday shops on the inner roads', 'দাম সর্বোচ্চদের মধ্যে, আর ভেতরের সড়কে দোকান কম'],
            ],
        ],
        'dhanmondi' => [
            'name' => 'Dhanmondi', 'bn' => 'ধানমন্ডি', 'bn_in' => 'ধানমন্ডিতে', 'match' => ['dhanmondi', 'dhanmandi'], 'tier' => 3,
            'types' => ['flat', 'apartment'], 'neighbors' => ['mohammadpur', 'mirpur', 'gulshan'],
            'blurb' => ["Dhanmondi is one of Dhaka's oldest planned residential areas, built around Dhanmondi Lake. It is centrally located, with many schools, colleges, hospitals and shops, and it has moved from houses to apartment buildings over the years.",
                        "ধানমন্ডি ঢাকার সবচেয়ে পুরোনো পরিকল্পিত আবাসিক এলাকাগুলোর একটি, ধানমন্ডি লেককে ঘিরে গড়ে উঠেছে। এটি শহরের কেন্দ্রে, এখানে অনেক স্কুল, কলেজ, হাসপাতাল ও দোকান আছে, আর বছরের পর বছর বাড়ি থেকে অ্যাপার্টমেন্ট ভবনে বদলেছে।"],
            'attrs' => [
                'character' => ['Established, central and mixed residential', 'প্রতিষ্ঠিত, কেন্দ্রীয় ও মিশ্র আবাসিক'],
                'homes'     => ['Apartments in low- and mid-rise buildings, plus older houses', 'নিচু ও মাঝারি উচ্চতার ভবনে অ্যাপার্টমেন্ট, সাথে পুরোনো বাড়ি'],
                'land'      => ['Plots are rare; most new building is redevelopment of older houses', 'প্লট কম; নতুন নির্মাণ বেশিরভাগই পুরোনো বাড়ি ভেঙে'],
                'access'    => ['Central, near Farmgate, New Market and Science Laboratory', 'কেন্দ্রীয়, ফার্মগেট, নিউ মার্কেট ও সায়েন্স ল্যাবরেটরির কাছে'],
                'life'      => ['Schools, colleges, hospitals, shops and the lake', 'স্কুল, কলেজ, হাসপাতাল, দোকান ও লেক'],
                'best'      => ['Families who want an established central area near schools and healthcare', 'যারা স্কুল ও চিকিৎসার কাছে প্রতিষ্ঠিত কেন্দ্রীয় এলাকা চান'],
                'watch'     => ['Traffic, parking and busy commercial stretches on the main roads', 'যানজট, পার্কিং ও প্রধান সড়কে ব্যস্ত বাণিজ্যিক অংশ'],
            ],
        ],
        'mohammadpur' => [
            'name' => 'Mohammadpur', 'bn' => 'মোহাম্মদপুর', 'bn_in' => 'মোহাম্মদপুরে', 'match' => ['mohammadpur', 'mohammedpur'], 'tier' => 2,
            'types' => ['flat', 'apartment'], 'neighbors' => ['dhanmondi', 'mirpur', 'uttara'],
            'blurb' => ["Mohammadpur is a dense residential area in west-central Dhaka around Town Hall and Tajmahal Road. It is popular with middle-income families for its markets, schools and central location.",
                        "মোহাম্মদপুর ঢাকার পশ্চিম-মধ্য অংশে টাউন হল ও তাজমহল রোডকে ঘিরে ঘনবসতিপূর্ণ আবাসিক এলাকা। বাজার, স্কুল ও কেন্দ্রীয় অবস্থানের কারণে মধ্যবিত্ত পরিবারের কাছে জনপ্রিয়।"],
            'attrs' => [
                'character' => ['Dense, middle-income and central-west', 'ঘনবসতিপূর্ণ, মধ্যবিত্ত ও পশ্চিম-মধ্য'],
                'homes'     => ['Apartments in older and newer buildings', 'পুরোনো ও নতুন ভবনে অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are limited', 'প্লট সীমিত'],
                'access'    => ['Close to Dhanmondi, Asad Gate and the Ring Road', 'ধানমন্ডি, আসাদ গেট ও রিং রোডের কাছে'],
                'life'      => ['Markets around Town Hall, schools and hospitals nearby', 'টাউন হলের বাজার, স্কুল ও হাসপাতাল কাছেই'],
                'best'      => ['Families who want a central location at a lower price than Dhanmondi', 'যারা ধানমন্ডির চেয়ে কম দামে কেন্দ্রীয় অবস্থান চান'],
                'watch'     => ['Narrow lanes and parking in older parts; check building age and plan approval', 'পুরোনো অংশে সরু গলি ও পার্কিং সমস্যা; ভবনের বয়স ও নকশা অনুমোদন দেখুন'],
            ],
        ],
        'mirpur' => [
            'name' => 'Mirpur', 'bn' => 'মিরপুর', 'bn_in' => 'মিরপুরে', 'match' => ['mirpur'], 'tier' => 2,
            'types' => ['flat', 'apartment'], 'neighbors' => ['uttara', 'mohammadpur', 'dhanmondi'],
            'blurb' => ["Mirpur is a large, densely populated area in north-west Dhaka, divided into numbered sections. It has the national cricket stadium and the zoo, Metro Rail stations along Mirpur Road, and a wide range of budgets from older low-rise areas to newer buildings.",
                        "মিরপুর ঢাকার উত্তর-পশ্চিমে বড় ও ঘনবসতিপূর্ণ এলাকা, সেকশনে ভাগ করা। এখানে জাতীয় ক্রিকেট স্টেডিয়াম ও চিড়িয়াখানা আছে, মিরপুর রোড ধরে মেট্রোরেল স্টেশন আছে, আর পুরোনো নিচু ভবন থেকে নতুন ভবন পর্যন্ত নানা বাজেটের বাসা পাওয়া যায়।"],
            'attrs' => [
                'character' => ['Large, dense and busy, with a wide range of budgets', 'বড়, ঘনবসতিপূর্ণ ও ব্যস্ত, নানা বাজেটের'],
                'homes'     => ['Apartments of many ages and sizes', 'নানা বয়স ও আকারের অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are limited and mostly small', 'প্লট সীমিত এবং বেশিরভাগ ছোট'],
                'access'    => ['Metro Rail stations along Mirpur Road, linking Uttara and central Dhaka', 'মিরপুর রোড ধরে মেট্রোরেল স্টেশন, উত্তরা ও মধ্য ঢাকার সাথে সংযোগ'],
                'life'      => ['Markets, schools, hospitals and the stadium', 'বাজার, স্কুল, হাসপাতাল ও স্টেডিয়াম'],
                'best'      => ['Buyers who want more space for the money, with metro access', 'যারা কম দামে বেশি জায়গা ও মেট্রো সুবিধা চান'],
                'watch'     => ['Crowding and traffic; older buildings, so check structure and plan approval', 'ভিড় ও যানজট; পুরোনো ভবনে কাঠামো ও নকশা অনুমোদন দেখুন'],
            ],
        ],
        'uttara' => [
            'name' => 'Uttara', 'bn' => 'উত্তরা', 'bn_in' => 'উত্তরায়', 'match' => ['uttara'], 'tier' => 3,
            'types' => ['flat', 'apartment', 'land'], 'neighbors' => ['mirpur', 'bashundhara', 'purbachal'],
            'blurb' => ["Uttara is a planned satellite town in the north of Dhaka, divided into numbered sectors near Hazrat Shahjalal International Airport. It has a large, settled residential community with Metro Rail stations, markets, schools and hospitals.",
                        "উত্তরা ঢাকার উত্তরে পরিকল্পিত উপশহর, হযরত শাহজালাল আন্তর্জাতিক বিমানবন্দরের কাছে নম্বরযুক্ত সেক্টরে ভাগ করা। এখানে বড় ও স্থিতিশীল আবাসিক সমাজ, মেট্রোরেল স্টেশন, বাজার, স্কুল ও হাসপাতাল আছে।"],
            'attrs' => [
                'character' => ['Planned northern suburb in numbered sectors', 'নম্বরযুক্ত সেক্টরে পরিকল্পিত উত্তরের উপশহর'],
                'homes'     => ['Many apartments, plus houses in the sectors', 'অনেক অ্যাপার্টমেন্ট, সাথে সেক্টরে বাড়ি'],
                'land'      => ['Plots exist in some sectors; check the sector and plot papers', 'কিছু সেক্টরে প্লট আছে; সেক্টর ও প্লটের কাগজ দেখুন'],
                'access'    => ['Near the airport and Abdullahpur, with Metro Rail stations in Uttara', 'বিমানবন্দর ও আব্দুল্লাহপুরের কাছে, উত্তরায় মেট্রোরেল স্টেশন আছে'],
                'life'      => ['Markets, schools, hospitals, parks and lakes', 'বাজার, স্কুল, হাসপাতাল, পার্ক ও লেক'],
                'best'      => ['Families who want a planned, settled suburb with airport and metro access', 'যারা বিমানবন্দর ও মেট্রো সুবিধাসহ পরিকল্পিত, স্থিতিশীল উপশহর চান'],
                'watch'     => ['Long travel to central and southern Dhaka at peak hours', 'ব্যস্ত সময়ে মধ্য ও দক্ষিণ ঢাকায় যেতে সময় বেশি লাগে'],
            ],
        ],
        'bashundhara' => [
            'name' => 'Bashundhara R/A', 'bn' => 'বসুন্ধরা আ/এ', 'bn_in' => 'বসুন্ধরায়', 'match' => ['bashundhara', 'basundhara'], 'tier' => 3,
            'types' => ['flat', 'apartment', 'land'], 'neighbors' => ['badda', 'uttara', 'purbachal'],
            'blurb' => ["Bashundhara Residential Area is a large private planned residential area in north-east Dhaka, laid out in lettered blocks with wide roads. It offers apartments as well as plots, and has hospitals, schools, universities and shopping close by.",
                        "বসুন্ধরা আবাসিক এলাকা ঢাকার উত্তর-পূর্বে বড় বেসরকারি পরিকল্পিত আবাসিক এলাকা, ইংরেজি অক্ষরের ব্লকে সাজানো ও চওড়া সড়কসহ। এখানে অ্যাপার্টমেন্টের পাশাপাশি প্লটও পাওয়া যায় এবং কাছেই হাসপাতাল, স্কুল, বিশ্ববিদ্যালয় ও শপিং আছে।"],
            'attrs' => [
                'character' => ['Large private planned area in lettered blocks', 'ইংরেজি অক্ষরের ব্লকে বড় বেসরকারি পরিকল্পিত এলাকা'],
                'homes'     => ['Apartments and houses in many blocks', 'অনেক ব্লকে অ্যাপার্টমেন্ট ও বাড়ি'],
                'land'      => ['Plots are common, but block and plot papers need careful checking', 'প্লট বেশি পাওয়া যায়, তবে ব্লক ও প্লটের কাগজ সাবধানে দেখতে হবে'],
                'access'    => ['Near Progoti Sarani and Kuril; a long trip to south Dhaka', 'প্রগতি সরণি ও কুড়িলের কাছে; দক্ষিণ ঢাকায় যেতে অনেক সময়'],
                'life'      => ['Hospitals, schools, universities and shopping', 'হাসপাতাল, স্কুল, বিশ্ববিদ্যালয় ও শপিং'],
                'best'      => ['Buyers who want a planned area with plots as well as apartments', 'যারা অ্যাপার্টমেন্ট ও প্লট দুটোই পাওয়া পরিকল্পিত এলাকা চান'],
                'watch'     => ['Check each block\'s documents, utilities and any charges before paying', 'টাকা দেওয়ার আগে প্রতিটি ব্লকের কাগজ, ইউটিলিটি ও চার্জ দেখুন'],
            ],
        ],
        'badda' => [
            'name' => 'Badda', 'bn' => 'বাড্ডা', 'bn_in' => 'বাড্ডায়', 'match' => ['badda'], 'tier' => 2,
            'types' => ['flat', 'apartment'], 'neighbors' => ['bashundhara', 'gulshan', 'banani'],
            'blurb' => ["Badda lies on Progoti Sarani in north-east Dhaka, between Gulshan, Rampura and Bashundhara. It is a busy mixed area, and many buyers choose it to be close to Gulshan on a smaller budget.",
                        "বাড্ডা ঢাকার উত্তর-পূর্বে প্রগতি সরণির ওপর, গুলশান, রামপুরা ও বসুন্ধরার মাঝে। এটি ব্যস্ত মিশ্র এলাকা, আর অনেকেই কম বাজেটে গুলশানের কাছাকাছি থাকতে এটি বেছে নেন।"],
            'attrs' => [
                'character' => ['Busy and mixed, on Progoti Sarani', 'ব্যস্ত ও মিশ্র, প্রগতি সরণির ওপর'],
                'homes'     => ['Apartments of many ages', 'নানা বয়সের অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are limited and mostly small', 'প্লট সীমিত এবং বেশিরভাগ ছোট'],
                'access'    => ['Progoti Sarani; close to Gulshan, Rampura and Bashundhara', 'প্রগতি সরণি; গুলশান, রামপুরা ও বসুন্ধরার কাছে'],
                'life'      => ['Markets, schools, hospitals and shops along the main road', 'প্রধান সড়ক ধরে বাজার, স্কুল, হাসপাতাল ও দোকান'],
                'best'      => ['Buyers who want to be near Gulshan and Bashundhara on a smaller budget', 'যারা কম বাজেটে গুলশান ও বসুন্ধরার কাছে থাকতে চান'],
                'watch'     => ['Congestion on Progoti Sarani; check each building\'s papers', 'প্রগতি সরণিতে যানজট; প্রতিটি ভবনের কাগজ দেখুন'],
            ],
        ],
        'purbachal' => [
            'name' => 'Purbachal', 'bn' => 'পূর্বাচল', 'bn_in' => 'পূর্বাচলে', 'match' => ['purbachal', 'purbachol'], 'tier' => 1,
            'types' => ['flat', 'apartment', 'land'], 'neighbors' => ['bashundhara', 'uttara', 'badda'],
            'blurb' => ["Purbachal New Town is a large planned project on Dhaka's eastern edge, developed by RAJUK in numbered sectors with wide roads. It is still developing, so it appeals to buyers looking for plots and long-term growth.",
                        "পূর্বাচল নিউ টাউন ঢাকার পূর্ব প্রান্তে রাজউকের বড় পরিকল্পিত প্রকল্প, চওড়া সড়কসহ নম্বরযুক্ত সেক্টরে ভাগ করা। এটি এখনো গড়ে উঠছে, তাই যারা প্লট ও দীর্ঘমেয়াদি প্রবৃদ্ধি খুঁজছেন তাদের কাছে আকর্ষণীয়।"],
            'attrs' => [
                'character' => ['New planned town, still developing', 'নতুন পরিকল্পিত শহর, এখনো গড়ে উঠছে'],
                'homes'     => ['A few apartments; mostly plots with houses being built', 'কিছু অ্যাপার্টমেন্ট; বেশিরভাগ প্লট, বাড়ি তৈরি হচ্ছে'],
                'land'      => ['Plots are the main offer, in numbered sectors and private projects', 'প্লটই মূল প্রস্তাব, নম্বরযুক্ত সেক্টর ও বেসরকারি প্রকল্পে'],
                'access'    => ['Reached by the wide Purbachal road towards Kuril; far from central Dhaka', 'কুড়িলের দিকে চওড়া পূর্বাচল সড়ক দিয়ে; মধ্য ঢাকা থেকে দূরে'],
                'life'      => ['Facilities are still being built, so check utilities, schools and services', 'সুবিধা এখনো তৈরি হচ্ছে, তাই ইউটিলিটি, স্কুল ও সেবা দেখে নিন'],
                'best'      => ['Buyers who want a plot or a newer home for the long term', 'যারা দীর্ঘমেয়াদে প্লট বা নতুন বাড়ি চান'],
                'watch'     => ['Distance, unfinished facilities and plot disputes: verify the allotment and papers with RAJUK or a lawyer', 'দূরত্ব, অসম্পূর্ণ সুবিধা ও প্লট বিরোধ: বরাদ্দ ও কাগজ রাজউক বা আইনজীবীর কাছে যাচাই করুন'],
            ],
        ],

        'mohakhali' => [
            'name' => 'Mohakhali', 'bn' => 'মহাখালী', 'bn_in' => 'মহাখালীতে', 'match' => ['mohakhali'], 'tier' => null,
            'types' => ['flat', 'apartment'], 'neighbors' => ['banani', 'gulshan', 'badda'],
            'blurb' => ["Mohakhali is a busy area in north-central Dhaka between Banani, Gulshan and Tejgaon. It is known for the Mohakhali bus terminal, a major transport junction, and for Mohakhali DOHS, a housing society of apartments and houses.",
                        "মহাখালী ঢাকার উত্তর-মধ্য অংশে বনানী, গুলশান ও তেজগাঁওয়ের মাঝে ব্যস্ত এলাকা। মহাখালী বাস টার্মিনাল নামে বড় যাতায়াত কেন্দ্র এবং অ্যাপার্টমেন্ট ও বাড়ির আবাসিক সোসাইটি মহাখালী ডিওএইচএসের জন্য পরিচিত।"],
            'attrs' => [
                'character' => ['Busy junction area beside Banani and Gulshan', 'বনানী ও গুলশানের পাশে ব্যস্ত সংযোগ এলাকা'],
                'homes'     => ['Apartments, including in the DOHS housing society, among offices and shops', 'অফিস ও দোকানের মাঝে অ্যাপার্টমেন্ট, ডিওএইচএস সোসাইটিতেও'],
                'land'      => ['Plots are rare and costly', 'প্লট কম এবং ব্যয়বহুল'],
                'access'    => ['Close to Banani, Gulshan and Tejgaon; the bus terminal makes it a transport hub', 'বনানী, গুলশান ও তেজগাঁওয়ের কাছে; বাস টার্মিনাল একে যাতায়াতের কেন্দ্র করেছে'],
                'life'      => ['Offices, hospitals, markets and restaurants nearby', 'অফিস, হাসপাতাল, বাজার ও রেস্তোরাঁ কাছেই'],
                'best'      => ['Buyers who want to be near Banani and Gulshan and need easy road connections', 'যারা বনানী ও গুলশানের কাছে থাকতে চান এবং সহজ সড়ক সংযোগ দরকার'],
                'watch'     => ['Heavy traffic and noise around the terminal and the main roads', 'টার্মিনাল ও প্রধান সড়কের আশপাশে যানজট ও শব্দ'],
            ],
        ],
        'aftabnagar' => [
            'name' => 'Aftabnagar', 'bn' => 'আফতাবনগর', 'bn_in' => 'আফতাবনগরে', 'match' => ['aftabnagar', 'aftab nagar'], 'tier' => null,
            'types' => ['flat', 'apartment'], 'neighbors' => ['badda', 'bashundhara', 'khilgaon'],
            'blurb' => ["Aftabnagar is a residential area in east Dhaka beside Badda, Rampura and Banasree, and is home to East West University. It has many apartment buildings.",
                        "আফতাবনগর ঢাকার পূর্বে বাড্ডা, রামপুরা ও বনশ্রীর পাশে আবাসিক এলাকা, এখানে ইস্ট ওয়েস্ট বিশ্ববিদ্যালয় আছে। এখানে অনেক অ্যাপার্টমেন্ট ভবন রয়েছে।"],
            'attrs' => [
                'character' => ['Residential area in east Dhaka beside Badda and Rampura', 'বাড্ডা ও রামপুরার পাশে ঢাকার পূর্বের আবাসিক এলাকা'],
                'homes'     => ['Mostly apartments in residential buildings', 'বেশিরভাগ আবাসিক ভবনে অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are limited', 'প্লট সীমিত'],
                'access'    => ['Close to Badda, Rampura and Banasree on the east side of the city', 'শহরের পূর্ব পাশে বাড্ডা, রামপুরা ও বনশ্রীর কাছে'],
                'life'      => ['A university, schools, markets and hospitals nearby', 'বিশ্ববিদ্যালয়, স্কুল, বাজার ও হাসপাতাল কাছেই'],
                'best'      => ['Families who want a residential east-side location near Badda and Rampura', 'যারা বাড্ডা ও রামপুরার কাছে পূর্ব পাশে আবাসিক এলাকা চান'],
                'watch'     => ['Traffic towards central Dhaka at peak hours; check each building\'s papers', 'ব্যস্ত সময়ে মধ্য ঢাকার দিকে যানজট; প্রতিটি ভবনের কাগজ দেখুন'],
            ],
        ],
        'khilgaon' => [
            'name' => 'Khilgaon', 'bn' => 'খিলগাঁও', 'bn_in' => 'খিলগাঁওয়ে', 'match' => ['khilgaon', 'khilgaun'], 'tier' => null,
            'types' => ['flat', 'apartment'], 'neighbors' => ['aftabnagar', 'badda', 'mohammadpur'],
            'blurb' => ["Khilgaon is a large, densely populated residential area in south-east Dhaka near Malibagh, Rampura and Banasree. It has busy markets and a wide range of older and newer apartment buildings.",
                        "খিলগাঁও ঢাকার দক্ষিণ-পূর্বে মালিবাগ, রামপুরা ও বনশ্রীর কাছে বড় ও ঘনবসতিপূর্ণ আবাসিক এলাকা। এখানে ব্যস্ত বাজার এবং পুরোনো ও নতুন নানা ধরনের অ্যাপার্টমেন্ট ভবন আছে।"],
            'attrs' => [
                'character' => ['Dense, busy and middle-income', 'ঘনবসতিপূর্ণ, ব্যস্ত ও মধ্যবিত্ত'],
                'homes'     => ['Apartments of many ages and sizes', 'নানা বয়স ও আকারের অ্যাপার্টমেন্ট'],
                'land'      => ['Plots are limited and mostly small', 'প্লট সীমিত এবং বেশিরভাগ ছোট'],
                'access'    => ['Close to Malibagh, Rampura, Basabo and Banasree', 'মালিবাগ, রামপুরা, বাসাবো ও বনশ্রীর কাছে'],
                'life'      => ['Markets, schools and hospitals within the area', 'এলাকার ভেতরেই বাজার, স্কুল ও হাসপাতাল'],
                'best'      => ['Families who want a central-east location across a wide range of budgets', 'যারা নানা বাজেটের মধ্যে মধ্য-পূর্ব অবস্থান চান'],
                'watch'     => ['Crowding, and waterlogging in some parts in heavy rain; check building age and approval', 'ভিড়, আর ভারী বর্ষণে কিছু অংশে জলাবদ্ধতা; ভবনের বয়স ও অনুমোদন দেখুন'],
            ],
        ],
        'keraniganj' => [
            'name' => 'Keraniganj', 'bn' => 'কেরানীগঞ্জ', 'bn_in' => 'কেরানীগঞ্জে', 'match' => ['keraniganj', 'keranigonj'], 'tier' => null,
            'types' => ['flat', 'apartment', 'land'], 'neighbors' => ['mohammadpur', 'dhanmondi', 'savar'],
            'blurb' => ["Keraniganj lies across the Buriganga river from old Dhaka and is an upazila of Dhaka district. It mixes residential areas, small industry and open land, and buyers often look there for more space than central Dhaka offers.",
                        "কেরানীগঞ্জ পুরোনো ঢাকার ওপারে বুড়িগঙ্গা নদীর অপর পাড়ে, ঢাকা জেলার একটি উপজেলা। এখানে আবাসিক এলাকা, ছোট শিল্প ও খোলা জমি মিশে আছে, আর ক্রেতারা প্রায়ই মধ্য ঢাকার চেয়ে বেশি জায়গার জন্য এখানে খোঁজেন।"],
            'attrs' => [
                'character' => ['Across the river from old Dhaka: residential, industrial and open land', 'পুরোনো ঢাকার নদীর ওপারে: আবাসিক, শিল্প ও খোলা জমি'],
                'homes'     => ['Apartments and houses in growing residential pockets', 'বেড়ে ওঠা আবাসিক এলাকায় অ্যাপার্টমেন্ট ও বাড়ি'],
                'land'      => ['Plots and land are available; check the land type and whether it is low-lying', 'প্লট ও জমি পাওয়া যায়; জমির ধরন ও নিচু কি না দেখুন'],
                'access'    => ['Linked to Dhaka by the bridges over the Buriganga; expect traffic at the bridges and at peak hours', 'বুড়িগঙ্গার সেতু দিয়ে ঢাকার সাথে যুক্ত; সেতুতে ও ব্যস্ত সময়ে যানজট থাকে'],
                'life'      => ['Local markets and schools; fewer large facilities than central Dhaka', 'স্থানীয় বাজার ও স্কুল; মধ্য ঢাকার চেয়ে বড় সুবিধা কম'],
                'best'      => ['Buyers who want more land or space and can accept a longer trip to the centre', 'যারা বেশি জমি বা জায়গা চান এবং কেন্দ্রে যেতে বেশি সময় মেনে নিতে পারেন'],
                'watch'     => ['Flooding risk on low land, the land class and the ownership papers, and the trip across the river', 'নিচু জমিতে বন্যার ঝুঁকি, জমির শ্রেণি ও মালিকানার কাগজ এবং নদী পার হওয়ার যাতায়াত'],
            ],
        ],
        'savar' => [
            'name' => 'Savar', 'bn' => 'সাভার', 'bn_in' => 'সাভারে', 'match' => ['savar'], 'tier' => null,
            'types' => ['flat', 'apartment', 'land'], 'neighbors' => ['mirpur', 'uttara', 'keraniganj'],
            'blurb' => ["Savar is an upazila in the north-west of Dhaka district, on the Dhaka–Aricha highway. It is known for the National Martyrs' Memorial, Jahangirnagar University, the Savar EPZ and Savar Cantonment.",
                        "সাভার ঢাকা জেলার উত্তর-পশ্চিমে ঢাকা–আরিচা মহাসড়কের ওপর একটি উপজেলা। জাতীয় স্মৃতিসৌধ, জাহাঙ্গীরনগর বিশ্ববিদ্যালয়, সাভার ইপিজেড ও সাভার সেনানিবাসের জন্য পরিচিত।"],
            'attrs' => [
                'character' => ['Large outer town on the Dhaka–Aricha highway', 'ঢাকা–আরিচা মহাসড়কের ওপর বড় শহরতলি'],
                'homes'     => ['Apartments and houses, with new residential projects', 'অ্যাপার্টমেন্ট ও বাড়ি, সাথে নতুন আবাসিক প্রকল্প'],
                'land'      => ['Plots and land are available, from small plots to larger holdings', 'ছোট প্লট থেকে বড় জমি পর্যন্ত পাওয়া যায়'],
                'access'    => ['On the Dhaka–Aricha highway; heavy traffic towards Dhaka at peak hours', 'ঢাকা–আরিচা মহাসড়কে; ব্যস্ত সময়ে ঢাকার দিকে যানজট'],
                'life'      => ['A university, industry and markets in the area', 'এলাকায় বিশ্ববিদ্যালয়, শিল্প ও বাজার'],
                'best'      => ['Buyers who want a larger plot or home outside central Dhaka and can accept a long commute', 'যারা মধ্য ঢাকার বাইরে বড় প্লট বা বাড়ি চান এবং দীর্ঘ যাতায়াত মেনে নিতে পারেন'],
                'watch'     => ['Highway traffic, distance from central Dhaka and land documents: verify carefully', 'মহাসড়কের যানজট, মধ্য ঢাকা থেকে দূরত্ব ও জমির কাগজ: সাবধানে যাচাই করুন'],
            ],
        ],
    ];
}

/** The three cities, described with the same rows so they can be compared too. */
function property_city_attrs(): array
{
    return [
        'dhaka' => [
            'character' => ["Bangladesh's capital and its largest property market", 'দেশের রাজধানী এবং সবচেয়ে বড় সম্পত্তির বাজার'],
            'homes'     => ['Mostly apartments, in a huge range of areas and budgets', 'বেশিরভাগ অ্যাপার্টমেন্ট, নানা এলাকা ও বাজেটে'],
            'land'      => ['Plots mainly in planned and outer areas such as Uttara, Bashundhara and Purbachal', 'প্লট বেশিরভাগ উত্তরা, বসুন্ধরা ও পূর্বাচলের মতো পরিকল্পিত ও শহরতলির এলাকায়'],
            'access'    => ['Airport, Metro Rail on one line and many bus routes; heavy traffic', 'বিমানবন্দর, একটি লাইনে মেট্রোরেল ও অনেক বাস রুট; যানজট বেশি'],
            'life'      => ['The widest choice of schools, hospitals, offices and shopping', 'স্কুল, হাসপাতাল, অফিস ও শপিংয়ের সবচেয়ে বেশি বিকল্প'],
            'best'      => ['Jobs, business and the widest choice of homes', 'চাকরি, ব্যবসা এবং সবচেয়ে বেশি বাসার বিকল্প'],
            'watch'     => ['High prices, traffic and crowding; verify RAJUK plan approval', 'দাম বেশি, যানজট ও ভিড়; রাজউকের নকশা অনুমোদন যাচাই করুন'],
        ],
        'chittagong' => [
            'character' => ['Port city and commercial centre of the south-east', 'দক্ষিণ-পূর্বের বন্দরনগরী ও বাণিজ্যকেন্দ্র'],
            'homes'     => ['Apartments in areas such as Khulshi, GEC Circle, Panchlaish and Nasirabad', 'খুলশী, জিইসি সার্কেল, পাঁচলাইশ ও নাসিরাবাদের মতো এলাকায় অ্যাপার্টমেন্ট'],
            'land'      => ['Plots in CDA-planned residential areas and the outer parts of the city', 'সিডিএ-পরিকল্পিত আবাসিক এলাকা ও শহরের বাইরের অংশে প্লট'],
            'access'    => ['Port, airport and the highway to Dhaka; hilly roads in parts', 'বন্দর, বিমানবন্দর ও ঢাকার মহাসড়ক; কিছু অংশে পাহাড়ি সড়ক'],
            'life'      => ['Port-linked business, universities, hospitals and the sea', 'বন্দরভিত্তিক ব্যবসা, বিশ্ববিদ্যালয়, হাসপাতাল ও সমুদ্র'],
            'best'      => ['Port-linked business and families settled in the south-east', 'বন্দরভিত্তিক ব্যবসা ও দক্ষিণ-পূর্বে স্থায়ী পরিবার'],
            'watch'     => ['Waterlogging and hill-cutting in some areas: check the land\'s history and drainage', 'কিছু এলাকায় জলাবদ্ধতা ও পাহাড় কাটা: জমির ইতিহাস ও পানি নিষ্কাশন দেখুন'],
        ],
        'feni' => [
            'character' => ['A smaller district town on the Dhaka–Chittagong highway', 'ঢাকা–চট্টগ্রাম মহাসড়কের ওপর ছোট জেলা শহর'],
            'homes'     => ['Mostly houses and smaller buildings; apartments around Feni Sadar and Trunk Road', 'বেশিরভাগ বাড়ি ও ছোট ভবন; ফেনী সদর ও ট্রাংক রোডে অ্যাপার্টমেন্ট'],
            'land'      => ['Plots and land across upazilas such as Chhagalnaiya, Sonagazi and Daganbhuiyan', 'ছাগলনাইয়া, সোনাগাজী ও দাগনভূঞার মতো উপজেলায় প্লট ও জমি'],
            'access'    => ['On the highway and railway between Dhaka and Chittagong', 'ঢাকা ও চট্টগ্রামের মাঝে মহাসড়ক ও রেললাইনের ওপর'],
            'life'      => ['District-level schools, hospitals and markets', 'জেলা পর্যায়ের স্কুল, হাসপাতাল ও বাজার'],
            'best'      => ['Families with local roots, and buyers who want land at small-town scale', 'স্থানীয় শিকড়ওয়ালা পরিবার এবং ছোট শহরের মাপে জমি কিনতে চাওয়া ক্রেতা'],
            'watch'     => ['Fewer apartment projects and less price information: verify papers and visit in person', 'অ্যাপার্টমেন্ট প্রকল্প কম, দামের তথ্যও কম: কাগজ যাচাই করুন ও নিজে গিয়ে দেখুন'],
        ],
    ];
}

/** Area a free-typed address belongs to ("Gulshan-2, Dhaka" -> 'gulshan'), or null. */
function property_area_for(?string $raw): ?string
{
    static $cache = [];
    $text = strtolower(trim((string) $raw));
    if ($text === '') {
        return null;
    }
    if (array_key_exists($text, $cache)) {
        return $cache[$text];
    }
    $norm = ' ' . trim((string) preg_replace('/[^a-z]+/', ' ', $text)) . ' ';
    $hit = null;
    $best = 0;
    foreach (property_areas() as $slug => $a) {
        foreach ($a['match'] as $needle) {
            if (strpos($norm, ' ' . $needle . ' ') !== false && strlen($needle) > $best) {
                $hit = $slug;
                $best = strlen($needle);
            }
        }
    }
    return $cache[$text] = $hit;
}

/* ===================================================================================== */
/*  Comparisons                                                                          */
/* ===================================================================================== */

/** Pairs worth comparing, in the order they appear in the address (a-vs-b). 'city' pairs compare whole cities. */
function property_compare_pairs(): array
{
    return [
        ['gulshan', 'banani'], ['gulshan', 'baridhara'], ['gulshan', 'dhanmondi'], ['gulshan', 'uttara'], ['banani', 'baridhara'],
        ['dhanmondi', 'mohammadpur'], ['dhanmondi', 'uttara'], ['mirpur', 'mohammadpur'], ['uttara', 'mirpur'], ['uttara', 'bashundhara'],
        ['badda', 'bashundhara'], ['bashundhara', 'purbachal'], ['uttara', 'purbachal'],
        ['banani', 'mohakhali'], ['badda', 'aftabnagar'], ['bashundhara', 'aftabnagar'], ['savar', 'keraniganj'], ['uttara', 'savar'],
        ['dhaka', 'chittagong'], ['dhaka', 'feni'], ['chittagong', 'feni'],
    ];
}

function property_compare_url(?string $a = null, ?string $b = null): string
{
    return base_path() . '/compare-locations/' . ($a && $b ? $a . '-vs-' . $b . '/' : '');
}

/** The place record for an area or a city: name, bn, attrs, tier, ... */
function property_place(string $slug): ?array
{
    $areas = property_areas();
    if (isset($areas[$slug])) {
        return $areas[$slug] + ['kind' => 'area', 'slug' => $slug];
    }
    $locs = property_locations();
    $cities = property_city_attrs();
    if (isset($locs[$slug], $cities[$slug])) {
        return ['kind' => 'city', 'slug' => $slug, 'name' => $locs[$slug]['name'], 'bn' => $locs[$slug]['bn'], 'bn_in' => $locs[$slug]['bn_in'],
                'attrs' => $cities[$slug], 'blurb' => [$locs[$slug]['blurb'], $locs[$slug]['blurb_bn']], 'tier' => null];
    }
    return null;
}

/** Pairs that involve this place, as [slugA, slugB]. */
function property_compare_pairs_for(string $slug): array
{
    return array_values(array_filter(property_compare_pairs(), function ($p) use ($slug) { return in_array($slug, $p, true); }));
}

/* ===================================================================================== */
/*  Sizes                                                                                */
/* ===================================================================================== */

/** Standard conversions used on the land pages. Katha and bigha differ by region, so the page says to check the deed. */
function land_unit_sqft(): array
{
    return ['sqft' => 1.0, 'katha' => 720.0, 'decimal' => 435.6, 'bigha' => 14400.0];
}

function size_to_sqft(?float $value, ?string $unit): ?float
{
    $u = land_unit_sqft();
    if ($value === null || $value <= 0 || !isset($u[(string) $unit])) {
        return null;
    }
    return round($value * $u[$unit], 2);
}

/**
 * Size pages. 'kind': flat_sqft | flat_bed | land. min/max are in sqft (flat_sqft, land); 'bed' for flat_bed
 * (bed_min = true means "this many or more"). Range is min <= size < max.
 */
function property_sizes(): array
{
    $katha = 720;
    return [
        'flat-for-sale-under-1000-sqft' => [
            'kind' => 'flat_sqft', 'type' => 'flat', 'short' => 'Under 1,000 sqft', 'short_bn' => '১,০০০ বর্গফুটের কম', 'min' => 0, 'max' => 1000,
            'h1' => 'Flat for Sale Under 1,000 sqft', 'h1_bn' => '১,০০০ বর্গফুটের কম ফ্ল্যাট বিক্রয়',
            'fit' => ['Usually one or two bedrooms. A common choice for first-time buyers, small families and investors who plan to rent the flat out.', 'সাধারণত এক বা দুই বেডরুম। প্রথমবারের ক্রেতা, ছোট পরিবার এবং ভাড়া দেওয়ার পরিকল্পনা করা বিনিয়োগকারীদের জন্য প্রচলিত পছন্দ।'],
            'typical' => ['1–2 bedrooms', '১–২ বেডরুম'],
        ],
        'flat-for-sale-1000-1500-sqft' => [
            'kind' => 'flat_sqft', 'type' => 'flat', 'short' => '1,000–1,500 sqft', 'short_bn' => '১,০০০–১,৫০০ বর্গফুট', 'min' => 1000, 'max' => 1500,
            'h1' => 'Flat for Sale, 1,000–1,500 sqft', 'h1_bn' => '১,০০০–১,৫০০ বর্গফুটের ফ্ল্যাট বিক্রয়',
            'fit' => ['Often two or three bedrooms with a separate dining area. A popular middle size for small and growing families.', 'প্রায়ই দুই বা তিন বেডরুম ও আলাদা ডাইনিং এলাকা। ছোট ও বড় হতে থাকা পরিবারের জন্য জনপ্রিয় মাঝারি আকার।'],
            'typical' => ['2–3 bedrooms', '২–৩ বেডরুম'],
        ],
        'flat-for-sale-1500-2000-sqft' => [
            'kind' => 'flat_sqft', 'type' => 'flat', 'short' => '1,500–2,000 sqft', 'short_bn' => '১,৫০০–২,০০০ বর্গফুট', 'min' => 1500, 'max' => 2000,
            'h1' => 'Flat for Sale, 1,500–2,000 sqft', 'h1_bn' => '১,৫০০–২,০০০ বর্গফুটের ফ্ল্যাট বিক্রয়',
            'fit' => ['Often three bedrooms with larger rooms and more than one bathroom. Suits families who want extra space.', 'প্রায়ই তিন বেডরুম, বড় রুম ও একাধিক বাথরুম। যারা বাড়তি জায়গা চান সেই পরিবারের জন্য।'],
            'typical' => ['3 bedrooms', '৩ বেডরুম'],
        ],
        'flat-for-sale-above-2000-sqft' => [
            'kind' => 'flat_sqft', 'type' => 'flat', 'short' => 'Above 2,000 sqft', 'short_bn' => '২,০০০ বর্গফুটের বেশি', 'min' => 2000, 'max' => 1000000,
            'h1' => 'Flat for Sale Above 2,000 sqft', 'h1_bn' => '২,০০০ বর্গফুটের বেশি ফ্ল্যাট বিক্রয়',
            'fit' => ['Often three or four bedrooms with generous living and dining space, usually in premium buildings. Fewer are available, so it pays to compare several.', 'প্রায়ই তিন বা চার বেডরুম, প্রশস্ত বসার ও খাবার জায়গা, সাধারণত প্রিমিয়াম ভবনে। এমন ফ্ল্যাট কম, তাই কয়েকটি তুলনা করা ভালো।'],
            'typical' => ['3–4 bedrooms', '৩–৪ বেডরুম'],
        ],
        '2-bedroom-flat-for-sale' => [
            'kind' => 'flat_bed', 'type' => 'flat', 'short' => '2 bedroom', 'short_bn' => '২ বেডরুম', 'bed' => 2, 'bed_min' => false,
            'h1' => '2 Bedroom Flat for Sale', 'h1_bn' => '২ বেডরুম ফ্ল্যাট বিক্রয়',
            'fit' => ['Suits couples, small families and families with one child, and is usually easier to rent out later.', 'দম্পতি, ছোট পরিবার ও এক সন্তানের পরিবারের জন্য উপযোগী, এবং পরে ভাড়া দেওয়া সাধারণত সহজ।'],
            'typical' => ['About 800–1,200 sqft', 'প্রায় ৮০০–১,২০০ বর্গফুট'],
        ],
        '3-bedroom-flat-for-sale' => [
            'kind' => 'flat_bed', 'type' => 'flat', 'short' => '3 bedroom', 'short_bn' => '৩ বেডরুম', 'bed' => 3, 'bed_min' => false,
            'h1' => '3 Bedroom Flat for Sale', 'h1_bn' => '৩ বেডরুম ফ্ল্যাট বিক্রয়',
            'fit' => ['The most common family size, for families with children or parents living together.', 'সবচেয়ে প্রচলিত পারিবারিক আকার, সন্তান বা বাবা-মা সাথে থাকা পরিবারের জন্য।'],
            'typical' => ['About 1,200–1,800 sqft', 'প্রায় ১,২০০–১,৮০০ বর্গফুট'],
        ],
        '4-bedroom-flat-for-sale' => [
            'kind' => 'flat_bed', 'type' => 'flat', 'short' => '4 bedroom and above', 'short_bn' => '৪ বেডরুম বা তার বেশি', 'bed' => 4, 'bed_min' => true,
            'h1' => '4 Bedroom Flat for Sale', 'h1_bn' => '৪ বেডরুম ফ্ল্যাট বিক্রয়',
            'fit' => ['For large or joint families. Fewer are available, usually in larger buildings, so compare carefully and check the layout.', 'বড় বা যৌথ পরিবারের জন্য। এমন ফ্ল্যাট কম, সাধারণত বড় ভবনে, তাই সাবধানে তুলনা করুন ও নকশা দেখুন।'],
            'typical' => ['About 2,000 sqft and above', 'প্রায় ২,০০০ বর্গফুট ও তার বেশি'],
        ],
        '3-katha-plot-for-sale' => [
            'kind' => 'land', 'type' => 'land', 'short' => '3 katha', 'short_bn' => '৩ কাঠা', 'min' => 2.5 * $katha, 'max' => 3.5 * $katha, 'katha' => 3,
            'h1' => '3 Katha Plot for Sale', 'h1_bn' => '৩ কাঠার প্লট বিক্রয়',
            'fit' => ['A small plot, about 2,160 sqft, often used for a single house or a small apartment building where the rules allow.', 'ছোট প্লট, প্রায় ২,১৬০ বর্গফুট, নিয়ম অনুমতি দিলে প্রায়ই একটি বাড়ি বা ছোট অ্যাপার্টমেন্ট ভবনের জন্য ব্যবহৃত হয়।'],
            'typical' => ['About 2,160 sqft', 'প্রায় ২,১৬০ বর্গফুট'],
        ],
        '5-katha-plot-for-sale' => [
            'kind' => 'land', 'type' => 'land', 'short' => '5 katha', 'short_bn' => '৫ কাঠা', 'min' => 4.5 * $katha, 'max' => 5.5 * $katha, 'katha' => 5,
            'h1' => '5 Katha Plot for Sale', 'h1_bn' => '৫ কাঠার প্লট বিক্রয়',
            'fit' => ['A popular size, about 3,600 sqft, for a family house or a modest apartment building where the rules allow.', 'জনপ্রিয় আকার, প্রায় ৩,৬০০ বর্গফুট, নিয়ম অনুমতি দিলে পারিবারিক বাড়ি বা মাঝারি অ্যাপার্টমেন্ট ভবনের জন্য।'],
            'typical' => ['About 3,600 sqft', 'প্রায় ৩,৬০০ বর্গফুট'],
        ],
        '10-katha-land-for-sale' => [
            'kind' => 'land', 'type' => 'land', 'short' => '10 katha', 'short_bn' => '১০ কাঠা', 'min' => 9 * $katha, 'max' => 11 * $katha, 'katha' => 10,
            'h1' => '10 Katha Land for Sale', 'h1_bn' => '১০ কাঠা জমি বিক্রয়',
            'fit' => ['A large plot, about 7,200 sqft, suited to a bigger building, a small project, or a house with garden space where the rules allow.', 'বড় প্লট, প্রায় ৭,২০০ বর্গফুট, বড় ভবন, ছোট প্রকল্প বা বাগানসহ বাড়ির জন্য, নিয়ম অনুমতি দিলে।'],
            'typical' => ['About 7,200 sqft', 'প্রায় ৭,২০০ বর্গফুট'],
        ],
        '1-bigha-land-for-sale' => [
            'kind' => 'land', 'type' => 'land', 'short' => '1 bigha', 'short_bn' => '১ বিঘা', 'min' => 18 * $katha, 'max' => 22 * $katha, 'katha' => 20,
            'h1' => '1 Bigha Land for Sale', 'h1_bn' => '১ বিঘা জমি বিক্রয়',
            'fit' => ['A large holding, about 14,400 sqft (20 katha), used for projects, farming or long-term investment. Check the land class and road access closely.', 'বড় জমি, প্রায় ১৪,৪০০ বর্গফুট (২০ কাঠা), প্রকল্প, চাষ বা দীর্ঘমেয়াদি বিনিয়োগের জন্য। জমির শ্রেণি ও যাতায়াতের রাস্তা ভালো করে দেখুন।'],
            'typical' => ['About 14,400 sqft', 'প্রায় ১৪,৪০০ বর্গফুট'],
        ],
    ];
}

function property_size_url(string $slug): string
{
    return base_path() . '/' . $slug . '/';
}

/** Size slugs of one kind group: 'flat' (sqft and bedrooms) or 'land'. */
function property_sizes_of(string $type): array
{
    return array_filter(property_sizes(), function ($s) use ($type) { return $s['type'] === $type; });
}


/**
 * Links from a property product page to the pages that describe it: its size band, bedroom count, Dhaka area
 * and city. [[href, label], ...]. Empty for anything that is not a Real Estate flat / apartment / land.
 */
function property_product_chips(array $p, array $trail, ?array $stall = null): array
{
    if (($trail[0]['url_slug'] ?? '') !== 'real-estate') {
        return [];
    }
    $sub = $trail[1]['url_slug'] ?? '';
    if (!in_array($sub, ['apartment', 'land'], true)) {
        return [];
    }
    $out = [];
    $sqft = (float) ($p['size_sqft'] ?? 0);
    foreach (property_sizes() as $slug => $sz) {
        if ($sub === 'land' && $sz['kind'] === 'land' && $sqft >= $sz['min'] && $sqft < $sz['max']) {
            $out[] = [property_size_url($slug), '📐 ' . $sz['short']];
        } elseif ($sub === 'apartment' && $sz['kind'] === 'flat_sqft' && $sqft > 0 && $sqft >= $sz['min'] && $sqft < $sz['max']) {
            $out[] = [property_size_url($slug), '📐 ' . $sz['short']];
        } elseif ($sub === 'apartment' && $sz['kind'] === 'flat_bed' && !empty($p['bedrooms'])) {
            $bd = (int) $p['bedrooms'];
            if (($sz['bed_min'] && $bd >= $sz['bed']) || (!$sz['bed_min'] && $bd === $sz['bed'])) {
                $out[] = [property_size_url($slug), '🛏 ' . $sz['short']];
            }
        }
    }
    $type = $sub === 'land' ? 'land' : 'flat';
    $raw  = trim((string) ($p['city'] ?? '')) !== '' ? $p['city'] : ($stall['city'] ?? '');
    $ak   = property_area_for($raw);
    if ($ak && in_array($type, property_areas()[$ak]['types'], true)) {
        $out[] = [property_url($type, $ak), '📍 ' . ucfirst($type) . ' for Sale in ' . property_areas()[$ak]['name']];
    }
    $d = district_for($raw);
    foreach (property_locations() as $ck => $l) {
        if ($d && $l['district'] === $d['slug']) {
            $out[] = [property_url($type, $ck), '📍 ' . ucfirst($type) . ' for Sale in ' . $l['name']];
        }
    }
    return $out;
}


/* ===================================================================================== */
/*  Filling size / bedrooms / area automatically                                         */
/* ===================================================================================== */

/** True when the category is Real Estate -> Apartment or Land (or something under them). */
function is_property_category(int $categoryId): bool
{
    $path = category_index()[$categoryId]['path'] ?? '';
    return strpos($path, 'real-estate/apartment') === 0 || strpos($path, 'real-estate/land') === 0;
}

/** 'land' for plots, 'flat' for flats and apartments. */
function property_kind_for_category(int $categoryId): string
{
    return strpos(category_index()[$categoryId]['path'] ?? '', 'real-estate/land') === 0 ? 'land' : 'flat';
}

/** The Dhaka area mentioned most often in a text (ties: the one mentioned first), or null. Bangla names count too. */
function property_area_in_text(string $text): ?string
{
    $low  = mb_strtolower($text);
    $best = null;
    $bestN = 0;
    $bestAt = PHP_INT_MAX;
    foreach (property_areas() as $slug => $a) {
        $needles = $a['match'];
        $bn = trim(explode(' ', $a['bn'])[0]);
        if ($bn !== '') { $needles[] = $bn; }
        $n = 0;
        $at = PHP_INT_MAX;
        foreach ($needles as $nd) {
            $off = 0;
            while (($pos = mb_strpos($low, $nd, $off)) !== false) {
                $n++;
                $at = min($at, $pos);
                $off = $pos + mb_strlen($nd);
            }
        }
        if ($n > $bestN || ($n === $bestN && $n > 0 && $at < $bestAt)) {
            $best = $slug; $bestN = $n; $bestAt = $at;
        }
    }
    return $bestN > 0 ? $best : null;
}

/**
 * Reads size, bedrooms and a place out of free text such as a title, specs or a description
 * ("3 Bed Flat, 1,450 sqft, Uttara", "Size: 5 katha", "2975 SFT apartments ... Bashundhara Residential Area").
 * $kind 'flat' reads only square feet (a plot size mentioned in a flat's description is the building's land, not the flat);
 * 'land' prefers katha / decimal / bigha. Returns only what it found:
 * ['size_value' => 1450.0, 'size_unit' => 'sqft', 'bedrooms' => 3, 'area' => 'uttara', 'city' => 'Uttara, Dhaka'].
 */
function property_guess_fields(string $text, string $kind = 'flat'): array
{
    $t = strtr($text, ['০' => '0', '১' => '1', '২' => '2', '৩' => '3', '৪' => '4', '৫' => '5', '৬' => '6', '৭' => '7', '৮' => '8', '৯' => '9']);
    $t = mb_strtolower(preg_replace('/\s+/u', ' ', $t));
    $out = [];

    // size: a number (optionally "2100+") followed by a unit; the first one written in the text wins
    $units = ['sqft' => 'sqft|sq\.? ?ft|sft|square ?feet|square ?foot|বর্গফুট', 'katha' => 'katha|kathas|kata|কাঠা|কাটা', 'decimal' => 'decimal|decimals|shotok|shatak|shotansho|শতক|শতাংশ', 'bigha' => 'bigha|bighas|বিঘা'];
    $allowed = $kind === 'land' ? ['katha', 'decimal', 'bigha', 'sqft'] : ['sqft'];
    $pick = function (array $unitNames) use ($units, $t) {
        $best = null;
        foreach ($unitNames as $unit) {
            if (preg_match('/(\d[\d,]*(?:\.\d+)?)\+?\s*(?:' . $units[$unit] . ')(?![a-z])/u', $t, $m, PREG_OFFSET_CAPTURE)) {
                $val = (float) str_replace(',', '', $m[1][0]);
                if ($val > 0 && ($best === null || $m[0][1] < $best[2])) {
                    $best = [$val, $unit, $m[0][1]];
                }
            }
        }
        return $best;
    };
    $best = $kind === 'land' ? ($pick(['katha', 'decimal', 'bigha']) ?: $pick(['sqft'])) : $pick(['sqft']);
    if ($best) {
        $out['size_value'] = $best[0];
        $out['size_unit']  = $best[1];
    }

    // bedrooms: "3 bed", "3-bedroom", "3 BHK", "৩ বেডরুম", or "bedrooms: 3"
    if (preg_match('/\b(\d{1,2})\s*[- ]?(?:(?:bed(?:room)?s?|br|bhk)\b|বেডরুম|বেড)/u', $t, $m) || preg_match('/bed(?:room)?s?\s*[:\-]\s*(\d{1,2})\b/u', $t, $m)) {
        $n = (int) $m[1];
        if ($n >= 1 && $n <= 20) {
            $out['bedrooms'] = $n;
        }
    }

    // place: the Dhaka area mentioned most, otherwise a district; Bangla names work too
    $ak = property_area_in_text($t);
    if ($ak) {
        $out['area'] = $ak;
        $out['city'] = property_areas()[$ak]['name'] . ', Dhaka';
    } elseif ($d = district_for($t)) {
        $out['city'] = $d['name'];
    } else {
        foreach (property_locations() as $l) {
            if (mb_strpos($t, $l['bn']) !== false) { $out['city'] = $l['name']; break; }
        }
    }
    return $out;
}

/**
 * Fills the empty size / bedroom / city fields of $data from its title, specs and description. Returns what it filled.
 * A city that is only "Dhaka" is refined to the area when the text names one. Anything already filled is left alone.
 */
function property_fill_missing(array &$data, ?string $title, ?string $specs, ?string $descriptionHtml, string $kind = 'flat'): array
{
    $filled = [];
    $desc = mb_substr(trim(html_entity_decode(strip_tags(preg_replace('#</(p|li|h[1-6]|div|tr)>#i', ' ', (string) $descriptionHtml)), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 0, 3000);
    foreach ([(string) $title . ' ' . (string) $specs, $desc] as $src) {
        if (trim($src) === '') {
            continue;
        }
        $g = property_guess_fields($src, $kind);
        if (empty($data['size_value']) && isset($g['size_value'])) {
            $data['size_value'] = $g['size_value'];
            $data['size_unit']  = $g['size_unit'];
            $data['size_sqft']  = size_to_sqft($g['size_value'], $g['size_unit']);
            $filled[] = rtrim(rtrim(number_format($g['size_value'], 2), '0'), '.') . ' ' . $g['size_unit'];
        }
        if (empty($data['bedrooms']) && isset($g['bedrooms']) && $kind === 'flat') {
            $data['bedrooms'] = $g['bedrooms'];
            $filled[] = $g['bedrooms'] . ' bed';
        }
        $city = trim((string) ($data['city'] ?? ''));
        if (isset($g['city'])) {
            $d = district_for($city);
            $needsPlace = $city === '' || ($d && $d['slug'] === 'dhaka' && !property_area_for($city) && isset($g['area']));
            if ($needsPlace) {
                $data['city'] = $g['city'];
                $filled[] = $g['city'];
            }
        }
    }
    return $filled;
}

/** Once (v2): fill size / bedrooms / place for property products that lack them, and fix flat sizes saved in a plot unit. */
function ensure_property_fields(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'prop_fields_v2'")) {
            return;
        }
        foreach (rows("SELECT id, category_id, title_en, specs, description_en, city, size_value, size_unit, bedrooms FROM products") as $r) {
            $cid = (int) $r['category_id'];
            if (!is_property_category($cid)) {
                continue;
            }
            $kind = property_kind_for_category($cid);
            $data = ['size_value' => $r['size_value'], 'size_unit' => $r['size_unit'], 'bedrooms' => $r['bedrooms'], 'city' => $r['city']];
            $fix = [];
            if ($kind === 'flat' && $r['size_unit'] && $r['size_unit'] !== 'sqft') {
                // a flat measured in katha / decimal / bigha is a mis-read (the plot the building stands on)
                $data['size_value'] = null; $data['size_unit'] = null;
                $fix = ['size_value' => null, 'size_unit' => null, 'size_sqft' => null];
            }
            property_fill_missing($data, $r['title_en'], $r['specs'], $r['description_en'], $kind);
            $change = $fix;
            foreach (['size_value', 'size_unit', 'size_sqft', 'bedrooms', 'city'] as $k) {
                if (array_key_exists($k, $data) && $data[$k] !== null && $data[$k] !== '' && ($data[$k] != ($r[$k] ?? null))) {
                    $change[$k] = $data[$k];
                }
            }
            if ($change) {
                update('products', $change, 'id = ?', [(int) $r['id']]);
            }
        }
        insert('settings', ['k' => 'prop_fields_v2', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_property_fields: ' . $e->getMessage());
    }
}
