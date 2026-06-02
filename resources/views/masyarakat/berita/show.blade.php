<x-pwa-layout title="Detail Berita">
    <style>
        .hidden { display: none !important; }
        .gc-news-detail, .gc-news-detail * { box-sizing: border-box; }
        .gc-news-detail {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 28px 38px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #4b5563;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
        }
        .gc-back svg { width: 14px; height: 14px; }
        .gc-hero { width: 100%; height: 169px; margin-top: 24px; overflow: hidden; border-radius: 3px; background: linear-gradient(135deg, #1e3a8a, #f97316); }
        .gc-hero img { width: 100%; height: 100%; object-fit: cover; }
        .gc-placeholder { display: grid; width: 100%; height: 100%; place-items: center; background: linear-gradient(135deg, #0f2f7e, #0b1026 55%, #f59e0b); color: #fff; text-align: center; }
        .gc-placeholder strong { display: block; font-size: 24px; font-weight: 800; }
        .gc-placeholder span { display: block; margin-top: 6px; font-size: 10px; color: #dbeafe; }
        .gc-title { margin: 18px 0 0; color: #111827; font-size: 14px; font-weight: 800; line-height: 1.25; letter-spacing: -.015em; }
        .gc-meta { margin: 9px 0 0; color: #6b7280; font-size: 10px; line-height: 1.45; }
        .gc-meta strong { color: #4b5563; font-weight: 800; }
        .gc-section-title { margin: 18px 0 0; color: #111827; font-size: 12px; font-weight: 800; }
        .gc-content { margin: 7px 0 0; color: #4b5563; font-size: 10.5px; line-height: 1.65; text-align: left; }
        .gc-content p { margin: 0 0 10px; }
        @media (max-width: 380px) { .gc-news-detail { padding-right: 22px; padding-left: 22px; } .gc-hero { height: 150px; } }
    </style>

    <main class="gc-news-detail">
        <a href="{{ route('masyarakat.berita.index') }}" class="gc-back">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Kembali
        </a>

        <div class="gc-hero">
            @if ($berita->foto)
                <img src="{{ asset('storage/'.$berita->foto) }}" alt="{{ $berita->judul }}">
            @else
                <div class="gc-placeholder">
                    <div>
                        <strong>GeoCrime News</strong>
                        <span>Informasi terbaru untuk masyarakat</span>
                    </div>
                </div>
            @endif
        </div>

        <h1 class="gc-title">{{ $berita->judul }}</h1>
        <p class="gc-meta">
            Date: {{ optional($berita->published_at ?? $berita->created_at)->format('d F, Y') }}<br>
            Author: {{ $berita->penulis?->name ?? 'GeoCrime' }}
        </p>

        <h2 class="gc-section-title">Deskripsi</h2>
        <article class="gc-content">
            @foreach (preg_split('/\r\n|\r|\n/', trim($berita->isi_berita)) as $paragraph)
                @if (trim($paragraph) !== '')
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        </article>
    </main>
</x-pwa-layout>
