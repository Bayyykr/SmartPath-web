<x-pwa-layout title="CCTV">
    <style>
        .hidden { display: none !important; }
        .gc-cctv-page, .gc-cctv-page * { box-sizing: border-box; }
        .gc-cctv-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 28px 96px;
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
        .gc-title { margin: 20px 0 0; color: #2b2b2f; font-size: 21px; font-weight: 800; line-height: 1; letter-spacing: -.04em; }
        .gc-subtitle { margin: 7px 0 0; color: #6b7280; font-size: 11px; line-height: 1.35; }
        .gc-search { position: relative; margin-top: 20px; }
        .gc-search svg { position: absolute; left: 12px; top: 50%; width: 13px; height: 13px; color: #9ca3af; transform: translateY(-50%); }
        .gc-search input {
            display: block;
            width: 100%;
            height: 32px;
            border: 0;
            border-radius: 3px;
            background: #f4f4f5;
            padding: 0 12px 0 34px;
            color: #111827;
            font-size: 10px;
            outline: none;
        }
        .gc-list { margin-top: 19px; }
        .gc-row {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 0;
            background: transparent;
            padding: 8px 0;
            color: inherit;
            text-align: left;
            cursor: pointer;
        }
        .gc-row-left { display: flex; min-width: 0; align-items: center; gap: 10px; }
        .gc-dot { width: 7px; height: 7px; flex: none; border-radius: 999px; background: #22c55e; }
        .gc-dot.is-offline { background: #ef2323; }
        .gc-status { margin: 0; color: #111827; font-size: 10px; font-weight: 800; line-height: 1.1; }
        .gc-name { margin: 3px 0 0; color: #6b7280; font-size: 9px; line-height: 1.15; }
        .gc-chevron { flex: none; color: #111827; font-size: 16px; line-height: 1; }
        .gc-empty { display: grid; min-height: 260px; place-items: center; color: #64748b; font-size: 12px; text-align: center; }
        .gc-detail { display: none; min-height: calc(100vh - 124px); padding-top: 26px; }
        .gc-detail.is-visible { display: block; }
        .gc-list-screen.is-hidden { display: none; }
        .gc-video-wrap {
            display: grid;
            min-height: 360px;
            place-items: center;
        }
        .gc-video-box {
            width: 100%;
            overflow: hidden;
            border: 4px solid #111827;
            background: #111827;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .08);
        }
        .gc-video-box iframe,
        .gc-video-box video {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            border: 0;
            background: #111827;
        }
        .gc-video-placeholder {
            display: grid;
            width: 100%;
            aspect-ratio: 16 / 9;
            place-items: center;
            background:
                linear-gradient(135deg, rgba(255,255,255,.08) 25%, transparent 25%) 0 0 / 28px 28px,
                linear-gradient(225deg, rgba(255,255,255,.08) 25%, transparent 25%) 0 0 / 28px 28px,
                #1f2937;
            color: #fff;
            text-align: center;
        }
        .gc-video-placeholder strong { display: block; font-size: 13px; }
        .gc-video-placeholder span { display: block; margin-top: 5px; color: #cbd5e1; font-size: 10px; }
        .gc-open-stream {
            display: block;
            margin-top: 12px;
            border-radius: 4px;
            background: #242424;
            padding: 12px 14px;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            text-align: center;
            text-decoration: none;
        }
        .gc-detail-meta { margin-top: 18px; color: #475569; font-size: 11px; text-align: center; }
        @media (max-width: 380px) { .gc-cctv-page { padding-right: 22px; padding-left: 22px; } .gc-video-wrap { min-height: 310px; } }
    </style>

    <main class="gc-cctv-page">
        <section class="gc-list-screen" data-cctv-list-screen>
            <a href="{{ route('masyarakat.home') }}" class="gc-back">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
                Kembali
            </a>

            <h1 class="gc-title">Semua CCTV</h1>
            <p class="gc-subtitle">Lihat CCTV Kota Jember</p>

            <label class="gc-search" aria-label="Cari CCTV">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
                <input type="search" placeholder="Search here" data-cctv-search>
            </label>

            <div class="gc-list">
                @forelse ($cctvs as $cctv)
                    <button
                        type="button"
                        class="gc-row"
                        data-cctv-row
                        data-name="{{ $cctv->nama }}"
                        data-status="{{ $cctv->aktif ? 'Online' : 'Offline' }}"
                        data-online="{{ $cctv->aktif ? '1' : '0' }}"
                        data-embed="{{ $cctv->embed_url }}"
                        data-stream="{{ $cctv->url_stream }}"
                    >
                        <span class="gc-row-left">
                            <span class="gc-dot{{ $cctv->aktif ? '' : ' is-offline' }}"></span>
                            <span>
                                <span class="gc-status">{{ $cctv->aktif ? 'Online' : 'Offline' }}</span>
                                <span class="gc-name">{{ $cctv->nama }}</span>
                            </span>
                        </span>
                        <span class="gc-chevron">›</span>
                    </button>
                @empty
                    <div class="gc-empty">Belum ada CCTV terdaftar.</div>
                @endforelse
            </div>
        </section>

        <section class="gc-detail" data-cctv-detail>
            <button type="button" class="gc-back" data-cctv-back>
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
                Kembali
            </button>

            <div class="gc-video-wrap">
                <div style="width:100%;">
                    <div class="gc-video-box" data-cctv-video>
                        <div class="gc-video-placeholder">
                            <div>
                                <strong>Pilih CCTV</strong>
                                <span>Stream akan tampil di sini</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" target="_blank" rel="noopener" class="gc-open-stream hidden" data-cctv-open>Buka Stream</a>
                    <p class="gc-detail-meta" data-cctv-meta></p>
                </div>
            </div>
        </section>
    </main>

    @include('masyarakat.components')

    <script>
        (() => {
            const listScreen = document.querySelector('[data-cctv-list-screen]');
            const detail = document.querySelector('[data-cctv-detail]');
            const back = document.querySelector('[data-cctv-back]');
            const video = document.querySelector('[data-cctv-video]');
            const open = document.querySelector('[data-cctv-open]');
            const meta = document.querySelector('[data-cctv-meta]');
            const rows = Array.from(document.querySelectorAll('[data-cctv-row]'));
            const search = document.querySelector('[data-cctv-search]');

            const placeholder = (title, subtitle) => `
                <div class="gc-video-placeholder">
                    <div>
                        <strong>${title}</strong>
                        <span>${subtitle}</span>
                    </div>
                </div>
            `;

            rows.forEach((row) => {
                row.addEventListener('click', () => {
                    const name = row.dataset.name || 'CCTV';
                    const status = row.dataset.status || 'Offline';
                    const embed = row.dataset.embed || '';
                    const stream = row.dataset.stream || '';

                    listScreen.classList.add('is-hidden');
                    detail.classList.add('is-visible');
                    meta.textContent = `${status} • ${name}`;

                    if (embed) {
                        video.innerHTML = `<iframe src="${embed}" title="${name}" allowfullscreen loading="lazy"></iframe>`;
                    } else if (stream && /\.(mp4|webm|ogg)(\?.*)?$/i.test(stream)) {
                        video.innerHTML = `<video src="${stream}" controls autoplay muted playsinline></video>`;
                    } else {
                        video.innerHTML = placeholder(name, stream ? 'Gunakan tombol di bawah untuk membuka stream' : 'Stream belum tersedia');
                    }

                    if (stream) {
                        open.href = stream;
                        open.classList.remove('hidden');
                    } else {
                        open.classList.add('hidden');
                    }
                });
            });

            back?.addEventListener('click', () => {
                detail.classList.remove('is-visible');
                listScreen.classList.remove('is-hidden');
                video.innerHTML = placeholder('Pilih CCTV', 'Stream akan tampil di sini');
                open.classList.add('hidden');
                meta.textContent = '';
            });

            search?.addEventListener('input', () => {
                const query = search.value.trim().toLowerCase();
                rows.forEach((row) => {
                    const name = (row.dataset.name || '').toLowerCase();
                    const status = (row.dataset.status || '').toLowerCase();
                    row.style.display = name.includes(query) || status.includes(query) ? 'flex' : 'none';
                });
            });
        })();
    </script>
</x-pwa-layout>
