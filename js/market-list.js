(function () {
  var sectionsEl = document.getElementById('marketSections');
  var mallStatEl = document.getElementById('marketMallStat');
  var cityStatEl = document.getElementById('marketCityStat');
  var searchInput = document.getElementById('marketSearch');
  if (!sectionsEl || typeof MARKET_CITIES === 'undefined') return;

  function label(i18nKey, fallback) {
    var lang = window.I18N ? window.I18N.currentLang() : 'en';
    var entry = window.I18N && window.I18N.dict[i18nKey];
    return entry ? entry[lang] : fallback;
  }

  var totalMalls = MARKET_CITIES.reduce(function (sum, city) { return sum + city.malls.length; }, 0);
  var totalCities = MARKET_CITIES.length;

  function renderStats() {
    if (mallStatEl) mallStatEl.textContent = totalMalls + ' ' + label('market.stat.malls', 'malls');
    if (cityStatEl) cityStatEl.textContent = totalCities + ' ' + label('market.stat.cities', 'cities');
  }

  function cityLabel(city) {
    return city.key === 'other' ? label('market.otherCity', 'Other') : city.name;
  }

  function buildCard(mall, colorIndex) {
    var a = document.createElement('a');
    a.className = 'market-card';
    a.href = '#';
    a.setAttribute('data-search', (mall.name + ' ' + mall.address).toLowerCase());

    var icon = document.createElement('div');
    icon.className = 'market-card-icon c' + ((colorIndex % 8) + 1);
    icon.textContent = '🏬';

    var body = document.createElement('div');
    body.className = 'market-card-body';

    var name = document.createElement('span');
    name.className = 'market-card-name';
    name.textContent = mall.name;

    var meta = document.createElement('div');
    meta.className = 'market-card-meta';
    var addr = document.createElement('span');
    addr.textContent = mall.address;
    meta.appendChild(addr);

    body.appendChild(name);
    body.appendChild(meta);

    if (mall.offday) {
      var offday = document.createElement('span');
      offday.className = 'market-card-offday';
      offday.textContent = label('market.closed', 'Closed {day}').replace('{day}', mall.offday);
      offday.setAttribute('data-offday', mall.offday);
      body.appendChild(offday);
    }

    var cta = document.createElement('span');
    cta.className = 'market-card-cta';
    cta.setAttribute('data-i18n-dynamic', 'market.viewStalls');
    cta.textContent = label('market.viewStalls', 'View stalls');
    body.appendChild(cta);

    a.appendChild(icon);
    a.appendChild(body);
    return a;
  }

  function renderSections() {
    sectionsEl.innerHTML = '';
    var colorIndex = 0;
    MARKET_CITIES.forEach(function (city) {
      var section = document.createElement('section');
      section.className = 'market-city-section';
      section.setAttribute('data-city', city.key);

      var heading = document.createElement('div');
      heading.className = 'market-city-heading';
      var h2 = document.createElement('h2');
      h2.textContent = cityLabel(city);
      var count = document.createElement('span');
      count.className = 'market-city-count';
      count.textContent = city.malls.length;
      heading.appendChild(h2);
      heading.appendChild(count);

      var grid = document.createElement('div');
      grid.className = 'market-grid';
      city.malls.forEach(function (mall) {
        grid.appendChild(buildCard(mall, colorIndex));
        colorIndex++;
      });

      section.appendChild(heading);
      section.appendChild(grid);
      sectionsEl.appendChild(section);
    });
  }

  function applyFilter() {
    if (!searchInput) return;
    var term = searchInput.value.trim().toLowerCase();
    sectionsEl.querySelectorAll('.market-city-section').forEach(function (section) {
      var visibleCount = 0;
      section.querySelectorAll('.market-card').forEach(function (card) {
        var match = !term || card.getAttribute('data-search').indexOf(term) !== -1;
        card.style.display = match ? '' : 'none';
        if (match) visibleCount++;
      });
      section.hidden = visibleCount === 0;
    });
  }

  renderStats();
  renderSections();

  if (searchInput) {
    searchInput.setAttribute('placeholder', label('market.searchPlaceholder', 'Search by name, city or area…'));
    searchInput.addEventListener('input', applyFilter);
  }

  if (window.I18N) {
    window.I18N.applyLanguage(window.I18N.currentLang());
    var toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function () {
        renderStats();
        if (searchInput) searchInput.setAttribute('placeholder', label('market.searchPlaceholder', 'Search by name, city or area…'));
        sectionsEl.querySelectorAll('.market-city-section').forEach(function (section, i) {
          section.querySelector('h2').textContent = cityLabel(MARKET_CITIES[i]);
        });
        sectionsEl.querySelectorAll('.market-card-offday[data-offday]').forEach(function (el) {
          el.textContent = label('market.closed', 'Closed {day}').replace('{day}', el.getAttribute('data-offday'));
        });
        sectionsEl.querySelectorAll('[data-i18n-dynamic="market.viewStalls"]').forEach(function (el) {
          el.textContent = label('market.viewStalls', 'View stalls');
        });
      });
    }
  }
})();
