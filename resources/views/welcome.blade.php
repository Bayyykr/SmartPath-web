<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-pwa-head />

        <script>
            if ((window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone)) {
                window.location.replace('/pwa');
            }
        </script>
        <title>SmartPath - Portal Keamanan & Laporan Kejahatan Masyarakat</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --page-bg: #eef7fa;
                --border: #e5e7eb;
                --text: #111827;
                --muted: #6b7280;
                --accent: #2563eb;
                --accent-hover: #1d4ed8;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background-color: var(--page-bg);
                color: var(--text);
            }

            .admin-card {
                background: #ffffff;
                border: 1px solid var(--border);
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            }

            .btn-admin-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: var(--accent);
                color: #ffffff;
                border-radius: 6px;
                padding: 10px 18px;
                font-size: 14px;
                font-weight: 600;
                transition: background 0.15s ease;
            }

            .btn-admin-primary:hover {
                background: var(--accent-hover);
            }

            .btn-admin-secondary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #ffffff;
                color: var(--text);
                border: 1px solid #d1d5db;
                border-radius: 6px;
                padding: 10px 18px;
                font-size: 14px;
                font-weight: 600;
                transition: background 0.15s ease;
            }

            .btn-admin-secondary:hover {
                background: #f9fafb;
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col justify-between overflow-x-hidden antialiased">

        <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm w-full">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3">
                    <img src="/icons/icon_app.png" alt="SmartPath Logo" class="w-7 h-7 object-contain">
                    <span class="text-xl font-extrabold tracking-tight text-gray-950">Smart<span class="text-blue-600">Path</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-950 transition px-3.5 py-2 rounded-[6px] hover:bg-gray-100">
                        Login
                    </a>
                    <button id="nav-install-btn" class="hidden text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-[6px] shadow-sm transition transform active:scale-95">
                        Download App
                    </button>
                </div>
            </div>
        </header>

        <section class="py-16 md:py-24 px-6 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-full text-xs font-bold text-blue-700 uppercase tracking-wide">
                    🛡️ Sistem Pemantauan Wilayah Terintegrasi
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-950 leading-tight tracking-tight">
                    Bersama Wujudkan Lingkungan <br>
                    <span class="text-blue-600">Aman & Kondusif</span>
                </h1>

                <p class="text-gray-600 text-base sm:text-lg max-w-xl leading-relaxed">
                    SmartPath adalah platform digital kolaboratif untuk memantau kerawanan wilayah secara real-time. Laporkan kejahatan, pantau CCTV kota, dan gunakan akses darurat SOS langsung ke kepolisian setempat.
                </p>

                <!-- Call to Action -->
                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <!-- PWA Download Button -->
                    <button id="hero-install-btn" class="hidden items-center justify-center gap-2 btn-admin-primary">
                        <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Aplikasi (PWA)
                    </button>

                    <a href="{{ route('login') }}" class="btn-admin-secondary gap-2">
                        Login
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                </div>

                <div id="ios-install-tip" class="hidden max-w-md p-4 rounded-lg border border-amber-200 bg-amber-50 text-amber-800 text-sm">
                    <div class="flex gap-2">
                        <svg class="w-5 h-5 flex-shrink-0 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>
                            <strong>Pengguna iOS (Safari)</strong>: Tekan tombol <strong>Share</strong> <span class="inline-block px-1.5 bg-white/80 border border-amber-300 rounded text-xs">📤</span> lalu pilih <strong>"Add to Home Screen"</strong> untuk memasang aplikasi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 flex justify-center">
                <div class="w-full max-w-md admin-card p-6 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <span class="text-xs font-bold text-blue-600 tracking-wider uppercase">Sistem Terintegrasi</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-lg flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Tingkat Penanganan</p>
                                <h4 class="text-lg font-bold text-gray-900">98.4%</h4>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Sangat Cepat</span>
                        </div>

                        <div class="bg-gray-50 border border-gray-100 p-4 rounded-lg flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-semibold">CCTV Kota Terhubung</p>
                                <h4 class="text-lg font-bold text-gray-900">Aktif Realtime</h4>
                            </div>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Stream Live</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="/pwa" class="text-sm font-bold text-blue-600 hover:underline">
                            Buka Peta Overview Masyarakat &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-20 px-6 border-t border-gray-200">
            <div class="max-w-7xl mx-auto space-y-12">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-950">
                        Fitur Utama Platform SmartPath
                    </h2>
                    <p class="text-gray-600">
                        Berikut adalah modul-modul utama yang dapat digunakan oleh masyarakat dan aparat kepolisian untuk mempercepat pelaporan serta penanganan insiden.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 0 1 3 16.382V5.618a1 1 0 0 1 1.447-.894L9 7m0 12l6-3m-6 3V7m6 9l4.553 2.276A1 1 0 0 0 21 17.382V6.618a1 1 0 0 0-.553-.894L16 4m0 12V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Pemetaan Area Rawan (GIS)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Melihat visualisasi peta titik-titik rawan kriminalitas, pencurian, kekerasan, serta kecelakaan lalu lintas untuk meningkatkan kewaspadaan berkendara.
                        </p>
                    </div>

                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Tombol Darurat SOS</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Satu ketukan tombol SOS mengirimkan koordinat lokasi persis Anda ke Polsek terdekat untuk penanganan cepat dalam kondisi darurat ekstrem.
                        </p>
                    </div>

                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0 1 21 8.618v6.764a1 1 0 0 1-1.447.894L15 14M5 18h8a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Pantauan CCTV Live</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Akses live streaming CCTV publik perkotaan secara langsung guna memantau arus jalanan dan keamanan di sekitar lokasi Anda tinggal.
                        </p>
                    </div>

                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Laporan Cepat Terverifikasi</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Laporkan kejadian kriminal atau kecelakaan lengkap dengan unggahan foto. Admin kepolisian akan langsung memverifikasi status penanganan laporan Anda.
                        </p>
                    </div>

                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 4a2 2 0 0 0-2-2v3m2-3V9m0 0a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Portal Berita Keamanan</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Membaca rilis berita kejahatan, imbauan keamanan dari kepolisian, serta penyuluhan kesadaran hukum masyarakat secara kredibel.
                        </p>
                    </div>

                    <div class="admin-card p-6 space-y-4 hover:shadow-md transition duration-200">
                        <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-950">Aplikasi PWA Ringan</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Instal aplikasi dengan mudah tanpa menguras memori HP. Mendukung notifikasi push darurat, akses instan, serta pembaruan berkala otomatis.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-6 max-w-7xl mx-auto w-full space-y-12">
            <div class="text-center max-w-3xl mx-auto space-y-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-950">Cara Kerja SmartPath</h2>
                <p class="text-gray-600">3 Langkah mudah untuk mulai berpartisipasi menjaga keamanan wilayah bersama.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="admin-card p-6 relative space-y-4">
                    <span class="absolute top-4 right-6 text-5xl font-black text-blue-50 select-none">01</span>
                    <h3 class="text-lg font-bold text-gray-950">Unduh & Registrasi</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Instal aplikasi PWA di HP Anda, kemudian daftarkan akun masyarakat menggunakan email aktif Anda dengan cepat.
                    </p>
                </div>

                <div class="admin-card p-6 relative space-y-4">
                    <span class="absolute top-4 right-6 text-5xl font-black text-blue-50 select-none">02</span>
                    <h3 class="text-lg font-bold text-gray-950">Pantau Kondisi Wilayah</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Gunakan peta interaktif serta CCTV kota untuk memantau titik-titik lokasi rawan yang ingin Anda lewati.
                    </p>
                </div>

                <div class="admin-card p-6 relative space-y-4">
                    <span class="absolute top-4 right-6 text-5xl font-black text-blue-50 select-none">03</span>
                    <h3 class="text-lg font-bold text-gray-950">Gunakan Menu SOS & Laporan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Kirimkan sinyal darurat SOS jika Anda dalam bahaya atau buat laporan kejahatan untuk segera ditindaklanjuti polisi.
                    </p>
                </div>
            </div>
        </section>

        <footer class="border-t border-gray-200 bg-white py-12 px-6 text-center text-sm text-gray-500">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
                <p>&copy; {{ date('Y') }} SmartPath. Hak Cipta Dilindungi.</p>
                <div class="flex gap-6 font-semibold text-gray-600">
                    <a href="/pwa" class="hover:text-gray-950 transition">Dashboard Masyarakat</a>
                    <a href="{{ route('login') }}" class="hover:text-gray-950 transition">Login Admin</a>
                </div>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const isStandalone = () => {
                    return (window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone);
                };

                if (isStandalone()) {
                    window.location.replace('/pwa');
                    return;
                }

                const navInstallBtn = document.getElementById('nav-install-btn');
                const heroInstallBtn = document.getElementById('hero-install-btn');
                const iosInstallTip = document.getElementById('ios-install-tip');

                const isIos = () => {
                    const userAgent = window.navigator.userAgent.toLowerCase();
                    return /iphone|ipad|ipod/.test(userAgent);
                };

                const showInstallButtons = () => {
                    if (isStandalone()) return;

                    if (isIos()) {
                        if (iosInstallTip) {
                            iosInstallTip.classList.remove('hidden');
                        }
                    } else {
                        if (heroInstallBtn) {
                            heroInstallBtn.classList.remove('hidden');
                            heroInstallBtn.style.display = 'inline-flex';
                        }
                        if (navInstallBtn) {
                            navInstallBtn.classList.remove('hidden');
                        }
                    }
                };

                const handleInstallPromptReady = () => {
                    showInstallButtons();
                };

                window.addEventListener('geocrime-pwa-install-ready', handleInstallPromptReady);

                if (window.geocrimePwaBeforeInstallPromptFired && window.geocrimePwaInstallPrompt) {
                    handleInstallPromptReady();
                }

                setTimeout(() => {
                    showInstallButtons();
                }, 2000);

                const triggerPrompt = async (e) => {
                    e.preventDefault();
                    const promptEvent = window.geocrimePwaInstallPrompt;
                    if (!promptEvent) {
                        window.location.href = '/pwa';
                        return;
                    }

                    promptEvent.prompt();
                    const { outcome } = await promptEvent.userChoice;
                    console.log(`PWA install response: ${outcome}`);
                    window.geocrimePwaInstallPrompt = null;
                    window.geocrimePwaBeforeInstallPromptFired = false;

                    if (heroInstallBtn) heroInstallBtn.classList.add('hidden');
                    if (navInstallBtn) navInstallBtn.classList.add('hidden');
                };

                if (heroInstallBtn) heroInstallBtn.addEventListener('click', triggerPrompt);
                if (navInstallBtn) navInstallBtn.addEventListener('click', triggerPrompt);
            });
        </script>
    </body>
</html>
