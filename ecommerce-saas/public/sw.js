// Atelier Zacatecas - Service Worker PWA con Auto-Actualización Automática
// Identificador de versión: cada cambio aquí provoca una auto-actualización inmediata en teléfonos y navegadores
const CACHE_NAME = 'atelier-zacatecas-v2.2.0';

// Recursos estáticos esenciales para funcionamiento offline
const STATIC_ASSETS = [
    '/manifest.json',
    '/offline.html',
    '/icons/icon.svg',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
    '/icons/apple-touch-icon.png'
];

// ========================================================
// 1. INSTALACIÓN: No esperar, activar inmediatamente (skipWaiting)
// ========================================================
self.addEventListener('install', (event) => {
    // Forzar activación inmediata sin esperar a que se cierren pestañas o la app
    self.skipWaiting();

    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS).catch((err) => {
                console.warn('[SW Atelier] Precaching parcial de assets:', err);
            });
        })
    );
});

// ========================================================
// 2. ACTIVACIÓN: Purgar cachés viejas y tomar control de clientes
// ========================================================
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.filter((key) => key !== CACHE_NAME).map((key) => {
                    console.log('[SW Atelier] Eliminando versión de caché anterior:', key);
                    return caches.delete(key);
                })
            );
        }).then(() => {
            // Tomar control inmediato de todas las pestañas y ventanas de la PWA
            return self.clients.claim();
        }).then(() => {
            // Notificar a todos los clientes abiertos que la app se ha actualizado
            return self.clients.matchAll({ type: 'window' }).then((clients) => {
                clients.forEach((client) => {
                    client.postMessage({ type: 'SW_UPDATED', version: CACHE_NAME });
                });
            });
        })
    );
});

// ========================================================
// 3. MENSAJES: Escuchar órdenes directas de actualización
// ========================================================
self.addEventListener('message', (event) => {
    if (event.data && (event.data.type === 'SKIP_WAITING' || event.data === 'skipWaiting')) {
        self.skipWaiting();
    }
});

// ========================================================
// 4. PETICIONES (FETCH): NETWORK-FIRST para navegación HTML
// ========================================================
self.addEventListener('fetch', (event) => {
    const request = event.request;
    
    // Solo gestionar peticiones GET
    if (request.method !== 'GET') return;

    // Solo nuestro propio dominio/origen
    if (!request.url.startsWith(self.location.origin)) {
        return;
    }

    // A. NAVEGACIÓN Y PÁGINAS HTML: NETWORK-FIRST
    // Cada vez que el usuario abre la app o navega, SIEMPRE pide primero la versión más nueva al servidor.
    // Solo si el usuario no tiene conexión (offline), recurre a la copia guardada en caché.
    const isHtmlNavigation = request.mode === 'navigate' || 
                            request.destination === 'document' || 
                            (request.headers.get('accept') && request.headers.get('accept').includes('text/html'));

    if (isHtmlNavigation) {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                })
                .catch(() => {
                    // Si no hay red, servir la última copia offline o la página offline nativa
                    return caches.match(request).then((cachedResponse) => {
                        if (cachedResponse) return cachedResponse;
                        return caches.match('/').then((homeResponse) => {
                            if (homeResponse) return homeResponse;
                            return caches.match('/offline.html');
                        });
                    });
                })
        );
        return;
    }

    // B. RECURSOS ESTÁTICOS (CSS, JS, IMÁGENES, FUENTES, SVG): STALE-WHILE-REVALIDATE
    // Sirve rápidamente desde caché si existe, pero revalida y actualiza en segundo plano
    event.respondWith(
        caches.match(request).then((cachedResponse) => {
            const fetchPromise = fetch(request).then((networkResponse) => {
                if (networkResponse && networkResponse.status === 200) {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseClone);
                    });
                }
                return networkResponse;
            }).catch(() => null);

            return cachedResponse || fetchPromise;
        })
    );
});
