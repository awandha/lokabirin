const CACHE_NAME = 'lokabirin-cache-v1';
const urlsToCache = [
    '/',
    '/offline.html',
    '/images/icons/icon-144x144.png'
];

// Install SW
self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            console.log('Opened cache');
            return cache.addAll(urlsToCache);
        })
    );
});

// Intercept requests
self.addEventListener('fetch', function (event) {
    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(event.request).then(response => {
                return response || caches.match('/offline.html');
            });
        })
    );
});

// Remove old caches
self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );
});
