(function () {
  var params = new URLSearchParams(window.location.search);
  var key = params.get('item');
  var cat = key && window.LEAF_CATALOG && window.LEAF_CATALOG[key];

  var breadcrumbEl = document.getElementById('breadcrumb');
  var titleEl = document.getElementById('listingTitle');
  var statEl = document.getElementById('listingStat');
  var gridEl = document.getElementById('listingGrid');
  var locationSelect = document.getElementById('listingLocationFilter');
  var sortSelect = document.getElementById('listingSort');
  var resetBtn = document.getElementById('listingFilterReset');
  var paginationEl = document.getElementById('listingPagination');

  function label(i18nKey, fallback) {
    var lang = window.I18N ? window.I18N.currentLang() : 'en';
    var entry = i18nKey && window.I18N && window.I18N.dict[i18nKey];
    return entry ? entry[lang] : fallback;
  }

  function makeCrumb(text, href, isCurrent, i18nKey) {
    var el = isCurrent ? document.createElement('span') : document.createElement('a');
    if (isCurrent) el.className = 'breadcrumb-current';
    else el.href = href;
    el.textContent = text;
    if (i18nKey) el.setAttribute('data-i18n', i18nKey);
    return el;
  }

  function buildBreadcrumb(trail) {
    breadcrumbEl.innerHTML = '';
    trail.forEach(function (crumb, i) {
      breadcrumbEl.appendChild(makeCrumb(crumb.text, crumb.href, i === trail.length - 1, crumb.i18nKey));
      if (i < trail.length - 1) {
        var sep = document.createElement('span');
        sep.className = 'breadcrumb-sep';
        sep.textContent = '›';
        breadcrumbEl.appendChild(sep);
      }
    });
  }

  if (!cat) {
    breadcrumbEl.innerHTML = '';
    breadcrumbEl.appendChild(makeCrumb(label('nav.home', 'Home'), 'index.html', false, 'nav.home'));
    titleEl.textContent = 'Category not found';
    gridEl.innerHTML = '';
    var msg = document.createElement('p');
    msg.className = 'listing-empty';
    msg.textContent = "We couldn't find that category.";
    gridEl.appendChild(msg);
    document.querySelector('.listing-filters').style.display = 'none';
    document.querySelector('.listing-toolbar').style.display = 'none';
    return;
  }

  var level1Key = cat.parent[0];
  var level2Key = cat.parent.length === 2 ? cat.parent[1] : null;
  var level1I18n = window.CATEGORY_TREE[level1Key].i18n;
  var thisI18n = level2Key ? null : window.LEVEL2_I18N[key];
  var thisLabel = thisI18n ? label(thisI18n, cat.label) : cat.label;

  function renderHeader() {
    var trail = [{ text: label('nav.home', 'Home'), href: 'index.html', i18nKey: 'nav.home' }];
    trail.push({ text: label(level1I18n, level1Key), href: 'category.html?cat=' + encodeURIComponent(level1Key), i18nKey: level1I18n });
    if (level2Key) {
      trail.push({ text: label(window.LEVEL2_I18N[level2Key], level2Key), href: 'category.html?sub=' + encodeURIComponent(level2Key), i18nKey: window.LEVEL2_I18N[level2Key] });
    }
    trail.push({ text: thisLabel, href: '', i18nKey: thisI18n });
    buildBreadcrumb(trail);
    titleEl.textContent = thisLabel;
    if (thisI18n) titleEl.setAttribute('data-i18n', thisI18n);
    document.title = thisLabel + ' — SaleBari';
  }

  var fallbackIcon = (level2Key && window.LEVEL2_ICONS[level2Key]) || window.LEVEL2_ICONS[key] || window.LEVEL1_ICONS[level1Key] || '🏷️';
  var icon = window.resolveIcon ? window.resolveIcon(cat.label, fallbackIcon) : fallbackIcon;

  /* Generated sample listings have been retired — only real, dashboard-added
     products (fetched below via api/products.php) appear here now. */
  var allItems = [];
  var realItems = [];
  var state = { location: 'all', sort: 'popular', page: 1 };
  var PER_PAGE = 8;

  function filteredSorted() {
    var items = allItems.slice();
    if (state.location !== 'all') items = items.filter(function (it) { return it.location === state.location; });
    if (state.sort === 'price-asc') items.sort(function (a, b) { return a.price - b.price; });
    else if (state.sort === 'price-desc') items.sort(function (a, b) { return b.price - a.price; });
    /* Real, dashboard-added products always lead the list (only under "All
       Locations", since they carry no location of their own yet). */
    var real = state.location === 'all' ? realItems : [];
    return real.concat(items);
  }

  function buildCard(item) {
    var a = document.createElement('a');
    a.className = 'listing-card';
    a.href = item.href || '#';

    var media = document.createElement('div');
    media.className = 'listing-card-media';
    if (item.image) {
      var img = document.createElement('img');
      img.src = item.image;
      img.alt = item.title;
      img.style.cssText = 'width:100%;height:100%;object-fit:cover';
      media.appendChild(img);
    } else {
      media.textContent = icon;
    }
    if (item.badge) {
      var badge = document.createElement('span');
      badge.className = 'listing-card-badge';
      badge.textContent = item.badge;
      media.appendChild(badge);
    }

    var body = document.createElement('div');
    body.className = 'listing-card-body';

    if (item.tag) {
      var tag = document.createElement('p');
      tag.className = 'listing-card-tag';
      tag.textContent = item.tag === 'sale' ? label('estate.forSale', 'For Sale') : label('estate.forRent', 'For Rent');
      tag.setAttribute('data-i18n', item.tag === 'sale' ? 'estate.forSale' : 'estate.forRent');
      body.appendChild(tag);
    }

    var title = document.createElement('h3');
    title.className = 'listing-card-title';
    var lang = window.I18N ? window.I18N.currentLang() : 'en';
    title.textContent = (lang === 'bn' && item.titleBn) ? item.titleBn : item.title;
    if (item.verified) {
      var v = document.createElement('span');
      v.className = 'listing-card-verified';
      v.textContent = '✓ Verified';
      title.appendChild(v);
    }

    var meta = document.createElement('p');
    meta.className = 'listing-card-meta';
    meta.textContent = item.meta;

    var price = document.createElement('div');
    price.className = 'listing-card-price';
    price.textContent = item.priceText;

    body.appendChild(title);
    body.appendChild(meta);
    body.appendChild(price);
    a.appendChild(media);
    a.appendChild(body);
    return a;
  }

  function renderLocationOptions() {
    var distinct = Array.from(new Set(allItems.map(function (it) { return it.location; })));
    locationSelect.innerHTML = '';
    var allOpt = document.createElement('option');
    allOpt.value = 'all';
    allOpt.textContent = 'All Locations';
    locationSelect.appendChild(allOpt);
    distinct.forEach(function (loc) {
      var opt = document.createElement('option');
      opt.value = loc;
      opt.textContent = loc;
      locationSelect.appendChild(opt);
    });
  }

  function renderGrid() {
    var items = filteredSorted();
    var totalPages = Math.max(1, Math.ceil(items.length / PER_PAGE));
    if (state.page > totalPages) state.page = totalPages;
    var start = (state.page - 1) * PER_PAGE;
    var pageItems = items.slice(start, start + PER_PAGE);

    statEl.textContent = items.length + (items.length === 1 ? ' listing' : ' listings');

    gridEl.innerHTML = '';
    if (!pageItems.length) {
      var empty = document.createElement('p');
      empty.className = 'listing-empty';
      empty.textContent = 'No listings match this filter.';
      gridEl.appendChild(empty);
    } else {
      pageItems.forEach(function (item) { gridEl.appendChild(buildCard(item)); });
    }

    renderPagination(totalPages);
  }

  function renderPagination(totalPages) {
    paginationEl.innerHTML = '';
    if (totalPages <= 1) return;

    var prev = document.createElement('button');
    prev.textContent = '‹';
    prev.disabled = state.page === 1;
    prev.addEventListener('click', function () { state.page--; renderGrid(); });
    paginationEl.appendChild(prev);

    for (var p = 1; p <= totalPages; p++) {
      (function (p) {
        var btn = document.createElement('button');
        btn.textContent = p;
        if (p === state.page) btn.className = 'active';
        btn.addEventListener('click', function () { state.page = p; renderGrid(); });
        paginationEl.appendChild(btn);
      })(p);
    }

    var next = document.createElement('button');
    next.textContent = '›';
    next.disabled = state.page === totalPages;
    next.addEventListener('click', function () { state.page++; renderGrid(); });
    paginationEl.appendChild(next);
  }

  renderHeader();
  renderLocationOptions();
  renderGrid();

  /* Real products added via the admin dashboard, if any, for this exact
     leaf category — layered on top of the generated sample listings. */
  fetch('api/products.php?slug=' + encodeURIComponent(key))
    .then(function (r) { return r.ok ? r.json() : []; })
    .then(function (data) {
      if (!data || !data.length) return;
      realItems = data.map(function (p) {
        return {
          location: '', badge: null, tag: null, verified: false,
          title: p.title, titleBn: p.titleBn,
          meta: '', priceText: p.price || '', price: 0,
          image: p.image, href: 'product.php?slug=' + encodeURIComponent(p.slug)
        };
      });
      renderGrid();
    })
    .catch(function () {});

  locationSelect.addEventListener('change', function () { state.location = locationSelect.value; state.page = 1; renderGrid(); });
  sortSelect.addEventListener('change', function () { state.sort = sortSelect.value; state.page = 1; renderGrid(); });
  resetBtn.addEventListener('click', function () {
    state.location = 'all'; state.sort = 'popular'; state.page = 1;
    locationSelect.value = 'all'; sortSelect.value = 'popular';
    renderGrid();
  });

  if (window.I18N) {
    window.I18N.applyLanguage(window.I18N.currentLang());
    var toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function () {
        document.title = titleEl.textContent + ' — SaleBari';
        renderGrid();
      });
    }
  }
})();
