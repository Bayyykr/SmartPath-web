<x-pwa-layout title="Buat Laporan">
    <style>
        .hidden { display: none !important; }
        .gc-form-page, .gc-form-page * { box-sizing: border-box; }
        .gc-form-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 28px 32px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-back { display: inline-flex; align-items: center; gap: 8px; color: #4b5563; font-size: 11px; font-weight: 800; text-decoration: none; }
        .gc-back svg { width: 14px; height: 14px; }
        .gc-title { margin: 20px 0 0; color: #2b2b2f; font-size: 21px; font-weight: 800; line-height: 1; letter-spacing: -.04em; }
        .gc-subtitle { max-width: 295px; margin: 8px 0 0; color: #6b7280; font-size: 11px; line-height: 1.45; }
        .gc-form { margin-top: 24px; }
        .gc-field { margin-bottom: 18px; }
        .gc-label { display: block; margin-bottom: 8px; color: #4b5563; font-size: 10.5px; font-weight: 800; letter-spacing: -.01em; }
        .gc-required { color: #ef4444; }
        .gc-control-wrap { position: relative; }
        .gc-input, .gc-select, .gc-textarea {
            display: block;
            width: 100%;
            border: 1px solid #dedfe3;
            border-radius: 4px;
            background: #f4f4f5;
            color: #111827;
            font-size: 12px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .gc-input, .gc-select { height: 39px; padding: 0 12px; }
        .gc-select { appearance: none; padding-right: 34px; color: #4b5563; }
        .gc-textarea { min-height: 96px; resize: vertical; padding: 11px 12px; line-height: 1.45; }
        .gc-input:focus, .gc-select:focus, .gc-textarea:focus { border-color: #a8adb7; background: #fff; box-shadow: 0 0 0 3px rgba(37, 58, 168, .08); }
        .gc-field-icon { position: absolute; right: 12px; top: 50%; width: 14px; height: 14px; color: #9ca3af; pointer-events: none; transform: translateY(-50%); }
        .gc-error { margin: 6px 0 0; color: #dc2626; font-size: 10px; line-height: 1.35; }
        .gc-location { margin: -4px 0 16px; color: #64748b; font-size: 10px; line-height: 1.4; }
        .gc-file-field { margin-top: -2px; }
        .gc-file-input { display: block; width: 100%; color: #64748b; font-size: 10px; }
        .gc-submit { display: block; width: 100%; height: 40px; margin-top: 24px; border: 0; border-radius: 4px; background: #242424; color: #fff; font-size: 10.5px; font-weight: 800; letter-spacing: .02em; cursor: pointer; box-shadow: 0 6px 12px rgba(15, 23, 42, .08); }
        @media (max-width: 380px) { .gc-form-page { padding-right: 22px; padding-left: 22px; } }
    </style>

    <main class="gc-form-page">
        <a href="{{ route('masyarakat.laporan.index') }}" class="gc-back">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Back
        </a>

        <h1 class="gc-title">Membuat Laporan</h1>
        <p class="gc-subtitle">Pastikan laporan anda sesuai valid dengan bukti-bukti</p>

        <form method="POST" action="{{ route('masyarakat.laporan.store') }}" enctype="multipart/form-data" class="gc-form" data-report-form>
            @csrf

            <div class="gc-field">
                <label for="judul_laporan" class="gc-label">Judul<span class="gc-required">*</span></label>
                <input id="judul_laporan" name="judul_laporan" value="{{ old('judul_laporan') }}" required class="gc-input" />
                @error('judul_laporan')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="deskripsi" class="gc-label">Kronologi<span class="gc-required">*</span></label>
                <textarea id="deskripsi" name="deskripsi" required class="gc-textarea">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="tanggal_waktu" class="gc-label">Tanggal &amp; Waktu<span class="gc-required">*</span></label>
                <div class="gc-control-wrap">
                    <input id="tanggal_waktu" type="datetime-local" value="{{ old('tanggal_waktu', now()->format('Y-m-d\TH:i')) }}" class="gc-input" />
                    <svg class="gc-field-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3v3M17 3v3M4 9h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
            </div>

            <div class="gc-field">
                <label for="kategori_id" class="gc-label">Kategori<span class="gc-required">*</span></label>
                <div class="gc-control-wrap">
                    <select id="kategori_id" name="kategori_id" required class="gc-select">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('kategori_id') == $category->id)>{{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <svg class="gc-field-icon" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                @error('kategori_id')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="lokasi_id" class="gc-label">Lokasi Area</label>
                <div class="gc-control-wrap">
                    <select id="lokasi_id" name="lokasi_id" class="gc-select">
                        <option value="">Deteksi dari GPS</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" @selected(old('lokasi_id') == $location->id)>{{ $location->nama_lokasi }}</option>
                        @endforeach
                    </select>
                    <svg class="gc-field-icon" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="gc-field gc-file-field">
                <label for="foto_kejadian" class="gc-label">Foto Bukti</label>
                <input id="foto_kejadian" type="file" name="foto_kejadian" accept="image/*" class="gc-file-input" />
                @error('foto_kejadian')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <input type="hidden" name="latitude" value="{{ old('latitude') }}" data-latitude>
            <input type="hidden" name="longitude" value="{{ old('longitude') }}" data-longitude>
            <p class="gc-location" data-location-message>Mengambil lokasi perangkat...</p>

            <button class="gc-submit" type="submit">KIRIM</button>
        </form>
    </main>

    <script>
        (() => {
            const latitude = document.querySelector('[data-latitude]');
            const longitude = document.querySelector('[data-longitude]');
            const message = document.querySelector('[data-location-message]');

            if (!navigator.geolocation) {
                if (message) message.textContent = 'Browser tidak mendukung GPS. Laporan tetap bisa dikirim.';
                return;
            }

            navigator.geolocation.getCurrentPosition((position) => {
                if (latitude) latitude.value = position.coords.latitude;
                if (longitude) longitude.value = position.coords.longitude;
                if (message) message.textContent = 'Lokasi berhasil dideteksi.';
            }, () => {
                if (message) message.textContent = 'Lokasi belum diizinkan. Aktifkan izin lokasi untuk akurasi laporan.';
            }, { enableHighAccuracy: true, timeout: 10000 });
        })();
    </script>
</x-pwa-layout>
