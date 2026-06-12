<x-pwa-layout title="Detail Laporan">
    <style>
        .gc-detail-page, .gc-detail-page * { box-sizing: border-box; }
        .gc-detail-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 24px 96px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-back { display: inline-flex; align-items: center; gap: 8px; color: #4b5563; font-size: 11px; font-weight: 800; text-decoration: none; }
        .gc-back svg { width: 14px; height: 14px; }
        
        .gc-category-badge {
            display: inline-block;
            margin-top: 18px;
            font-size: 9px;
            font-weight: 800;
            padding: 4px 8px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 4px;
            text-transform: uppercase;
        }
        
        .gc-title { margin: 8px 0 0; color: #0f172a; font-size: 21px; font-weight: 800; line-height: 1.2; letter-spacing: -.03em; }
        
        .gc-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .gc-meta-date {
            font-size: 10.5px;
            color: #64748b;
        }
        
        /* Status Badges */
        .gc-status {
            font-size: 9.5px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 9999px;
            text-transform: capitalize;
        }
        .gc-status-pending { background: #ffedd5; color: #ea580c; }
        .gc-status-dikonfirmasi { background: #dbeafe; color: #2563eb; }
        .gc-status-diproses { background: #e0e7ff; color: #4f46e5; }
        .gc-status-selesai { background: #dcfce7; color: #166534; }
        .gc-status-ditolak { background: #fee2e2; color: #dc2626; }

        .gc-section-title {
            margin: 20px 0 8px;
            color: #1e293b;
            font-size: 12px;
            font-weight: 800;
        }
        
        .gc-desc {
            font-size: 12px;
            line-height: 1.6;
            color: #475569;
            background: #f8fafc;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }
        
        .gc-image-box {
            margin-top: 14px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            max-height: 240px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gc-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gc-map-container {
            margin-top: 14px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            height: 180px;
        }
        #detail-map {
            width: 100%;
            height: 100%;
        }
        .gc-location-text {
            font-size: 10.5px;
            color: #64748b;
            margin-top: 6px;
            line-height: 1.4;
        }
    </style>

    <main class="gc-detail-page">
        <a href="{{ route('masyarakat.laporan.index') }}" class="gc-back">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Kembali
        </a>

        <div>
            <span class="gc-category-badge">{{ $laporan->kategori?->nama_kategori ?? 'Laporan' }}</span>
            <h1 class="gc-title">{{ $laporan->judul_laporan }}</h1>
            
            <div class="gc-meta">
                <span class="gc-meta-date">Diajukan pada {{ $laporan->created_at?->format('d M Y H:i') }}</span>
                <span class="gc-status gc-status-{{ $laporan->status }}">
                    {{ str_replace('_', ' ', $laporan->status) }}
                </span>
            </div>
            
            <h2 class="gc-section-title">Kronologi Kejadian</h2>
            <div class="gc-desc">
                {!! nl2br(e($laporan->deskripsi)) !!}
            </div>

            @if($laporan->foto_kejadian)
                <h2 class="gc-section-title">Foto Bukti</h2>
                <div class="gc-image-box">
                    <img src="{{ asset('storage/' . $laporan->foto_kejadian) }}" alt="Foto bukti {{ $laporan->judul_laporan }}">
                </div>
            @endif

            @if($laporan->latitude && $laporan->longitude)
                <h2 class="gc-section-title">Lokasi Kejadian</h2>
                <div class="gc-map-container">
                    <div id="detail-map"></div>
                </div>
                <p class="gc-location-text">
                    📍 Area: {{ $laporan->lokasi?->nama_lokasi ?? 'GPS Terdeteksi' }}<br>
                    <span>Koordinat: {{ $laporan->latitude }}, {{ $laporan->longitude }}</span>
                </p>
            @endif
        </div>
    </main>

    @if($laporan->latitude && $laporan->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ (float) $laporan->latitude }};
                const lng = {{ (float) $laporan->longitude }};
                
                const map = L.map('detail-map', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([lat, lng], 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                
                L.marker([lat, lng]).addTo(map);
            });
        </script>
    @endif

    @include('masyarakat.components')
</x-pwa-layout>
