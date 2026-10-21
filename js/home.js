(function () {
  var statStalls = document.getElementById('statStalls');
  var statDistricts = document.getElementById('statDistricts');
  var statProducts = document.getElementById('statProducts');
  if (statStalls || statDistricts || statProducts) {
    fetch('api/stats.php')
      .then(function (r) { return r.ok ? r.json() : null; })
      .then(function (s) {
        if (!s) return;
        if (statStalls) statStalls.textContent = s.verifiedStalls.toLocaleString('en-US');
        if (statDistricts) statDistricts.textContent = s.districts.toLocaleString('en-US');
        if (statProducts) statProducts.textContent = s.products.toLocaleString('en-US');
      })
      .catch(function () {});
  }

  var gridEl = document.getElementById('trendingGrid');
  var emptyEl = document.getElementById('trendingEmpty');
  if (!gridEl) return;

  var GRADIENTS = ['grad-1', 'grad-2', 'grad-3', 'grad-4', 'grad-5', 'grad-6'];

  function render(products) {
    var lang = window.I18N ? window.I18N.currentLang() : 'en';
    gridEl.innerHTML = '';

    if (!products.length) {
      if (emptyEl) emptyEl.hidden = false;
      return;
    }
    if (emptyEl) emptyEl.hidden = true;

    products.forEach(function (p, i) {
      var a = document.createElement('a');
      a.className = 'product-card';
      a.href = 'details/' + encodeURIComponent(p.slug) + '-' + p.id + '/';
      a.style.cssText = 'text-decoration:none;color:inherit;display:block';

      var media = document.createElement('div');
      media.className = 'product-media ' + GRADIENTS[i % GRADIENTS.length];
      if (p.image) {
        var img = document.createElement('img');
        img.src = p.image;
        img.alt = p.title;
        img.style.cssText = 'width:100%;height:100%;object-fit:cover';
        media.appendChild(img);
      } else {
        media.innerHTML = '<span>🛒</span>';
      }

      var body = document.createElement('div');
      body.className = 'product-body';

      var stall = document.createElement('p');
      stall.className = 'product-stall';
      stall.textContent = p.category || '';

      var title = document.createElement('h3');
      title.className = 'product-title';
      title.textContent = (lang === 'bn' && p.titleBn) ? p.titleBn : p.title;

      body.appendChild(stall);
      body.appendChild(title);

      if (p.price) {
        var priceRow = document.createElement('div');
        priceRow.className = 'product-price';
        var priceTag = document.createElement('span');
        priceTag.className = 'price-tag';
        priceTag.textContent = p.price;
        priceRow.appendChild(priceTag);
        body.appendChild(priceRow);
      }

      a.appendChild(media);
      a.appendChild(body);
      gridEl.appendChild(a);
    });
  }

  var lastData = [];
  fetch('api/products.php?recent=8')
    .then(function (r) { return r.ok ? r.json() : []; })
    .then(function (data) {
      lastData = data || [];
      render(lastData);
    })
    .catch(function () { render([]); });

  var toggleBtn = document.getElementById('langToggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () { render(lastData); });
  }
})();
