<x-pwa-layout title="Home">
    @php
        $firstName = Str::of(Auth::user()->name)->before(' ');
        $crimeCategory = $categories->first(fn ($category) => ($category->jenis ?? '') !== 'kecelakaan') ?? $categories->first();
        $accidentCategory = $categories->first(fn ($category) => ($category->jenis ?? '') === 'kecelakaan') ?? $categories->skip(1)->first() ?? $categories->first();
    @endphp

    <style>
        .hidden { display: none !important; }
        .gc-home, .gc-home * { box-sizing: border-box; }
        .gc-home {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 30px 28px 96px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-topbar { display: flex; align-items: center; justify-content: space-between; gap: 14px; }
        .gc-user { display: flex; min-width: 0; align-items: center; gap: 12px; }
        .gc-avatar { width: 43px; height: 43px; flex: none; overflow: hidden; border-radius: 999px; background: #eaf1ff; }
        .gc-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .gc-avatar-fallback { display: grid; width: 100%; height: 100%; place-items: center; color: #253aa8; font-size: 20px; font-weight: 800; }
        .gc-greeting { margin: 0; color: #2b2b2f; font-size: 17px; font-weight: 800; line-height: 1.1; letter-spacing: -.035em; }
        .gc-subtitle { margin: 5px 0 0; color: #6b7280; font-size: 11px; line-height: 1.35; }
        .gc-notification { display: grid; width: 32px; height: 32px; flex: none; place-items: center; border-radius: 999px; background: #f5f6f8; color: #253aa8; border: 0; cursor: pointer; }
        .gc-notification svg { width: 16px; height: 16px; }

        /* Notification Drawer & List Styles */
        .gc-notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #ef4444;
            border: 1.5px solid #f5f6f8;
        }
        .gc-drawer {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: flex;
            align-items: end;
            justify-content: center;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(4px);
        }
        .gc-drawer-content {
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            border-radius: 20px 20px 0 0;
            padding: 24px 20px calc(24px + env(safe-area-inset-bottom));
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.1);
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
        }
        .gc-drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .gc-drawer-title {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }
        .gc-drawer-close {
            font-size: 18px;
            color: #64748b;
            cursor: pointer;
            border: 0;
            background: none;
            padding: 4px;
        }
        .gc-notif-list {
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .gc-notif-item {
            display: flex;
            gap: 14px;
            padding: 12px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
            align-items: start;
        }
        .gc-notif-item:hover {
            background: #f1f5f9;
            border-color: #e2e8f0;
        }
        .gc-notif-icon-box {
            font-size: 18px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .gc-notif-info {
            flex: 1;
            min-width: 0;
        }
        .gc-notif-title {
            font-weight: 800;
            font-size: 11.5px;
            color: #1e293b;
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .gc-notif-unread-dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: #3b82f6;
            display: inline-block;
        }
        .gc-notif-desc {
            font-size: 10.5px;
            color: #64748b;
            line-height: 1.4;
            margin: 0;
        }
        .gc-notif-time {
            font-size: 8.5px;
            color: #94a3b8;
            margin-top: 6px;
            display: block;
        }
        .gc-notif-empty {
            text-align: center;
            padding: 40px 20px;
            color: #64748b;
            font-size: 12px;
        }
        .gc-section-head { display: flex; align-items: center; justify-content: space-between; margin-top: 29px; }
        .gc-section-title { margin: 0; color: #2f333b; font-size: 12px; font-weight: 800; letter-spacing: -.02em; }
        .gc-see-all { color: #253aa8; font-size: 9px; font-weight: 800; text-decoration: none; }
        .gc-risk-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin-top: 12px; }
        .gc-risk-card { min-height: 130px; overflow: hidden; border-radius: 3px; background: #f4f5f7; padding: 11px 10px 8px; text-decoration: none; color: inherit; }
        .gc-risk-card-title { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin: 0; color: #2d3340; font-size: 11px; font-weight: 800; }
        .gc-risk-card-title span { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .gc-risk-art { display: grid; height: 90px; margin-top: 10px; place-items: center; }
        .gc-risk-art svg,
        .gc-risk-art img { width: 100%; max-width: 120px; height: 90px; object-fit: contain; }
        .gc-cctv-list { margin-top: 12px; }
        .gc-cctv-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 8px 0; color: inherit; text-decoration: none; }
        .gc-cctv-left { display: flex; min-width: 0; align-items: center; gap: 10px; }
        .gc-status-dot { width: 7px; height: 7px; flex: none; border-radius: 999px; background: #22c55e; }
        .gc-status-dot.is-offline { background: #ef2323; }
        .gc-cctv-status { margin: 0; color: #111827; font-size: 10px; font-weight: 800; line-height: 1.1; }
        .gc-cctv-name { margin: 3px 0 0; color: #6b7280; font-size: 9px; line-height: 1.15; }
        .gc-chevron { flex: none; color: #111827; font-size: 16px; line-height: 1; }
        .gc-map-panel { margin-top: 12px; overflow: hidden; border: 1px solid #e7e9ee; border-radius: 3px; background: #eef1f4; }
        .gc-map-header { display: flex; align-items: center; gap: 8px; padding: 8px 10px; background: #fff; color: #2f333b; font-size: 11px; font-weight: 800; }
        .gc-map-header svg { width: 14px; height: 14px; }
        #map { height: 380px; width: 100%; z-index: 1; }
        .gc-map-canvas::before {
            content: "";
            position: absolute;
            inset: -25px;
            background:
                linear-gradient(28deg, transparent 48%, rgba(58, 130, 189, .18) 49%, rgba(58, 130, 189, .18) 51%, transparent 52%),
                linear-gradient(118deg, transparent 48%, rgba(58, 130, 189, .14) 49%, rgba(58, 130, 189, .14) 51%, transparent 52%),
                linear-gradient(0deg, transparent 48%, rgba(148, 163, 184, .30) 49%, rgba(148, 163, 184, .30) 50%, transparent 51%),
                linear-gradient(90deg, transparent 48%, rgba(148, 163, 184, .24) 49%, rgba(148, 163, 184, .24) 50%, transparent 51%);
            background-size: 170px 120px, 150px 155px, 58px 58px, 64px 64px;
            transform: rotate(-7deg) scale(1.08);
        }
        .gc-map-road { position: absolute; border-radius: 999px; background: rgba(255, 255, 255, .88); box-shadow: 0 0 0 1px rgba(203, 213, 225, .75); }
        .gc-map-road.one { width: 390px; height: 16px; left: -40px; top: 130px; transform: rotate(-18deg); }
        .gc-map-road.two { width: 340px; height: 13px; left: -16px; top: 235px; transform: rotate(14deg); }
        .gc-map-road.three { width: 13px; height: 360px; left: 180px; top: -20px; transform: rotate(17deg); }
        .gc-map-river { position: absolute; width: 430px; height: 55px; left: -55px; top: 285px; border-radius: 50%; border-top: 8px solid rgba(56, 189, 248, .35); transform: rotate(-8deg); }
        .gc-map-label { position: absolute; color: rgba(71, 85, 105, .55); font-size: 10px; font-weight: 700; }
        .gc-map-marker { position: absolute; display: grid; width: 25px; height: 25px; place-items: center; border-radius: 999px; background: #fff; box-shadow: 0 4px 12px rgba(15, 23, 42, .16); }
        .gc-map-marker svg { width: 15px; height: 15px; }
        .gc-map-marker.pin { color: #ef4444; left: 64px; top: 110px; }
        .gc-map-marker.pin2 { color: #f59e0b; right: 88px; top: 155px; }
        .gc-map-marker.cam { color: #2563eb; left: 128px; top: 205px; }
        .gc-map-marker.warn { color: #f97316; right: 54px; bottom: 82px; }
        .gc-map-legend { position: absolute; left: 10px; top: 10px; z-index: 2; min-width: 98px; border-radius: 3px; background: rgba(255,255,255,.94); padding: 8px; box-shadow: 0 6px 14px rgba(15, 23, 42, .08); }
        .gc-map-legend-row { display: flex; align-items: center; gap: 6px; margin: 5px 0; color: #334155; font-size: 9px; font-weight: 700; }
        .gc-map-legend-dot { width: 9px; height: 9px; border-radius: 999px; background: #2563eb; }
        .gc-map-zoom { position: absolute; right: 10px; top: 78px; z-index: 2; overflow: hidden; border-radius: 3px; background: #fff; box-shadow: 0 5px 12px rgba(15,23,42,.12); }
        .gc-map-zoom span { display: grid; width: 28px; height: 28px; place-items: center; color: #334155; font-size: 16px; font-weight: 800; }
        .gc-map-zoom span + span { border-top: 1px solid #e5e7eb; }
        .gc-empty { margin-top: 12px; border-radius: 4px; background: #f8fafc; padding: 14px; color: #64748b; font-size: 11px; }
        @media (max-width: 380px) { .gc-home { padding-right: 22px; padding-left: 22px; } .gc-map-canvas { height: 340px; } }
    </style>

    <main class="gc-home">
        <header class="gc-topbar">
            <div class="gc-user">
                <div class="gc-avatar">
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="Profil {{ Auth::user()->name }}">
                    @else
                        <span class="gc-avatar-fallback">{{ Str::of($firstName)->substr(0, 1)->upper() }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="gc-greeting">Hello, {{ $firstName }}!</h1>
                    <p class="gc-subtitle">Perhatikan sekeliling Anda, tetap aman.</p>
                </div>
            </div>
            <button type="button" onclick="showNotificationDrawer()" class="gc-notification relative" aria-label="Notifikasi">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 9a6 6 0 1 1 12 0c0 7 2.5 7 2.5 8.5H3.5C3.5 16 6 16 6 9Z" stroke="currentColor" stroke-width="2"/><path d="M9.5 19a2.5 2.5 0 0 0 5 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                @if ($notifications->where('is_unread', true)->count() > 0)
                    <span class="gc-notification-badge"></span>
                @endif
            </button>
        </header>

        <section>
            <div class="gc-section-head">
                <h2 class="gc-section-title">Daerah Rentan</h2>
            </div>

            <div class="gc-risk-grid">
                @foreach ($locations->take(2) as $loc)
                    <a href="#street-map" class="gc-risk-card" onclick="if(window.focusLocation) { window.focusLocation('{{ $loc->nama_lokasi }}'); }">
                        <p class="gc-risk-card-title"><span>{{ $loc->nama_lokasi }}</span><span>›</span></p>
                        <div class="gc-risk-art">
                            <img src="{{ asset('overview_map.png') }}" alt="{{ $loc->nama_lokasi }}" class="h-full max-h-[90px] w-full max-w-[120px] object-contain">
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section>
            <div class="gc-section-head">
                <h2 class="gc-section-title">Lokasi CCTV</h2>
                <a href="{{ route('masyarakat.cctv') }}" class="gc-see-all">Lihat Semua</a>
            </div>

            <div class="gc-cctv-list">
                @forelse ($cctvs->take(4) as $cctv)
                    <a href="{{ route('masyarakat.cctv') }}" class="gc-cctv-row">
                        <div class="gc-cctv-left">
                            <span class="gc-status-dot{{ $cctv->aktif ? '' : ' is-offline' }}"></span>
                            <div>
                                <p class="gc-cctv-status">{{ $cctv->aktif ? 'Online' : 'Offline' }}</p>
                                <p class="gc-cctv-name">{{ $cctv->nama }}</p>
                            </div>
                        </div>
                        <span class="gc-chevron">›</span>
                    </a>
                @empty
                    <div class="gc-empty">Belum ada CCTV terdaftar.</div>
                @endforelse
            </div>
        </section>

        <section id="street-map">
            <div class="gc-section-head">
                <h2 class="gc-section-title">Street Maps</h2>
            </div>

            <div class="gc-map-panel">
                <div class="gc-map-header">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m4 7 5-2 6 2 5-2v12l-5 2-6-2-5 2V7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 5v12M15 7v12" stroke="currentColor" stroke-width="2"/></svg>
                    <span>Street Maps</span>
                </div>
                <div id="map"></div>
            </div>
        </section>
    </main>

    <!-- Notification Drawer -->
    <div id="notification-drawer" class="gc-drawer hidden" onclick="if(event.target === this) hideNotificationDrawer()">
        <div id="notification-drawer-content" class="gc-drawer-content">
            <div class="gc-drawer-header">
                <span class="gc-drawer-title">Notifikasi Aktivitas</span>
                <button type="button" onclick="hideNotificationDrawer()" class="gc-drawer-close">×</button>
            </div>
            
            <div class="gc-notif-list">
                @forelse ($notifications as $notif)
                    <a href="{{ route('masyarakat.laporan.show', $notif['id']) }}" class="gc-notif-item">
                        <span class="gc-notif-icon-box">
                            {{ $notif['icon'] }}
                        </span>
                        <span class="gc-notif-info">
                            <span class="gc-notif-title">
                                <span>{{ $notif['title'] }}</span>
                                @if($notif['is_unread'])
                                    <span class="gc-notif-unread-dot"></span>
                                @endif
                            </span>
                            <p class="gc-notif-desc">{{ $notif['desc'] }}</p>
                            <span class="gc-notif-time">{{ $notif['time'] }}</span>
                        </span>
                    </a>
                @empty
                    <div class="gc-notif-empty">
                        <p style="font-size: 24px; margin-bottom: 8px;">📭</p>
                        <p>Belum ada notifikasi baru untuk Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function showNotificationDrawer() {
            const drawer = document.getElementById('notification-drawer');
            const content = document.getElementById('notification-drawer-content');
            drawer.classList.remove('hidden');
            setTimeout(() => {
                content.style.transform = 'translateY(0)';
            }, 10);
        }

        function hideNotificationDrawer() {
            const drawer = document.getElementById('notification-drawer');
            const content = document.getElementById('notification-drawer-content');
            content.style.transform = 'translateY(100%)';
            setTimeout(() => {
                drawer.classList.add('hidden');
            }, 300);
        }
    </script>

    @include('masyarakat.components')
</x-pwa-layout>
