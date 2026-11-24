<?php
/* Buying guides and calculators for the property section.

     /guides/                                   hub
     /guides/<slug>/                            one guide (guide.php)
     /tools/land-size-converter/                calculators (tool.php)
     /tools/home-loan-emi-calculator/

   One page per topic, each covering a cluster of related searches. The text is general explanation only: no
   interest rates, fees, tax rates or other figures that change, and no legal or financial advice (every page
   says so). Each text is [English, Bangla]. Section kinds: 'text' (paragraphs), 'list', 'steps', 'table'. */

function guide_pages(): array
{
    return [

        /* ------------------------------------------------------------------ */
        'how-to-buy-a-flat-in-bangladesh' => [
            'short' => ['How to buy a flat', 'ফ্ল্যাট কেনার ধাপ'],
            'title' => 'How to Buy a Flat in Bangladesh: Step by Step',
            'h1' => ['How to Buy a Flat in Bangladesh: Step by Step', 'বাংলাদেশে ফ্ল্যাট কেনার ধাপে ধাপে নির্দেশিকা'],
            'descr' => 'A step-by-step guide to buying a flat in Bangladesh: budget, visits, checking the developer and the land papers, the agreement, registration and handover, with a checklist for each stage.',
            'lead' => ['Buying a flat is likely the biggest purchase you will make. This guide walks through the steps in order, from setting a budget to handover, and says what to ask for at each stage.',
                       'ফ্ল্যাট কেনা সম্ভবত আপনার জীবনের সবচেয়ে বড় কেনাকাটা। বাজেট ঠিক করা থেকে হস্তান্তর পর্যন্ত ধাপগুলো ক্রমানুসারে এখানে আছে, আর প্রতিটি ধাপে কী চাইবেন তাও বলা আছে।'],
            'sections' => [
                ['id' => 'budget', 'h' => ['Step 1: Set your budget and needs', 'ধাপ ১: বাজেট ও প্রয়োজন ঠিক করুন'], 'kind' => 'list', 'items' => [
                    ['Add up what you can pay: savings, a possible home loan, and the costs beyond the price, such as registration, utility connections and moving.', 'আপনি কত দিতে পারবেন যোগ করুন: সঞ্চয়, সম্ভাব্য হোম লোন, এবং দামের বাইরের খরচ, যেমন রেজিস্ট্রেশন, ইউটিলিটি সংযোগ ও স্থানান্তর।'],
                    ['Choose the area by travel time, schools, hospitals and safety, then the size and the number of bedrooms.', 'যাতায়াতের সময়, স্কুল, হাসপাতাল ও নিরাপত্তা দেখে এলাকা বেছে নিন, তারপর আকার ও বেডরুমের সংখ্যা ঠিক করুন।'],
                    ['Decide between a ready flat and an under-construction one. The guide on ready versus under-construction flats explains the trade-offs.', 'তৈরি ফ্ল্যাট নাকি নির্মাণাধীন, ঠিক করুন। তৈরি বনাম নির্মাণাধীন ফ্ল্যাটের গাইডে সুবিধা-অসুবিধা বলা আছে।'],
                ]],
                ['id' => 'visit', 'h' => ['Step 2: Shortlist and visit', 'ধাপ ২: বাছাই করুন ও দেখতে যান'], 'kind' => 'list', 'items' => [
                    ['Visit at least two or three options, at different times of day, and check noise, light, water and parking.', 'অন্তত দুটি-তিনটি ফ্ল্যাট দিনের আলাদা সময়ে দেখুন এবং শব্দ, আলো, পানি ও পার্কিং যাচাই করুন।'],
                    ['Ask for the exact area (net and super built-up), the floor, the direction it faces, the land share and the price per square foot.', 'সঠিক আকার (নিট ও সুপার বিল্ট-আপ), ফ্লোর, ফ্ল্যাট কোনদিকে মুখ করা, জমির অংশ ও বর্গফুট প্রতি দাম জিজ্ঞাসা করুন।'],
                    ['Look at the surroundings: road width, drainage, waterlogging in the rains, and how far daily needs are.', 'আশপাশ দেখুন: রাস্তার প্রস্থ, পানি নিষ্কাশন, বর্ষায় জলাবদ্ধতা এবং প্রতিদিনের প্রয়োজনের দোকান কতদূর।'],
                ]],
                ['id' => 'developer', 'h' => ['Step 3: Check the developer and the building', 'ধাপ ৩: ডেভেলপার ও ভবন যাচাই করুন'], 'kind' => 'list', 'items' => [
                    ['Ask for the developer\'s completed projects and visit one. Speak to the owners about handover on time and after-sales service.', 'ডেভেলপারের সম্পন্ন প্রকল্পের তালিকা চান এবং একটি গিয়ে দেখুন। সময়মতো হস্তান্তর ও বিক্রয়-পরবর্তী সেবা নিয়ে মালিকদের সাথে কথা বলুন।'],
                    ['Ask to see the approved building plan from the authority (RAJUK in Dhaka, CDA in Chittagong, or the local pourashava) and confirm the building follows it.', 'কর্তৃপক্ষের (ঢাকায় রাজউক, চট্টগ্রামে সিডিএ, অথবা স্থানীয় পৌরসভা) অনুমোদিত নকশা দেখতে চান এবং ভবন সেটি মেনে হচ্ছে কি না নিশ্চিত হোন।'],
                    ['Ask whether the building has, or will get, the completion or occupancy certificate from the authority.', 'ভবনের সমাপ্তি বা অকুপেন্সি সনদ কর্তৃপক্ষ থেকে আছে কি না, বা পাওয়া যাবে কি না জিজ্ঞাসা করুন।'],
                ]],
                ['id' => 'papers', 'h' => ['Step 4: Verify the land and the papers', 'ধাপ ৪: জমি ও কাগজ যাচাই করুন'], 'kind' => 'list', 'items' => [
                    ['Check the deed and ownership history of the land, the mutation (namjari) and the latest land development tax receipt. The guide on land records and deeds explains each one.', 'জমির দলিল ও মালিকানার ধারাবাহিকতা, নামজারি ও সর্বশেষ ভূমি উন্নয়ন কর রশিদ দেখুন। জমির রেকর্ড ও দলিলের গাইডে প্রতিটি ব্যাখ্যা করা আছে।'],
                    ['Confirm that the land share written for your flat matches the agreement.', 'আপনার ফ্ল্যাটের জন্য লেখা জমির অংশ চুক্তির সাথে মিলছে কি না নিশ্চিত করুন।'],
                    ['Have a lawyer search for disputes, mortgages and court cases before you pay anything.', 'কোনো টাকা দেওয়ার আগে আইনজীবীকে দিয়ে বিরোধ, বন্ধক ও মামলা আছে কি না দেখিয়ে নিন।'],
                ]],
                ['id' => 'agreement', 'h' => ['Step 5: Agree the price and sign', 'ধাপ ৫: দাম ঠিক করে চুক্তি সই করুন'], 'kind' => 'list', 'items' => [
                    ['Get everything in writing: the price, parking, utilities, the payment schedule and the handover date.', 'সবকিছু লিখিত নিন: দাম, পার্কিং, ইউটিলিটি, কিস্তির সময়সূচি ও হস্তান্তরের তারিখ।'],
                    ['Understand what happens if handover is late or you cancel: the penalty and refund terms.', 'হস্তান্তরে দেরি হলে বা আপনি বাতিল করলে কী হবে বুঝে নিন: জরিমানা ও ফেরতের শর্ত।'],
                    ['Pay by traceable bank transfer or cheque and keep a signed receipt for every payment. Be careful with cash.', 'ব্যাংক ট্রান্সফার বা চেকে টাকা দিন এবং প্রতিটি পেমেন্টের সই করা রশিদ রাখুন। নগদে সতর্ক থাকুন।'],
                ]],
                ['id' => 'handover', 'h' => ['Step 6: Registration and handover', 'ধাপ ৬: রেজিস্ট্রেশন ও হস্তান্তর'], 'kind' => 'list', 'items' => [
                    ['The sale is completed by registering the sale deed at the sub-registry office. Registration fees and taxes change, so ask for the current amount in writing.', 'সাব-রেজিস্ট্রি অফিসে বিক্রয় দলিল রেজিস্ট্রি করলে বিক্রয় সম্পূর্ণ হয়। রেজিস্ট্রেশন ফি ও কর বদলায়, তাই বর্তমান পরিমাণ লিখিত জেনে নিন।'],
                    ['After registration, apply for mutation (namjari) in your name and pay the land development tax.', 'রেজিস্ট্রির পর আপনার নামে নামজারির আবেদন করুন এবং ভূমি উন্নয়ন কর দিন।'],
                    ['Before taking the keys, inspect the flat against the agreement: fittings, electricity, water, lift, generator, gas and finishing. Note any defect in writing.', 'চাবি নেওয়ার আগে চুক্তির সাথে মিলিয়ে ফ্ল্যাট দেখুন: ফিটিংস, বিদ্যুৎ, পানি, লিফট, জেনারেটর, গ্যাস ও ফিনিশিং। কোনো ত্রুটি থাকলে লিখে রাখুন।'],
                    ['Ask about the owners\' association, the service charge and how the common areas are managed.', 'মালিক সমিতি, সার্ভিস চার্জ এবং কমন এলাকা কীভাবে পরিচালিত হয় তা জিজ্ঞাসা করুন।'],
                ]],
            ],
            'faq' => [
                ['How much money do I need to buy a flat in Bangladesh?', 'It depends on the flat. Besides the price, plan for registration fees and taxes, utility connection charges and any service or club charges. Ask the seller to list every cost in writing.', 'বাংলাদেশে ফ্ল্যাট কিনতে কত টাকা লাগে?', 'ফ্ল্যাটভেদে আলাদা। দামের বাইরে রেজিস্ট্রেশন ফি ও কর, ইউটিলিটি সংযোগ খরচ এবং সার্ভিস বা ক্লাব চার্জের হিসাব রাখুন। বিক্রেতাকে সব খরচ লিখে দিতে বলুন।'],
                ['Do I need a lawyer to buy a flat?', 'It is strongly advised. A lawyer can check the deed, the ownership history, the mutation and the agreement before you pay, which costs far less than fixing a problem afterwards.', 'ফ্ল্যাট কিনতে কি আইনজীবী লাগে?', 'আইনজীবী নেওয়া জোরালোভাবে পরামর্শযোগ্য। টাকা দেওয়ার আগে তিনি দলিল, মালিকানার ধারাবাহিকতা, নামজারি ও চুক্তি দেখে দিতে পারেন, যা পরে সমস্যা মেটানোর চেয়ে অনেক কম খরচ।'],
                ['Can I pay for a flat in instalments?', 'Many developers offer instalment plans for under-construction flats, and banks offer home loans. Compare the total cost, check the penalty for late payment, and read the home loan guide.', 'কিস্তিতে কি ফ্ল্যাট কেনা যায়?', 'অনেক ডেভেলপার নির্মাণাধীন ফ্ল্যাটে কিস্তির সুবিধা দেয় এবং ব্যাংক হোম লোন দেয়। মোট খরচ তুলনা করুন, দেরিতে দিলে জরিমানা দেখুন এবং হোম লোন গাইড পড়ুন।'],
            ],
            'related' => ['ready-vs-under-construction-flats', 'land-share-and-super-built-up-area', 'land-records-and-deeds-bangladesh', 'home-loan-for-a-flat-in-bangladesh'],
            'tools' => ['home-loan-emi-calculator', 'land-size-converter'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'flat:bashundhara', 'flat:uttara', 'size:3-bedroom-flat-for-sale', 'size:flat-for-sale-1000-1500-sqft'],
        ],

        /* ------------------------------------------------------------------ */
        'ready-vs-under-construction-flats' => [
            'short' => ['Ready vs under-construction', 'তৈরি বনাম নির্মাণাধীন'],
            'title' => 'Ready vs Under-Construction Flats: Which to Buy?',
            'h1' => ['Ready vs Under-Construction Flats: Which Should You Buy?', 'তৈরি বনাম নির্মাণাধীন ফ্ল্যাট: কোনটি কিনবেন?'],
            'descr' => 'Ready flat or under-construction flat? Compare price, choice, risk and time to move in, learn how to protect yourself if you buy before the building is finished, and what to ask about handover delays.',
            'lead' => ['A ready flat lets you see exactly what you are buying. An under-construction flat can start cheaper and let you choose early, but it carries delay and quality risk. Here is how to weigh them.',
                       'তৈরি ফ্ল্যাটে কী কিনছেন তা সরাসরি দেখা যায়। নির্মাণাধীন ফ্ল্যাটে শুরুতে খরচ কম হতে পারে এবং আগেভাগে বেছে নেওয়া যায়, তবে দেরি ও মানের ঝুঁকি থাকে। কীভাবে তুলনা করবেন তা এখানে।'],
            'sections' => [
                ['id' => 'compare', 'h' => ['Side by side', 'পাশাপাশি তুলনা'], 'kind' => 'table',
                 'cols' => [['', ''], ['Ready flat', 'তৈরি ফ্ল্যাট'], ['Under construction', 'নির্মাণাধীন']],
                 'rows' => [
                    [['Price', 'দাম'], ['Often higher than the same flat sold before completion', 'সমাপ্তির আগে বিক্রি হওয়া একই ফ্ল্যাটের চেয়ে প্রায়ই বেশি'], ['Often a lower starting price, paid in instalments', 'প্রায়ই শুরুর দাম কম, কিস্তিতে দেওয়া যায়']],
                    [['Choice', 'পছন্দ'], ['Limited to what is left', 'যা বাকি আছে তার মধ্যেই'], ['Wider choice of floor, layout and direction early on', 'শুরুতে ফ্লোর, নকশা ও দিক বেছে নেওয়ার সুযোগ বেশি']],
                    [['Seeing what you buy', 'কী কিনছেন দেখা'], ['You can inspect the finish, light, noise and utilities', 'ফিনিশ, আলো, শব্দ ও ইউটিলিটি নিজে দেখা যায়'], ['You rely on drawings, a sample flat and the developer\'s record', 'নকশা, নমুনা ফ্ল্যাট ও ডেভেলপারের রেকর্ডের ওপর নির্ভর করতে হয়']],
                    [['Time to move in', 'ওঠার সময়'], ['Soon after registration', 'রেজিস্ট্রির অল্প পরেই'], ['After handover, which can be late', 'হস্তান্তরের পর, যা দেরি হতে পারে']],
                    [['Main risk', 'প্রধান ঝুঁকি'], ['Older flats may need repair', 'পুরোনো ফ্ল্যাটে মেরামত লাগতে পারে'], ['Delay, or a result that differs from the brochure', 'দেরি, অথবা ব্রোশিওর থেকে আলাদা ফল']],
                 ]],
                ['id' => 'protect', 'h' => ['If you buy before it is finished', 'শেষ হওয়ার আগে কিনলে সুরক্ষা'], 'kind' => 'list', 'items' => [
                    ['Check the developer\'s record: visit a finished project and speak to the owners.', 'ডেভেলপারের রেকর্ড দেখুন: সম্পন্ন একটি প্রকল্প গিয়ে মালিকদের সাথে কথা বলুন।'],
                    ['Sign an agreement that states the handover date, what counts as a delay, and the compensation or refund if it is late.', 'এমন চুক্তি সই করুন যাতে হস্তান্তরের তারিখ, কী দেরি বলে গণ্য হবে এবং দেরি হলে ক্ষতিপূরণ বা ফেরত লেখা থাকে।'],
                    ['Where you can, tie your payments to construction progress rather than paying everything early.', 'সম্ভব হলে সব টাকা আগে না দিয়ে নির্মাণের অগ্রগতির সাথে মিলিয়ে কিস্তি দিন।'],
                    ['Visit the site during construction and keep dated photographs.', 'নির্মাণের সময় সাইটে যান এবং তারিখসহ ছবি রাখুন।'],
                    ['Confirm the approved plan and the land papers, and ask what happens to your money if the project stops.', 'অনুমোদিত নকশা ও জমির কাগজ নিশ্চিত করুন এবং প্রকল্প থেমে গেলে আপনার টাকার কী হবে জিজ্ঞাসা করুন।'],
                ]],
                ['id' => 'almost', 'h' => ['Almost ready flats', 'প্রায় তৈরি ফ্ল্যাট'], 'kind' => 'text', 'items' => [
                    ['A flat close to completion combines a view of the real building with some price flexibility. Ask for the expected handover date in writing, and check the state of the finishing, the lift, the generator and the utility connections.', 'সমাপ্তির কাছাকাছি ফ্ল্যাটে আসল ভবন দেখা যায় এবং দামে কিছুটা নমনীয়তাও থাকতে পারে। প্রত্যাশিত হস্তান্তরের তারিখ লিখিত নিন এবং ফিনিশিং, লিফট, জেনারেটর ও ইউটিলিটি সংযোগের অবস্থা দেখুন।'],
                ]],
                ['id' => 'delay', 'h' => ['Questions about handover delays', 'হস্তান্তরে দেরি নিয়ে প্রশ্ন'], 'kind' => 'list', 'items' => [
                    ['Is there a written delay clause, and when does the clock start?', 'দেরির কোনো লিখিত ধারা আছে কি এবং কখন থেকে গণনা শুরু?'],
                    ['What compensation or refund applies, and how is it paid?', 'কী ক্ষতিপূরণ বা ফেরত প্রযোজ্য এবং তা কীভাবে দেওয়া হয়?'],
                    ['Which events does the developer count as reasons for delay?', 'কোন কারণগুলোকে ডেভেলপার দেরির কারণ ধরে?'],
                    ['Can you cancel, and what will you get back?', 'আপনি কি বাতিল করতে পারবেন এবং কত ফেরত পাবেন?'],
                ]],
                ['id' => 'choose', 'h' => ['Which suits you?', 'কোনটি আপনার জন্য?'], 'kind' => 'list', 'items' => [
                    ['Choose a ready flat if you need to move soon, want to inspect everything, or dislike waiting and uncertainty.', 'দ্রুত উঠতে হলে, সবকিছু নিজে দেখতে চাইলে, বা অপেক্ষা ও অনিশ্চয়তা পছন্দ না হলে তৈরি ফ্ল্যাট বেছে নিন।'],
                    ['Choose an under-construction flat if you can wait, want to spread the payments, and have checked the developer well.', 'অপেক্ষা করতে পারলে, কিস্তিতে দিতে চাইলে এবং ডেভেলপার ভালো করে যাচাই করে থাকলে নির্মাণাধীন ফ্ল্যাট বেছে নিন।'],
                ]],
            ],
            'faq' => [
                ['Is an under-construction flat cheaper?', 'Often the starting price is lower than a similar ready flat, but compare the total cost including any instalment charges, and weigh the risk of delay.', 'নির্মাণাধীন ফ্ল্যাট কি সস্তা?', 'প্রায়ই একই ধরনের তৈরি ফ্ল্যাটের চেয়ে শুরুর দাম কম হয়, তবে কিস্তির চার্জসহ মোট খরচ তুলনা করুন এবং দেরির ঝুঁকিও বিবেচনা করুন।'],
                ['What if the developer delays handover?', 'Your agreement should say. Without a clear clause your options are limited, so get the delay terms written before you pay. A lawyer can advise.', 'ডেভেলপার হস্তান্তরে দেরি করলে কী হবে?', 'চুক্তিতে তা থাকা উচিত। স্পষ্ট ধারা না থাকলে আপনার উপায় সীমিত, তাই টাকা দেওয়ার আগে দেরির শর্ত লিখিত নিন। আইনজীবী পরামর্শ দিতে পারেন।'],
                ['How can I check construction progress?', 'Visit the site, take dated photographs, and ask for progress updates from the developer. Compare the stage reached with the payments you have made.', 'নির্মাণের অগ্রগতি কীভাবে যাচাই করব?', 'সাইটে যান, তারিখসহ ছবি তুলুন এবং ডেভেলপারের কাছে অগ্রগতির তথ্য চান। কাজের ধাপের সাথে আপনার দেওয়া কিস্তি মিলিয়ে দেখুন।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-share-and-super-built-up-area', 'home-loan-for-a-flat-in-bangladesh'],
            'tools' => ['home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'flat:bashundhara', 'size:flat-for-sale-above-2000-sqft', 'size:4-bedroom-flat-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'land-share-and-super-built-up-area' => [
            'short' => ['Land share and area', 'জমির অংশ ও আকার'],
            'title' => 'Land Share and Super Built-Up Area Explained',
            'h1' => ['Land Share and Super Built-Up Area Explained', 'জমির অংশ ও সুপার বিল্ট-আপ এরিয়া ব্যাখ্যা'],
            'descr' => 'What land share (undivided share of land) means when you buy a flat, the difference between net, built-up and super built-up area, and how to compare flats fairly by price per square foot.',
            'lead' => ['Two terms confuse most flat buyers: land share and super built-up area. This page explains both in plain language and shows how to compare flats on a fair basis.',
                       'ফ্ল্যাটের বেশিরভাগ ক্রেতা দুটি শব্দে বিভ্রান্ত হন: জমির অংশ আর সুপার বিল্ট-আপ এরিয়া। সহজ ভাষায় দুটিই এবং ফ্ল্যাট ন্যায্যভাবে তুলনার উপায় এখানে বলা হলো।'],
            'sections' => [
                ['id' => 'land-share', 'h' => ['What is land share?', 'জমির অংশ কী?'], 'kind' => 'text', 'items' => [
                    ['When you buy a flat you also own a share of the land under the building. This is the undivided land share (অবিভক্ত জমির অংশ). It is written in the deed, usually in katha, decimal or square feet, and is linked to the size of your flat compared with the whole building.', 'ফ্ল্যাট কিনলে আপনি ভবনের নিচের জমিরও একটি অংশের মালিক হন। এটিই অবিভক্ত জমির অংশ। এটি দলিলে লেখা থাকে, সাধারণত কাঠা, শতক বা বর্গফুটে, এবং পুরো ভবনের তুলনায় আপনার ফ্ল্যাটের আকারের সাথে সম্পর্কিত।'],
                    ['It is why a flat buyer owns property, and not only the space inside the walls.', 'এ কারণেই ফ্ল্যাটের ক্রেতা শুধু দেয়ালের ভেতরের জায়গার নয়, সম্পত্তিরও মালিক হন।'],
                ]],
                ['id' => 'why', 'h' => ['Why land share matters', 'জমির অংশ কেন গুরুত্বপূর্ণ'], 'kind' => 'list', 'items' => [
                    ['It is part of what you own, sell or pass on to your heirs.', 'এটি আপনার মালিকানার অংশ, যা আপনি বিক্রি বা উত্তরাধিকারীদের দিতে পারেন।'],
                    ['It matters if the building is ever rebuilt.', 'ভবন কখনো নতুন করে বানানো হলে এটি গুরুত্বপূর্ণ।'],
                    ['It is worth asking how the land share was worked out and whether all the shares in the building add up to the land.', 'জমির অংশ কীভাবে হিসাব করা হয়েছে এবং ভবনের সব অংশ মিলে জমির সমান হয় কি না জিজ্ঞাসা করা ভালো।'],
                ]],
                ['id' => 'areas', 'h' => ['Net, built-up and super built-up area', 'নিট, বিল্ট-আপ ও সুপার বিল্ট-আপ এরিয়া'], 'kind' => 'table',
                 'cols' => [['Measure', 'মাপ'], ['What it usually includes', 'সাধারণত কী ধরে'], ['Size', 'আকার']],
                 'rows' => [
                    [['Net (carpet) area', 'নিট (কার্পেট) এরিয়া'], ['The usable floor space inside the walls of the flat', 'ফ্ল্যাটের দেয়ালের ভেতরের ব্যবহারযোগ্য মেঝে'], ['Smallest', 'সবচেয়ে ছোট']],
                    [['Built-up area', 'বিল্ট-আপ এরিয়া'], ['Net area plus the walls and usually the balconies', 'নিট এরিয়া, সাথে দেয়াল এবং সাধারণত বারান্দা'], ['Larger', 'তার চেয়ে বড়']],
                    [['Super built-up area', 'সুপার বিল্ট-আপ এরিয়া'], ['Built-up area plus a share of the common areas such as stairs, lift and lobby', 'বিল্ট-আপ এরিয়া, সাথে সিঁড়ি, লিফট ও লবির মতো কমন এলাকার অংশ'], ['Largest', 'সবচেয়ে বড়']],
                 ]],
                ['id' => 'compare', 'h' => ['How to compare flats fairly', 'ফ্ল্যাট ন্যায্যভাবে কীভাবে তুলনা করবেন'], 'kind' => 'steps', 'items' => [
                    ['Ask which area the price is based on, and ask for both the net and the super built-up figures.', 'দাম কোন আকারের ভিত্তিতে তা জিজ্ঞাসা করুন এবং নিট ও সুপার বিল্ট-আপ দুটোই চান।'],
                    ['Divide the price by that area to get the price per square foot. For example, a flat of 1,500 sqft super built-up priced at 1 crore works out at about ৳6,667 per sqft, while the same price on a net area of 1,200 sqft is about ৳8,333 per sqft. The figures are only an example.', 'দামকে ওই আকার দিয়ে ভাগ করে বর্গফুট প্রতি দাম বের করুন। যেমন ১,৫০০ বর্গফুট সুপার বিল্ট-আপের ফ্ল্যাট ১ কোটি টাকা হলে বর্গফুট প্রতি প্রায় ৬,৬৬৭ টাকা, আর একই দাম ১,২০০ বর্গফুট নিট এরিয়ায় ধরলে প্রায় ৮,৩৩৩ টাকা। অঙ্কগুলো শুধু উদাহরণ।'],
                    ['Compare the same kind of area across flats: super built-up with super built-up, net with net.', 'সব ফ্ল্যাটে একই ধরনের আকার তুলনা করুন: সুপার বিল্ট-আপের সাথে সুপার বিল্ট-আপ, নিটের সাথে নিট।'],
                    ['Then compare the land share, the floor, the direction, the age and the facilities.', 'এরপর জমির অংশ, ফ্লোর, দিক, বয়স ও সুবিধা তুলনা করুন।'],
                ]],
                ['id' => 'papers', 'h' => ['What to check in the papers', 'কাগজে কী দেখবেন'], 'kind' => 'list', 'items' => [
                    ['The land share is written in the deed and matches the agreement.', 'জমির অংশ দলিলে লেখা আছে এবং চুক্তির সাথে মেলে।'],
                    ['The land area in the deed matches the plot on which the building stands.', 'দলিলের জমির পরিমাণ ভবনটি যে প্লটে দাঁড়িয়ে তার সাথে মেলে।'],
                    ['The flat\'s area in the deed matches the area in the sale agreement.', 'দলিলে ফ্ল্যাটের আকার বিক্রয় চুক্তির আকারের সাথে মেলে।'],
                ]],
            ],
            'faq' => [
                ['Is the land share included in the price of the flat?', 'Usually the price covers the flat and its land share together, but confirm this in the agreement.', 'ফ্ল্যাটের দামে কি জমির অংশ ধরা থাকে?', 'সাধারণত দামে ফ্ল্যাট ও তার জমির অংশ একসাথে ধরা থাকে, তবে চুক্তিতে তা নিশ্চিত করুন।'],
                ['Why do two flats of the same size cost different amounts?', 'Location, floor, direction, age, finishing, facilities and which area measure the price uses can all differ. Compare the price per square foot on the same measure.', 'একই আকারের দুটি ফ্ল্যাটের দাম আলাদা কেন?', 'অবস্থান, ফ্লোর, দিক, বয়স, ফিনিশিং, সুবিধা এবং দাম কোন আকারের মাপে তা আলাদা হতে পারে। একই মাপে বর্গফুট প্রতি দাম তুলনা করুন।'],
                ['How many square feet are in a katha?', 'In the standard Dhaka measure 1 katha is 720 square feet, but katha differs by region. Use the land size converter and check the measure on your deed.', 'এক কাঠায় কত বর্গফুট?', 'ঢাকার প্রচলিত মাপে ১ কাঠা ৭২০ বর্গফুট, তবে অঞ্চলভেদে কাঠা আলাদা। জমির মাপ রূপান্তর টুল ব্যবহার করুন এবং দলিলের মাপ দেখে নিন।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-records-and-deeds-bangladesh', 'ready-vs-under-construction-flats'],
            'tools' => ['land-size-converter'],
            'links' => ['flat:dhaka', 'apartment:bashundhara', 'size:flat-for-sale-1500-2000-sqft', 'size:flat-for-sale-above-2000-sqft', 'size:5-katha-plot-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'land-records-and-deeds-bangladesh' => [
            'short' => ['Land records and deeds', 'জমির রেকর্ড ও দলিল'],
            'title' => 'Land Records and Deeds in Bangladesh: Khatian, Namjari',
            'h1' => ['Land Records and Deeds in Bangladesh', 'বাংলাদেশে জমির রেকর্ড ও দলিল'],
            'descr' => 'Khatian (CS, SA, RS, BS), mouza and dag, mutation (namjari), land development tax and the main deed types such as saf kabala, baina nama and heba, with a step-by-step way to check a property.',
            'lead' => ['Before you pay for land or a flat, the papers should line up: the deed, the government record, the mutation and the tax receipts. This page explains each one and how to check them. It is general information, not legal advice.',
                       'জমি বা ফ্ল্যাটের টাকা দেওয়ার আগে কাগজগুলো মিলতে হবে: দলিল, সরকারি রেকর্ড, নামজারি ও কর রশিদ। প্রতিটি কী এবং কীভাবে যাচাই করবেন তা এখানে ব্যাখ্যা করা আছে। এটি সাধারণ তথ্য, আইনি পরামর্শ নয়।'],
            'sections' => [
                ['id' => 'khatian', 'h' => ['Khatian, mouza and dag', 'খতিয়ান, মৌজা ও দাগ'], 'kind' => 'table',
                 'cols' => [['Term', 'শব্দ'], ['What it is', 'কী'], ['', '']],
                 'rows' => [
                    [['Mouza (মৌজা)', 'মৌজা'], ['The revenue village the land belongs to', 'জমি যে রাজস্ব গ্রামের অন্তর্গত'], ['', '']],
                    [['Dag (দাগ)', 'দাগ'], ['The number of a plot within the mouza', 'মৌজার ভেতরে প্লটের নম্বর'], ['', '']],
                    [['Khatian (খতিয়ান)', 'খতিয়ান'], ['The government record of who holds the land, listed by dag', 'কে জমির মালিক তার সরকারি রেকর্ড, দাগ অনুযায়ী'], ['', '']],
                    [['CS, SA, RS, BS', 'সিএস, এসএ, আরএস, বিএস'], ['The survey records made over time: Cadastral Survey (CS), State Acquisition (SA), Revisional Survey (RS) and Bangladesh Survey (BS), from older to newer. City areas also have city survey records', 'সময়ের সাথে তৈরি জরিপের রেকর্ড: ক্যাডাস্ট্রাল সার্ভে (সিএস), রাষ্ট্রীয় অধিগ্রহণ (এসএ), রিভিশনাল সার্ভে (আরএস) ও বাংলাদেশ সার্ভে (বিএস), পুরোনো থেকে নতুন। শহর এলাকায় সিটি জরিপের রেকর্ডও আছে'], ['', '']],
                 ]],
                ['id' => 'mutation', 'h' => ['Mutation (namjari) and land development tax', 'নামজারি ও ভূমি উন্নয়ন কর'], 'kind' => 'text', 'items' => [
                    ['After you buy, mutation (namjari) records you as the new owner in the government land record. You apply at the local land office, and the government also offers an online mutation service. Until mutation is done, the government record still shows the old owner, which can cause problems when you sell, take a loan or pay tax.', 'কেনার পর নামজারি সরকারি জমির রেকর্ডে আপনাকে নতুন মালিক হিসেবে নথিভুক্ত করে। স্থানীয় ভূমি অফিসে আবেদন করতে হয়, সরকারের অনলাইন নামজারি সেবাও আছে। নামজারি না হওয়া পর্যন্ত সরকারি রেকর্ডে পুরোনো মালিকই থাকেন, যা বিক্রি, ঋণ নেওয়া বা কর দেওয়ার সময় সমস্যা করতে পারে।'],
                    ['The land development tax (খাজনা) is paid every year, and the receipts show who is paying for the land. Ask to see the latest receipts. The tax can be paid online through the government land portal.', 'ভূমি উন্নয়ন কর (খাজনা) প্রতি বছর দিতে হয় এবং রশিদ দেখায় কে জমির কর দিচ্ছে। সর্বশেষ রশিদ দেখতে চান। কর সরকারের ভূমি পোর্টালে অনলাইনে দেওয়া যায়।'],
                ]],
                ['id' => 'deeds', 'h' => ['Common deed types', 'প্রচলিত দলিলের ধরন'], 'kind' => 'table',
                 'cols' => [['Deed', 'দলিল'], ['What it does', 'কী করে'], ['', '']],
                 'rows' => [
                    [['Saf kabala (সাফ কবলা)', 'সাফ কবলা'], ['An outright sale deed, registered at the sub-registry office, that transfers ownership', 'সাব-রেজিস্ট্রি অফিসে নিবন্ধিত বিক্রয় দলিল, যা মালিকানা হস্তান্তর করে'], ['', '']],
                    [['Baina nama (বায়না নামা)', 'বায়না নামা'], ['An agreement to sell, usually with earnest money. It does not transfer ownership by itself', 'বিক্রির চুক্তি, সাধারণত বায়নার টাকাসহ। এটি নিজে মালিকানা হস্তান্তর করে না'], ['', '']],
                    [['Heba (হেবা)', 'হেবা'], ['A gift deed: ownership passes without a sale', 'দানপত্র: বিক্রি ছাড়া মালিকানা যায়'], ['', '']],
                    [['Bontonnama (বণ্টননামা)', 'বণ্টননামা'], ['A partition deed that divides property among co-owners', 'সহ-মালিকদের মধ্যে সম্পত্তি ভাগ করার দলিল'], ['', '']],
                    [['Power of attorney (পাওয়ার অব অ্যাটর্নি)', 'পাওয়ার অব অ্যাটর্নি'], ['Authorises someone to act for the owner. Check exactly what it allows and whether it is registered', 'মালিকের পক্ষে কাজ করার ক্ষমতা দেয়। ঠিক কী কী অনুমতি দেয় এবং নিবন্ধিত কি না দেখুন'], ['', '']],
                 ]],
                ['id' => 'check', 'h' => ['How to check a property, step by step', 'একটি সম্পত্তি ধাপে ধাপে যাচাই'], 'kind' => 'steps', 'items' => [
                    ['Get copies of the seller\'s deed and the earlier deeds in the chain of ownership.', 'বিক্রেতার দলিল এবং মালিকানার ধারাবাহিকতার আগের দলিলগুলোর কপি নিন।'],
                    ['Match the deeds with the khatian records (CS, SA, RS, BS), the mouza and the dag numbers.', 'দলিলগুলো খতিয়ানের রেকর্ড (সিএস, এসএ, আরএস, বিএস), মৌজা ও দাগ নম্বরের সাথে মিলান।'],
                    ['Check the mutation and the latest land development tax receipts in the seller\'s name.', 'বিক্রেতার নামে নামজারি ও সর্বশেষ ভূমি উন্নয়ন কর রশিদ দেখুন।'],
                    ['Visit the land with the dag number and check the boundary, the access road and who is in possession.', 'দাগ নম্বর নিয়ে জমি দেখতে যান এবং সীমানা, যাতায়াতের রাস্তা ও কে দখলে আছে দেখুন।'],
                    ['Ask a lawyer to search the deed at the sub-registry office and to check for any mortgage, dispute or court case, and that the land is not government (khas), vested or acquired land.', 'আইনজীবীকে দিয়ে সাব-রেজিস্ট্রি অফিসে দলিল অনুসন্ধান করান এবং কোনো বন্ধক, বিরোধ বা মামলা আছে কি না, আর জমিটি সরকারি (খাস), অর্পিত বা অধিগ্রহণকৃত নয় তা দেখান।'],
                    ['If the owner has died, check the heirs\' (warish) certificate and that every heir agrees to the sale. Shares depend on the law that applies to the family, so ask a lawyer.', 'মালিক মারা গেলে ওয়ারিশ সনদ এবং সব ওয়ারিশ বিক্রিতে রাজি কি না দেখুন। অংশ পরিবারের জন্য প্রযোজ্য আইনের ওপর নির্ভর করে, তাই আইনজীবীকে জিজ্ঞাসা করুন।'],
                ]],
                ['id' => 'flats', 'h' => ['For a flat', 'ফ্ল্যাটের ক্ষেত্রে'], 'kind' => 'text', 'items' => [
                    ['The same checks apply to the land under the building. In addition, ask for the approved building plan from the authority and check the land share written for your flat.', 'ভবনের নিচের জমিতেও একই যাচাই প্রযোজ্য। এর সাথে কর্তৃপক্ষের অনুমোদিত নকশা চান এবং আপনার ফ্ল্যাটের জন্য লেখা জমির অংশ দেখুন।'],
                ]],
            ],
            'faq' => [
                ['What is the difference between a khatian and a deed?', 'A deed (দলিল) records a transaction between people. A khatian is the government record of who holds the land. For a safe purchase the two should agree.', 'খতিয়ান আর দলিলের পার্থক্য কী?', 'দলিল মানুষের মধ্যে লেনদেনের নথি। খতিয়ান কে জমির মালিক তার সরকারি রেকর্ড। নিরাপদ কেনার জন্য দুটি মিলতে হবে।'],
                ['Is mutation necessary after buying?', 'You should do it. Without mutation the government record does not show you as the owner, which can cause problems when you sell, pay tax or apply for a loan.', 'কেনার পর কি নামজারি করা দরকার?', 'করা উচিত। নামজারি না হলে সরকারি রেকর্ডে আপনি মালিক হিসেবে থাকেন না, ফলে বিক্রি, কর দেওয়া বা ঋণের আবেদনে সমস্যা হতে পারে।'],
                ['Can I check land records online?', 'The government offers online services for land records and mutation. Online records are a useful first check, but have a lawyer verify the papers and compare them with the deeds before you pay.', 'অনলাইনে কি জমির রেকর্ড দেখা যায়?', 'সরকার জমির রেকর্ড ও নামজারির অনলাইন সেবা দেয়। অনলাইন রেকর্ড ভালো প্রাথমিক যাচাই, তবে টাকা দেওয়ার আগে আইনজীবীকে দিয়ে কাগজ যাচাই করান এবং দলিলের সাথে মিলান।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-share-and-super-built-up-area', 'buying-property-in-bangladesh-from-abroad'],
            'tools' => ['land-size-converter'],
            'links' => ['land:dhaka', 'land:feni', 'land:purbachal', 'size:5-katha-plot-for-sale', 'size:10-katha-land-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'home-loan-for-a-flat-in-bangladesh' => [
            'short' => ['Home loan', 'হোম লোন'],
            'title' => 'Home Loan for a Flat in Bangladesh: How It Works',
            'h1' => ['Home Loan for a Flat in Bangladesh: How It Works', 'ফ্ল্যাটের জন্য হোম লোন: কীভাবে কাজ করে'],
            'descr' => 'How a home loan for a flat works in Bangladesh: who offers it, the documents banks usually ask for, down payment and EMI, common reasons for rejection, and questions to ask before you sign. Includes an EMI calculator.',
            'lead' => ['A home loan lets you pay for a flat over many years. This page explains how it works, what banks usually ask for and what to check before you sign. It does not quote interest rates, because they differ by bank and change over time: ask your bank for its current terms.',
                       'হোম লোনে অনেক বছর ধরে ফ্ল্যাটের টাকা শোধ করা যায়। এটি কীভাবে কাজ করে, ব্যাংক সাধারণত কী চায় এবং সই করার আগে কী দেখবেন তা এখানে আছে। সুদের হার এখানে দেওয়া হয়নি, কারণ ব্যাংকভেদে আলাদা এবং সময়ের সাথে বদলায়: ব্যাংকের বর্তমান শর্ত জিজ্ঞাসা করুন।'],
            'sections' => [
                ['id' => 'how', 'h' => ['How a home loan works', 'হোম লোন কীভাবে কাজ করে'], 'kind' => 'text', 'items' => [
                    ['You pay a down payment from your own money. The bank finances part of the price, and you repay it in equal monthly instalments (EMI) over an agreed number of years. The flat is normally held as security until the loan is repaid.', 'আপনি নিজের টাকা থেকে ডাউন পেমেন্ট দেন। ব্যাংক দামের একটি অংশ দেয় এবং আপনি নির্ধারিত কয়েক বছরে সমান মাসিক কিস্তিতে (ইএমআই) তা শোধ করেন। ঋণ শোধ না হওয়া পর্যন্ত ফ্ল্যাটটি সাধারণত জামানত থাকে।'],
                ]],
                ['id' => 'who', 'h' => ['Who offers home loans', 'কারা হোম লোন দেয়'], 'kind' => 'list', 'items' => [
                    ['Commercial banks, including Islamic banks, which offer home finance on a profit basis instead of interest.', 'বাণিজ্যিক ব্যাংক, ইসলামী ব্যাংকসহ, যারা সুদের বদলে মুনাফার ভিত্তিতে হোম ফাইন্যান্স দেয়।'],
                    ['The Bangladesh House Building Finance Corporation (BHBFC).', 'বাংলাদেশ হাউস বিল্ডিং ফাইন্যান্স কর্পোরেশন (বিএইচবিএফসি)।'],
                    ['Housing finance companies and other non-bank financial institutions.', 'হাউজিং ফাইন্যান্স কোম্পানি ও অন্যান্য ননব্যাংক আর্থিক প্রতিষ্ঠান।'],
                ]],
                ['id' => 'documents', 'h' => ['What banks usually ask for', 'ব্যাংক সাধারণত কী চায়'], 'kind' => 'list', 'items' => [
                    ['Identity and tax papers: national ID, TIN and photographs.', 'পরিচয় ও কর সংক্রান্ত কাগজ: জাতীয় পরিচয়পত্র, টিআইএন ও ছবি।'],
                    ['Proof of income: salary certificate and pay slips, or business and trade papers, plus bank statements.', 'আয়ের প্রমাণ: বেতনের সনদ ও পে স্লিপ, অথবা ব্যবসার কাগজ, সাথে ব্যাংক স্টেটমেন্ট।'],
                    ['Property papers: the deed, mutation, tax receipts, the approved plan and the developer\'s agreement.', 'সম্পত্তির কাগজ: দলিল, নামজারি, কর রশিদ, অনুমোদিত নকশা ও ডেভেলপারের চুক্তি।'],
                    ['Your credit history, which the bank checks through the Credit Information Bureau (CIB) of Bangladesh Bank.', 'আপনার ঋণের ইতিহাস, যা ব্যাংক বাংলাদেশ ব্যাংকের ক্রেডিট ইনফরমেশন ব্যুরোর (সিআইবি) মাধ্যমে দেখে।'],
                ]],
                ['id' => 'emi', 'h' => ['Down payment and EMI', 'ডাউন পেমেন্ট ও ইএমআই'], 'kind' => 'text', 'items' => [
                    ['Banks set the largest share of the price they will finance, so you must be ready with the rest as a down payment. The EMI depends on the loan amount, the yearly rate and the number of years.', 'ব্যাংক দামের কত অংশ পর্যন্ত ঋণ দেবে তা ঠিক করে, তাই বাকিটা ডাউন পেমেন্ট হিসেবে আপনাকে তৈরি রাখতে হবে। ইএমআই নির্ভর করে ঋণের পরিমাণ, বার্ষিক হার ও বছরের সংখ্যার ওপর।'],
                    ['The standard formula is EMI = P × r × (1 + r)^n ÷ ((1 + r)^n − 1), where P is the loan amount, r is the monthly rate (the yearly rate ÷ 12 ÷ 100) and n is the number of months. The EMI calculator on this site does the sum for you.', 'প্রচলিত সূত্র হলো ইএমআই = P × r × (1 + r)^n ÷ ((1 + r)^n − 1), যেখানে P ঋণের পরিমাণ, r মাসিক হার (বার্ষিক হার ÷ ১২ ÷ ১০০) এবং n মাসের সংখ্যা। এই সাইটের ইএমআই ক্যালকুলেটর হিসাবটি করে দেয়।'],
                ]],
                ['id' => 'rejection', 'h' => ['Common reasons for rejection', 'আবেদন বাতিলের সাধারণ কারণ'], 'kind' => 'list', 'items' => [
                    ['Income that is too low for the EMI, or that cannot be shown on paper.', 'ইএমআইয়ের তুলনায় আয় কম, অথবা আয় কাগজে দেখানো যায় না।'],
                    ['Existing loans or cards that already use much of the income.', 'বিদ্যমান ঋণ বা কার্ডে আয়ের বড় অংশ চলে যাওয়া।'],
                    ['A poor credit record in the CIB report.', 'সিআইবি রিপোর্টে খারাপ ঋণের ইতিহাস।'],
                    ['Property papers that are incomplete, unclear or disputed.', 'সম্পত্তির কাগজ অসম্পূর্ণ, অস্পষ্ট বা বিরোধপূর্ণ।'],
                ]],
                ['id' => 'instalment', 'h' => ['Bank loan or developer instalments?', 'ব্যাংক ঋণ নাকি ডেভেলপারের কিস্তি?'], 'kind' => 'list', 'items' => [
                    ['Developer instalments are agreed with the developer and often run while the building is under construction. Check the penalty for a late instalment.', 'ডেভেলপারের কিস্তি ডেভেলপারের সাথে ঠিক হয় এবং প্রায়ই নির্মাণ চলাকালীন চলে। দেরিতে কিস্তি দিলে জরিমানা দেখুন।'],
                    ['A bank loan can fund a larger part and run for longer, but it needs approval and brings fees and interest or profit.', 'ব্যাংক ঋণ বড় অংশের টাকা দিতে পারে এবং দীর্ঘ সময় চলে, তবে অনুমোদন লাগে এবং ফি ও সুদ বা মুনাফা যোগ হয়।'],
                ]],
                ['id' => 'sign', 'h' => ['Before you sign', 'সই করার আগে'], 'kind' => 'list', 'items' => [
                    ['Ask for the total cost: interest or profit, processing, valuation, legal and insurance fees.', 'মোট খরচ জিজ্ঞাসা করুন: সুদ বা মুনাফা, প্রসেসিং, মূল্যায়ন, আইনি ও বিমা ফি।'],
                    ['Ask whether the rate is fixed or can change, and what happens to your EMI if it changes.', 'হার স্থির না পরিবর্তনযোগ্য এবং বদলালে ইএমআইয়ের কী হবে জিজ্ঞাসা করুন।'],
                    ['Ask about paying early or settling the loan, and the charge for a missed instalment.', 'আগে শোধ বা ঋণ নিষ্পত্তি এবং কিস্তি মিস করার চার্জ সম্পর্কে জিজ্ঞাসা করুন।'],
                ]],
            ],
            'faq' => [
                ['How much can I borrow for a flat?', 'It depends on the bank\'s policy, your income and credit history, and the value of the flat. Ask your bank for its eligibility rules and use the EMI calculator to see what instalment you could manage.', 'ফ্ল্যাটের জন্য কত ঋণ পাব?', 'ব্যাংকের নীতি, আপনার আয় ও ঋণের ইতিহাস এবং ফ্ল্যাটের মূল্যের ওপর নির্ভর করে। ব্যাংকের যোগ্যতার নিয়ম জিজ্ঞাসা করুন এবং কত কিস্তি সামলাতে পারবেন তা ইএমআই ক্যালকুলেটরে দেখুন।'],
                ['Can I get a loan for an under-construction flat?', 'Some banks do, often releasing the money in stages as the building progresses. Policies differ, so ask the bank before you commit to the developer.', 'নির্মাণাধীন ফ্ল্যাটের জন্য কি ঋণ পাওয়া যায়?', 'কিছু ব্যাংক দেয়, প্রায়ই ভবনের অগ্রগতি অনুযায়ী ধাপে ধাপে টাকা ছাড় করে। নীতি আলাদা, তাই ডেভেলপারকে কথা দেওয়ার আগে ব্যাংককে জিজ্ঞাসা করুন।'],
                ['Is an EMI the same as rent?', 'No. An EMI repays your loan, and the flat becomes yours when the loan is cleared. Rent is paid for use only. Compare the full monthly cost of both before you decide.', 'ইএমআই কি ভাড়ার মতো?', 'না। ইএমআই আপনার ঋণ শোধ করে এবং ঋণ শেষ হলে ফ্ল্যাট আপনার হয়। ভাড়া শুধু ব্যবহারের জন্য। সিদ্ধান্তের আগে দুটির পূর্ণ মাসিক খরচ তুলনা করুন।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'ready-vs-under-construction-flats', 'buying-property-in-bangladesh-from-abroad'],
            'tools' => ['home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'size:flat-for-sale-under-1000-sqft', 'size:flat-for-sale-1000-1500-sqft', 'size:2-bedroom-flat-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'buying-property-in-bangladesh-from-abroad' => [
            'short' => ['Buying from abroad (NRB)', 'প্রবাস থেকে কেনা (এনআরবি)'],
            'title' => 'Buying Property in Bangladesh from Abroad: NRB Guide',
            'h1' => ['Buying Property in Bangladesh from Abroad (NRB Guide)', 'প্রবাস থেকে বাংলাদেশে সম্পত্তি কেনা (এনআরবি গাইড)'],
            'descr' => 'A practical guide for non-resident Bangladeshis buying a flat or land in Bangladesh: steps from abroad, paying safely, power of attorney, common mistakes and what to do after you buy.',
            'lead' => ['Many Bangladeshis living abroad buy a flat or land back home. You can do it safely if you verify the papers independently, pay only through proper banking channels and keep a trusted person on the ground. This is general information; confirm the current rules with a lawyer and your bank.',
                       'প্রবাসে থাকা অনেক বাংলাদেশি দেশে ফ্ল্যাট বা জমি কেনেন। স্বাধীনভাবে কাগজ যাচাই করে, শুধু ব্যাংকিং মাধ্যমে টাকা দিয়ে এবং দেশে একজন বিশ্বস্ত লোক রেখে নিরাপদে তা করা সম্ভব। এটি সাধারণ তথ্য; বর্তমান নিয়ম আইনজীবী ও ব্যাংকের কাছে নিশ্চিত করুন।'],
            'sections' => [
                ['id' => 'before', 'h' => ['Before you start', 'শুরুর আগে'], 'kind' => 'list', 'items' => [
                    ['Hire your own lawyer in Bangladesh, not one suggested only by the seller or an agent.', 'বাংলাদেশে নিজের আইনজীবী নিন, শুধু বিক্রেতা বা এজেন্টের পরামর্শ করা কাউকে নয়।'],
                    ['Choose a trusted person, such as a close relative, who can visit the property and the office on your behalf.', 'একজন বিশ্বস্ত ব্যক্তি, যেমন কাছের আত্মীয়, ঠিক করুন যিনি আপনার পক্ষে সম্পত্তি ও অফিস দেখতে যেতে পারবেন।'],
                    ['Plan to visit before the large payments if you can. If not, arrange a live video visit that shows the site, the building and the papers.', 'সম্ভব হলে বড় অঙ্কের টাকা দেওয়ার আগে নিজে যান। না হলে সাইট, ভবন ও কাগজ দেখানো একটি লাইভ ভিডিও ভিজিটের ব্যবস্থা করুন।'],
                ]],
                ['id' => 'steps', 'h' => ['The steps from abroad', 'প্রবাস থেকে ধাপসমূহ'], 'kind' => 'steps', 'items' => [
                    ['Shortlist online and ask for scanned copies of the deed, the khatian, the mutation, the tax receipts and, for a flat, the approved plan.', 'অনলাইনে বাছাই করুন এবং দলিল, খতিয়ান, নামজারি, কর রশিদ এবং ফ্ল্যাটের ক্ষেত্রে অনুমোদিত নকশার স্ক্যান কপি চান।'],
                    ['Have your lawyer verify the papers independently and search for disputes, mortgages and court cases.', 'আপনার আইনজীবীকে দিয়ে স্বাধীনভাবে কাগজ যাচাই করান এবং বিরোধ, বন্ধক ও মামলা অনুসন্ধান করান।'],
                    ['Have your trusted person, or the lawyer, visit and record a video of the property with the documents.', 'বিশ্বস্ত লোক বা আইনজীবীকে দিয়ে সম্পত্তি ও কাগজের ভিডিও করান।'],
                    ['Sign a clear booking or sale agreement, with the price, the payment schedule and the handover date.', 'দাম, কিস্তির সময়সূচি ও হস্তান্তরের তারিখসহ স্পষ্ট বুকিং বা বিক্রয় চুক্তি সই করুন।'],
                    ['Pay through proper banking channels and keep every transfer record and receipt.', 'ব্যাংকিং মাধ্যমে টাকা দিন এবং প্রতিটি ট্রান্সফার রেকর্ড ও রশিদ রাখুন।'],
                    ['Complete registration of the sale deed, either in person or through a power of attorney holder, then apply for mutation.', 'বিক্রয় দলিল রেজিস্ট্রি সম্পন্ন করুন, নিজে বা পাওয়ার অব অ্যাটর্নি ধারকের মাধ্যমে, তারপর নামজারির আবেদন করুন।'],
                ]],
                ['id' => 'pay', 'h' => ['Paying safely', 'নিরাপদে টাকা পাঠানো'], 'kind' => 'list', 'items' => [
                    ['Send money by bank transfer to the account of the seller or the developer company named in the agreement, not to an agent\'s personal account.', 'চুক্তিতে নাম থাকা বিক্রেতা বা ডেভেলপার কোম্পানির অ্যাকাউন্টে ব্যাংক ট্রান্সফার করুন, এজেন্টের ব্যক্তিগত অ্যাকাউন্টে নয়।'],
                    ['Keep the transfer records. Ask your bank about the account options and the rules for sending money to Bangladesh for a property purchase, including accounts meant for non-residents.', 'ট্রান্সফারের রেকর্ড রাখুন। প্রবাসীদের জন্য অ্যাকাউন্টসহ সম্পত্তি কেনার জন্য বাংলাদেশে টাকা পাঠানোর অপশন ও নিয়ম আপনার ব্যাংকে জিজ্ঞাসা করুন।'],
                    ['Do not pay a large advance before the papers are verified.', 'কাগজ যাচাইয়ের আগে বড় অগ্রিম দেবেন না।'],
                ]],
                ['id' => 'poa', 'h' => ['Power of attorney', 'পাওয়ার অব অ্যাটর্নি'], 'kind' => 'text', 'items' => [
                    ['If you cannot attend registration, you can authorise someone with a power of attorney. A power of attorney signed abroad usually has to be attested, for example through the Bangladesh embassy or consulate, and checked in Bangladesh. The rules change, so ask a lawyer for the current requirements.', 'নিবন্ধনে উপস্থিত থাকতে না পারলে পাওয়ার অব অ্যাটর্নির মাধ্যমে কাউকে ক্ষমতা দিতে পারেন। প্রবাসে সই করা পাওয়ার অব অ্যাটর্নি সাধারণত সত্যায়িত করতে হয়, যেমন বাংলাদেশ দূতাবাস বা কনসুলেটের মাধ্যমে, এবং বাংলাদেশে যাচাই হয়। নিয়ম বদলায়, তাই বর্তমান শর্ত আইনজীবীকে জিজ্ঞাসা করুন।'],
                    ['Name a person you trust, limit the powers to what is needed, keep copies, and never sign a broad document with blanks.', 'বিশ্বস্ত কাউকে নাম দিন, ক্ষমতা যতটুকু দরকার ততটুকুতেই সীমাবদ্ধ রাখুন, কপি রাখুন এবং ফাঁকা রেখে বিস্তৃত ক্ষমতার কাগজে কখনো সই করবেন না।'],
                ]],
                ['id' => 'mistakes', 'h' => ['Common mistakes', 'সাধারণ ভুল'], 'kind' => 'list', 'items' => [
                    ['Paying an advance before the papers are checked.', 'কাগজ যাচাইয়ের আগে অগ্রিম দেওয়া।'],
                    ['Trusting photos, videos and an agent\'s word without independent checks.', 'নিজে যাচাই না করে ছবি, ভিডিও ও এজেন্টের কথায় ভরসা করা।'],
                    ['Buying land without checking the khatian and the mutation.', 'খতিয়ান ও নামজারি না দেখে জমি কেনা।'],
                    ['Giving a power of attorney that is too broad.', 'অতিরিক্ত ব্যাপক পাওয়ার অব অ্যাটর্নি দেওয়া।'],
                    ['Not keeping written receipts and bank records.', 'লিখিত রশিদ ও ব্যাংক রেকর্ড না রাখা।'],
                ]],
                ['id' => 'after', 'h' => ['After you buy', 'কেনার পর'], 'kind' => 'list', 'items' => [
                    ['Finish mutation, move the utility accounts to your name and pay the land development tax each year.', 'নামজারি শেষ করুন, ইউটিলিটি অ্যাকাউন্ট আপনার নামে নিন এবং প্রতি বছর ভূমি উন্নয়ন কর দিন।'],
                    ['Appoint a reliable caretaker or manager if the property will be empty or rented out.', 'সম্পত্তি খালি বা ভাড়া থাকলে একজন নির্ভরযোগ্য তত্ত্বাবধায়ক বা ম্যানেজার নিয়োগ করুন।'],
                    ['Keep digital copies of every document in more than one place.', 'প্রতিটি কাগজের ডিজিটাল কপি একাধিক জায়গায় রাখুন।'],
                    ['Before selling, ask your bank and lawyer how sale proceeds can be sent abroad.', 'বিক্রির আগে বিক্রয়ের টাকা বিদেশে পাঠানোর নিয়ম আপনার ব্যাংক ও আইনজীবীকে জিজ্ঞাসা করুন।'],
                ]],
            ],
            'faq' => [
                ['Can a non-resident Bangladeshi buy property in Bangladesh?', 'Bangladeshi citizens living abroad can generally buy property in Bangladesh. Rules for foreign citizens differ. Confirm your own situation with a lawyer.', 'প্রবাসী বাংলাদেশি কি বাংলাদেশে সম্পত্তি কিনতে পারেন?', 'বিদেশে থাকা বাংলাদেশি নাগরিকরা সাধারণত বাংলাদেশে সম্পত্তি কিনতে পারেন। বিদেশি নাগরিকদের জন্য নিয়ম আলাদা। নিজের অবস্থা আইনজীবীর কাছে নিশ্চিত করুন।'],
                ['Can I buy without visiting?', 'People do, using a trusted lawyer and relative, but it adds risk. Verify the papers independently, arrange a live video visit, and consider a visit before large payments.', 'না গিয়ে কি কেনা যায়?', 'অনেকে বিশ্বস্ত আইনজীবী ও আত্মীয়ের মাধ্যমে কেনেন, তবে ঝুঁকি বাড়ে। কাগজ স্বাধীনভাবে যাচাই করুন, লাইভ ভিডিও ভিজিটের ব্যবস্থা করুন এবং বড় অঙ্ক দেওয়ার আগে একবার যাওয়ার কথা ভাবুন।'],
                ['How do I avoid fraud?', 'Use your own lawyer, pay only by bank to the named seller or company, get written receipts, check the developer\'s record, and be careful if a price looks far too low.', 'প্রতারণা কীভাবে এড়াব?', 'নিজের আইনজীবী নিন, শুধু নামধারী বিক্রেতা বা কোম্পানির অ্যাকাউন্টে ব্যাংকে টাকা দিন, লিখিত রশিদ নিন, ডেভেলপারের রেকর্ড দেখুন এবং দাম অস্বাভাবিক কম হলে সতর্ক হোন।'],
            ],
            'related' => ['land-records-and-deeds-bangladesh', 'how-to-buy-a-flat-in-bangladesh', 'home-loan-for-a-flat-in-bangladesh'],
            'tools' => ['land-size-converter', 'home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'land:dhaka', 'flat:feni', 'land:feni', 'flat:chittagong', 'compare:dhaka-chittagong'],
        ],
    ];
}

/** Calculators. 'faq' entries are [q_en, a_en, q_bn, a_bn]. */
function guide_tools(): array
{
    return [
        'land-size-converter' => [
            'short' => ['Land size converter', 'জমির মাপ রূপান্তর'],
            'title' => 'Land Size Converter: Katha, Decimal, Bigha, Sqft',
            'h1' => ['Land Size Converter: Katha, Decimal, Bigha, Sqft', 'জমির মাপ রূপান্তর: কাঠা, শতক, বিঘা, বর্গফুট'],
            'descr' => 'Convert between katha, decimal (shotangsho), bigha, square feet, acre and square metre. Set the katha size to match your area. Free calculator for buyers of land and plots in Bangladesh.',
            'lead' => ['Enter a size in any unit and see it in all the others. The katha is not the same everywhere, so you can change its size to match your deed. The standard Dhaka measure is 720 square feet.',
                       'যেকোনো এককে আকার লিখলে বাকি সব এককে দেখুন। কাঠার মাপ সব জায়গায় এক নয়, তাই দলিল অনুযায়ী এর মাপ বদলাতে পারবেন। ঢাকার প্রচলিত মাপ ৭২০ বর্গফুট।'],
            'faq' => [
                ['How many square feet are in a katha?', 'In the standard Dhaka measure, 1 katha is 720 square feet. Katha differs by region, so check the measure written on the deed and set it in the converter.', 'এক কাঠায় কত বর্গফুট?', 'ঢাকার প্রচলিত মাপে ১ কাঠা ৭২০ বর্গফুট। অঞ্চলভেদে কাঠা আলাদা, তাই দলিলে লেখা মাপ দেখে কনভার্টারে সেট করুন।'],
                ['How do I convert decimal (shotangsho) to katha?', 'One decimal is 435.6 square feet, so with a 720 sqft katha, 1 decimal is about 0.605 katha and 1 katha is about 1.65 decimal.', 'শতাংশ থেকে কাঠায় কীভাবে বদলাব?', 'এক শতাংশ ৪৩৫.৬ বর্গফুট, তাই ৭২০ বর্গফুটের কাঠায় ১ শতাংশ প্রায় ০.৬০৫ কাঠা এবং ১ কাঠা প্রায় ১.৬৫ শতাংশ।'],
                ['How many katha are in a bigha?', 'In the standard Dhaka measure 1 bigha is 20 katha, or 14,400 square feet. Bigha differs by region too, so confirm it for your area.', 'এক বিঘায় কত কাঠা?', 'ঢাকার প্রচলিত মাপে ১ বিঘা ২০ কাঠা বা ১৪,৪০০ বর্গফুট। বিঘাও অঞ্চলভেদে আলাদা, তাই আপনার এলাকার মাপ নিশ্চিত করুন।'],
            ],
            'related' => ['land-share-and-super-built-up-area', 'land-records-and-deeds-bangladesh'],
            'links' => ['land:dhaka', 'land:feni', 'size:3-katha-plot-for-sale', 'size:5-katha-plot-for-sale', 'size:10-katha-land-for-sale', 'size:1-bigha-land-for-sale'],
        ],
        'home-loan-emi-calculator' => [
            'short' => ['Home loan EMI calculator', 'হোম লোন ইএমআই ক্যালকুলেটর'],
            'title' => 'Home Loan EMI Calculator for Bangladesh',
            'h1' => ['Home Loan EMI Calculator', 'হোম লোন ইএমআই ক্যালকুলেটর'],
            'descr' => 'Work out the monthly instalment (EMI), total payment and interest for a flat loan. Enter the price, down payment, your bank\'s rate and the years. Includes a year-by-year summary.',
            'lead' => ['Enter the price of the flat, your down payment, the yearly rate your bank quotes and the number of years. The calculator shows the monthly instalment, the total you will pay and the interest. The values shown at first are only examples: replace them with your own.',
                       'ফ্ল্যাটের দাম, ডাউন পেমেন্ট, ব্যাংকের বলা বার্ষিক হার ও বছরের সংখ্যা লিখুন। ক্যালকুলেটর মাসিক কিস্তি, মোট পরিশোধ ও সুদ দেখাবে। শুরুর মানগুলো শুধু উদাহরণ: নিজের মান দিয়ে বদলে নিন।'],
            'faq' => [
                ['How is the EMI calculated?', 'EMI = P × r × (1 + r)^n ÷ ((1 + r)^n − 1), where P is the loan amount, r is the monthly rate (the yearly rate ÷ 12 ÷ 100) and n is the number of months. If the rate is zero, the EMI is simply the loan divided by the months.', 'ইএমআই কীভাবে হিসাব হয়?', 'ইএমআই = P × r × (1 + r)^n ÷ ((1 + r)^n − 1), যেখানে P ঋণ, r মাসিক হার (বার্ষিক হার ÷ ১২ ÷ ১০০) এবং n মাসের সংখ্যা। হার শূন্য হলে ইএমআই শুধু ঋণ ÷ মাস।'],
                ['Is this the exact amount my bank will charge?', 'No. It is an estimate using the standard reducing-balance formula. Banks may add fees, use different methods, or change the rate, so ask your bank for its schedule.', 'ব্যাংক কি ঠিক এই অঙ্কই নেবে?', 'না, এটি প্রচলিত হ্রাসমান স্থিতির সূত্রে একটি আনুমানিক হিসাব। ব্যাংক ফি যোগ করতে, ভিন্ন পদ্ধতি ব্যবহার করতে বা হার বদলাতে পারে, তাই ব্যাংকের কাছ থেকে তাদের সূচি নিন।'],
                ['What rate should I enter?', 'Use the rate your bank quotes you. Rates differ by bank and change over time, so this page does not suggest one.', 'কত হার দেব?', 'ব্যাংক আপনাকে যে হার বলে সেটি দিন। হার ব্যাংকভেদে আলাদা ও সময়ের সাথে বদলায়, তাই এই পেজ কোনো হার সুপারিশ করে না।'],
            ],
            'related' => ['home-loan-for-a-flat-in-bangladesh', 'how-to-buy-a-flat-in-bangladesh'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'size:flat-for-sale-under-1000-sqft', 'size:flat-for-sale-1000-1500-sqft', 'size:2-bedroom-flat-for-sale'],
        ],
    ];
}

/* ---------- URLs and links ---------- */

function guide_url(?string $slug = null): string
{
    return base_path() . '/guides/' . ($slug ? $slug . '/' : '');
}

function tool_url(string $slug): string
{
    return base_path() . '/tools/' . $slug . '/';
}

/** Turns codes like 'flat:dhaka', 'size:3-bedroom-flat-for-sale', 'compare:uttara-bashundhara' into [href, label] chips. */
function guide_links(array $codes): array
{
    $out = [];
    $types = property_types();
    foreach ($codes as $code) {
        [$kind, $arg] = array_pad(explode(':', $code, 2), 2, '');
        if (isset($types[$kind])) {
            $place = property_place($arg);
            if ($place) {
                $out[] = [property_url($kind, $arg), $types[$kind]['en'] . ' for Sale in ' . $place['name']];
            }
        } elseif ($kind === 'size' && isset(property_sizes()[$arg])) {
            $out[] = [property_size_url($arg), property_sizes()[$arg]['h1']];
        } elseif ($kind === 'compare') {
            [$x, $y] = array_pad(explode('-', $arg, 2), 2, '');
            if (property_place($x) && property_place($y)) {
                $out[] = [property_compare_url($x, $y), property_place($x)['name'] . ' vs ' . property_place($y)['name']];
            }
        }
    }
    return $out;
}

/** Chips to every guide and tool (for the property pages, the footer and the hub). */
function guide_all_chips(?string $exclude = null): array
{
    $out = [];
    foreach (guide_pages() as $slug => $g) {
        if ($slug !== $exclude) {
            $out[] = [guide_url($slug), $g['h1'][0]];
        }
    }
    foreach (guide_tools() as $slug => $t) {
        if ($slug !== $exclude) {
            $out[] = [tool_url($slug), $t['short'][0]];
        }
    }
    return $out;
}

function guide_all_paths(): array
{
    $paths = [guide_url()];
    foreach (array_keys(guide_pages()) as $s) { $paths[] = guide_url($s); }
    foreach (array_keys(guide_tools()) as $s) { $paths[] = tool_url($s); }
    return $paths;
}
