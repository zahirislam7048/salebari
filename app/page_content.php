<?php
/* Plain-language guide text for the pages that would otherwise be thin: stall, brand and mall pages, the
   directory and utility pages. Each block holds well over 300 words even when a stall or brand has filled in
   almost nothing, and says only things that are true of SaleBari: no invented facts about a seller. */

function pg_wrap(string $inner): string
{
    return '<section class="section"><div class="wrap seo-block page-guide">' . $inner . '</div></section>';
}

function pg_faq(array $qa): string
{
    $h = '';
    foreach ($qa as [$q, $a]) {
        $h .= '<details><summary>' . e($q) . '</summary><p>' . e($a) . '</p></details>';
    }
    return $h;
}

/** About a stall, how to buy from it, visiting it, and common questions. */
function stall_guide_html(array $stall, ?array $mall, array $cats, int $productCount): string
{
    $name = (string) $stall['name'];
    $city = trim((string) ($stall['city'] ?? ''));
    $addr = trim((string) ($stall['address'] ?? ''));
    $loc  = $city !== '' ? ' in ' . $city : '';
    $h  = '<h2>About ' . e($name) . '</h2>';
    $h .= '<p>' . e($name) . ' is a stall listed on SaleBari' . e($loc) . ($addr !== '' ? ', at ' . e($addr) : '') . ($mall ? ', inside ' . e($mall['name']) : '') . '. A stall is a seller\'s own page on SaleBari: it shows who the seller is, where they are, and the products or services they offer, so you can judge a seller before you contact them.</p>';
    $cn = array_map(function ($c) { return e($c['name_en']); }, array_slice($cats, 0, 8));
    $h .= '<p>' . ($productCount > 0
        ? e($name) . ' currently has ' . (int) $productCount . ' product ' . ($productCount === 1 ? 'listing' : 'listings') . ' on SaleBari' . ($cn ? ', in ' . natural_list($cn) : '') . '. Open any listing for photos, details and the seller\'s contact buttons.'
        : 'Product listings from ' . e($name) . ' will appear on this page as the seller adds them. Until then, you can contact the seller through the details above to ask what is available.') . '</p>';
    if (!empty($stall['verified'])) {
        $h .= '<p>This stall carries the Verified badge, which means the SaleBari team has marked it as verified. A badge is a helpful signal, but it is still sensible to confirm price, availability and delivery with the seller before you pay.</p>';
    }
    $h .= '<h2>How to buy from ' . e($name) . '</h2><ol>'
        . '<li>Browse the listings and open the one you want to see the photos and the description.</li>'
        . '<li>Use the WhatsApp or Call button to ask about the price, availability, delivery and warranty. Send the product name so the seller knows which item you mean.</li>'
        . '<li>Agree the price and how you will pay and receive the item. SaleBari does not take payment for products on the site, so the payment is between you and the seller.</li>'
        . '<li>Inspect the item when you receive it, and keep the chat, the invoice and any warranty card.</li></ol>';
    $h .= '<h2>Visiting ' . e($name) . ($mall ? ' at ' . e($mall['name']) : '') . '</h2>';
    $h .= '<p>If you plan to visit the stall' . e($loc) . ', call or message first to confirm that it is open and that the item you want is in stock. Ask for the exact location and a landmark, and bring a photo or the name of the product. Check the item in person where you can: switch on electronics, look at the finish of furniture, and read the label or warranty on packaged goods. Ask for a receipt for every purchase.</p>';
    $h .= '<h2>Questions about ' . e($name) . '</h2>' . pg_faq([
        ['How do I contact ' . $name . '?', 'Open one of the stall\'s listings and use the WhatsApp or Call button, or use the contact details shown on this page. Mention the product you are asking about.'],
        ['Is the price on a listing final?', 'Prices are set by the seller and can change. Confirm the price, the availability, the delivery cost and the warranty with the seller before you pay.'],
        ['What if something goes wrong with an order?', 'Talk to the seller first, because return and refund terms for a product are decided by the seller you buy from. If the seller does not respond or the listing was misleading, send us the page link and your chat or receipt and we will look into it.'],
        ['How can I report a problem with this stall?', 'Use the "Report this ad" link on any of its listings, or message us on WhatsApp with the page link and a short description.'],
    ]);
    $h .= '<h2>Open a stall like ' . e($name) . '</h2><p>If you sell products or services, you can open your own stall on SaleBari and reach buyers across Bangladesh. <a href="' . e(base_path()) . '/sell/">See how to open a stall</a> and the seller packages, or read the <a href="' . e(base_path()) . '/help/">Help Center</a>.</p>';
    return pg_wrap($h);
}

