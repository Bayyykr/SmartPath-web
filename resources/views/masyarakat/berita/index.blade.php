<x-pwa-layout title="Berita">
    <style>
        .hidden { display: none !important; }
        .gc-news-page, .gc-news-page * { box-sizing: border-box; }
        .gc-news-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 42px 28px 96px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-title { margin: 0; color: #2b2b2f; font-size: 18px; font-weight: 800; line-height: 1; letter-spacing: -.035em; }
        .gc-subtitle { margin: 9px 0 0; color: #6b7280; font-size: 11px; line-height: 1.45; }
        .gc-search { position: relative; margin-top: 18px; }
        .gc-search svg { position: absolute; left: 13px; top: 50%; width: 13px; height: 13px; color: #9ca3af; transform: translateY(-50%); }
        .gc-search input {
            display: block;
            width: 100%;
            height: 34px;
            border: 0;
            border-radius: 3px;
            background: #f4f4f5;
            padding: 0 12px 0 35px;
            color: #111827;
            font-size: 10px;
            outline: none;
        }
        .gc-news-list { margin-top: 18px; }
        .gc-news-card { display: block; margin-bottom: 22px; color: inherit; text-decoration: none; }
        .gc-news-image { width: 100%; height: 145px; overflow: hidden; border-radius: 3px; background: linear-gradient(135deg, #1e3a8a, #f97316); }
        .gc-news-image img { width: 100%; height: 100%; object-fit: cover; }
        .gc-news-placeholder { display: grid; width: 100%; height: 100%; place-items: center; background: linear-gradient(135deg, #0f2f7e, #0b1026 55%, #f59e0b); color: #fff; text-align: center; }
        .gc-news-placeholder strong { display: block; font-size: 22px; font-weight: 800; }
        .gc-news-placeholder span { display: block; margin-top: 5px; font-size: 10px; color: #dbeafe; }
        .gc-news-heading { margin: 9px 0 0; color: #111827; font-size: 12px; font-weight: 800; line-height: 1.25; letter-spacing: -.01em; }
        .gc-news-desc { margin: 5px 0 0; color: #6b7280; font-size: 10px; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .gc-empty { display: grid; min-height: 360px; place-items: center; text-align: center; color: #64748b; }
        .gc-empty svg { width: 118px; height: 118px; }
        .gc-empty p { margin: 12px 0 0; font-size: 11px; font-weight: 700; }
        @media (max-width: 380px) { .gc-news-page { padding-right: 22px; padding-left: 22px; } .gc-news-image { height: 132px; } }
    </style>

    <main class="gc-news-page">
        <h1 class="gc-title">Berita</h1>
        <p class="gc-subtitle">Dapatkan berita terkini</p>

        <label class="gc-search" aria-label="Cari berita">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            <input type="search" placeholder="Search Here" data-news-search>
        </label>

        <section class="gc-news-list">
            @forelse ($beritas as $berita)
                <a
                    href="{{ route('masyarakat.berita.show', $berita) }}"
                    class="gc-news-card"
                    data-news-card
                    data-title="{{ Str::lower($berita->judul) }}"
                    data-content="{{ Str::lower(strip_tags($berita->isi_berita)) }}"
                >
                    <div class="gc-news-image">
                        @if ($berita->foto)
                            <img src="{{ asset('storage/'.$berita->foto) }}" alt="{{ $berita->judul }}">
                        @else
                            <div class="gc-news-placeholder">
                                <div>
                                    <strong>GeoCrime News</strong>
                                    <span>Informasi terbaru untuk masyarakat</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <h2 class="gc-news-heading">{{ $berita->judul }}</h2>
                    <p class="gc-news-desc">{{ Str::limit(strip_tags($berita->isi_berita), 112) }}</p>
                </a>
            @empty
                <div class="gc-empty">
                    <div>
                        <svg viewBox="0 0 160 140" fill="none" aria-hidden="true">
                            <ellipse cx="80" cy="122" rx="50" ry="9" fill="#E9EDF7"/>
                            <rect x="37" y="29" width="82" height="88" rx="8" fill="#EFF6FF"/>
                            <rect x="48" y="43" width="60" height="14" rx="3" fill="#253aa8"/>
                            <rect x="48" y="67" width="60" height="6" rx="3" fill="#CBD5E1"/>
                            <rect x="48" y="82" width="48" height="6" rx="3" fill="#CBD5E1"/>
                            <rect x="48" y="97" width="55" height="6" rx="3" fill="#CBD5E1"/>
                            <circle cx="116" cy="33" r="17" fill="#FDBA38"/>
                            <path d="M109 33h14M116 26v14" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                        <p>Belum ada berita</p>
                    </div>
                </div>
            @endforelse
        </section>
    </main>

    @include('masyarakat.components')

    <script>
        (() => {
            const search = document.querySelector('[data-news-search]');
            const cards = Array.from(document.querySelectorAll('[data-news-card]'));

            search?.addEventListener('input', () => {
                const query = search.value.trim().toLowerCase();
                cards.forEach((card) => {
                    const text = `${card.dataset.title || ''} ${card.dataset.content || ''}`;
                    card.style.display = text.includes(query) ? 'block' : 'none';
                });
            });
        })();
    </script>
</x-pwa-layout>
