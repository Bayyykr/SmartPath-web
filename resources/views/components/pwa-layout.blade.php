@props(['title' => 'SmartPath'])

@php
    $viteManifestPath = public_path('build/manifest.json');
    $viteManifest = file_exists($viteManifestPath) ? json_decode(file_get_contents($viteManifestPath), true) : [];
    $cssEntry = $viteManifest['resources/css/app.css']['file'] ?? null;
    $jsEntry = $viteManifest['resources/js/app.js']['file'] ?? null;
    $jsCss = $viteManifest['resources/js/app.js']['css'] ?? [];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-pwa-head />
    <title>{{ $title }} - SmartPath</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @if ($cssEntry)
        <link rel="stylesheet" href="/build/{{ $cssEntry }}?v=2">
    @endif

    @foreach ($jsCss as $cssFile)
        <link rel="stylesheet" href="/build/{{ $cssFile }}?v=2">
    @endforeach

    <style>
        [x-cloak] { display: none !important; }
        body { margin: 0; background: #f1f5f9; font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: #020617; }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-950 antialiased">
    <div class="mx-auto min-h-screen w-full max-w-md bg-white shadow-2xl">
        {{ $slot }}
    </div>

    <div id="pwa-install-banner" class="fixed inset-x-4 bottom-4 z-50 mx-auto hidden max-w-md rounded-2xl bg-slate-950 p-4 text-white shadow-2xl">
            <img src="/icons/icon_app.png" alt="SmartPath Logo" class="h-10 w-10 flex-none object-contain rounded-xl bg-white p-1">
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Install SmartPath</p>
                <p id="pwa-install-message" class="mt-1 text-xs leading-5 text-slate-300">Pasang aplikasi agar lebih mudah dibuka dari layar utama.</p>
                <div class="mt-3 flex gap-2">
                    <button id="pwa-install-button" type="button" class="rounded-xl bg-[#3159d4] px-4 py-2 text-xs font-bold text-white">Install App</button>
                    <button id="pwa-install-close" type="button" class="rounded-xl bg-white/10 px-4 py-2 text-xs font-bold text-white">Nanti</button>
                </div>
            </div>
        </div>
    </div>

    <div id="pwa-debug-panel" class="fixed inset-x-3 top-3 z-[60] mx-auto hidden max-w-md rounded-2xl bg-white p-4 text-xs text-slate-800 shadow-2xl ring-1 ring-slate-200">
        <div class="mb-2 flex items-center justify-between gap-3">
            <p class="font-extrabold text-slate-950">PWA Debug</p>
            <button id="pwa-debug-close" type="button" class="rounded-lg bg-slate-100 px-2 py-1 font-bold">Tutup</button>
        </div>
        <pre id="pwa-debug-output" class="max-h-80 overflow-auto whitespace-pre-wrap rounded-xl bg-slate-950 p-3 text-[11px] leading-5 text-green-300"></pre>
        <div class="mt-3 flex flex-wrap gap-2">
            <button id="pwa-debug-refresh" type="button" class="rounded-lg bg-[#3159d4] px-3 py-2 font-bold text-white">Refresh Debug</button>
            <button id="pwa-debug-reset" type="button" class="rounded-lg bg-slate-900 px-3 py-2 font-bold text-white">Reset Install</button>
            <button id="pwa-debug-clear" type="button" class="rounded-lg bg-red-600 px-3 py-2 font-bold text-white">Clear SW Cache</button>
        </div>
    </div>

    @if ($jsEntry)
        <script type="module" src="/build/{{ $jsEntry }}?v=2"></script>
    @endif

    <script>
        (() => {
            const banner = document.getElementById('pwa-install-banner');
            const installButton = document.getElementById('pwa-install-button');
            const closeButton = document.getElementById('pwa-install-close');
            const message = document.getElementById('pwa-install-message');
            const debugPanel = document.getElementById('pwa-debug-panel');
            const debugOutput = document.getElementById('pwa-debug-output');
            const debugClose = document.getElementById('pwa-debug-close');
            const debugRefresh = document.getElementById('pwa-debug-refresh');
            const debugReset = document.getElementById('pwa-debug-reset');
            const debugClear = document.getElementById('pwa-debug-clear');
            const dismissedKey = 'geocrime-pwa-install-dismissed';
            const debugEnabled = new URLSearchParams(window.location.search).has('pwa_debug');
            let deferredPrompt = window.geocrimePwaInstallPrompt || null;
            let beforeInstallPromptFired = window.geocrimePwaBeforeInstallPromptFired === true;

            const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
            const isIos = /iphone|ipad|ipod/i.test(window.navigator.userAgent);
            const isAndroid = /android/i.test(window.navigator.userAgent);
            const isSecure = window.isSecureContext;
            const dismissed = localStorage.getItem(dismissedKey) === '1';

            const showBanner = () => banner?.classList.remove('hidden');
            const hideBanner = () => banner?.classList.add('hidden');
            const log = (...args) => console.log('[SmartPath PWA]', ...args);

            const withTimeout = (promise, timeoutMs, fallback) => Promise.race([
                promise,
                new Promise((resolve) => window.setTimeout(() => resolve(fallback), timeoutMs)),
            ]);

            const updateDebug = async () => {
                if (!debugEnabled || !debugOutput) {
                    return;
                }

                deferredPrompt = deferredPrompt || window.geocrimePwaInstallPrompt || null;
                beforeInstallPromptFired = beforeInstallPromptFired || window.geocrimePwaBeforeInstallPromptFired === true;

                const checks = [];
                const add = (name, value) => checks.push(`${name}: ${value}`);
                const checkImage = (src) => new Promise((resolve) => {
                    const image = new Image();
                    image.onload = () => resolve(`${src} - OK ${image.naturalWidth}x${image.naturalHeight}`);
                    image.onerror = () => resolve(`${src} - FAILED`);
                    image.src = `${src}${src.includes('?') ? '&' : '?'}debug=${Date.now()}`;
                });

                add('URL', window.location.href);
                add('Origin', window.location.origin);
                add('Path', window.location.pathname);
                add('User Agent', window.navigator.userAgent);
                add('Secure Context / HTTPS', isSecure ? 'YES' : 'NO - PWA install di HP biasanya wajib HTTPS');
                add('Standalone Mode', isStandalone ? 'YES' : 'NO');
                add('Platform', isIos ? 'iOS' : isAndroid ? 'Android' : 'Other');
                add('Service Worker Support', 'serviceWorker' in navigator ? 'YES' : 'NO');
                add('beforeinstallprompt Fired', beforeInstallPromptFired ? 'YES' : 'NO');
                add('Install Prompt Saved', deferredPrompt ? 'YES' : 'NO');
                add('Install Dismissed LocalStorage', localStorage.getItem(dismissedKey) === '1' ? 'YES' : 'NO');

                const manifestLink = document.querySelector('link[rel="manifest"]');
                const manifestHref = manifestLink?.href || '/pwa-manifest.webmanifest';
                add('Manifest Link Tag', manifestLink ? manifestLink.href : 'NO');

                try {
                    if ('getInstalledRelatedApps' in navigator) {
                        const relatedApps = await navigator.getInstalledRelatedApps();
                        add('Installed Related Apps API', `${relatedApps.length} app(s)`);
                    } else {
                        add('Installed Related Apps API', 'NOT SUPPORTED');
                    }
                } catch (error) {
                    add('Installed Related Apps API', `ERROR - ${error.message}`);
                }

                try {
                    const manifestResponse = await fetch(manifestHref, { cache: 'no-store' });
                    add('Manifest Fetch', `${manifestResponse.status} ${manifestResponse.ok ? 'OK' : 'FAILED'}`);
                    add('Manifest Content-Type', manifestResponse.headers.get('content-type') || '-');
                    if (manifestResponse.ok) {
                        const manifest = await manifestResponse.json();
                        add('Manifest id', manifest.id || '-');
                        add('Manifest name', manifest.name || '-');
                        add('Manifest short_name', manifest.short_name || '-');
                        add('Manifest start_url', manifest.start_url || '-');
                        add('Manifest scope', manifest.scope || '-');
                        add('Manifest display', manifest.display || '-');
                        add('Manifest theme_color', manifest.theme_color || '-');
                        add('Manifest icons', Array.isArray(manifest.icons) ? manifest.icons.length : 0);

                        if (manifest.start_url) {
                            try {
                                const startUrl = new URL(manifest.start_url, window.location.origin).href;
                                const startResponse = await fetch(startUrl, { cache: 'no-store', credentials: 'same-origin' });
                                add('Manifest start_url Fetch', `${startResponse.status} ${startResponse.ok ? 'OK' : 'FAILED'} | redirected: ${startResponse.redirected ? 'YES' : 'NO'} | ${startResponse.url}`);
                            } catch (error) {
                                add('Manifest start_url Fetch', `ERROR - ${error.message}`);
                            }
                        }

                        if (Array.isArray(manifest.icons)) {
                            for (const icon of manifest.icons) {
                                add(`Manifest icon ${icon.sizes || '-'}`, `${icon.src || '-'} | ${icon.type || '-'} | ${icon.purpose || 'any'}`);
                            }
                        }
                    }
                } catch (error) {
                    add('Manifest Fetch', `ERROR - ${error.message}`);
                }

                try {
                    add('Icon /favicon-192.png', await checkImage('/favicon-192.png'));
                    add('Icon /favicon-512.png', await checkImage('/favicon-512.png'));
                    add('Icon /apple-touch-icon.png', await checkImage('/apple-touch-icon.png'));
                    add('Icon /icons/icon-192.png', await checkImage('/icons/icon-192.png'));
                    add('Icon /icons/icon-512.png', await checkImage('/icons/icon-512.png'));
                    add('Icon /icons/maskable-512.png', await checkImage('/icons/maskable-512.png'));
                } catch (error) {
                    add('Icon Check', `ERROR - ${error.message}`);
                }

                try {
                    const swResponse = await fetch('/sw.js', { cache: 'no-store' });
                    add('SW File Fetch', `${swResponse.status} ${swResponse.ok ? 'OK' : 'FAILED'}`);
                    add('SW Content-Type', swResponse.headers.get('content-type') || '-');
                } catch (error) {
                    add('SW File Fetch', `ERROR - ${error.message}`);
                }

                try {
                    if ('serviceWorker' in navigator) {
                        const registration = await navigator.serviceWorker.getRegistration('/');
                        const readyRegistration = await withTimeout(navigator.serviceWorker.ready, 3000, null);
                        add('SW Registered', registration ? 'YES' : 'NO');
                        add('SW Ready', readyRegistration ? 'YES' : 'NO - belum ready dalam 3 detik');
                        add('SW Controller', navigator.serviceWorker.controller ? 'YES' : 'NO - refresh halaman sekali lagi setelah SW aktif');
                        if (registration) {
                            add('SW Scope', registration.scope);
                            add('SW Active', registration.active ? registration.active.scriptURL : 'NO');
                            add('SW Waiting', registration.waiting ? registration.waiting.scriptURL : 'NO');
                            add('SW Installing', registration.installing ? registration.installing.scriptURL : 'NO');
                        }
                    }
                } catch (error) {
                    add('SW Check', `ERROR - ${error.message}`);
                }

                debugOutput.textContent = checks.join('\n');
            };

            if (debugEnabled) {
                debugPanel?.classList.remove('hidden');
                window.addEventListener('load', updateDebug);
                debugRefresh?.addEventListener('click', updateDebug);
                debugClose?.addEventListener('click', () => debugPanel?.classList.add('hidden'));
                debugReset?.addEventListener('click', () => {
                    localStorage.removeItem(dismissedKey);
                    hideBanner();
                    updateDebug();
                    alert('Status install direset. Refresh halaman, lalu tunggu event install muncul.');
                });
                debugClear?.addEventListener('click', async () => {
                    localStorage.removeItem(dismissedKey);

                    if ('caches' in window) {
                        const cacheNames = await caches.keys();
                        await Promise.all(cacheNames.map((cacheName) => caches.delete(cacheName)));
                    }

                    if ('serviceWorker' in navigator) {
                        const registrations = await navigator.serviceWorker.getRegistrations();
                        await Promise.all(registrations.map((registration) => registration.unregister()));
                    }

                    alert('Service worker dan cache dihapus. Tutup tab ini, hapus shortcut icon N dari home screen, lalu buka ulang /pwa?pwa_debug=1.');
                    window.location.reload();
                });
            }

            log({ isSecure, isStandalone, isIos, isAndroid, dismissed, debugEnabled });

            closeButton?.addEventListener('click', () => {
                localStorage.setItem(dismissedKey, '1');
                hideBanner();
                updateDebug();
            });

            const handleInstallReady = (event = null) => {
                log('beforeinstallprompt fired');
                event?.preventDefault?.();
                beforeInstallPromptFired = true;
                deferredPrompt = event || window.geocrimePwaInstallPrompt || deferredPrompt;
                window.geocrimePwaBeforeInstallPromptFired = true;
                window.geocrimePwaInstallPrompt = deferredPrompt;
                if (!isStandalone && localStorage.getItem(dismissedKey) !== '1') {
                    showBanner();
                }
                updateDebug();
            };

            if (deferredPrompt) {
                handleInstallReady();
            }

            window.addEventListener('beforeinstallprompt', handleInstallReady);
            window.addEventListener('geocrime-pwa-install-ready', () => handleInstallReady());

            installButton?.addEventListener('click', async () => {
                if (!deferredPrompt) {
                    alert('Chrome belum memberikan prompt install otomatis. Buka menu ⋮ di Chrome, lalu pilih "Install app" atau "Add to Home screen".');
                    updateDebug();
                    return;
                }

                deferredPrompt.prompt();
                const choice = await deferredPrompt.userChoice;
                log('install prompt result', choice);
                deferredPrompt = null;
                hideBanner();
                updateDebug();
            });

            window.addEventListener('appinstalled', () => {
                log('appinstalled fired');
                deferredPrompt = null;
                localStorage.setItem(dismissedKey, '1');
                hideBanner();
                updateDebug();
            });

            if (!isStandalone && !dismissed && isIos) {
                message.textContent = 'Di iPhone/iPad, buka tombol Share lalu pilih Add to Home Screen.';
                installButton.classList.add('hidden');
                window.addEventListener('load', showBanner);
            }

            if (!isStandalone && !dismissed && isAndroid) {
                window.addEventListener('load', () => {
                    window.setTimeout(() => {
                        if (!deferredPrompt) {
                            message.textContent = 'Chrome belum mengirim event install. Jika menu Chrome masih "Add to Home screen", hapus shortcut lama dan clear site data, lalu buka ulang /pwa tanpa ?pwa_debug.';
                            installButton.textContent = 'Cek Lagi';
                            showBanner();
                            updateDebug();
                        }
                    }, 3000);
                });
            }
            // Force reload when navigating back/forward from cached history to prevent showing authenticated pages after logout
            window.addEventListener('pageshow', (event) => {
                if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                    window.location.reload();
                }
            });
        })();
    </script>
</body>
</html>