/** About a brand, how to buy, and questions. */
function brand_guide_html(array $brand, array $cats, int $productCount): string
{
    $name = (string) $brand['name'];
    $loc  = trim((string) ($brand['location'] ?? ''));
    $h  = '<h2>About ' . e($name) . ' on SaleBari</h2>';
    $h .= '<p>' . e($name) . ' has a brand page on SaleBari' . ($loc !== '' ? ', based in ' . e($loc) : '') . '. A brand page collects what a brand or company wants buyers to know in one place: who they are, how to contact them, and the products listed under their name, so you can look at the maker or the seller as well as the item.</p>';
    $cn = array_map(function ($c) { return e($c['name_en']); }, array_slice($cats, 0, 8));
    $h .= '<p>' . ($productCount > 0
        ? 'Under this brand you can currently see ' . (int) $productCount . ' ' . ($productCount === 1 ? 'listing' : 'listings') . ($cn ? ' in ' . natural_list($cn) : '') . '. Open a listing to see photos, details and the seller\'s contact buttons.'
        : 'Listings under ' . e($name) . ' will appear here as they are added. You can use the contact details on this page to ask the brand what is available.') . '</p>';
    $h .= '<h2>Why check the brand before you buy</h2><ul>'
        . '<li>A known brand is easier to hold to account: you can look up its address, its website and its social pages before you pay.</li>'
        . '<li>Ask whether the product is original, whether the seller is an authorised dealer, and what warranty applies and who honours it.</li>'
        . '<li>Compare the same model across sellers, and check that the model number and specification match what you are shown.</li>'
        . '<li>Be careful with prices far below the usual market range, which can point to a copy, a used item or a scam.</li></ul>';
    $h .= '<h2>How to buy ' . e($name) . ' products</h2>';
    $h .= '<p>Open a listing and use the WhatsApp or Call button to talk to the seller. Agree the price, the payment and the delivery directly, since SaleBari does not take payment for products on the site. When the item arrives, check it against the listing, keep the invoice and the warranty card, and tell the seller straight away if anything is wrong.</p>';
    $h .= '<h2>Questions about ' . e($name) . '</h2>' . pg_faq([
        ['How do I contact ' . $name . '?', 'Use the contact details and social links on this page, or open one of the brand\'s listings and use the WhatsApp or Call button.'],
        ['Are the products original?', 'Ask the seller directly and look for the brand\'s warranty card, the invoice and the serial or model number. If you are not sure, compare with the brand\'s official information before you pay.'],
        ['Who is responsible for returns and refunds?', 'Return, exchange and refund terms for a product are decided by the seller you buy from. Ask about them before you pay and keep the messages as a record.'],
        ['How can I report a problem with this brand page?', 'Message us on WhatsApp with the page link and a short description, and we will look into it.'],
    ]);
    $h .= '<h2>List your brand on SaleBari</h2><p>If you run a brand or company, you can create a brand page and open a stall to list your products. <a href="' . e(base_path()) . '/sell/">See how it works</a> or visit the <a href="' . e(base_path()) . '/brand/list/">brand directory</a> to see other brands.</p>';
    return pg_wrap($h);
}

