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
            'related' => ['ready-vs-under-construction-flats', 'land-share-and-super-built-up-area', 'land-records-and-deeds-bangladesh', 'home-loan-for-a-flat-in-bangladesh', 'hidden-costs-of-buying-a-flat-in-bangladesh', 'apartment-construction-quality-and-safety'],
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
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-share-and-super-built-up-area', 'home-loan-for-a-flat-in-bangladesh', 'apartment-construction-quality-and-safety'],
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
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-records-and-deeds-bangladesh', 'ready-vs-under-construction-flats', 'hidden-costs-of-buying-a-flat-in-bangladesh'],
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
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'land-share-and-super-built-up-area', 'buying-property-in-bangladesh-from-abroad', 'joint-venture-for-landowners'],
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
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'ready-vs-under-construction-flats', 'buying-property-in-bangladesh-from-abroad', 'hidden-costs-of-buying-a-flat-in-bangladesh', 'flat-or-plot-which-to-buy'],
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
            'related' => ['land-records-and-deeds-bangladesh', 'how-to-buy-a-flat-in-bangladesh', 'home-loan-for-a-flat-in-bangladesh', 'flat-or-plot-which-to-buy'],
            'tools' => ['land-size-converter', 'home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'land:dhaka', 'flat:feni', 'land:feni', 'flat:chittagong', 'compare:dhaka-chittagong'],
        ],

        /* ------------------------------------------------------------------ */
        'joint-venture-for-landowners' => [
            'short' => ['Joint venture for landowners', 'জমির মালিকদের জয়েন্ট ভেঞ্চার'],
            'title' => 'Joint Venture with a Developer: What Landowners Should Know',
            'h1' => ['Joint Venture with a Developer: What Landowners Should Know', 'ডেভেলপারের সাথে জয়েন্ট ভেঞ্চার: জমির মালিকদের যা জানা দরকার'],
            'descr' => 'How a landowner and developer joint venture works in Bangladesh, how it differs from selling the land, how to choose a developer, what the agreement should cover and how to protect yourself.',
            'lead' => ['In a joint venture the landowner provides the land and the developer builds on it, and both share the finished flats. It can suit owners who want built space instead of a lump sum, but the agreement decides who is protected. This is general information, not legal advice.',
                       'জয়েন্ট ভেঞ্চারে জমির মালিক জমি দেন আর ডেভেলপার তাতে ভবন বানান, এবং তৈরি ফ্ল্যাট দুপক্ষ ভাগ করে নেয়। একবারে টাকার বদলে তৈরি জায়গা চান এমন মালিকদের জন্য এটি মানানসই হতে পারে, তবে চুক্তিই ঠিক করে কে সুরক্ষিত থাকবেন। এটি সাধারণ তথ্য, আইনি পরামর্শ নয়।'],
            'sections' => [
                ['id' => 'what', 'h' => ['What a joint venture means', 'জয়েন্ট ভেঞ্চার মানে কী'], 'kind' => 'text', 'items' => [
                    ['The landowner contributes the land. The developer arranges the design, the approvals, the money and the construction. When the building is finished, the landowner receives an agreed share of the flats and the developer keeps the rest to sell.', 'জমির মালিক জমি দেন। ডেভেলপার নকশা, অনুমোদন, অর্থ ও নির্মাণের ব্যবস্থা করেন। ভবন শেষ হলে মালিক ফ্ল্যাটের একটি নির্ধারিত অংশ পান এবং বাকিটা ডেভেলপার বিক্রির জন্য রাখেন।'],
                ]],
                ['id' => 'compare', 'h' => ['Joint venture or outright sale?', 'জয়েন্ট ভেঞ্চার নাকি সরাসরি বিক্রি?'], 'kind' => 'table',
                 'cols' => [['', ''], ['Joint venture', 'জয়েন্ট ভেঞ্চার'], ['Selling the land', 'জমি বিক্রি']],
                 'rows' => [
                    [['Money', 'টাকা'], ['You get built flats over time, often with little cash at the start', 'সময়ের সাথে তৈরি ফ্ল্যাট পান, শুরুতে প্রায়ই নগদ কম'], ['You get the price, usually at once or in instalments', 'দাম পান, সাধারণত একসাথে বা কিস্তিতে']],
                    [['Upside', 'সম্ভাব্য লাভ'], ['You share in the value of the finished building', 'তৈরি ভবনের মূল্যের অংশীদার হন'], ['The price is fixed when you sell', 'বিক্রির সময়ই দাম ঠিক হয়ে যায়']],
                    [['Risk', 'ঝুঁকি'], ['Delay, a stalled project or a weak developer can leave you waiting', 'দেরি, থেমে যাওয়া প্রকল্প বা দুর্বল ডেভেলপার আপনাকে অপেক্ষায় রাখতে পারে'], ['Little risk after the sale is complete', 'বিক্রি সম্পূর্ণ হলে ঝুঁকি কম']],
                    [['Effort', 'ঝামেলা'], ['You stay involved until handover', 'হস্তান্তর পর্যন্ত জড়িত থাকতে হয়'], ['The deal ends at registration', 'রেজিস্ট্রিতেই লেনদেন শেষ']],
                 ]],
                ['id' => 'developer', 'h' => ['Choosing a developer', 'ডেভেলপার বাছাই'], 'kind' => 'list', 'items' => [
                    ['Visit completed projects and speak to the owners and to other landowners who worked with the developer.', 'সম্পন্ন প্রকল্প দেখুন এবং মালিকদের ও এই ডেভেলপারের সাথে কাজ করা অন্য জমির মালিকদের সাথে কথা বলুন।'],
                    ['Ask whether projects were handed over on time and whether the landowners received their flats as agreed.', 'প্রকল্প সময়মতো হস্তান্তর হয়েছে কি না এবং মালিকরা চুক্তি অনুযায়ী ফ্ল্যাট পেয়েছেন কি না জিজ্ঞাসা করুন।'],
                    ['Check how many projects the developer is running at once and whether it has the money and the team to finish yours.', 'ডেভেলপার একসাথে কয়টি প্রকল্প চালাচ্ছে এবং আপনার প্রকল্প শেষ করার অর্থ ও দল আছে কি না দেখুন।'],
                    ['Compare offers from more than one developer rather than accepting the first.', 'প্রথম প্রস্তাবে রাজি না হয়ে একাধিক ডেভেলপারের প্রস্তাব তুলনা করুন।'],
                ]],
                ['id' => 'agreement', 'h' => ['What the agreement should cover', 'চুক্তিতে কী থাকা উচিত'], 'kind' => 'list', 'items' => [
                    ['The land and its papers, described exactly, and the ownership you are bringing to the project.', 'জমি ও তার কাগজ হুবহু বর্ণনা, এবং প্রকল্পে আপনি যে মালিকানা আনছেন।'],
                    ['Your share written as named flats, with floor and direction, not only as a percentage.', 'আপনার অংশ নির্দিষ্ট ফ্ল্যাট হিসেবে ফ্লোর ও দিকসহ লেখা, শুধু শতকরা হিসেবে নয়।'],
                    ['Any signing or advance money, and exactly when it is paid.', 'কোনো সাইনিং বা অগ্রিম টাকা এবং ঠিক কখন দেওয়া হবে।'],
                    ['The completion date, the penalty for delay, and your right to end the agreement if the project stalls.', 'সমাপ্তির তারিখ, দেরির জরিমানা এবং প্রকল্প থেমে গেলে চুক্তি বাতিলের অধিকার।'],
                    ['Whether the developer pays a rent or allowance if you have to live elsewhere while the building is built.', 'ভবন তৈরির সময় অন্যত্র থাকতে হলে ডেভেলপার ভাড়া বা ভাতা দেবে কি না।'],
                    ['Who applies for the approvals from the authority and who pays for them.', 'কর্তৃপক্ষের অনুমোদনের আবেদন কে করবে এবং খরচ কে দেবে।'],
                    ['Exactly what any power of attorney allows, and for how long. The developer\'s share of the land should pass to the buyers only as flats are sold or built.', 'কোনো পাওয়ার অব অ্যাটর্নি ঠিক কী কী ক্ষমতা দেয় এবং কতদিনের জন্য। ডেভেলপারের অংশের জমি ফ্ল্যাট বিক্রি বা নির্মাণের সাথে সাথে ক্রেতাদের কাছে যাওয়া উচিত।'],
                    ['Who bears taxes and fees, and how disputes will be settled.', 'কর ও ফি কে বহন করবে এবং বিরোধ কীভাবে মেটানো হবে।'],
                ]],
                ['id' => 'protect', 'h' => ['Protecting yourself', 'নিজেকে সুরক্ষিত রাখা'], 'kind' => 'list', 'items' => [
                    ['Use your own lawyer, not the developer\'s, to read and negotiate the agreement. Ask which documents should be registered.', 'চুক্তি পড়া ও দরকষাকষির জন্য ডেভেলপারের নয়, নিজের আইনজীবী নিন। কোন কাগজ নিবন্ধিত হওয়া উচিত জিজ্ঞাসা করুন।'],
                    ['Do not hand over the original deeds or a broad power of attorney early. Keep the powers narrow and time-limited.', 'আসল দলিল বা ব্যাপক পাওয়ার অব অ্যাটর্নি আগেভাগে দেবেন না। ক্ষমতা সীমিত ও সময়সীমাযুক্ত রাখুন।'],
                    ['Keep copies of everything, and visit the site during construction.', 'সবকিছুর কপি রাখুন এবং নির্মাণের সময় সাইটে যান।'],
                    ['Ask a tax adviser about the tax and fee effects for you, because a joint venture can have them for both sides.', 'আপনার ওপর কর ও ফি-র প্রভাব কর পরামর্শককে জিজ্ঞাসা করুন, কারণ জয়েন্ট ভেঞ্চারে দুপক্ষেরই তা থাকতে পারে।'],
                ]],
            ],
            'faq' => [
                ['What share does a landowner get?', 'There is no standard share. It depends on the location, the size and shape of the plot, the road width, what can be built and the market. Compare offers from several developers and write the share as specific flats.', 'জমির মালিক কত অংশ পান?', 'কোনো প্রচলিত অংশ নেই। এটি অবস্থান, প্লটের আকার ও আকৃতি, রাস্তার প্রস্থ, কী বানানো যাবে এবং বাজারের ওপর নির্ভর করে। কয়েকজন ডেভেলপারের প্রস্তাব তুলনা করুন এবং অংশ নির্দিষ্ট ফ্ল্যাট হিসেবে লিখুন।'],
                ['Should the joint venture agreement be registered?', 'Ask your lawyer which parts to register. Registered documents are generally easier to prove if there is a dispute.', 'জয়েন্ট ভেঞ্চার চুক্তি কি নিবন্ধন করা উচিত?', 'কোন অংশ নিবন্ধন করবেন তা আইনজীবীকে জিজ্ঞাসা করুন। বিরোধ হলে নিবন্ধিত কাগজ সাধারণত প্রমাণ করা সহজ।'],
                ['What if the developer delays or abandons the project?', 'The agreement should set a deadline, a penalty and your right to end it and keep the land. Without such terms your remedies are limited, so settle them before you sign.', 'ডেভেলপার দেরি করলে বা প্রকল্প ছেড়ে দিলে কী হবে?', 'চুক্তিতে সময়সীমা, জরিমানা এবং চুক্তি বাতিল করে জমি রেখে দেওয়ার অধিকার থাকা উচিত। এমন শর্ত না থাকলে আপনার প্রতিকার সীমিত, তাই সই করার আগেই তা ঠিক করুন।'],
            ],
            'related' => ['land-records-and-deeds-bangladesh', 'apartment-construction-quality-and-safety', 'flat-or-plot-which-to-buy'],
            'tools' => ['land-size-converter'],
            'links' => ['land:dhaka', 'land:uttara', 'land:bashundhara', 'land:savar', 'size:5-katha-plot-for-sale', 'size:10-katha-land-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'apartment-construction-quality-and-safety' => [
            'short' => ['Construction quality and safety', 'নির্মাণের মান ও নিরাপত্তা'],
            'title' => 'Apartment Construction Quality and Safety Checklist',
            'h1' => ['Apartment Construction Quality and Safety Checklist', 'অ্যাপার্টমেন্ট নির্মাণের মান ও নিরাপত্তার চেকলিস্ট'],
            'descr' => 'How to check the quality and safety of an apartment building in Bangladesh: approved plan, soil test and structural design, the National Building Code (BNBC), foundation, steel and cement, fire safety and what to look at at each construction stage.',
            'lead' => ['Bangladesh lies in an earthquake-prone region, so the strength and safety of a building matter as much as the flat itself. You cannot judge everything yourself, but you can ask the right questions and bring in an engineer. This is general information, not an engineering opinion.',
                       'বাংলাদেশ ভূমিকম্পপ্রবণ অঞ্চলে, তাই ফ্ল্যাটের মতোই ভবনের শক্তি ও নিরাপত্তা গুরুত্বপূর্ণ। সবকিছু নিজে বিচার করা যায় না, তবে সঠিক প্রশ্ন করতে এবং একজন প্রকৌশলীকে আনতে পারেন। এটি সাধারণ তথ্য, প্রকৌশলগত মতামত নয়।'],
            'sections' => [
                ['id' => 'papers', 'h' => ['Papers to ask for', 'যে কাগজ চাইবেন'], 'kind' => 'list', 'items' => [
                    ['The approved building plan from the authority (RAJUK in Dhaka, CDA in Chittagong, or the local pourashava), and a check that the building follows it.', 'কর্তৃপক্ষের (ঢাকায় রাজউক, চট্টগ্রামে সিডিএ, বা স্থানীয় পৌরসভা) অনুমোদিত নকশা এবং ভবন সেটি মেনে হচ্ছে কি না তার যাচাই।'],
                    ['The structural design made by a qualified engineer, and the soil test report it was based on.', 'যোগ্য প্রকৌশলীর করা স্ট্রাকচারাল ডিজাইন এবং যে মাটি পরীক্ষার রিপোর্টের ভিত্তিতে তা হয়েছে।'],
                    ['A confirmation that the design follows the Bangladesh National Building Code (BNBC), which sets the rules for design, construction and safety.', 'ডিজাইন বাংলাদেশ ন্যাশনাল বিল্ডিং কোড (বিএনবিসি) মেনে হয়েছে তার নিশ্চয়তা, যা নকশা, নির্মাণ ও নিরাপত্তার নিয়ম ঠিক করে।'],
                    ['Whether the building has, or will get, the completion or occupancy certificate, and what the fire safety arrangements and any required clearance are.', 'ভবনের সমাপ্তি বা অকুপেন্সি সনদ আছে বা পাওয়া যাবে কি না, এবং অগ্নি নিরাপত্তার ব্যবস্থা ও প্রয়োজনীয় ছাড়পত্র কী।'],
                ]],
                ['id' => 'structure', 'h' => ['Foundation and structure', 'ভিত্তি ও কাঠামো'], 'kind' => 'list', 'items' => [
                    ['Ask what type of foundation was used (for example piles) and why, based on the soil test.', 'কোন ধরনের ভিত্তি (যেমন পাইল) ব্যবহৃত হয়েছে এবং মাটি পরীক্ষার ভিত্তিতে কেন, জিজ্ঞাসা করুন।'],
                    ['Check that the number of floors being built matches the number in the approved plan. Do not buy in a building built higher than it was approved for.', 'যে কয়তলা বানানো হচ্ছে তা অনুমোদিত নকশার তলার সংখ্যার সাথে মেলে কি না দেখুন। অনুমোদনের চেয়ে বেশি উঁচু ভবনে কিনবেন না।'],
                    ['Look for cracks in columns, beams and walls, and ask about any that you find.', 'কলাম, বিম ও দেয়ালে ফাটল খুঁজুন এবং পেলে সে সম্পর্কে জিজ্ঞাসা করুন।'],
                ]],
                ['id' => 'materials', 'h' => ['Materials', 'নির্মাণ সামগ্রী'], 'kind' => 'list', 'items' => [
                    ['Ask which steel reinforcement (rod) and cement are used, and ask to see the supplier\'s test certificates.', 'কোন রড ও সিমেন্ট ব্যবহৃত হচ্ছে জিজ্ঞাসা করুন এবং সরবরাহকারীর পরীক্ষার সনদ দেখতে চান।'],
                    ['Ask whether the concrete is tested in a laboratory during construction, and ask to see the results.', 'নির্মাণের সময় কংক্রিট ল্যাবরেটরিতে পরীক্ষা করা হয় কি না জিজ্ঞাসা করুন এবং ফলাফল দেখতে চান।'],
                    ['Check the bricks or blocks, the finish of the walls and the quality of the fittings in the sample or finished flats.', 'নমুনা বা তৈরি ফ্ল্যাটে ইট বা ব্লক, দেয়ালের ফিনিশ ও ফিটিংসের মান দেখুন।'],
                ]],
                ['id' => 'safety', 'h' => ['Safety features', 'নিরাপত্তার ব্যবস্থা'], 'kind' => 'list', 'items' => [
                    ['Fire exits, staircases and their widths, fire extinguishers and alarms, and clear access for fire vehicles.', 'অগ্নি নির্গমন পথ, সিঁড়ি ও তার প্রস্থ, অগ্নিনির্বাপক যন্ত্র ও অ্যালার্ম, এবং ফায়ার সার্ভিসের গাড়ির জন্য খোলা পথ।'],
                    ['A lift that is serviced and certified, a working generator and a safe water tank.', 'রক্ষণাবেক্ষণ ও সনদপ্রাপ্ত লিফট, চালু জেনারেটর এবং নিরাপদ পানির ট্যাংক।'],
                    ['Open space around the building and a way out to the roof or an open area in an emergency.', 'ভবনের চারপাশে খোলা জায়গা এবং জরুরি অবস্থায় ছাদ বা খোলা জায়গায় যাওয়ার পথ।'],
                ]],
                ['id' => 'stages', 'h' => ['What to look at at each stage', 'প্রতিটি ধাপে কী দেখবেন'], 'kind' => 'table',
                 'cols' => [['Stage', 'ধাপ'], ['What to check', 'কী দেখবেন'], ['', '']],
                 'rows' => [
                    [['Foundation', 'ভিত্তি'], ['The foundation type matches the soil test and the design drawings', 'ভিত্তির ধরন মাটি পরীক্ষা ও ডিজাইন নকশার সাথে মেলে'], ['', '']],
                    [['Columns, beams and slabs', 'কলাম, বিম ও স্ল্যাব'], ['Steel is tied as designed, concrete is poured and cured with care, and tests are done', 'রড নকশা অনুযায়ী বাঁধা, কংক্রিট যত্নসহ ঢালা ও কিউরিং করা, এবং পরীক্ষা হচ্ছে'], ['', '']],
                    [['Walls and plaster', 'দেয়াল ও প্লাস্টার'], ['Straight walls, firm plaster and no early cracks', 'সোজা দেয়াল, শক্ত প্লাস্টার এবং আগেভাগে ফাটল নেই'], ['', '']],
                    [['Fittings and utilities', 'ফিটিংস ও ইউটিলিটি'], ['Electrical and plumbing work done to a standard, with no leaks', 'বৈদ্যুতিক ও পানির লাইনের কাজ মান অনুযায়ী, কোনো লিক নেই'], ['', '']],
                    [['Before handover', 'হস্তান্তরের আগে'], ['A full inspection of the flat and the common areas against the agreement', 'চুক্তির সাথে মিলিয়ে ফ্ল্যাট ও কমন এলাকার পূর্ণ পরিদর্শন'], ['', '']],
                 ]],
                ['id' => 'engineer', 'h' => ['Bring an independent engineer', 'স্বাধীন প্রকৌশলী নিন'], 'kind' => 'text', 'items' => [
                    ['For a large purchase, pay a qualified engineer who is not connected to the developer to look at the building, the drawings and the test reports before you commit, and again before handover. The fee is small compared with the risk it can remove.', 'বড় কেনাকাটার আগে ডেভেলপারের সাথে সম্পর্কহীন একজন যোগ্য প্রকৌশলীকে টাকা দিয়ে ভবন, নকশা ও পরীক্ষার রিপোর্ট দেখান, আর হস্তান্তরের আগেও। যে ঝুঁকি এতে কমে তার তুলনায় ফি কম।'],
                ]],
                ['id' => 'flags', 'h' => ['Warning signs', 'সতর্ক সংকেত'], 'kind' => 'list', 'items' => [
                    ['No approved plan, or a building being built higher than the plan.', 'অনুমোদিত নকশা নেই, অথবা নকশার চেয়ে উঁচু ভবন তৈরি হচ্ছে।'],
                    ['The developer will not show the soil test, the design or the test results.', 'ডেভেলপার মাটি পরীক্ষা, ডিজাইন বা পরীক্ষার ফল দেখাতে চান না।'],
                    ['A price that is far below similar flats nearby, with no clear reason.', 'কাছের একই ধরনের ফ্ল্যাটের চেয়ে দাম অনেক কম, অথচ স্পষ্ট কারণ নেই।'],
                    ['Visible poor workmanship, such as uneven walls, wide cracks or damp.', 'চোখে পড়ার মতো খারাপ কাজ, যেমন অসমান দেয়াল, চওড়া ফাটল বা স্যাঁতসেঁতে ভাব।'],
                ]],
            ],
            'faq' => [
                ['What is the BNBC?', 'The Bangladesh National Building Code is the national code that sets requirements for the design, construction and safety of buildings, including for earthquake and fire. Ask the developer to confirm the design follows it.', 'বিএনবিসি কী?', 'বাংলাদেশ ন্যাশনাল বিল্ডিং কোড ভূমিকম্প ও আগুনসহ ভবনের নকশা, নির্মাণ ও নিরাপত্তার প্রয়োজনীয়তা ঠিক করা জাতীয় কোড। ডেভেলপারকে নিশ্চিত করতে বলুন যে নকশা এটি মেনে হয়েছে।'],
                ['Is a soil test necessary?', 'Yes. The soil test shows what the ground can carry and helps the engineer choose the foundation. Ask to see the report and the design that followed it.', 'মাটি পরীক্ষা কি দরকার?', 'হ্যাঁ। মাটি পরীক্ষায় জমি কতটা ভার নিতে পারে তা বোঝা যায় এবং প্রকৌশলী ভিত্তি বেছে নিতে পারেন। রিপোর্ট ও তার ভিত্তিতে করা নকশা দেখতে চান।'],
                ['How can I tell whether a building is safe?', 'You cannot be sure from a visit alone. Check the approved plan, the soil test, the design and the test results, look for cracks and poor work, and have an independent engineer inspect it.', 'ভবন নিরাপদ কি না কীভাবে বুঝব?', 'শুধু একবার দেখে নিশ্চিত হওয়া যায় না। অনুমোদিত নকশা, মাটি পরীক্ষা, ডিজাইন ও পরীক্ষার ফল দেখুন, ফাটল ও খারাপ কাজ খুঁজুন এবং স্বাধীন প্রকৌশলীকে দিয়ে পরিদর্শন করান।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'ready-vs-under-construction-flats', 'joint-venture-for-landowners'],
            'tools' => [],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'flat:uttara', 'flat:dhanmondi', 'size:flat-for-sale-1000-1500-sqft'],
        ],

        /* ------------------------------------------------------------------ */
        'hidden-costs-of-buying-a-flat-in-bangladesh' => [
            'short' => ['Costs beyond the price', 'দামের বাইরের খরচ'],
            'title' => 'Hidden Costs of Buying a Flat in Bangladesh',
            'h1' => ['Hidden Costs of Buying a Flat in Bangladesh', 'ফ্ল্যাট কেনার লুকানো খরচ'],
            'descr' => 'The costs beyond the price when you buy a flat in Bangladesh: registration and taxes, parking, utility connections, service charges, interior work and bank fees, with a way to list them all before you sign.',
            'lead' => ['The price on the brochure is rarely the full cost. Registration, parking, utility connections, charges and fit-out can add up. This guide lists the usual extra costs so you can ask for each one in writing. It gives no amounts, because they change: ask for the current figure for each.',
                       'ব্রোশিওরের দামই সাধারণত পূর্ণ খরচ নয়। রেজিস্ট্রেশন, পার্কিং, ইউটিলিটি সংযোগ, বিভিন্ন চার্জ ও সাজসজ্জা মিলে অঙ্ক বাড়তে পারে। এখানে সাধারণ বাড়তি খরচের তালিকা আছে, যাতে প্রতিটি লিখিত চাইতে পারেন। অঙ্ক দেওয়া হয়নি, কারণ তা বদলায়: প্রতিটির বর্তমান অঙ্ক জিজ্ঞাসা করুন।'],
            'sections' => [
                ['id' => 'costs', 'h' => ['Costs beyond the price', 'দামের বাইরের খরচ'], 'kind' => 'table',
                 'cols' => [['Cost', 'খরচ'], ['What to ask', 'কী জিজ্ঞাসা করবেন'], ['', '']],
                 'rows' => [
                    [['Registration, stamp duty and taxes', 'রেজিস্ট্রেশন, স্ট্যাম্প ও কর'], ['The current amounts set by the government, and who pays which part', 'সরকারের নির্ধারিত বর্তমান অঙ্ক এবং কোন অংশ কে দেবে'], ['', '']],
                    [['Parking', 'পার্কিং'], ['Whether a space is included or priced separately, and which space it is', 'জায়গা দামে ধরা না আলাদা, এবং কোন জায়গাটি'], ['', '']],
                    [['Utility connections', 'ইউটিলিটি সংযোগ'], ['One-time charges for electricity, water, sewer and gas, and whether new connections are available for the building', 'বিদ্যুৎ, পানি, নর্দমা ও গ্যাসের এককালীন চার্জ এবং ভবনে নতুন সংযোগ পাওয়া যায় কি না'], ['', '']],
                    [['Lift, generator and common areas', 'লিফট, জেনারেটর ও কমন এলাকা'], ['Whether a one-time or deposit charge applies for shared facilities', 'শেয়ার্ড সুবিধার জন্য এককালীন বা জামানত চার্জ আছে কি না'], ['', '']],
                    [['Monthly service charge', 'মাসিক সার্ভিস চার্জ'], ['The amount per month, what it covers, and how it can change', 'মাসে কত, কী কী ধরে এবং কীভাবে বদলাতে পারে'], ['', '']],
                    [['Floor and view premium', 'ফ্লোর ও ভিউয়ের বাড়তি দাম'], ['Whether the price changes with the floor, the direction or the view', 'ফ্লোর, দিক বা ভিউ অনুযায়ী দাম বদলায় কি না'], ['', '']],
                    [['Legal and bank fees', 'আইনি ও ব্যাংক ফি'], ['Your lawyer\'s fee, and for a loan the processing, valuation and insurance fees', 'আপনার আইনজীবীর ফি, এবং ঋণ হলে প্রসেসিং, মূল্যায়ন ও বিমা ফি'], ['', '']],
                    [['Interior and moving', 'সাজসজ্জা ও স্থানান্তর'], ['What the flat includes and what you must add: cabinets, lights, fans, paint', 'ফ্ল্যাটে কী আছে আর কী আপনাকে যোগ করতে হবে: কেবিনেট, লাইট, ফ্যান, রং'], ['', '']],
                    [['Yearly land development tax', 'বার্ষিক ভূমি উন্নয়ন কর'], ['Whether it is paid on your flat\'s land share, and who arranges it', 'আপনার ফ্ল্যাটের জমির অংশের জন্য তা দিতে হয় কি না এবং কে ব্যবস্থা করবে'], ['', '']],
                 ]],
                ['id' => 'avoid', 'h' => ['How to avoid surprises', 'অপ্রত্যাশিত খরচ এড়ানোর উপায়'], 'kind' => 'steps', 'items' => [
                    ['Ask the seller or developer for a written cost sheet that lists every charge, one-time and monthly.', 'বিক্রেতা বা ডেভেলপারের কাছে প্রতিটি এককালীন ও মাসিক চার্জসহ লিখিত খরচের তালিকা চান।'],
                    ['Check each line with your lawyer, and ask which items are fixed and which can change.', 'প্রতিটি লাইন আইনজীবীর সাথে যাচাই করুন এবং কোনটি স্থির ও কোনটি বদলাতে পারে জিজ্ঞাসা করুন।'],
                    ['Add everything to the price to find the real total, and the real price per square foot. The flat price calculator does the sum.', 'সবকিছু দামের সাথে যোগ করে আসল মোট এবং আসল বর্গফুট প্রতি দাম বের করুন। ফ্ল্যাট প্রাইস ক্যালকুলেটর হিসাবটি করে দেয়।'],
                    ['Make sure the agreement says that nothing else will be charged without your written consent.', 'চুক্তিতে লেখা আছে কি না দেখুন যে আপনার লিখিত সম্মতি ছাড়া আর কিছু ধরা হবে না।'],
                ]],
            ],
            'faq' => [
                ['Is parking included in the price of the flat?', 'Not always. Some developers include one space and others price it separately. Ask, and have the space and the price written in the agreement.', 'ফ্ল্যাটের দামে কি পার্কিং ধরা থাকে?', 'সবসময় নয়। কিছু ডেভেলপার একটি জায়গা দামে ধরে, কিছু আলাদা দাম নেয়। জিজ্ঞাসা করুন এবং জায়গা ও দাম চুক্তিতে লিখিয়ে নিন।'],
                ['Does the price include registration costs?', 'Usually not. Registration fees and taxes are separate and are set by the government, so ask for the current amounts and who pays each part.', 'দামে কি রেজিস্ট্রেশন খরচ ধরা থাকে?', 'সাধারণত না। রেজিস্ট্রেশন ফি ও কর আলাদা এবং সরকার ঠিক করে, তাই বর্তমান অঙ্ক এবং কোন অংশ কে দেবে জিজ্ঞাসা করুন।'],
                ['Can the service charge change later?', 'Often yes, by decision of the owners\' association. Ask what the charge covers today and how it is decided.', 'সার্ভিস চার্জ কি পরে বদলাতে পারে?', 'প্রায়ই হ্যাঁ, মালিক সমিতির সিদ্ধান্তে। এখন এটি কী কী ধরে এবং কীভাবে ঠিক হয় জিজ্ঞাসা করুন।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'home-loan-for-a-flat-in-bangladesh', 'land-share-and-super-built-up-area'],
            'tools' => ['flat-price-calculator', 'home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'size:flat-for-sale-1000-1500-sqft', 'size:flat-for-sale-1500-2000-sqft', 'size:3-bedroom-flat-for-sale'],
        ],

        /* ------------------------------------------------------------------ */
        'flat-or-plot-which-to-buy' => [
            'short' => ['Flat or plot', 'ফ্ল্যাট নাকি প্লট'],
            'title' => 'Flat or Plot: Which Is Better to Buy?',
            'h1' => ['Flat or Plot: Which Is Better to Buy?', 'ফ্ল্যাট নাকি প্লট: কোনটি কেনা ভালো?'],
            'descr' => 'Flat or plot, new or resale, rent or buy? A plain comparison of what each choice costs you in effort, risk and income, with a way to work out rental yield. No promises of returns.',
            'lead' => ['Neither a flat nor a plot is always the better buy. The right choice depends on your money, your plans and how much effort and risk you can take on. This page sets out the trade-offs. It does not promise any return, because no one can.',
                       'ফ্ল্যাট বা প্লট কোনোটিই সবসময় ভালো কেনা নয়। সঠিক পছন্দ নির্ভর করে আপনার টাকা, পরিকল্পনা এবং কতটা ঝামেলা ও ঝুঁকি নিতে পারবেন তার ওপর। এখানে সুবিধা-অসুবিধা সাজিয়ে দেওয়া হলো। কোনো লাভের প্রতিশ্রুতি নেই, কারণ কেউ তা দিতে পারে না।'],
            'sections' => [
                ['id' => 'compare', 'h' => ['Flat or plot side by side', 'ফ্ল্যাট ও প্লট পাশাপাশি'], 'kind' => 'table',
                 'cols' => [['', ''], ['Flat', 'ফ্ল্যাট'], ['Plot', 'প্লট']],
                 'rows' => [
                    [['Effort', 'ঝামেলা'], ['Ready to live in or rent out', 'থাকার বা ভাড়া দেওয়ার জন্য তৈরি'], ['You must design, get approvals and build', 'নকশা, অনুমোদন ও নির্মাণ নিজেকে করতে হবে']],
                    [['Income', 'আয়'], ['Can earn rent as soon as it is let', 'ভাড়া দিলেই আয় শুরু'], ['Earns nothing until built or sold', 'বানানো বা বিক্রির আগে কোনো আয় নেই']],
                    [['Upkeep', 'রক্ষণাবেক্ষণ'], ['Service charge and repairs in a shared building', 'শেয়ার্ড ভবনে সার্ভিস চার্জ ও মেরামত'], ['A vacant plot needs guarding against encroachment', 'খালি প্লট দখল থেকে রক্ষা করতে হয়']],
                    [['Papers', 'কাগজ'], ['The deed, the land share and the approved plan', 'দলিল, জমির অংশ ও অনুমোদিত নকশা'], ['The deed, the khatian, the mutation and the land class', 'দলিল, খতিয়ান, নামজারি ও জমির শ্রেণি']],
                    [['Flexibility', 'নমনীয়তা'], ['Fixed layout inside', 'ভেতরের নকশা স্থির'], ['You decide what to build, within the rules', 'নিয়মের মধ্যে কী বানাবেন আপনি ঠিক করেন']],
                    [['Main risk', 'প্রধান ঝুঁকি'], ['Building quality, delay and a weak developer', 'ভবনের মান, দেরি ও দুর্বল ডেভেলপার'], ['Disputed or unclear ownership, and the land class', 'বিরোধপূর্ণ বা অস্পষ্ট মালিকানা এবং জমির শ্রেণি']],
                 ]],
                ['id' => 'resale', 'h' => ['New or resale flat', 'নতুন নাকি পুনঃবিক্রয়ের ফ্ল্যাট'], 'kind' => 'list', 'items' => [
                    ['A new flat has fresh finishing and a developer to answer for defects for a period; check what the agreement promises.', 'নতুন ফ্ল্যাটে ফিনিশিং নতুন এবং কিছু সময় ত্রুটির জন্য ডেভেলপার দায়ী থাকে; চুক্তিতে কী প্রতিশ্রুতি আছে দেখুন।'],
                    ['A resale flat can be checked as it stands and may be in an established area, but it may need repairs and the papers have a longer history to verify.', 'পুনঃবিক্রয়ের ফ্ল্যাট যেমন আছে তেমন দেখে যাচাই করা যায় এবং প্রতিষ্ঠিত এলাকায় হতে পারে, তবে মেরামত লাগতে পারে এবং কাগজের ইতিহাস দীর্ঘ বলে যাচাই বেশি।'],
                    ['For a resale flat, check the previous deeds, the mutation, any unpaid dues and the building\'s age and condition.', 'পুনঃবিক্রয়ের ফ্ল্যাটে আগের দলিল, নামজারি, বকেয়া পাওনা এবং ভবনের বয়স ও অবস্থা দেখুন।'],
                ]],
                ['id' => 'rent', 'h' => ['Rent or buy?', 'ভাড়া নাকি কেনা?'], 'kind' => 'list', 'items' => [
                    ['Compare the full monthly cost of buying (the EMI or instalment plus service charge and upkeep) with the rent for a similar flat.', 'কেনার পূর্ণ মাসিক খরচ (ইএমআই বা কিস্তি, সাথে সার্ভিস চার্জ ও রক্ষণাবেক্ষণ) একই ধরনের ফ্ল্যাটের ভাড়ার সাথে তুলনা করুন।'],
                    ['Think about how long you will stay: buying has large one-time costs, so it suits a longer stay.', 'কতদিন থাকবেন ভাবুন: কেনায় বড় এককালীন খরচ আছে, তাই দীর্ঘ সময়ের জন্য এটি বেশি মানায়।'],
                    ['Renting keeps you flexible; buying builds something you own. Neither is right for everyone.', 'ভাড়া আপনাকে নমনীয় রাখে; কেনা আপনার নিজের কিছু গড়ে। কোনোটিই সবার জন্য ঠিক নয়।'],
                ]],
                ['id' => 'yield', 'h' => ['Buying a flat to rent out', 'ভাড়া দেওয়ার জন্য ফ্ল্যাট কেনা'], 'kind' => 'text', 'items' => [
                    ['A simple measure is the gross rental yield: the yearly rent divided by the total cost of buying, as a percentage. For example, ৳30,000 a month is ৳3,60,000 a year, which on a total cost of ৳1,00,00,000 is 3.6%. The figures are only an example.', 'একটি সহজ মাপ হলো মোট ভাড়া-আয়ের হার: বার্ষিক ভাড়াকে কেনার মোট খরচ দিয়ে ভাগ করে শতকরা। যেমন মাসে ৩০,০০০ টাকা মানে বছরে ৩,৬০,০০০ টাকা, যা ১,০০,০০,০০০ টাকা মোট খরচে ৩.৬%। অঙ্কগুলো শুধু উদাহরণ।'],
                    ['The real return is lower: allow for months with no tenant, the service charge, repairs and tax. The flat price calculator shows the gross figure for your numbers.', 'প্রকৃত আয় কম: ভাড়াটিয়া না থাকা মাস, সার্ভিস চার্জ, মেরামত ও করের হিসাব রাখুন। ফ্ল্যাট প্রাইস ক্যালকুলেটর আপনার অঙ্কে মোট হার দেখায়।'],
                ]],
                ['id' => 'ask', 'h' => ['Questions to ask yourself', 'নিজেকে যে প্রশ্ন করবেন'], 'kind' => 'list', 'items' => [
                    ['Do I need somewhere to live soon, or am I buying for later?', 'আমার কি শিগগির থাকার জায়গা দরকার, নাকি পরের জন্য কিনছি?'],
                    ['Can I manage the paperwork and the building of a plot, or do I want something ready?', 'প্লটের কাগজপত্র ও নির্মাণ কি আমি সামলাতে পারব, নাকি তৈরি কিছু চাই?'],
                    ['How much money can I tie up, and for how long?', 'কত টাকা কতদিনের জন্য আটকে রাখতে পারব?'],
                ]],
            ],
            'faq' => [
                ['Which is the better investment, a flat or a plot?', 'Neither is always better. A flat can earn rent but has building and service costs; a plot earns nothing until you build or sell and needs careful paperwork. Decide from your money, your plans and the risks you can take.', 'বিনিয়োগ হিসেবে ফ্ল্যাট না প্লট ভালো?', 'কোনোটিই সবসময় ভালো নয়। ফ্ল্যাট থেকে ভাড়া পাওয়া যায় কিন্তু ভবন ও সার্ভিস খরচ আছে; প্লট বানানো বা বিক্রির আগে কিছু দেয় না এবং কাগজ সাবধানে দেখতে হয়। আপনার টাকা, পরিকল্পনা ও ঝুঁকির সামর্থ্য থেকে ঠিক করুন।'],
                ['Will the price of my flat or plot go up?', 'No one can promise that. Prices can rise, stay flat or fall. Buy because the home or land suits your needs and you can afford it, not because of a promised return.', 'আমার ফ্ল্যাট বা প্লটের দাম কি বাড়বে?', 'কেউ তা নিশ্চিত করে বলতে পারে না। দাম বাড়তে, একই থাকতে বা কমতে পারে। প্রতিশ্রুত লাভের জন্য নয়, বাড়ি বা জমি আপনার প্রয়োজনে মানায় এবং সামর্থ্যে কুলায় বলে কিনুন।'],
            ],
            'related' => ['how-to-buy-a-flat-in-bangladesh', 'home-loan-for-a-flat-in-bangladesh', 'hidden-costs-of-buying-a-flat-in-bangladesh'],
            'tools' => ['flat-price-calculator', 'home-loan-emi-calculator'],
            'links' => ['flat:dhaka', 'land:dhaka', 'apartment:uttara', 'land:purbachal', 'size:5-katha-plot-for-sale', 'compare:uttara-purbachal'],
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
            'related' => ['home-loan-for-a-flat-in-bangladesh', 'how-to-buy-a-flat-in-bangladesh', 'hidden-costs-of-buying-a-flat-in-bangladesh', 'flat-or-plot-which-to-buy'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'size:flat-for-sale-under-1000-sqft', 'size:flat-for-sale-1000-1500-sqft', 'size:2-bedroom-flat-for-sale'],
        ],

        'flat-price-calculator' => [
            'short' => ['Flat price calculator', 'ফ্ল্যাট প্রাইস ক্যালকুলেটর'],
            'title' => 'Flat Price Calculator: Total Cost and Price per Sqft',
            'h1' => ['Flat Price Calculator', 'ফ্ল্যাট প্রাইস ক্যালকুলেটর'],
            'descr' => 'Work out a flat\'s total price from the area and the rate per square foot, add parking and other costs to see the real total and the real price per sqft, and check the gross rental yield.',
            'lead' => ['Enter the area and either the rate per square foot or the total price. Add parking and the other costs you were quoted, and see the real total and the real price per square foot. Add the monthly rent to see the gross rental yield. The starting values are only examples: replace them with your own.',
                       'আকার এবং বর্গফুট প্রতি দাম বা মোট দাম লিখুন। পার্কিং ও আপনাকে বলা অন্যান্য খরচ যোগ করে আসল মোট ও আসল বর্গফুট প্রতি দাম দেখুন। মাসিক ভাড়া দিলে মোট ভাড়া-আয়ের হার দেখাবে। শুরুর মানগুলো শুধু উদাহরণ: নিজের মান দিয়ে বদলে নিন।'],
            'faq' => [
                ['How is the price per square foot worked out?', 'The price divided by the area. Use the same kind of area (net or super built-up) for every flat you compare, and compare the all-in cost, including parking and other charges.', 'বর্গফুট প্রতি দাম কীভাবে বের হয়?', 'দামকে আকার দিয়ে ভাগ করে। তুলনার সব ফ্ল্যাটে একই ধরনের আকার (নিট বা সুপার বিল্ট-আপ) ব্যবহার করুন এবং পার্কিং ও অন্যান্য চার্জসহ মোট খরচ তুলনা করুন।'],
                ['What is the gross rental yield?', 'The yearly rent divided by the total cost of buying, as a percentage. It ignores empty months, service charges, repairs and tax, so the real return is lower.', 'মোট ভাড়া-আয়ের হার কী?', 'বার্ষিক ভাড়াকে কেনার মোট খরচ দিয়ে ভাগ করে শতকরা। এতে খালি মাস, সার্ভিস চার্জ, মেরামত ও কর ধরা হয় না, তাই প্রকৃত আয় কম।'],
                ['What should I put in the other costs box?', 'The one-time costs you were quoted: registration and taxes, utility connections, legal fees and similar. Ask the seller and your lawyer for the current amounts; this page does not guess them.', 'অন্যান্য খরচের ঘরে কী দেব?', 'আপনাকে বলা এককালীন খরচ: রেজিস্ট্রেশন ও কর, ইউটিলিটি সংযোগ, আইনি ফি ইত্যাদি। বিক্রেতা ও আইনজীবীর কাছ থেকে বর্তমান অঙ্ক জেনে নিন; এই পেজ অঙ্ক অনুমান করে না।'],
            ],
            'related' => ['hidden-costs-of-buying-a-flat-in-bangladesh', 'land-share-and-super-built-up-area', 'flat-or-plot-which-to-buy'],
            'links' => ['flat:dhaka', 'apartment:dhaka', 'size:flat-for-sale-1000-1500-sqft', 'size:flat-for-sale-1500-2000-sqft', 'size:3-bedroom-flat-for-sale'],
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
