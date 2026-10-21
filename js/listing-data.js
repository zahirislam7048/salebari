/* ============================================================
   Leaf-category listing data: every "last layer" category (the
   ones with no further subcategories) gets a real listing page,
   driven by listing.html?item=<key>. Listings are generated
   deterministically from small pools, not hand-authored one by one.
   ============================================================ */
var LOCATIONS = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Rangpur', 'Comilla', 'Gazipur', 'Narayanganj', 'Bogura', 'Mymensingh', 'Barisal'];
var AREAS = ['Bashundhara', 'Dhanmondi', 'Uttara', 'Mirpur', 'Gulshan', 'Banani', 'Mohammadpur', 'Rampura', 'Badda', 'Jatrabari'];
var CONDITIONS = ['Used', 'Used', 'Used', 'New'];
var MODIFIERS = ['Standard', 'Premium', 'Heavy Duty', 'Economy', 'Deluxe'];
var BADGES = [null, null, 'NEW', 'POPULAR'];

var LEAF_CATALOG = {
  apartment: { label: 'Apartment', parent: ['realestate'], archetype: 'property', kind: 'Apartment', bedsRange: [2, 5], sqftRange: [850, 2600], priceRange: [3500000, 25000000] },
  land: { label: 'Land', parent: ['realestate'], archetype: 'property', kind: 'Land', kathaRange: [2, 12], priceRange: [1800000, 18000000] },
  commercialSpace: { label: 'Commercial Space', parent: ['realestate'], archetype: 'property', kind: 'Commercial Space', sqftRange: [400, 3500], priceRange: [2500000, 30000000] },
  commode: { label: 'Commode', parent: ['realestate', 'sanitary'], archetype: 'product', unit: 'piece', priceRange: [1200, 8500] },
  basin: { label: 'Basin', parent: ['realestate', 'sanitary'], archetype: 'product', unit: 'piece', priceRange: [900, 6000] },
  waterTap: { label: 'Water Tap', parent: ['realestate', 'sanitary'], archetype: 'product', unit: 'piece', priceRange: [350, 3200] },
  cement: { label: 'Cement', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'bag', priceRange: [480, 560] },
  sand: { label: 'Sand', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'cft', priceRange: [35, 60] },
  stone: { label: 'Stone', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'cft', priceRange: [85, 140] },
  brick: { label: 'Brick', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'piece', priceRange: [9, 14] },
  rod: { label: 'Rod', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'ton', priceRange: [92000, 105000] },
  constructionEquipment: { label: 'Construction Equipment', parent: ['realestate', 'constructionMaterial'], archetype: 'product', unit: 'day rental', priceRange: [1500, 12000] },

  carScratchRemover: { label: 'Car Scratch Remover', parent: ['carbike', 'carAccessories'], archetype: 'product', unit: 'piece', priceRange: [350, 1800] },
  engineOil: { label: 'Engine Oil', parent: ['carbike', 'carAccessories'], archetype: 'product', unit: 'litre', priceRange: [450, 2200] },
  carScanner: { label: 'Car Scanner', parent: ['carbike', 'carAccessories'], archetype: 'product', unit: 'piece', priceRange: [1800, 15000] },
  dashcam: { label: 'DashCam', parent: ['carbike', 'carAccessories'], archetype: 'product', unit: 'piece', priceRange: [2500, 18000] },
  motorcycleHelmet: { label: 'Motorcycle Helmet', parent: ['carbike', 'bikeAccessories'], archetype: 'product', unit: 'piece', priceRange: [900, 7500] },
  motorcycleTyre: { label: 'Motorcycle Tyre', parent: ['carbike', 'bikeAccessories'], archetype: 'product', unit: 'piece', priceRange: [1200, 6800] },
  cng: { label: 'CNG', parent: ['carbike', 'threeWheeler'], archetype: 'vehicle', brands: ['Bajaj', 'TVS', 'Piaggio'], priceRange: [280000, 450000] },
  autoRickshaw: { label: 'Auto Rickshaw', parent: ['carbike', 'threeWheeler'], archetype: 'vehicle', brands: ['Bajaj', 'TVS', 'Piaggio'], priceRange: [220000, 380000] },
  boat: { label: 'Boat', parent: ['carbike', 'commercialVehicle'], archetype: 'vehicle', brands: ['Wooden Boat', 'Speed Boat', 'Fishing Trawler', 'Cargo Boat'], priceRange: [80000, 1200000], noYear: true },
  truck: { label: 'Truck', parent: ['carbike', 'commercialVehicle'], archetype: 'vehicle', brands: ['Tata', 'Ashok Leyland', 'Hino', 'Isuzu'], priceRange: [1800000, 6500000] },
  tractor: { label: 'Tractor', parent: ['carbike', 'commercialVehicle'], archetype: 'vehicle', brands: ['Sonalika', 'Mahindra', 'Massey Ferguson'], priceRange: [750000, 2200000] },
  bus: { label: 'Bus', parent: ['carbike', 'commercialVehicle'], archetype: 'vehicle', brands: ['Hino', 'Ashok Leyland', 'Tata'], priceRange: [3500000, 9500000] },
  pickupRental: { label: 'Pickup Rental', parent: ['carbike', 'rental'], archetype: 'product', unit: 'day', priceRange: [1800, 4500] },
  ambulanceService: { label: 'Ambulance Service', parent: ['carbike', 'rental'], archetype: 'product', unit: 'trip', priceRange: [1500, 8000] },

  cow: { label: 'Cow', parent: ['agro', 'livestock'], archetype: 'livestock', breeds: ['Deshi Cross', 'Sahiwal', 'Holstein Friesian Cross', 'Brahma Cross'], weightUnit: 'kg', weightRange: [180, 420], priceRange: [65000, 220000] },
  goat: { label: 'Goat', parent: ['agro', 'livestock'], archetype: 'livestock', breeds: ['Black Bengal', 'Jamunapari', 'Total Cross'], weightUnit: 'kg', weightRange: [14, 32], priceRange: [8000, 22000] },
  buffalo: { label: 'Buffalo', parent: ['agro', 'livestock'], archetype: 'livestock', breeds: ['Murrah Cross', 'Local Buffalo'], weightUnit: 'kg', weightRange: [300, 520], priceRange: [95000, 280000] },
  rui: { label: 'Rui', parent: ['agro', 'fish'], archetype: 'fish', priceRange: [280, 380] },
  katla: { label: 'Katla', parent: ['agro', 'fish'], archetype: 'fish', priceRange: [300, 420] },
  tilapia: { label: 'Tilapia', parent: ['agro', 'fish'], archetype: 'fish', priceRange: [180, 260] },
  pangas: { label: 'Pangas', parent: ['agro', 'fish'], archetype: 'fish', priceRange: [150, 220] },
  otherFish: { label: 'Other Fish', parent: ['agro', 'fish'], archetype: 'fish', priceRange: [200, 500] },
  chicken: { label: 'Chicken', parent: ['agro', 'poultry'], archetype: 'livestock', breeds: ['Sonali', 'Broiler', 'Layer', 'Deshi'], weightUnit: 'kg', weightRange: [1, 3], priceRange: [220, 420] },
  duck: { label: 'Duck', parent: ['agro', 'poultry'], archetype: 'livestock', breeds: ['Deshi Duck', 'Cherry Valley', 'Khaki Campbell'], weightUnit: 'kg', weightRange: [1, 3], priceRange: [350, 600] },
  pigeon: { label: 'Pigeon', parent: ['agro', 'birds'], archetype: 'livestock', breeds: ['Giribaj', 'King Pigeon', 'Fantail'], weightUnit: 'pair', weightRange: [1, 1], priceRange: [400, 3500] },
  otherPermittedBirds: { label: 'Other Permitted Birds', parent: ['agro', 'birds'], archetype: 'livestock', breeds: ['Quail', 'Guinea Fowl'], weightUnit: 'piece', weightRange: [1, 1], priceRange: [150, 1200] }
};