/** About a shopping mall, visiting it, and questions. */
function mall_guide_html(array $mall, int $stallCount): string
{
    $name = (string) $mall['name'];
    $city = (string) $mall['city_name_en'];
    $h  = '<h2>About ' . e($name) . ', ' . e($city) . '</h2>';
    $h .= '<p>' . e($name) . ' is a shopping mall in ' . e($city) . ' that you can find on SaleBari. The mall page gives you the practical details in one place, such as the address, the opening hours and the contact numbers where the mall has shared them, so you can plan a visit and see which stalls are inside.</p>';
    $h .= '<p>' . ($stallCount > 0
        ? e($name) . ' has ' . (int) $stallCount . ' ' . ($stallCount === 1 ? 'stall' : 'stalls') . ' listed on SaleBari. Open a stall to see what the seller offers and to contact them before you go.'
        : 'Stalls inside ' . e($name) . ' will appear here as sellers add them. Sellers can choose the mall when they open a stall.') . '</p>';
    $h .= '<h2>Planning a visit to ' . e($name) . '</h2><ul>'
        . '<li>Check the opening hours and the weekly closed day before you travel, since malls and individual shops can keep different hours.</li>'
        . '<li>Call or message the stall first to confirm that the item you want is in stock.</li>'
        . '<li>Use the map link, where there is one, and note a landmark and the floor so you can find the shop quickly.</li>'
        . '<li>Compare prices between two or three stalls for the same specification before you buy, and ask for a receipt.</li>'
        . '<li>Think about parking and how you will carry large items home.</li></ul>';
    $h .= '<h2>Shopping in ' . e($city) . '</h2>';
    $h .= '<p>Shopping at a mall lets you see and handle the product, ask questions face to face and take it home the same day. Buying through a SaleBari listing lets you compare sellers and prices first and then arrange delivery or collection. Many buyers use both: they find a seller on SaleBari, check the listing and message the stall, and then visit to inspect the item before they pay.</p>';
    $h .= '<h2>Questions about ' . e($name) . '</h2>' . pg_faq([
        ['How do I find a stall inside ' . $name . '?', 'Open the stall pages listed here. Each stall shows its address and contact details, and you can message the seller to ask for directions or the floor.'],
        ['Can I buy from a stall without visiting the mall?', 'Often yes. Use the WhatsApp or Call button on a listing to ask the seller about delivery or collection. Agree the price and payment directly with the seller.'],
        ['Are the opening hours on this page always correct?', 'We show the hours the mall has shared, but they can change on holidays and festivals. Confirm with the mall or the stall before a long trip.'],
        ['How do I add my stall to this mall?', 'When you open a stall on SaleBari you can choose the mall it is in. The SaleBari team reviews each new stall before it appears.'],
    ]);
    $h .= '<h2>Other malls and stalls</h2><p>See the <a href="' . e(base_path()) . '/market/list/">list of shopping malls</a> or the <a href="' . e(base_path()) . '/stall/list/">stall directory</a> to compare more places, or <a href="' . e(base_path()) . '/sell/">open a stall</a> of your own.</p>';
    return pg_wrap($h);
}

