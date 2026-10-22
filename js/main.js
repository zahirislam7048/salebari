(function () {
  /* The category menu comes from the dashboard's categories (api/category-urls.php). Pages that
     are plain .html files carry a copy of it; swap in the live one so new categories show up. */
  var liveList = window.CATEGORY_NAV_HTML;
  var staticList = document.querySelector('.category-nav .cat-list');
  if (liveList && staticList) {
    var holder = document.createElement('div');
    holder.innerHTML = liveList;
    if (holder.firstChild) staticList.parentNode.replaceChild(holder.firstChild, staticList);
  }

  var menuToggle = document.querySelector('.menu-toggle');
  var categoryNav = document.querySelector('.category-nav');

  if (menuToggle && categoryNav) {
    menuToggle.addEventListener('click', function () {
      var isOpen = categoryNav.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  document.querySelectorAll('.has-mega > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        link.parentElement.classList.toggle('open');
      }
    });
  });

  /* Third-level flyout submenus, built from SUBMENU_DATA (js/nav-data.js) */
  document.querySelectorAll('.mega-item[data-flyout]').forEach(function (item) {
    var key = item.getAttribute('data-flyout');
    var entries = window.SUBMENU_DATA && window.SUBMENU_DATA[key];
    if (!entries) return;
    var flyout = document.createElement('div');
    flyout.className = 'flyout';
    entries.forEach(function (label, i) {
      var a = document.createElement('a');
      if (i === 0) {
        a.href = (window.CATEGORY_URLS && window.CATEGORY_URLS[key]) || ('category.html?sub=' + encodeURIComponent(key));
        a.className = 'flyout-all';
      } else {
        var listingKey = window.LABEL_TO_LISTING_KEY && window.LABEL_TO_LISTING_KEY[label];
        var kids = window.CATEGORY_CHILD_URLS && window.CATEGORY_CHILD_URLS[key];
        if (kids && kids[label]) { a.href = kids[label]; a.textContent = label; flyout.appendChild(a); return; }
        a.href = listingKey ? ((window.CATEGORY_URLS && window.CATEGORY_URLS[listingKey]) || ('listing.html?item=' + encodeURIComponent(listingKey))) : '#';
      }
      a.textContent = label;
      flyout.appendChild(a);
    });
    item.appendChild(flyout);
  });

  document.querySelectorAll('.mega-item > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        link.parentElement.classList.toggle('open');
      }
    });
  });

  var scrollTopBtn = document.querySelector('.scroll-top');
  if (scrollTopBtn) {
    window.addEventListener('scroll', function () {
      scrollTopBtn.classList.toggle('visible', window.scrollY > 500);
    });
    scrollTopBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  var newsletterForm = document.querySelector('.newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var input = newsletterForm.querySelector('input');
      var button = newsletterForm.querySelector('button');
      var originalLabel = button.textContent;
      button.textContent = 'Subscribed ✓';
      button.disabled = true;
      setTimeout(function () {
        button.textContent = originalLabel;
        button.disabled = false;
        input.value = '';
      }, 2400);
    });
  }
})();

/* ============================================================
   Automatic translation: English <-> Bangla
   ============================================================ */
