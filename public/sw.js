const CACHE_NAME = 'budget-pwa-v2';

// Aset inti yang di-precache saat instalasi service worker
const PRECACHE_ASSETS = [
    '/offline.html',
    '/manifest.json',
    '/manifest.webmanifest',
    '/favicon.ico',
    '/favicon.png',
    '/icons/icon-48x48.png',
    '/icons/icon-192x192.png',
    '/icons/icon-512x512.png',
    '/icons/icon-180x180.png',
    '/assets/vendor/fontawesome/css/all.css',
    '/assets/vendor/notiflix/notiflix.min.js',
];

// Event: Install Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('[PWA] Pre-cache warning:', err);
            });
        }).then(() => {
            return self.skipWaiting();
        })
    );
});

// Event: Activate & Hapus Cache Versi Lama
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => {
            return self.clients.claim();
        })
    );
});

// Event: Fetch Strategy
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Abaikan request non-GET (POST, PUT, DELETE, dll.)
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // 1. Navigasi Halaman HTML (Network-First dengan Offline Fallback)
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .catch(() => {
                    return caches.match(request).then((cachedResponse) => {
                        return cachedResponse || caches.match('/offline.html');
                    });
                })
        );
        return;
    }

    // 2. Aset Statis Lokal (Build assets, Fonts, PWA Icons, Splash, Vendor) - Stale-While-Revalidate
    if (
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/assets/') ||
        url.pathname.startsWith('/icons/') ||
        url.pathname.startsWith('/splash/') ||
        url.pathname.endsWith('.woff2') ||
        url.pathname.endsWith('.woff') ||
        url.pathname.endsWith('.css') ||
        url.pathname.endsWith('.js') ||
        url.pathname.endsWith('.png') ||
        url.pathname.endsWith('.svg')
    ) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {
                const fetchPromise = fetch(request).then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseToCache);
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    // Jika fetch gagal dan tidak ada di cache
                    return cachedResponse;
                });

                return cachedResponse || fetchPromise;
            })
        );
        return;
    }

    // 3. Request lainnya: Coba network biasa
    event.respondWith(
        fetch(request).catch(() => {
            return caches.match(request);
        })
    );
});