/** The three directory pages: 'stall', 'brand' or 'mall'. */
function directory_guide_html(string $type): string
{
    $sell = '<a href="' . e(base_path()) . '/sell/">open a stall</a>';
    $texts = [
        'stall' => [
            'h' => 'How the SaleBari stall directory works',
            'p' => [
                'The stall directory lists the sellers on SaleBari. A stall is a seller\'s own page: it shows the seller\'s name, city and address, the category they sell in and the products they have listed. Use the directory to find a seller near you, to see who sells a particular kind of product, or to check a seller before you contact them.',
                'You can browse the stalls on this page, narrow them by city or category where the filters are offered, and open any stall to see its listings and contact details. A Verified badge means the SaleBari team has marked that stall as verified. It is a useful signal, but you should still confirm the price, the availability and the delivery with the seller before you pay.',
                'To buy, open a stall or one of its listings and use the WhatsApp or Call button. You agree the price, the payment and the delivery directly with the seller, because SaleBari does not take payment for products on the site. Return and refund terms for a product are decided by the seller you buy from, so ask about them first and keep the chat and the invoice.',
                'New stalls are reviewed by the SaleBari team before they appear in the directory. If you see a stall or a listing that looks wrong, use the "Report this ad" link on a listing or message us on WhatsApp.',
            ],
            'ul' => ['Check the stall\'s city and address, and ask for a landmark before you visit.', 'Look at several listings, not only one, to see how the seller describes and photographs items.', 'Compare two or three sellers for the same specification before you decide.', 'Avoid sending a large advance to a seller you have not checked.'],
            'faq' => [['How do I find a stall near me?', 'Look for your city in the directory, or open a category page and use the city filter to see sellers and products from your area.'], ['How can I open my own stall?', 'Choose a package on the Sell page and fill in your details. The SaleBari team reviews each new stall before it goes live.'], ['Does SaleBari guarantee the sellers?', 'SaleBari reviews new stalls and listings and looks into reports, but it does not sell the products itself. Check the details and agree the terms with the seller before you pay.']],
        ],
        'brand' => [
            'h' => 'How the SaleBari brand directory works',
            'p' => [
                'The brand directory lists the brands and companies that have a page on SaleBari. A brand page gathers what a brand wants buyers to know: where it is based, how to contact it, its website and social pages, and the products listed under its name. It helps you look at the company behind a product, not only the product.',
                'Use the directory when you already know the brand you want, or to discover brands that sell the kind of product you are looking for. Open a brand to see its description, its contact details and its listings.',
                'To buy, open a listing under the brand and use the WhatsApp or Call button to talk to the seller. Agree the price, the payment and the delivery directly. SaleBari does not take payment for products on the site, and return and refund terms are set by the seller.',
                'Brand pages are reviewed by the SaleBari team before they appear. If something on a brand page looks wrong, message us on WhatsApp with the page link and we will look into it.',
            ],
            'ul' => ['Check whether the seller is an authorised dealer of the brand, and ask what warranty applies and who honours it.', 'Compare the model number and the specification across sellers.', 'Be careful with prices far below the usual range, which can mean a copy or a used item.', 'Keep the invoice and the warranty card.'],
            'faq' => [['How do I add my brand to SaleBari?', 'Create a seller account, then add your brand with its logo, contact details, social pages and description. The team reviews it before it goes live.'], ['Are all the products on a brand page original?', 'Ask the seller and look for the warranty card and the invoice. SaleBari does not sell the products itself, so confirm originality before you pay.'], ['Can I contact a brand directly?', 'Yes. Use the contact details and social links on the brand page, or the WhatsApp and Call buttons on a listing.']],
        ],
        'mall' => [
            'h' => 'How the SaleBari shopping mall directory works',
            'p' => [
                'The mall directory lists shopping malls and markets by city. Each mall page gives the practical details in one place, such as the address, the opening hours, the weekly closed day and the contact numbers where the mall has shared them, along with the stalls inside it that sell on SaleBari.',
                'Use the directory to plan a shopping trip: pick a mall in your city, check when it is open, and look at the stalls inside to see who sells what. You can message a stall before you go to confirm that the item you want is in stock.',
                'Shopping in person lets you see and handle a product and take it home the same day. Buying through a listing lets you compare sellers and prices first. Many buyers do both, finding a seller on SaleBari and then visiting to inspect the item before they pay. Either way, agree the price and payment directly with the seller, since SaleBari does not take payment for products on the site.',
                'Opening hours can change on holidays and festivals, so confirm with the mall or the stall before a long trip.',
            ],
            'ul' => ['Check the opening hours and the closed day before you travel.', 'Call or message the stall to confirm stock.', 'Compare two or three stalls for the same specification before you buy.', 'Ask for a receipt for every purchase.'],
            'faq' => [['How do I find stalls inside a mall?', 'Open a mall page to see the stalls that have listed themselves there, or use the stall directory and look at each stall\'s address.'], ['How do I add my mall or stall?', 'Sellers choose the mall when they open a stall. The SaleBari team reviews each new stall before it appears.'], ['Do malls on SaleBari take online orders?', 'That depends on the stall. Use the WhatsApp or Call button on a listing to ask about delivery or collection.']],
        ],
    ];
    $t = $texts[$type];
    $h = '<h2>' . e($t['h']) . '</h2>';
    foreach ($t['p'] as $p) {
        $h .= '<p>' . e($p) . '</p>';
    }
    $h .= '<h3>Tips before you buy</h3><ul>';
    foreach ($t['ul'] as $li) {
        $h .= '<li>' . e($li) . '</li>';
    }
    $h .= '</ul><h3>Questions</h3>' . pg_faq($t['faq']);
    $h .= '<p>Want to sell on SaleBari? You can ' . $sell . ' and reach buyers across Bangladesh.</p>';
    return pg_wrap($h);
}