(function () {
  var dict = {
    'nav.home': { en: 'Home', bn: 'হোম' },

    'stall.directory': { en: 'Stall Directory', bn: 'স্টল ডিরেক্টরি' },
    'stall.title': { en: 'Stall Directory — SaleBari Seller', bn: 'স্টল ডিরেক্টরি — SaleBari বিক্রেতা' },
    'stall.count': { en: '28,400', bn: '২৮,৪০০' },
    'stall.countLabel': { en: 'stalls listed', bn: 'টি স্টল তালিকাভুক্ত' },
    'stall.lede': { en: 'Discover verified sellers across real estate, car & bike, and agro.', bn: 'রিয়েল এস্টেট, গাড়ি ও বাইক এবং এগ্রো জুড়ে ভেরিফায়েড বিক্রেতা খুঁজুন।' },
    'stall.prev': { en: 'Previous', bn: 'আগে' },
    'stall.next': { en: 'Next', bn: 'পরে' },
    'stall.last': { en: 'Last', bn: 'শেষ' },
    'stall.allProducts': { en: 'All Products', bn: 'সব পণ্য' },
    'stall.searchWithin': { en: 'Search within {name}…', bn: '{name}-এর মধ্যে খুঁজুন…' },
    'stall.searchBtn': { en: 'Search', bn: 'খুঁজুন' },
    'stall.noProductsTitle': { en: 'No products found', bn: 'কোনো পণ্য পাওয়া যায়নি' },
    'stall.noProductsMsg': { en: "This stall hasn't listed any products yet.", bn: 'এই স্টল এখনও কোনো পণ্য তালিকাভুক্ত করেনি।' },
    'vbadge.nid': { en: 'NID Verified', bn: 'এনআইডি ভেরিফায়েড' },

    'utility.location': { en: '📍 Serving all 64 districts', bn: '📍 ৬৪ জেলাতেই সেবা' },
    'utility.helpline': { en: '☎ +8801515286327', bn: '☎ +8801515286327' },
    'utility.sell': { en: 'Sell on SaleBari', bn: 'SaleBari-তে বিক্রি করুন' },
    'utility.help': { en: 'Help', bn: 'সহায়তা' },

    'search.scope.all': { en: 'All stalls', bn: 'সব স্টল' },
    'search.placeholder': { en: 'Search for a product, brand or stall…', bn: 'পণ্য, ব্র্যান্ড বা স্টল খুঁজুন…' },

    'header.account': { en: 'Account', bn: 'অ্যাকাউন্ট' },
    'header.sell': { en: 'Sell', bn: 'বিক্রি' },
    'header.cart': { en: 'Cart', bn: 'কার্ট' },

    'cat.carbike': { en: 'Car & Bike', bn: 'গাড়ি ও বাইক' },
    'cat.realestate': { en: 'Real Estate', bn: 'রিয়েল এস্টেট' },
    'cat.agro': { en: 'Agro', bn: 'এগ্রো' },
    'stock.available': { en: 'Available', bn: 'স্টকে আছে' },
    'stock.limited': { en: 'Stock limited', bn: 'স্টক সীমিত' },
    'stock.out': { en: 'Stock out', bn: 'স্টক শেষ' },
    'cat.travels': { en: 'Travels', bn: 'ভ্রমণ' },
    'cat.jobs': { en: 'Jobs', bn: 'চাকরি' },
    'cat.household': { en: 'Household', bn: 'গৃহস্থালি' },
    'deals.tag': { en: "Today's Deals", bn: 'আজকের অফার' },

    'mega.carAccessories': { en: 'Car Accessories', bn: 'কার অ্যাক্সেসরিজ' },
    'mega.bikeAccessories': { en: 'Bike Accessories', bn: 'বাইক অ্যাক্সেসরিজ' },
    'mega.threeWheeler': { en: 'Three Wheeler', bn: 'থ্রি হুইলার' },
    'mega.commercialVehicle': { en: 'Commercial Vehicle', bn: 'কমার্শিয়াল ভেহিকল' },
    'mega.rental': { en: 'Rental', bn: 'রেন্টাল' },

    'mega.apartment': { en: 'Apartment', bn: 'অ্যাপার্টমেন্ট' },
    'mega.land': { en: 'Land', bn: 'জমি' },
    'mega.commercialSpace': { en: 'Commercial Space', bn: 'কমার্শিয়াল স্পেস' },
    'mega.sanitary': { en: 'Sanitary', bn: 'স্যানিটারি' },
    'mega.constructionMaterial': { en: 'Construction Material', bn: 'নির্মাণ সামগ্রী' },

    'mega.livestock': { en: 'Livestock', bn: 'গবাদি পশু' },
    'mega.fish': { en: 'Fish', bn: 'মাছ' },
    'mega.poultry': { en: 'Poultry', bn: 'পোল্ট্রি' },
    'mega.birds': { en: 'Birds', bn: 'পাখি' },

    'hero.eyebrow': { en: "Bangladesh's digital bazaar", bn: 'বাংলাদেশের ডিজিটাল বাজার' },
    'hero.title': { en: 'Every stall.<br>One <em>address</em>.', bn: 'সব স্টল।<br>এক <em>ঠিকানা</em>।' },
    'hero.sub': {
      en: 'Compare prices across thousands of verified stalls before you spend a single taka — land and flats, cars and bikes, livestock and fish, all under one roof.',
      bn: 'একটি টাকাও খরচ করার আগে হাজারো ভেরিফায়েড স্টলের দাম তুলনা করুন — জমি ও ফ্ল্যাট, গাড়ি ও বাইক, গবাদি পশু ও মাছ, সব এক ছাদের নিচে।'
    },
    'hero.cta.browse': { en: 'Browse the bazaar', bn: 'বাজার ঘুরে দেখুন' },
    'hero.cta.sell': { en: 'Open your stall →', bn: 'আপনার স্টল খুলুন →' },
    'hero.stat.stalls': { en: 'verified stalls', bn: 'ভেরিফায়েড স্টল' },
    'hero.stat.districts': { en: 'districts covered', bn: 'জেলা কভার করা' },
    'hero.stat.products': { en: 'products listed', bn: 'পণ্য তালিকাভুক্ত' },
    'hero.stamp': { en: 'Verified<br>Stall', bn: 'ভেরিফায়েড<br>স্টল' },

    'trust.verifiedSellers': { en: 'Verified Sellers', bn: 'ভেরিফায়েড বিক্রেতা' },
    'trust.buyerProtection': { en: 'Buyer Protection', bn: 'ক্রেতা সুরক্ষা' },
    'trust.cod': { en: 'Cash on Delivery', bn: 'ক্যাশ অন ডেলিভারি' },
    'trust.ssl': { en: 'SSL Secured Checkout', bn: 'SSL সুরক্ষিত চেকআউট' },
    'trust.returns': { en: '7-Day Returns', bn: '৭ দিনের রিটার্ন' },

    'categories.eyebrow': { en: 'Walk the aisles', bn: 'আইল ঘুরে দেখুন' },
    'categories.heading': { en: 'Shop by category', bn: 'ক্যাটাগরি অনুযায়ী কিনুন' },

    'deals.eyebrow': { en: 'Fresh off the shelf', bn: 'তাজা মজুদ' },
    'deals.heading': { en: 'Trending in the bazaar', bn: 'বাজারে এখন জনপ্রিয়' },
    'deals.seeAll': { en: 'See all deals →', bn: 'সব অফার দেখুন →' },
    'deals.empty': { en: 'No products added yet — add some from the dashboard\'s Products page.', bn: 'এখনো কোনো পণ্য যোগ করা হয়নি — ড্যাশবোর্ডের প্রোডাক্টস পেজ থেকে যোগ করুন।' },

    'estate.eyebrow': { en: 'Looking for a new bari?', bn: 'নতুন বাড়ি খুঁজছেন?' },
    'estate.heading': { en: 'Flats, land & commercial space, listed by real owners.', bn: 'ফ্ল্যাট, জমি ও বাণিজ্যিক স্পেস, প্রকৃত মালিকদের তালিকাভুক্ত।' },
    'estate.sub': {
      en: 'Every listing is verified by our field agents before it goes live — no ghost listings, no middleman markup.',
      bn: 'প্রতিটি লিস্টিং প্রকাশের আগে আমাদের ফিল্ড এজেন্ট যাচাই করেন — কোনো ভুয়া লিস্টিং নেই, কোনো মধ্যস্বত্বভোগীর বাড়তি দাম নেই।'
    },
    'estate.cta': { en: 'Browse listings', bn: 'লিস্টিং দেখুন' },
    'estate.forSale': { en: 'For Sale', bn: 'বিক্রয়ের জন্য' },
    'estate.forRent': { en: 'For Rent', bn: 'ভাড়ার জন্য' },
    'estate.listing1': { en: '1,450 sqft Apartment — Bashundhara R/A', bn: '১,৪৫০ বর্গফুট অ্যাপার্টমেন্ট — বসুন্ধরা আর/এ' },
    'estate.price1': { en: '৳ 1.35 Crore', bn: '৳ ১.৩৫ কোটি' },
    'estate.listing2': { en: '3 Bed Flat — Dhanmondi, Dhaka', bn: '৩ বেড ফ্ল্যাট — ধানমন্ডি, ঢাকা' },
    'estate.price2': { en: '৳ 32,000 / month', bn: '৳ ৩২,০০০ / মাস' },

    'seller.eyebrow': { en: 'For business owners', bn: 'ব্যবসায়ীদের জন্য' },
    'seller.heading': { en: 'Open a stall. Reach the whole country.', bn: 'একটি স্টল খুলুন। সারা দেশে পৌঁছান।' },
    'seller.sub': {
      en: 'Set up your storefront in a day, list unlimited products, and get paid on delivery — no warehouse, no waiting.',
      bn: 'একদিনেই আপনার স্টোরফ্রন্ট চালু করুন, আনলিমিটেড পণ্য তালিকাভুক্ত করুন, এবং ডেলিভারিতে পেমেন্ট পান — কোনো গুদাম নেই, কোনো অপেক্ষা নেই।'
    },
    'seller.cta': { en: 'Start selling for free →', bn: 'বিনামূল্যে বিক্রি শুরু করুন →' },

    'newsletter.heading': { en: 'Never miss bazaar day', bn: 'বাজারের দিন মিস করবেন না' },
    'newsletter.sub': { en: 'Price-drop alerts and weekly deals, straight to your inbox.', bn: 'প্রাইস-ড্রপ অ্যালার্ট ও সাপ্তাহিক অফার, সরাসরি আপনার ইনবক্সে।' },
    'newsletter.cta': { en: 'Subscribe', bn: 'সাবস্ক্রাইব করুন' },

    'footer.brandDesc': {
      en: "Bangladesh's digital bazaar — verified stalls, instant price comparison, one address for everything you need.",
      bn: 'বাংলাদেশের ডিজিটাল বাজার — ভেরিফায়েড স্টল, তাৎক্ষণিক দাম তুলনা, আপনার সব প্রয়োজনের এক ঠিকানা।'
    },
    'footer.shop': { en: 'Shop', bn: 'কেনাকাটা' },
    'footer.allStalls': { en: 'All stalls', bn: 'সব স্টল' },
    'footer.shoppingMall': { en: 'Shopping Mall', bn: 'শপিং মল' },

    'market.title': { en: 'Shopping Malls', bn: 'শপিং মল' },
    'market.stat.malls': { en: 'malls', bn: 'টি মল' },
    'market.stat.cities': { en: 'cities', bn: 'টি শহর' },
    'market.searchPlaceholder': { en: 'Search by name, city or area…', bn: 'নাম, শহর বা এলাকা দিয়ে খুঁজুন…' },
    'market.viewStalls': { en: 'View stalls', bn: 'স্টল দেখুন' },
    'market.closed': { en: 'Closed {day}', bn: '{day} বন্ধ' },
    'market.otherCity': { en: 'Other', bn: 'অন্যান্য' },
    'footer.giftCards': { en: 'Gift cards', bn: 'গিফট কার্ড' },
    'footer.blog': { en: 'Blog', bn: 'ব্লগ' },
    'footer.brands': { en: 'Brands', bn: 'ব্র্যান্ড' },
    'footer.forSellers': { en: 'For Sellers', bn: 'বিক্রেতাদের জন্য' },
    'footer.startSelling': { en: 'Start selling', bn: 'বিক্রি শুরু করুন' },
    'footer.howItWorks': { en: 'How it works', bn: 'যেভাবে কাজ করে' },
    'footer.sellerFees': { en: 'Seller fees', bn: 'বিক্রেতা ফি' },
    'footer.successStories': { en: 'Success stories', bn: 'সাফল্যের গল্প' },
    'footer.package': { en: 'Package', bn: 'প্যাকেজ' },

    'pkg.title': { en: 'Seller Packages', bn: 'বিক্রেতা প্যাকেজ' },
    'pkg.sub': { en: 'Pick the plan that matches how much support you want growing your stall.', bn: 'আপনার স্টল বাড়াতে কতটা সহায়তা চান, সেই অনুযায়ী প্ল্যান বেছে নিন।' },
    'pkg.perMonth': { en: '/ month', bn: '/ মাস' },
    'pkg.popular': { en: 'Most popular', bn: 'সবচেয়ে জনপ্রিয়' },
    'pkg.cta': { en: 'Get started', bn: 'শুরু করুন' },
    'pkg.note': { en: 'Want to talk through which package fits your business? <a href="https://wa.me/8801644842785" target="_blank" rel="noopener">Message us on WhatsApp</a>.', bn: 'কোন প্যাকেজ আপনার ব্যবসার জন্য উপযুক্ত তা নিয়ে কথা বলতে চান? <a href="https://wa.me/8801644842785" target="_blank" rel="noopener">হোয়াটসঅ্যাপে আমাদের মেসেজ করুন</a>।' },

    'pkg.1.name': { en: 'Growth BluePrint', bn: 'গ্রোথ ব্লুপ্রিন্ট' },
    'pkg.1.price': { en: '৳ 500', bn: '৳ ৫০০' },
    'pkg.1.f1': { en: '✓ Stall listing on SaleBari', bn: '✓ SaleBari-তে স্টল লিস্টিং' },

    'pkg.2.name': { en: 'Scale System', bn: 'স্কেল সিস্টেম' },
    'pkg.2.price': { en: '৳ 2,500', bn: '৳ ২,৫০০' },
    'pkg.2.f1': { en: '✓ Stall listing on SaleBari', bn: '✓ SaleBari-তে স্টল লিস্টিং' },
    'pkg.2.f2': { en: '✓ SEO for 1 product', bn: '✓ ১টি পণ্যের জন্য SEO' },

    'pkg.3.name': { en: 'Growth Partner', bn: 'গ্রোথ পার্টনার' },
    'pkg.3.price': { en: '৳ 10,000', bn: '৳ ১০,০০০' },
    'pkg.3.f1': { en: '✓ Stall listing on SaleBari', bn: '✓ SaleBari-তে স্টল লিস্টিং' },
    'pkg.3.f2': { en: '✓ Full SEO management', bn: '✓ সম্পূর্ণ SEO ব্যবস্থাপনা' },
    'pkg.3.f3': { en: '✓ Paid ads management', bn: '✓ পেইড বিজ্ঞাপন ব্যবস্থাপনা' },
    'footer.contactUs': { en: 'Contact us', bn: 'যোগাযোগ করুন' },
    'footer.faq': { en: 'FAQ', bn: 'সচরাচর জিজ্ঞাসা' },
    'footer.returnPolicy': { en: 'Return & refund policy', bn: 'রিটার্ন ও রিফান্ড নীতি' },
    'footer.trackOrder': { en: 'Track an order', bn: 'অর্ডার ট্র্যাক করুন' },
    'footer.getInTouch': { en: 'Get in touch', bn: 'যোগাযোগ' },
    'footer.badgeSsl': { en: '✓ SSL Secured', bn: '✓ SSL সুরক্ষিত' },
    'footer.badgeVerified': { en: '✓ Verified Sellers', bn: '✓ ভেরিফায়েড বিক্রেতা' },
    'footer.badgeBuyer': { en: '✓ Buyer Protection', bn: '✓ ক্রেতা সুরক্ষা' },
    'footer.copyright': { en: '© 2026 SaleBari.com — All rights reserved.', bn: '© ২০২৬ SaleBari.com — সর্বস্বত্ব সংরক্ষিত।' },
    'footer.privacy': { en: 'Privacy Policy', bn: 'গোপনীয়তা নীতি' },
    'footer.terms': { en: 'Terms of Service', bn: 'সেবার শর্তাবলী' },
    'footer.sitemap': { en: 'Sitemap', bn: 'সাইটম্যাপ' }
  };

  /* Category names (English / বাংলা) from the dashboard, for the menu and category pages. */
  if (window.CATEGORY_I18N) {
    Object.keys(window.CATEGORY_I18N).forEach(function (k) { dict[k] = window.CATEGORY_I18N[k]; });
  }

  var STORAGE_KEY = 'salebari-lang';
  var toggleBtn = document.getElementById('langToggle');

  function applyLanguage(lang) {
    document.documentElement.lang = lang;

    document.querySelectorAll('[data-i18n]').forEach(function (el) {
      var key = el.getAttribute('data-i18n');
      var entry = dict[key];
      if (entry) el.textContent = entry[lang];
    });

    document.querySelectorAll('[data-i18n-html]').forEach(function (el) {
      var key = el.getAttribute('data-i18n-html');
      var entry = dict[key];
      if (entry) el.innerHTML = entry[lang];
    });

    document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
      var key = el.getAttribute('data-i18n-placeholder');
      var entry = dict[key];
      if (entry) el.setAttribute('placeholder', entry[lang]);
    });

    if (toggleBtn) {
      toggleBtn.textContent = lang === 'bn' ? 'English' : 'বাংলা';
    }

    try { localStorage.setItem(STORAGE_KEY, lang); } catch (e) { /* storage unavailable */ }
  }

  function currentLang() {
    return document.documentElement.lang === 'bn' ? 'bn' : 'en';
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      applyLanguage(currentLang() === 'bn' ? 'en' : 'bn');
    });
  }

  var saved = null;
  try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) { /* storage unavailable */ }
  if (saved === 'bn') applyLanguage('bn');

  window.I18N = { dict: dict, applyLanguage: applyLanguage, currentLang: currentLang };
})();
