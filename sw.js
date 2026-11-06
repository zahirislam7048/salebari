/* SaleBari service worker. It only does one thing: when a page cannot be loaded because the phone is
   offline, show a friendly offline page instead of the browser's error. It never caches site pages,
   so visitors always see fresh listings and prices. */
var CACHE = 'sb-offline-v1';
var OFFLINE = '/offline.html';

self.addEventListener('install', function (e) {
  e.waitUntil(caches.open(CACHE).then(function (c) { return c.add(OFFLINE); }).then(function () { return self.skipWaiting(); }));
});

self.addEventListener('activate', function (e) {
  e.waitUntil(
    caches.keys().then(function (keys) {
      return Promise.all(keys.filter(function (k) { return k !== CACHE; }).map(function (k) { return caches.delete(k); }));
    }).then(function () { return self.clients.claim(); })
  );
});

self.addEventListener('fetch', function (e) {
  if (e.request.mode !== 'navigate') return;
  e.respondWith(fetch(e.request).catch(function () { return caches.match(OFFLINE); }));
});
