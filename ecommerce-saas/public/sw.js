// Atelier Zacatecas - Service Worker PWA Ultrarrápido con Resiliencia Offline
// Versión 3.0.0: Precachea la página principal y soporta Render spin-up con timeout fallback
const CACHE_NAME = 'atelier-zacatecas-v3.0.0';

// Recursos estáticos iniciales
const STATIC_ASSETS = [
    '/',
    '/?source=pwa',
    '/manifest.json',
    '/offline.html',
    '/app-icons/icon.svg',
    '/app-icons/icon-192.png',
    '/app-icons/icon-512.png',
    '/app-icons/icon-maskable-512.png',
    '/app-icons/apple-touch-icon.png'
];

// 1. INSTALACIÓN: Guardar assets iniciales tolerando fallos de red
self.addEventListener('install', (event) => {
    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return Promise.allSettled(
                STATIC_ASSETS.map((url) =>
                    fetch(url, { cache: 'no-cache' })
                        .then((res) => {
                            if (res.ok) return cache.put(url, res);
                        })
                        .catch((err) => console.warn('[SW Atelier] Fallo al precachear:', url, err))
                )
            );
        })
    );
});

// 2. ACTIVACIÓN: Purgar cachés viejas y tomar control
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.filter((key) => key !== CACHE_NAME).map((key) => {
                    console.log('[SW Atelier] Eliminando versión anterior:', key);
                    return caches.delete(key);
                })
            );
        }).then(() => self.clients.claim())
    );
});

// 3. MENSAJES: Forzar actualización
self.addEventListener('message', (event) => {
    if (event.data && (event.data.type === 'SKIP_WAITING' || event.data === 'skipWaiting')) {
        self.skipWaiting();
    }
});

// 4. FETCH: Network-first con fallback a caché para HTML, Stale-while-revalidate para estáticos
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Solo solicitudes GET del mismo origen
    if (request.method !== 'GET' || !request.url.startsWith(self.location.origin)) {
        return;
    }

    const isHtmlNavigation = request.mode === 'navigate' || 
                            request.destination === 'document' || 
                            (request.headers.get('accept') && request.headers.get('accept').includes('text/html'));

    if (isHtmlNavigation) {
        event.respondWith(
            new Promise((resolve) => {
                let resolved = false;

                // Timeout de 3.5 segundos: si Render está despertando o la señal es débil,
                // responde de inmediato con la copia guardada en caché para no congelar la pantalla.
                const timeoutId = setTimeout(() => {
                    if (!resolved) {
                        caches.match(request, { ignoreSearch: true }).then((cached) => {
                            if (cached && !resolved) {
                                resolved = true;
                                resolve(cached);
                            }
                        });
                    }
                }, 3500);

                fetch(request)
                    .then((networkResponse) => {
                        clearTimeout(timeoutId);
                        if (networkResponse && networkResponse.status === 200) {
                            const clone = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                        }
                        if (!resolved) {
                            resolved = true;
                            resolve(networkResponse);
                        }
                    })
                    .catch(() => {
                        clearTimeout(timeoutId);
                        if (!resolved) {
                            resolved = true;
                            caches.match(request, { ignoreSearch: true })
                                .then((cached) => {
                                    if (cached) return cached;
                                    return caches.match('/', { ignoreSearch: true });
                                })
                                .then((home) => {
                                    if (home) return home;
                                    return caches.match('/offline.html');
                                })
                                .then((fallback) => resolve(fallback || new Response('Offline', { status: 503 })));
                        }
                    });
            })
        );
        return;
    }

    // RECURSOS ESTÁTICOS (CSS, JS, IMÁGENES, FUENTES): Stale-While-Revalidate
    event.respondWith(
        caches.match(request, { ignoreSearch: true }).then((cachedResponse) => {
            const networkFetch = fetch(request).then((networkResponse) => {
                if (networkResponse && networkResponse.status === 200) {
                    const clone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(request, clone));
                }
                return networkResponse;
            }).catch(() => null);

            return cachedResponse || networkFetch;
        })
    );
});