/** Blog index. */
function blog_guide_html(): string
{
    $h  = '<h2>About the SaleBari blog</h2>';
    $h .= '<p>The SaleBari blog publishes articles to help people buy and sell with more confidence in Bangladesh. We write about how to choose products, how to spot a fair price, what to check before you pay, and how sellers can present their listings so buyers trust them. New posts are added as we publish them, and each one is written to be read on a phone as easily as on a computer.</p>';
    $h .= '<p>If you are here for property, our buying guides go deeper than a blog post. They explain how to buy a flat step by step, how ready flats compare with under-construction ones, what land share and super built-up area mean, how land records and deeds work, how a home loan works, and what to know when buying from abroad. Our calculators work out land size conversions, home loan instalments and the real cost of a flat.</p>';
    $guides = [];
    foreach (guide_pages() as $slug => $g) {
        $guides[] = '<li><a href="' . e(guide_url($slug)) . '">' . e($g['h1'][0]) . '</a></li>';
    }
    foreach (guide_tools() as $slug => $g) {
        $guides[] = '<li><a href="' . e(tool_url($slug)) . '">' . e($g['h1'][0]) . '</a></li>';
    }
    $h .= '<h3>Buying guides and calculators</h3><ul>' . implode('', $guides) . '</ul>';
    $h .= '<h3>What you will find on the blog</h3><ul>'
        . '<li>Buying advice for the main categories on SaleBari, such as property, vehicles, electronics and household goods.</li>'
        . '<li>Explanations of the terms you meet when you shop, from warranty types to land measures.</li>'
        . '<li>Tips for sellers on photos, descriptions and replying to buyers.</li>'
        . '<li>Notes on staying safe from scams when you buy and sell online.</li></ul>';
    $h .= '<p>Have a topic you would like us to cover, or a question that other buyers may share? Message us on WhatsApp from the contact details in the footer and we will consider it for a future post. You can also visit the <a href="' . e(base_path()) . '/help/">Help Center</a> for answers about buying, selling and your account.</p>';
    return pg_wrap($h);
}

/** Success stories page. */
function success_guide_html(): string
{
    $h  = '<h2>About SaleBari success stories</h2>';
    $h .= '<p>Success stories are short accounts from sellers who have grown their business on SaleBari, in their own words. We publish them to show other sellers and buyers what real use of the marketplace looks like: what the seller sells, how they present their stall, how buyers find them, and what has changed for their business.</p>';
    $h .= '<p>We only publish stories from real sellers, and we ask for their permission first. When there are no stories yet, this page says so instead of showing made-up examples. As more sellers share their experience, their stories will appear here with their name, their business and their city.</p>';
    $h .= '<h3>How sellers get results on SaleBari</h3><ul>'
        . '<li>Clear, honest photos and descriptions help buyers decide and cut down on repeat questions.</li>'
        . '<li>Quick replies on WhatsApp and phone win buyers, because most enquiries come in through those buttons.</li>'
        . '<li>Keeping stock and prices up to date builds trust and avoids disappointed buyers.</li>'
        . '<li>A complete stall with an address, a city and contact details looks more reliable than a bare listing.</li>'
        . '<li>Listing in the right category and using a descriptive title helps buyers and search engines find the item.</li></ul>';
    $h .= '<h3>Share your story</h3><p>If you sell on SaleBari and would like to share how it has worked for you, use the Share your story button on this page to message us on WhatsApp. Tell us what you sell, where you are and what has changed. We may follow up with a few questions before we publish, and nothing goes live without your approval.</p>';
    $h .= '<h3>Questions</h3>' . pg_faq([
        ['Are these stories real?', 'Yes. We publish stories only from real sellers and only with their permission. We do not invent testimonials.'],
        ['How do I get my story featured?', 'Message us on WhatsApp using the Share your story button. We will ask a few questions and ask for your approval before publishing.'],
        ['Can I open a stall and start selling today?', 'Yes. Choose a package on the Sell page and fill in your details. The SaleBari team reviews each new stall before it goes live.'],
    ]);
    $h .= '<p>Ready to start? <a href="' . e(base_path()) . '/sell/">Open your stall</a> or see the <a href="' . e(base_path()) . '/package.html">seller packages</a>.</p>';
    return pg_wrap($h);
}

