(function () {
  var gridEl = document.getElementById('stallGrid');
  if (!gridEl || typeof STALL_LIST === 'undefined') return;

  function buildCard(stall, index) {
    var a = document.createElement('a');
    a.className = 'stall-card';
    a.href = '#';

    var logo = document.createElement('div');
    logo.className = 'stall-logo c' + ((index % 8) + 1);
    logo.textContent = stall.name.trim().charAt(0).toUpperCase();

    var body = document.createElement('div');
    body.className = 'stall-card-body';

    var nameEl = document.createElement('p');
    nameEl.className = 'stall-card-name';
    var nameText = document.createElement('span');
    nameText.className = 'stall-card-name-text';
    nameText.textContent = stall.name;
    nameEl.appendChild(nameText);

    if (stall.verified) {
      var badge = document.createElement('span');
      badge.className = 'vbadge';
      badge.title = 'Verified Seller';
      badge.textContent = '✓';
      nameEl.appendChild(badge);
    }

    var meta = document.createElement('div');
    meta.className = 'stall-card-meta';
    var district = document.createElement('span');
    district.className = 'stall-card-meta-item';
    district.textContent = '📍 ' + stall.district;
    meta.appendChild(district);

    if (stall.products) {
      var products = document.createElement('span');
      products.className = 'stall-card-meta-item stall-card-meta-sep';
      products.textContent = '📦 ' + stall.products + (stall.products === 1 ? ' product' : ' products');
      meta.appendChild(products);
    }

    body.appendChild(nameEl);
    body.appendChild(meta);
    a.appendChild(logo);
    a.appendChild(body);
    return a;
  }

  STALL_LIST.forEach(function (stall, i) {
    gridEl.appendChild(buildCard(stall, i));
  });
})();
