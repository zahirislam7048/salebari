(function () {
  var params = new URLSearchParams(window.location.search);
  var catKey = params.get('cat');
  var subKey = params.get('sub');

  var breadcrumbEl = document.getElementById('breadcrumb');
  var titleEl = document.getElementById('categoryTitle');
  var gridEl = document.getElementById('subcatGrid');

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

  function buildCard(icon, text, href, i18nKey) {
    var a = document.createElement('a');
    a.className = 'subcat-card';
    a.href = href || '#';
    var iconSpan = document.createElement('span');
    iconSpan.className = 'subcat-icon';
    iconSpan.textContent = icon;
    var labelSpan = document.createElement('span');
    labelSpan.className = 'subcat-label';
    labelSpan.textContent = text;
    if (i18nKey) labelSpan.setAttribute('data-i18n', i18nKey);
    a.appendChild(iconSpan);
    a.appendChild(labelSpan);
    return a;
  }

  function setTitle(text, i18nKey) {
    titleEl.textContent = text;
    if (i18nKey) titleEl.setAttribute('data-i18n', i18nKey);
    document.title = text + ' — SaleBari';
  }

  function renderLevel1(key) {
    var node = CATEGORY_TREE[key];
    if (!node) return false;

    buildBreadcrumb([
      { text: label('nav.home', 'Home'), href: 'index.html', i18nKey: 'nav.home' },
      { text: label(node.i18n, key), href: '', i18nKey: node.i18n }
    ]);
    setTitle(label(node.i18n, key), node.i18n);

    gridEl.innerHTML = '';
    node.children.forEach(function (childKey) {
      var childI18n = LEVEL2_I18N[childKey];
      var childLabel = label(childI18n, childKey);
      var icon = LEVEL2_ICONS[childKey] || LEVEL1_ICONS[key];
      var hasSubmenu = !!(window.SUBMENU_DATA && window.SUBMENU_DATA[childKey]);
      var isLeaf = !!(window.LEAF_CATALOG && window.LEAF_CATALOG[childKey]);
      var href = hasSubmenu ? 'category.html?sub=' + encodeURIComponent(childKey) : (isLeaf ? 'listing.html?item=' + encodeURIComponent(childKey) : '#');
      gridEl.appendChild(buildCard(icon, childLabel, href, childI18n));
    });
    return true;
  }

  function renderLevel2(key) {
    var entries = window.SUBMENU_DATA && window.SUBMENU_DATA[key];
    if (!entries) return false;
    var parentKey = LEVEL2_PARENT[key];
    var parentNode = parentKey && CATEGORY_TREE[parentKey];
    var thisI18n = LEVEL2_I18N[key];

    var trail = [{ text: label('nav.home', 'Home'), href: 'index.html', i18nKey: 'nav.home' }];
    if (parentNode) {
      trail.push({ text: label(parentNode.i18n, parentKey), href: 'category.html?cat=' + encodeURIComponent(parentKey), i18nKey: parentNode.i18n });
    }
    trail.push({ text: label(thisI18n, key), href: '', i18nKey: thisI18n });
    buildBreadcrumb(trail);
    setTitle(label(thisI18n, key), thisI18n);

    var fallbackIcon = LEVEL2_ICONS[key] || (parentKey && LEVEL1_ICONS[parentKey]) || '🏷️';
    gridEl.innerHTML = '';
    entries.slice(1).forEach(function (itemLabel) {
      var listingKey = window.LABEL_TO_LISTING_KEY && window.LABEL_TO_LISTING_KEY[itemLabel];
      var href = listingKey ? 'listing.html?item=' + encodeURIComponent(listingKey) : '#';
      gridEl.appendChild(buildCard(resolveIcon(itemLabel, fallbackIcon), itemLabel, href));
    });
    return true;
  }

  var ok = false;
  if (catKey) ok = renderLevel1(catKey);
  else if (subKey) ok = renderLevel2(subKey);

  if (!ok) {
    breadcrumbEl.innerHTML = '';
    breadcrumbEl.appendChild(makeCrumb(label('nav.home', 'Home'), 'index.html', false, 'nav.home'));
    titleEl.textContent = 'Category not found';
    gridEl.innerHTML = '';
    var msg = document.createElement('p');
    msg.className = 'category-empty';
    msg.textContent = "We couldn't find that category.";
    gridEl.appendChild(msg);
  }

  if (window.I18N) {
    window.I18N.applyLanguage(window.I18N.currentLang());
    var toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function () {
        document.title = titleEl.textContent + ' — SaleBari';
      });
    }
  }
})();
