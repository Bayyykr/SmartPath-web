<x-pwa-layout title="SOS">
    <style>
        .hidden { display: none !important; }
        .gc-sos-page, .gc-sos-page * { box-sizing: border-box; }
        .gc-sos-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 38px 28px 96px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-screen { display: block; }
        .gc-screen.is-hidden { display: none; }
        .gc-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
        .gc-title { margin: 0; color: #2b2b2f; font-size: 17px; font-weight: 800; line-height: 1; letter-spacing: -.035em; }
        .gc-subtitle { margin: 8px 0 0; color: #6b7280; font-size: 11px; line-height: 1.4; }
        .gc-actions { display: flex; align-items: center; gap: 9px; }
        .gc-icon-btn { display: grid; width: 25px; height: 25px; place-items: center; border: 0; border-radius: 999px; background: #f3f4f6; color: #6b7280; cursor: pointer; }
        .gc-icon-btn.is-danger { color: #c95b5f; }
        .gc-icon-btn svg { width: 14px; height: 14px; }
        .gc-alert { margin-top: 18px; border-radius: 4px; background: #ecfdf5; padding: 10px 12px; color: #047857; font-size: 11px; font-weight: 700; }
        .gc-sos-form { margin-top: 88px; text-align: center; }
        .gc-sos-button { display: grid; width: 166px; height: 166px; margin: 0 auto; place-items: center; border: 0; border-radius: 999px; background: #f4c8cb; padding: 13px; cursor: pointer; box-shadow: 0 14px 30px rgba(201, 91, 95, .18); }
        .gc-sos-button:disabled { cursor: not-allowed; opacity: .72; }
        .gc-sos-inner { display: grid; width: 126px; height: 126px; place-items: center; border-radius: 999px; background: #c95b5f; color: #fff; font-size: 25px; font-weight: 800; letter-spacing: -.02em; }
        .gc-sos-help { max-width: 210px; margin: 34px auto 0; color: #6b7280; font-size: 10.5px; line-height: 1.5; }
        .gc-error { margin: 12px 0 0; color: #dc2626; font-size: 10px; }
        .gc-latest { margin-top: 48px; border-radius: 8px; background: #f8fafc; padding: 14px; color: #334155; font-size: 10px; }
        .gc-latest-title { margin: 0 0 10px; font-weight: 800; }
        .gc-latest-row { display: flex; justify-content: space-between; gap: 12px; padding: 4px 0; }
        .gc-back { display: inline-flex; align-items: center; gap: 8px; border: 0; background: transparent; padding: 0; color: #4b5563; font-size: 11px; font-weight: 800; text-decoration: none; cursor: pointer; }
        .gc-back svg { width: 14px; height: 14px; }
        .gc-settings-title { margin: 24px 0 0; color: #2b2b2f; font-size: 21px; font-weight: 800; line-height: 1; letter-spacing: -.04em; }
        .gc-settings-subtitle { margin: 8px 0 0; color: #6b7280; font-size: 11px; line-height: 1.45; }
        .gc-contact { margin-top: 24px; }
        .gc-contact-title { margin: 0 0 12px; color: #4b5563; font-size: 10.5px; font-weight: 800; }
        .gc-polsek-row { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 8px 0; }
        .gc-polsek-left { display: flex; min-width: 0; align-items: center; gap: 10px; }
        .gc-dot { width: 7px; height: 7px; flex: none; border-radius: 999px; background: #253aa8; }
        .gc-polsek-name { margin: 0; color: #111827; font-size: 10px; font-weight: 800; line-height: 1.15; }
        .gc-polsek-phone { margin: 3px 0 0; color: #6b7280; font-size: 9px; line-height: 1.15; }
        .gc-polsek-tools { display: flex; flex: none; align-items: center; gap: 13px; color: #4b5563; }
        .gc-polsek-tools svg { width: 13px; height: 13px; }
        .gc-add { display: inline-block; margin: 8px 0 0 118px; color: #4b5563; font-size: 10px; font-weight: 700; text-decoration: none; }
        .gc-message { margin-top: 23px; }
        .gc-label { display: block; margin-bottom: 9px; color: #4b5563; font-size: 10.5px; font-weight: 800; }
        .gc-textarea { display: block; width: 100%; min-height: 128px; border: 1px solid #dedfe3; border-radius: 4px; background: #f8f8f9; padding: 12px; color: #111827; font-size: 11px; line-height: 1.45; resize: vertical; outline: none; }
        .gc-textarea:focus { border-color: #a8adb7; background: #fff; box-shadow: 0 0 0 3px rgba(37, 58, 168, .08); }
        .gc-map { position: relative; height: 330px; margin-top: 25px; overflow: hidden; border: 1px solid #e5e7eb; background: #edf3f7; }
        .gc-map::before {
            content: "";
            position: absolute;
            inset: -24px;
            background:
                linear-gradient(30deg, transparent 48%, rgba(58, 130, 189, .18) 49%, rgba(58, 130, 189, .18) 51%, transparent 52%),
                linear-gradient(120deg, transparent 48%, rgba(58, 130, 189, .13) 49%, rgba(58, 130, 189, .13) 51%, transparent 52%),
                linear-gradient(0deg, transparent 48%, rgba(148, 163, 184, .30) 49%, rgba(148, 163, 184, .30) 50%, transparent 51%),
                linear-gradient(90deg, transparent 48%, rgba(148, 163, 184, .24) 49%, rgba(148, 163, 184, .24) 50%, transparent 51%);
            background-size: 165px 120px, 150px 150px, 58px 58px, 64px 64px;
            transform: rotate(-7deg) scale(1.08);
        }
        .gc-road { position: absolute; border-radius: 999px; background: rgba(255, 255, 255, .88); box-shadow: 0 0 0 1px rgba(203, 213, 225, .75); }
        .gc-road.one { width: 360px; height: 15px; left: -32px; top: 114px; transform: rotate(-18deg); }
        .gc-road.two { width: 330px; height: 13px; left: -24px; top: 226px; transform: rotate(15deg); }
        .gc-road.three { width: 13px; height: 330px; left: 170px; top: -28px; transform: rotate(16deg); }
        .gc-radius { position: absolute; left: 50%; top: 50%; width: 178px; height: 178px; border-radius: 999px; background: rgba(37, 99, 235, .20); border: 1px solid rgba(37, 99, 235, .28); transform: translate(-50%, -50%); }
        .gc-user-pin { position: absolute; left: 50%; top: 50%; display: grid; width: 29px; height: 29px; place-items: center; border-radius: 999px; background: #253aa8; color: #fff; transform: translate(-50%, -50%); box-shadow: 0 8px 16px rgba(37,58,168,.25); }
        .gc-user-pin svg { width: 16px; height: 16px; }
        .gc-red-pin { position: absolute; width: 12px; height: 12px; border-radius: 999px; background: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, .14); }
        .gc-red-pin.one { left: 79px; top: 94px; }
        .gc-red-pin.two { right: 76px; top: 119px; }
        .gc-red-pin.three { left: 112px; bottom: 89px; }
        .gc-map-badge { position: absolute; display: grid; width: 29px; height: 29px; place-items: center; border-radius: 999px; background: #d25b61; color: #fff; font-size: 12px; font-weight: 800; }
        .gc-map-badge.top { left: 132px; top: 38px; }
        .gc-map-badge.bottom { right: 72px; bottom: 62px; }
        .gc-map-label { position: absolute; left: 50%; top: calc(50% + 24px); color: #111827; font-size: 10px; font-weight: 800; transform: translateX(-50%); white-space: nowrap; }
        .gc-save { display: block; width: 100%; height: 40px; margin-top: 28px; border: 0; border-radius: 4px; background: #242424; color: #fff; font-size: 10.5px; font-weight: 800; letter-spacing: .02em; cursor: pointer; box-shadow: 0 6px 12px rgba(15, 23, 42, .08); }
        @media (max-width: 380px) { .gc-sos-page { padding-right: 22px; padding-left: 22px; } .gc-sos-form { margin-top: 70px; } .gc-map { height: 300px; } }
    </style>

    <main class="gc-sos-page" data-sos-page>
        <section class="gc-screen" data-sos-main>
            <header class="gc-head">
                <div>
                    <h1 class="gc-title">SoS Button</h1>
                    <p class="gc-subtitle">Kirimkan sinyal darurat</p>
                </div>
                <div class="gc-actions">
                    <button type="button" class="gc-icon-btn is-danger" aria-label="Status SOS">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 3 20h18L12 3Z" stroke="currentColor" stroke-width="2"/><path d="M12 9v5M12 17h.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                    </button>
                    <button type="button" class="gc-icon-btn" data-open-settings aria-label="Pengaturan SOS">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" stroke="currentColor" stroke-width="2"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 1.55V21a2 2 0 0 1-4 0v-.09A1.7 1.7 0 0 0 9 19.4a1.7 1.7 0 0 0-1.88.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.55-1H3a2 2 0 0 1 0-4h.09A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.88l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-1.55V3a2 2 0 0 1 4 0v.09A1.7 1.7 0 0 0 15 4.6a1.7 1.7 0 0 0 1.88-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9c.23.61.8 1 1.55 1H21a2 2 0 0 1 0 4h-.09A1.7 1.7 0 0 0 19.4 15Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </header>

            @if (session('status'))
                <div class="gc-alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('masyarakat.sos.store') }}" class="gc-sos-form" data-sos-form>
                @csrf
                <input type="hidden" name="latitude" data-sos-latitude value="">
                <input type="hidden" name="longitude" data-sos-longitude value="">
                <input type="hidden" name="alamat_terdeteksi" data-sos-address value="">
                <input type="hidden" name="catatan" data-sos-note value="Tolong saya segera datang, saya dalam kondisi darurat.">

                <button type="submit" class="gc-sos-button" data-sos-submit disabled>
                    <span class="gc-sos-inner">SoS</span>
                </button>
                <p class="gc-sos-help" data-sos-message>Tekan tombol darurat dan bantuan akan segera datang</p>
                @error('latitude')<p class="gc-error">Aktifkan lokasi terlebih dahulu.</p>@enderror
            </form>

            @if ($latestEmergency)
                <section class="gc-latest">
                    <p class="gc-latest-title">Status SOS Terakhir</p>
                    <div class="gc-latest-row"><span>Kode</span><strong>{{ $latestEmergency->kode_darurat }}</strong></div>
                    <div class="gc-latest-row"><span>Status</span><strong>{{ str_replace('_', ' ', $latestEmergency->status) }}</strong></div>
                    <div class="gc-latest-row"><span>Polsek</span><strong>{{ $latestEmergency->nearestPolsek?->nama ?? '-' }}</strong></div>
                </section>
            @endif
        </section>

        <section class="gc-screen is-hidden" data-sos-settings>
            <button type="button" class="gc-back" data-close-settings>
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
                Kembali
            </button>

            <h1 class="gc-settings-title">Pengaturan</h1>
            <p class="gc-settings-subtitle">Atur kontak darurat sesuai personalisasi Anda</p>

            <section class="gc-contact">
                <p class="gc-contact-title">Polsek</p>
                @forelse ($polseks->take(2) as $polsek)
                    <div class="gc-polsek-row">
                        <div class="gc-polsek-left">
                            <span class="gc-dot"></span>
                            <div>
                                <p class="gc-polsek-name">{{ $polsek->nama }}</p>
                                <p class="gc-polsek-phone">{{ $polsek->telepon ?: '+628xxxx' }}</p>
                            </div>
                        </div>
                        <div class="gc-polsek-tools" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M17 3a2.8 2.8 0 0 1 4 4L8 20l-5 1 1-5L17 3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            <svg viewBox="0 0 24 24" fill="none"><path d="M6 7h12M10 11v6M14 11v6M9 7l1-3h4l1 3M7 7l1 14h8l1-14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                @empty
                    <div class="gc-polsek-row">
                        <div class="gc-polsek-left"><span class="gc-dot"></span><div><p class="gc-polsek-name">Polsek Terdekat</p><p class="gc-polsek-phone">+628xxxx</p></div></div>
                    </div>
                @endforelse
                <a href="#" class="gc-add">Tambah +</a>
            </section>

            <section class="gc-message">
                <label for="sos-custom-message" class="gc-label">Ubah pesan</label>
                <textarea id="sos-custom-message" class="gc-textarea" data-custom-note>Help me pleaseeeeeeee!</textarea>
            </section>

            <div class="gc-map" aria-label="Peta radius lokasi SOS">
                <div class="gc-road one"></div>
                <div class="gc-road two"></div>
                <div class="gc-road three"></div>
                <div class="gc-radius"></div>
                <span class="gc-red-pin one"></span>
                <span class="gc-red-pin two"></span>
                <span class="gc-red-pin three"></span>
                <span class="gc-map-badge top">2</span>
                <span class="gc-map-badge bottom">5</span>
                <span class="gc-user-pin"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></svg></span>
                <span class="gc-map-label">Lokasi Anda</span>
            </div>

            <button type="button" class="gc-save" data-save-settings>SIMPAN</button>
        </section>
    </main>

    @include('masyarakat.components')

    <script>
        (() => {
            const main = document.querySelector('[data-sos-main]');
            const settings = document.querySelector('[data-sos-settings]');
            const openSettings = document.querySelector('[data-open-settings]');
            const closeSettings = document.querySelector('[data-close-settings]');
            const saveSettings = document.querySelector('[data-save-settings]');
            const customNote = document.querySelector('[data-custom-note]');
            const noteInput = document.querySelector('[data-sos-note]');
            const latitude = document.querySelector('[data-sos-latitude]');
            const longitude = document.querySelector('[data-sos-longitude]');
            const address = document.querySelector('[data-sos-address]');
            const message = document.querySelector('[data-sos-message]');
            const submit = document.querySelector('[data-sos-submit]');

            const showSettings = () => {
                main?.classList.add('is-hidden');
                settings?.classList.remove('is-hidden');
            };

            const showMain = () => {
                settings?.classList.add('is-hidden');
                main?.classList.remove('is-hidden');
            };

            openSettings?.addEventListener('click', showSettings);
            closeSettings?.addEventListener('click', showMain);
            saveSettings?.addEventListener('click', () => {
                if (noteInput && customNote) noteInput.value = customNote.value;
                showMain();
            });

            if (customNote && noteInput) {
                customNote.addEventListener('input', () => noteInput.value = customNote.value);
                noteInput.value = customNote.value;
            }

            if (!navigator.geolocation) {
                if (message) message.textContent = 'GPS tidak didukung browser ini.';
                return;
            }

            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude.toFixed(7);
                const lng = position.coords.longitude.toFixed(7);
                if (latitude) latitude.value = lat;
                if (longitude) longitude.value = lng;
                if (address) address.value = `Lat ${lat}, Lng ${lng}`;
                if (submit) submit.disabled = false;
                if (message) message.textContent = 'Tekan tombol darurat dan bantuan akan segera datang';
            }, () => {
                if (message) message.textContent = 'Izinkan akses lokasi agar tombol SOS dapat dikirim.';
                if (submit) submit.disabled = true;
            }, { enableHighAccuracy: true, timeout: 10000 });
        })();
    </script>
</x-pwa-layout>