/* Third-level flyout label (plain text, from SUBMENU_DATA) -> LEAF_CATALOG key,
   so links can resolve to a real listing page instead of "#". */
var LABEL_TO_LISTING_KEY = {};
Object.keys(LEAF_CATALOG).forEach(function (k) {
  LABEL_TO_LISTING_KEY[LEAF_CATALOG[k].label] = k;
});

function pick(arr, i) { return arr[i % arr.length]; }
function spread(range, i, n) {
  if (range[0] === range[1]) return range[0];
  var step = (range[1] - range[0]) / (n - 1 || 1);
  return Math.round(range[0] + step * i);
}
function formatTaka(n) {
  if (n >= 10000000) return '৳ ' + (n / 10000000).toFixed(2).replace(/\.00$/, '') + ' Crore';
  if (n >= 100000) return '৳ ' + (n / 100000).toFixed(2).replace(/\.00$/, '') + ' Lakh';
  return '৳ ' + n.toLocaleString('en-US');
}

function generateListings(key) {
  var cat = LEAF_CATALOG[key];
  if (!cat) return null;
  var count = 12;
  var out = [];
  for (var i = 0; i < count; i++) {
    var location = pick(LOCATIONS, i);
    var area = pick(AREAS, i + 3);
    var item = { id: key + '-' + (i + 1), location: location, badge: pick(BADGES, i + 1) };

    if (cat.archetype === 'property') {
      item.price = spread(cat.priceRange, i, count);
      if (cat.kind === 'Apartment') {
        var beds = spread(cat.bedsRange, i, count);
        var sqft = spread(cat.sqftRange, i, count);
        item.title = beds + ' Bed Apartment, ' + sqft + ' sqft';
        item.meta = area + ', ' + location;
      } else if (cat.kind === 'Land') {
        var katha = spread(cat.kathaRange, i, count);
        item.title = katha + ' Katha Land';
        item.meta = area + ', ' + location;
      } else {
        var csqft = spread(cat.sqftRange, i, count);
        item.title = csqft + ' sqft Commercial Space';
        item.meta = area + ', ' + location;
      }
      item.priceText = formatTaka(item.price);
      item.tag = pick(['sale', 'sale', 'rent'], i);
    } else if (cat.archetype === 'vehicle') {
      var brand = pick(cat.brands, i);
      var year = cat.noYear ? null : 2015 + (i % 9);
      item.title = brand + (cat.noYear ? '' : ' (' + year + ')');
      item.condition = pick(CONDITIONS, i);
      item.price = spread(cat.priceRange, i, count);
      item.priceText = formatTaka(item.price);
      item.meta = location + ' · ' + item.condition;
    } else if (cat.archetype === 'product') {
      var modifier = pick(MODIFIERS, i);
      item.title = modifier + ' ' + cat.label;
      item.price = spread(cat.priceRange, i, count);
      item.priceText = '৳ ' + item.price.toLocaleString('en-US') + ' / ' + cat.unit;
      item.meta = location + ' Stall';
    } else if (cat.archetype === 'livestock') {
      var breed = pick(cat.breeds, i);
      var weight = spread(cat.weightRange, i, count);
      item.title = breed + ' ' + cat.label;
      item.price = spread(cat.priceRange, i, count);
      item.priceText = formatTaka(item.price);
      item.meta = weight + ' ' + cat.weightUnit + ' · ' + location;
      item.verified = i % 3 === 0;
    } else if (cat.archetype === 'fish') {
      item.title = cat.label + ' — Fresh Catch';
      var qty = 20 + (i * 15) % 180;
      item.price = spread(cat.priceRange, i, count);
      item.priceText = '৳ ' + item.price + ' / kg';
      item.meta = qty + ' kg available · ' + location;
    }
    out.push(item);
  }
  return out;
}
