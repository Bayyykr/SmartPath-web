@php
    $pwaManifestPath = public_path('manifest.webmanifest');
    $pwaManifestVersion = file_exists($pwaManifestPath) ? filemtime($pwaManifestPath) : time();
@endphp

<meta name="theme-color" content="#3159d4">
<meta name="application-name" content="SmartPath">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="SmartPath">
<link rel="manifest" href="/pwa-manifest.webmanifest?v={{ $pwaManifestVersion }}">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/icons/icon_app.png" sizes="192x192" type="image/png">
<link rel="icon" href="/icons/icon_app.png" sizes="512x512" type="image/png">
<link rel="icon" href="/icons/icon_app.png" sizes="192x192" type="image/png">
<link rel="icon" href="/icons/icon_app.png" sizes="512x512" type="image/png">
<link rel="apple-touch-icon" href="/icons/icon_app.png" sizes="180x180">
<link rel="apple-touch-icon" href="/icons/icon_app.png" sizes="192x192">
<script>
    window.geocrimePwaBeforeInstallPromptFired = false;
    window.geocrimePwaInstallPrompt = null;

    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        window.geocrimePwaBeforeInstallPromptFired = true;
        window.geocrimePwaInstallPrompt = event;
        window.dispatchEvent(new CustomEvent('geocrime-pwa-install-ready'));
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker
                .register('/sw.js', { scope: '/' })
                .then((registration) => registration.update?.())
                .catch((error) => console.error('Service worker registration failed', error));
        });
    }
</script>