/** Sell page. */
function sell_guide_html(): string
{
    $h  = '<h2>How selling on SaleBari works</h2>';
    $h .= '<p>SaleBari is a marketplace for sellers across Bangladesh. You open a stall, list your products or services with photos, a description, a price and your contact details, and buyers contact you directly by WhatsApp or phone. You agree the price, the payment and the delivery with the buyer, and SaleBari does not take payment for products on the site.</p>';
    $h .= '<ol><li>Choose a package and fill in the form on this page with your name, mobile number, email and area.</li>'
        . '<li>The SaleBari team reviews your request and your stall. New stalls are checked before they appear publicly.</li>'
        . '<li>Add your listings with clear photos and honest details, and keep them up to date.</li>'
        . '<li>Reply quickly when buyers message or call, and agree the sale directly with them.</li></ol>';
    $h .= '<h3>The packages</h3><ul>'
        . '<li><strong>Growth BluePrint, ৳500 a month:</strong> your stall listing on SaleBari.</li>'
        . '<li><strong>Scale System, ৳2,500 a month:</strong> your stall listing plus SEO work for one product.</li>'
        . '<li><strong>Growth Partner, ৳10,000 a month:</strong> your stall listing plus full SEO management and paid ads management.</li></ul>';
    $h .= '<p>You can cancel at any time by telling us before the next month starts. You get a full refund if we reject your stall or cannot provide the package you paid for, and there is no refund for a month that has already started once your stall is live or SEO or advertising work has begun, unless we agree otherwise in writing. Read the full <a href="' . e(base_path()) . '/return-and-refund-policy/">Return and Refund Policy</a>.</p>';
    $h .= '<h3>Tips for a listing buyers trust</h3><ul>'
        . '<li>Use your own clear photos from more than one angle, and show the item in real light.</li>'
        . '<li>Write the title like a buyer would search, and include the model, size or key detail.</li>'
        . '<li>State the price honestly and say what is included, such as delivery or a warranty.</li>'
        . '<li>Fill in your address, city and contact details so buyers can reach you.</li>'
        . '<li>Mark an item as out of stock or limited rather than leaving it listed as available.</li></ul>';
    $h .= '<h3>Questions from sellers</h3>' . pg_faq([
        ['Do I need a shop to sell on SaleBari?', 'No. You can list products or services from a shop, a home business or an online business. Give a clear address or area so buyers know where you are.'],
        ['How long does approval take?', 'The SaleBari team reviews new stalls before they go live, usually within a day. We contact you if we need more details.'],
        ['Does SaleBari take a commission on my sales?', 'SaleBari does not take payment for products on the site. You agree the sale and receive the payment directly from the buyer.'],
        ['Can I list more than one product?', 'Yes. Your stall can carry many listings, each in its own category with its own photos and price.'],
    ]);
    $h .= '<p>Need help choosing? Message us on WhatsApp, visit the <a href="' . e(base_path()) . '/help/">Help Center</a> or read the <a href="' . e(base_path()) . '/success-stories/">success stories</a>.</p>';
    return pg_wrap($h);
}

/** Track-an-order page. */
function track_guide_html(): string
{
    $h  = '<h2>How order tracking works</h2>';
    $h .= '<p>If you placed an order through SaleBari, you can follow it here by entering the mobile number you gave when you ordered. The page shows each order linked to that number, with its order number, the items, the date and its current status, so you do not need to call to ask where your order is.</p>';
    $h .= '<h3>The order stages</h3><ul>';
    foreach (order_statuses() as $s) {
        $h .= '<li><strong>' . e($s[0]) . ':</strong> ' . e($s[3]) . '</li>';
    }
    $h .= '</ul>';
    $h .= '<h3>Tips</h3><ul>'
        . '<li>Enter the same mobile number you used when you placed the order, including the leading zero.</li>'
        . '<li>If you do not see your order, check the number for a typo and try again, and message us on WhatsApp if it still does not appear.</li>'
        . '<li>Keep your order number and any messages from the seller until the order is delivered.</li>'
        . '<li>When your order arrives, check it against the listing before you accept it and tell the seller at once if anything is wrong.</li></ul>';
    $h .= '<h3>Questions</h3>' . pg_faq([
        ['Why can I not see my order?', 'Check that you entered the mobile number used for the order. If the number is right and the order still does not appear, message us on WhatsApp with the product name and the date.'],
        ['Can I change or cancel an order?', 'Contact the seller or message us on WhatsApp as soon as possible. Whether an order can be changed depends on how far it has progressed.'],
        ['Who decides about returns and refunds?', 'For a product, the seller you bought from decides. See the Return and Refund Policy for how this works and for the refund rules on seller package fees.'],
    ]);
    $h .= '<p>Need help? Message us on WhatsApp from the contact details in the footer, or visit the <a href="' . e(base_path()) . '/help/">Help Center</a>.</p>';
    return pg_wrap($h);
}
