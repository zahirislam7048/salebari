/* SaleBari tracking layer — dataLayer + Google (GA4 / GTM) + Meta Pixel.

   Visitors choose in the cookie banner; until they accept, Google runs in "consent mode"
   (no cookies, no ad storage) and Meta Pixel is not loaded at all. Names, phone numbers and
   emails are never put in the dataLayer in clear text — only SHA-256 hashes, and only for
   signed-in sellers who have accepted.

   Config comes from Admin → Site Settings via api/tracking-config.php (window.SB_TRACK).
   Pages can describe themselves with window.SB_PAGE = { type, product, items, ... }. */
(function () {
  'use strict';
  var cfg = window.SB_TRACK || {};
  var page = window.SB_PAGE || {};
  window.dataLayer = window.dataLayer || [];
  function gtag() { window.dataLayer.push(arguments); }
  window.gtag = window.gtag || gtag;

  var CONSENT_KEY = 'sb_consent';
  var GA4 = cfg.ga4 || '', GTM = cfg.gtm || '', PIXEL = cfg.pixel || '';

  function store(kind) {
    try { return window[kind]; } catch (e) { return null; }
  }
  function get(kind, k) { var s = store(kind); try { return s ? s.getItem(k) : null; } catch (e) { return null; } }
  function set(kind, k, v) { var s = store(kind); try { if (s) s.setItem(k, v); } catch (e) { /* storage blocked */ } }
  function consent() { return get('localStorage', CONSENT_KEY); }   // 'granted' | 'denied' | null

  /* ---------- who is visiting (no personal data) ---------- */
  function rand() { return Math.random().toString(36).slice(2) + Date.now().toString(36); }
  var sessionId = get('sessionStorage', 'sb_sid') || (function () { var s = rand(); set('sessionStorage', 'sb_sid', s); return s; })();
  var returning = !!get('localStorage', 'sb_seen');
  var visits = parseInt(get('localStorage', 'sb_visits') || '0', 10);
  if (!get('sessionStorage', 'sb_counted')) { visits++; set('localStorage', 'sb_visits', String(visits)); set('sessionStorage', 'sb_counted', '1'); }
  set('localStorage', 'sb_seen', '1');

  var utm = {};
  try {
    var qs = new URLSearchParams(location.search);
    ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid'].forEach(function (k) { if (qs.get(k)) utm[k] = qs.get(k); });
  } catch (e) { /* old browser */ }
  if (Object.keys(utm).length) set('sessionStorage', 'sb_utm', JSON.stringify(utm));
  else { try { utm = JSON.parse(get('sessionStorage', 'sb_utm') || '{}'); } catch (e) { utm = {}; } }

  function inferType() {
    var p = location.pathname;
    if (page.type) return page.type;
    if (p === '/' || /\/index\.html$/.test(p)) return 'home';
    if (/\/details\//.test(p)) return 'product';
    if (/\/stall\/list/.test(p)) return 'stall_list';
    if (/\/stall\//.test(p)) return 'stall';
    if (/\/market\/list/.test(p)) return 'market_list';
    if (/\/market\//.test(p)) return 'market';
    if (/\/brand\/list/.test(p)) return 'brand_list';
    if (/\/brand\//.test(p)) return 'brand';
    if (/blog-post/.test(p)) return 'blog_post';
    if (/blog/.test(p)) return 'blog';
    if (/\/sell\//.test(p)) return 'sell';
    if (/\/account\//.test(p)) return 'account';
    if (/package/.test(p)) return 'package';
    return 'category';
  }

  function context() {
    var user = cfg.user || {};
    return {
      page_type: inferType(),
      page_path: location.pathname,
      page_location: location.href.split('#')[0],
      page_title: document.title,
      page_referrer: document.referrer || '',
      site_language: document.documentElement.lang === 'bn' ? 'bn' : 'en',
      device_type: window.innerWidth < 768 ? 'mobile' : (window.innerWidth < 1100 ? 'tablet' : 'desktop'),
      screen_size: (window.screen ? screen.width + 'x' + screen.height : ''),
      visitor_type: returning ? 'returning' : 'new',
      visit_count: visits,
      session_key: sessionId,
      logged_in: !!user.logged_in,
      user_role: user.logged_in ? 'seller' : 'visitor',
      user_id: (consent() === 'granted' && user.id_hash) ? user.id_hash : undefined,
      utm_source: utm.utm_source, utm_medium: utm.utm_medium, utm_campaign: utm.utm_campaign,
      utm_term: utm.utm_term, utm_content: utm.utm_content
    };
  }

  /* ---------- loaders ---------- */
  var pixelReady = false, pixelQueue = [], gaLoaded = false;

  function loadScript(src) {
    var s = document.createElement('script');
    s.async = true; s.src = src;
    document.head.appendChild(s);
  }

  function loadGoogle() {
    if (gaLoaded) return;
    gaLoaded = true;
    if (GTM) {
      window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' });
      loadScript('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(GTM));
    } else if (GA4) {
      loadScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA4));
      gtag('js', new Date());
      gtag('config', GA4, { send_page_view: false, anonymize_ip: true });
    }
  }

  function loadPixel() {
    if (pixelReady || !PIXEL || consent() !== 'granted') return;
    pixelReady = true;
    /* Meta Pixel base code */
    (function (f, b, e, v, n, t, s) {
      if (f.fbq) return; n = f.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = true; n.version = '2.0'; n.queue = [];
      t = b.createElement(e); t.async = true; t.src = v; s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s);
    })(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
    var user = cfg.user || {}, match = {};
    if (user.em) match.em = user.em;
    if (user.ph) match.ph = user.ph;
    window.fbq('init', PIXEL, match);
    pixelQueue.forEach(function (q) { window.fbq(q[0], q[1], q[2]); });
    pixelQueue = [];
  }

  function pixel(kind, name, params) {
    if (!PIXEL) return;
    if (pixelReady) window.fbq(kind, name, params || {});
    else if (consent() !== 'granted') pixelQueue.push([kind, name, params || {}]).length > 40 && pixelQueue.shift();
  }

  /* ---------- sending events ---------- */
  var META_MAP = {
    page_view: ['track', 'PageView'], view_item: ['track', 'ViewContent'], view_item_list: ['trackCustom', 'ViewCategory'],
    search: ['track', 'Search'], contact: ['track', 'Contact'], generate_lead: ['track', 'Lead'], sign_up: ['track', 'CompleteRegistration']
  };

  function metaParams(name, p) {
    var o = {};
    if (p.items && p.items[0]) {
      o.content_ids = p.items.map(function (i) { return String(i.item_id); });
      o.content_name = p.items[0].item_name;
      o.content_type = 'product';
      o.contents = p.items.map(function (i) { return { id: String(i.item_id), quantity: 1, item_price: i.price }; });
    }
    if (p.value != null) { o.value = p.value; o.currency = p.currency || 'BDT'; }
    if (p.search_term) o.search_string = p.search_term;
    if (p.content_category) o.content_category = p.content_category;
    if (p.method) o.content_name = (o.content_name || '') + ' ' + p.method;
    return o;
  }

  function track(name, params) {
    var data = {};
    var base = context();
    Object.keys(base).forEach(function (k) { if (base[k] !== undefined && base[k] !== '') data[k] = base[k]; });
    Object.keys(params || {}).forEach(function (k) { data[k] = params[k]; });

    window.dataLayer.push(Object.assign({ event: name }, data));          // for Google Tag Manager
    if (!GTM && GA4 && gaLoaded) {                                          // direct GA4 (no GTM)
      var flat = {};
      Object.keys(data).forEach(function (k) { var v = data[k]; if (typeof v !== 'object' || k === 'items') flat[k] = v; });
      gtag('event', name, flat);
    }
    var m = META_MAP[name];
    if (m) pixel(m[0], m[1], metaParams(name, data));
  }
  window.sbTrack = track;                                                   // pages / dashboards can call this too

  /* ---------- consent banner ---------- */
  var TEXT = {
    en: { msg: 'We use cookies and similar tools to understand how SaleBari is used and to show relevant ads. You can accept or decline.', ok: 'Accept', no: 'Decline', more: 'Privacy policy' },
    bn: { msg: 'SaleBari কীভাবে ব্যবহৃত হয় তা বুঝতে এবং প্রাসঙ্গিক বিজ্ঞাপন দেখাতে আমরা কুকি ও অনুরূপ টুল ব্যবহার করি। আপনি গ্রহণ বা প্রত্যাখ্যান করতে পারেন।', ok: 'গ্রহণ করুন', no: 'প্রত্যাখ্যান', more: 'গোপনীয়তা নীতি' }
  };

  function applyConsent(state) {
    var g = state === 'granted' ? 'granted' : 'denied';
    gtag('consent', 'update', { ad_storage: g, analytics_storage: g, ad_user_data: g, ad_personalization: g });
    if (state === 'granted') {
      loadPixel();
      var u = cfg.user || {};
      if (u.em || u.ph) gtag('set', 'user_data', { sha256_email_address: u.em, sha256_phone_number: u.ph });
    }
  }

  function showBanner() {
    if (cfg.consent === false || document.getElementById('sbConsent')) return;
    var lang = document.documentElement.lang === 'bn' ? 'bn' : 'en';
    var bar = document.createElement('div');
    bar.id = 'sbConsent'; bar.className = 'consent-bar'; bar.setAttribute('role', 'dialog'); bar.setAttribute('aria-label', 'Cookie consent');
    var p = document.createElement('p'); p.className = 'consent-text';
    var more = document.createElement('a'); more.href = '/privacy.php';
    var ok = document.createElement('button'); ok.type = 'button'; ok.className = 'btn btn-primary consent-btn';
    var no = document.createElement('button'); no.type = 'button'; no.className = 'btn btn-ghost consent-btn';
    function label() {
      var t = TEXT[document.documentElement.lang === 'bn' ? 'bn' : 'en'];
      p.textContent = t.msg + ' '; more.textContent = t.more; p.appendChild(more);
      ok.textContent = t.ok; no.textContent = t.no;
    }
    label();
    var actions = document.createElement('div'); actions.className = 'consent-actions';
    actions.appendChild(no); actions.appendChild(ok);
    bar.appendChild(p); bar.appendChild(actions);
    document.body.appendChild(bar);
    function choose(state) {
      set('localStorage', CONSENT_KEY, state);
      bar.parentNode && bar.parentNode.removeChild(bar);
      applyConsent(state);
      if (state === 'granted') track('consent_granted', {});
    }
    ok.addEventListener('click', function () { choose('granted'); });
    no.addEventListener('click', function () { choose('denied'); });
    var lt = document.getElementById('langToggle');
    if (lt) lt.addEventListener('click', function () { setTimeout(label, 0); });
  }

  /* ---------- start ---------- */
  gtag('consent', 'default', { ad_storage: 'denied', analytics_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied', wait_for_update: 500 });
  var saved = consent();
  if (saved === 'granted') applyConsent('granted');
  loadGoogle();

  function priceNumber(s) {
    var n = parseFloat(String(s || '').replace(/[^0-9.]/g, ''));
    return isNaN(n) ? undefined : n;
  }

  function firstEvents() {
    var type = inferType();
    track('page_view', { content_group: type });
    if (page.product) {
      var pr = page.product;
      var item = { item_id: String(pr.id), item_name: pr.name, item_category: pr.category, item_brand: pr.brand, price: pr.price, currency: 'BDT', affiliation: pr.seller };
      track('view_item', { currency: 'BDT', value: pr.price, items: [item] });
    } else if (page.items && page.items.length) {
      track('view_item_list', { item_list_name: page.list_name || '', content_category: page.list_name || '', items: page.items });
    }
    (cfg.queue || []).forEach(function (q) { track(q.name, q.params || {}); });
  }
  firstEvents();

  document.addEventListener('DOMContentLoaded', function () { if (saved === null) showBanner(); });
  if (document.readyState !== 'loading' && saved === null) showBanner();

  /* ---------- behaviour ---------- */
  var depths = [25, 50, 75, 90], sent = {};
  window.addEventListener('scroll', function () {
    var h = document.documentElement.scrollHeight - window.innerHeight;
    if (h <= 0) return;
    var pct = Math.round((window.scrollY / h) * 100);
    depths.forEach(function (d) { if (pct >= d && !sent[d]) { sent[d] = 1; track('scroll', { percent_scrolled: d }); } });
  }, { passive: true });

  var openedAt = Date.now(), leftSent = false;
  function leaving() {
    if (leftSent) return; leftSent = true;
    track('page_exit', { engagement_seconds: Math.round((Date.now() - openedAt) / 1000) });
  }
  window.addEventListener('pagehide', leaving);

  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a');
    if (!a) return;
    var href = a.getAttribute('href') || '';
    var pr = page.product;
    var extra = pr ? { item_id: String(pr.id), item_name: pr.name, item_category: pr.category, value: pr.price, currency: 'BDT' } : {};
    if (/wa\.me|api\.whatsapp\.com/.test(href)) {
      track('contact', Object.assign({ method: 'whatsapp', link_text: (a.textContent || '').trim().slice(0, 60) }, extra));
      track('generate_lead', Object.assign({ method: 'whatsapp' }, extra));
    } else if (/^tel:/i.test(href)) {
      track('contact', Object.assign({ method: 'call' }, extra));
    } else if (/^mailto:/i.test(href)) {
      track('contact', Object.assign({ method: 'email' }, extra));
    } else if (a.classList.contains('product-card') || a.classList.contains('listing-card') || a.classList.contains('stalldir-card') || a.classList.contains('market-card') || a.classList.contains('brand-pill') || a.classList.contains('subcat-card') || a.classList.contains('cat-ticket')) {
      var nameEl = a.querySelector('h3, .product-title, .stall-card-name-text, .market-card-name, .subcat-label, .cat-name');
      track('select_item', { link_url: href, item_name: nameEl ? nameEl.textContent.trim() : (a.textContent || '').trim().slice(0, 60), item_list_name: inferType() });
    } else if (/^https?:\/\//i.test(href) && href.indexOf(location.host) === -1) {
      track('click', { link_url: href, outbound: true });
    }
  }, true);

  var search = document.querySelector('.search-bar');
  if (search) {
    search.addEventListener('submit', function () {
      var input = search.querySelector('input[type="search"]');
      track('search', { search_term: input ? input.value.trim() : '' });
    });
  }
  var lt2 = document.getElementById('langToggle');
  if (lt2) lt2.addEventListener('click', function () { setTimeout(function () { track('language_change', { site_language: document.documentElement.lang === 'bn' ? 'bn' : 'en' }); }, 0); });
  var nl = document.querySelector('.newsletter-form');
  if (nl) nl.addEventListener('submit', function () { track('generate_lead', { method: 'newsletter' }); });
})();
