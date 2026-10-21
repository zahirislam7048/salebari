/* ============================================================
   Category tree: level-1 -> level-2 keys, for category.html
   (level-2 -> level-3 lists already live in SUBMENU_DATA, nav-data.js)
   ============================================================ */
var CATEGORY_TREE = {
  carbike: { i18n: 'cat.carbike', children: ['carAccessories', 'bikeAccessories', 'threeWheeler', 'commercialVehicle', 'rental'] },
  realestate: { i18n: 'cat.realestate', children: ['apartment', 'land', 'commercialSpace', 'sanitary', 'constructionMaterial'] },
  agro: { i18n: 'cat.agro', children: ['livestock', 'fish', 'poultry', 'birds'] }
};

/* level-2 key -> its i18n dict key (mega.* or more.*), for breadcrumb/title lookup */
var LEVEL2_I18N = {
  carAccessories: 'mega.carAccessories', bikeAccessories: 'mega.bikeAccessories', threeWheeler: 'mega.threeWheeler', commercialVehicle: 'mega.commercialVehicle', rental: 'mega.rental',
  apartment: 'mega.apartment', land: 'mega.land', commercialSpace: 'mega.commercialSpace',
  sanitary: 'mega.sanitary', constructionMaterial: 'mega.constructionMaterial',
  livestock: 'mega.livestock', fish: 'mega.fish', poultry: 'mega.poultry', birds: 'mega.birds'
};

/* level-2 key -> which level-1 category it belongs to, for breadcrumb */
var LEVEL2_PARENT = {};
Object.keys(CATEGORY_TREE).forEach(function (parentKey) {
  CATEGORY_TREE[parentKey].children.forEach(function (childKey) {
    LEVEL2_PARENT[childKey] = parentKey;
  });
});

/* level-1/level-2 icons, with keyword-based fallback for level-3 items */
var LEVEL1_ICONS = {
  carbike: '🚗', realestate: '🏢', agro: '🌾'
};

var LEVEL2_ICONS = {
  carAccessories: '🚘', bikeAccessories: '🪖', threeWheeler: '🛺', commercialVehicle: '🚛', rental: '🔑',
  apartment: '🏢', land: '🗺️', commercialSpace: '🏬',
  sanitary: '🚽', constructionMaterial: '🧱',
  livestock: '🐄', fish: '🐟', poultry: '🐔', birds: '🕊️'
};

/* Keyword -> icon rules, applied to level-3 (product-tier) labels in order */
var ICON_KEYWORD_RULES = [
  [/\banimal\b|pet accessories|\bcow\b/i, '🐄'],
  [/\bgoat\b/i, '🐐'], [/\bbuffalo\b/i, '🐃'],
  [/\brui\b|\bkatla\b|\btilapia\b|\bpangas\b|other fish/i, '🐟'],
  [/\bchicken\b/i, '🐔'], [/\bduck\b/i, '🦆'],
  [/\bpigeon\b|other permitted birds/i, '🕊️'],
  [/scratch remover|engine oil|car scanner|dashcam/i, '🚘'],
  [/motorcycle helmet|motorcycle tyre/i, '🪖'],
  [/\bcng\b|auto rickshaw/i, '🛺'],
  [/\bboat\b|truck\b|tractor|\bbus\b/i, '🚛'],
  [/pickup rental|ambulance/i, '🚑'],
  [/commode|basin|water tap/i, '🚽'],
  [/cement|sand\b|stone\b|brick|\brod\b|construction equipment/i, '🧱']
];

function resolveIcon(label, fallback) {
  for (var i = 0; i < ICON_KEYWORD_RULES.length; i++) {
    if (ICON_KEYWORD_RULES[i][0].test(label)) return ICON_KEYWORD_RULES[i][1];
  }
  return fallback || '🏷️';
}
