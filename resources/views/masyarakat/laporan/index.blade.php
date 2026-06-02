<x-pwa-layout title="Laporan">
    <style>
        .hidden { display: none !important; }
        .gc-report-page, .gc-report-page * { box-sizing: border-box; }
        .gc-report-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 42px 28px 96px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-title { margin: 0; color: #2b2b2f; font-size: 17px; font-weight: 800; line-height: 1; letter-spacing: -.035em; }
        .gc-subtitle { margin: 9px 0 0; color: #6b7280; font-size: 11px; line-height: 1.45; }
        .gc-subtitle a { color: #253aa8; font-weight: 800; text-decoration: none; }
        .gc-alert { margin-top: 16px; border-radius: 4px; background: #ecfdf5; padding: 10px 12px; color: #047857; font-size: 11px; font-weight: 700; }
        .gc-list { margin-top: 24px; }
        .gc-report-row { display: flex; align-items: center; gap: 12px; padding: 0 0 13px; color: inherit; text-decoration: none; }
        .gc-thumb { width: 42px; height: 42px; flex: none; overflow: hidden; border-radius: 2px; background: #e5e7eb; }
        .gc-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .gc-thumb-placeholder { display: grid; width: 100%; height: 100%; place-items: center; background: linear-gradient(135deg, #111827, #334155); color: #fff; }
        .gc-thumb-placeholder svg { width: 22px; height: 22px; }
        .gc-report-info { min-width: 0; flex: 1; }
        .gc-report-title { margin: 0; overflow: hidden; color: #111827; font-size: 10px; font-weight: 800; line-height: 1.15; text-overflow: ellipsis; white-space: nowrap; }
        .gc-report-date { margin: 4px 0 0; color: #6b7280; font-size: 9px; line-height: 1.15; }
        .gc-report-status { margin: 4px 0 0; color: #6b7280; font-size: 8.5px; line-height: 1.15; text-transform: capitalize; }
        .gc-chevron { flex: none; color: #111827; font-size: 16px; line-height: 1; }
        .gc-empty { display: grid; min-height: 430px; place-items: center; text-align: center; }
        .gc-empty svg { width: 122px; height: 122px; }
        .gc-empty-text { margin: 12px 0 0; color: #4b5563; font-size: 10px; font-weight: 600; }
        @media (max-width: 380px) { .gc-report-page { padding-right: 22px; padding-left: 22px; } }
    </style>

    <main class="gc-report-page">
        <h1 class="gc-title">Laporan Anda</h1>
        <p class="gc-subtitle">Daftar laporan Anda, <a href="{{ route('masyarakat.laporan.create') }}">Buat di sini</a></p>

        @if (session('status'))
            <div class="gc-alert">{{ session('status') }}</div>
        @endif

        @if ($laporans->isNotEmpty())
            <div class="gc-list">
                @foreach ($laporans as $laporan)
                    <a href="{{ route('masyarakat.laporan.create') }}" class="gc-report-row">
                        <span class="gc-thumb">
                            @if ($laporan->foto_kejadian)
                                <img src="{{ asset('storage/'.$laporan->foto_kejadian) }}" alt="{{ $laporan->judul_laporan }}">
                            @else
                                <span class="gc-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 17 9 12l3 3 3-4 5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 5h14v14H5z" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="9" r="1.5" fill="currentColor"/></svg>
                                </span>
                            @endif
                        </span>
                        <span class="gc-report-info">
                            <span class="gc-report-title">{{ $laporan->judul_laporan }}</span>
                            <span class="gc-report-date">{{ $laporan->created_at?->format('d-m-Y H:i') }}</span>
                            <span class="gc-report-status">{{ str_replace('_', ' ', $laporan->status) }}</span>
                        </span>
                        <span class="gc-chevron">›</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="gc-empty">
                <div>
                    <svg viewBox="0 0 180 150" fill="none" aria-hidden="true">
                        <ellipse cx="88" cy="128" rx="50" ry="10" fill="#E9EDF7"/>
                        <path d="M58 98c-10-20-4-42 15-56 17-12 41-11 58 2 18 14 23 36 12 55-14 25-71 25-85-1Z" fill="#D9F0FF"/>
                        <path d="M77 78c0-17 10-30 25-31 15-1 27 10 29 26 2 20-9 37-26 38-16 1-28-13-28-33Z" fill="#FFB3A6"/>
                        <path d="M86 59c7-13 21-17 36-10" stroke="#253269" stroke-width="7" stroke-linecap="round"/>
                        <path d="M86 76c-17 8-29 22-34 42" stroke="#4699D8" stroke-width="17" stroke-linecap="round"/>
                        <path d="M123 75c17 9 27 23 31 43" stroke="#4699D8" stroke-width="17" stroke-linecap="round"/>
                        <rect x="70" y="89" width="54" height="35" rx="5" fill="#fff"/>
                        <path d="M80 101h34M80 110h25" stroke="#CBD5E1" stroke-width="4" stroke-linecap="round"/>
                        <path d="M126 30h27v32h-27z" fill="#FF595E" transform="rotate(8 126 30)"/>
                        <path d="M133 40h11M133 48h8" stroke="#fff" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                    <p class="gc-empty-text">Tidak Ada Data</p>
                </div>
            </div>
        @endif
    </main>

    @include('masyarakat.components')
</x-pwa-layout>
