(function () {
  var id = window.STALL_ID;
  var stall = id && window.STALL_DETAILS && window.STALL_DETAILS[id];
  if (!stall) return;

  function label(i18nKey, fallback) {
    var lang = window.I18N ? window.I18N.currentLang() : 'en';
    var entry = window.I18N && window.I18N.dict[i18nKey];
    return entry ? entry[lang] : fallback;
  }

  document.title = stall.name + ', ' + stall.district + ' — SaleBari Seller';

  var crumbCurrent = document.getElementById('breadcrumbCurrent');
  if (crumbCurrent) crumbCurrent.textContent = stall.name;

  var heroName = document.getElementById('heroName');
  if (heroName) heroName.textContent = stall.name;

  var logo = document.getElementById('identityLogo');
  if (logo) {
    logo.textContent = stall.name.trim().charAt(0).toUpperCase();
    logo.classList.add(stall.color || 'c1');
  }

  var nameEl = document.getElementById('identityName');
  if (nameEl) nameEl.textContent = stall.name;

  var districtEl = document.getElementById('identityDistrict');
  if (districtEl) districtEl.textContent = stall.district;

  document.querySelectorAll('.vbadge-optional').forEach(function (el) {
    el.style.display = stall.verified ? '' : 'none';
  });

  var searchInput = document.getElementById('stallSearchInput');
  function updateSearchPlaceholder() {
    if (!searchInput) return;
    var placeholder = label('stall.searchWithin', 'Search within {name}…').replace('{name}', stall.name);
    searchInput.setAttribute('placeholder', placeholder);
  }
  updateSearchPlaceholder();

  if (window.I18N) {
    window.I18N.applyLanguage(window.I18N.currentLang());
    var toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) toggleBtn.addEventListener('click', updateSearchPlaceholder);
  }
})();
