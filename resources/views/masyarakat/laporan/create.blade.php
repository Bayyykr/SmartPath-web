<x-pwa-layout title="Buat Laporan">
    <main class="min-h-screen px-6 pb-10 pt-7">
        <a href="{{ route('masyarakat.laporan.index') }}" class="text-sm font-bold text-slate-500">‹ Back</a>
        <h1 class="mt-4 text-2xl font-extrabold">Membuat Laporan</h1>
        <p class="text-sm text-slate-500">Pastikan laporan Anda sesuai valid dengan bukti-bukti.</p>

        <form method="POST" action="{{ route('masyarakat.laporan.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4" x-data="geoForm()" x-init="detect()">
            @csrf
            <div>
                <label class="text-sm font-bold">Judul<span class="text-red-500">*</span></label>
                <input name="judul_laporan" value="{{ old('judul_laporan') }}" required class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" />
                @error('judul_laporan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-bold">Kronologi<span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="5" required class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-bold">Kategori<span class="text-red-500">*</span></label>
                <select name="kategori_id" required class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50">
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('kategori_id') == $category->id)>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-bold">Lokasi area</label>
                <select name="lokasi_id" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50">
                    <option value="">Deteksi dari GPS</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('lokasi_id') == $location->id)>{{ $location->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-bold">Foto bukti</label>
                <input type="file" name="foto_kejadian" accept="image/*" class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm" />
            </div>
            <input type="hidden" name="latitude" x-model="latitude">
            <input type="hidden" name="longitude" x-model="longitude">
            <p class="rounded-2xl bg-blue-50 p-3 text-xs text-blue-700" x-text="message"></p>
            <button class="w-full rounded-xl bg-slate-900 py-3.5 text-sm font-extrabold text-white">KIRIM</button>
        </form>
    </main>

    <script>
        function geoForm() {
            return {
                latitude: "{{ old('latitude') }}",
                longitude: "{{ old('longitude') }}",
                message: 'Mengambil lokasi perangkat...',
                detect() {
                    if (!navigator.geolocation) {
                        this.message = 'Browser tidak mendukung GPS. Laporan tetap bisa dikirim.';
                        return;
                    }
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.latitude = position.coords.latitude;
                        this.longitude = position.coords.longitude;
                        this.message = 'Lokasi berhasil dideteksi.';
                    }, () => {
                        this.message = 'Lokasi belum diizinkan. Aktifkan izin lokasi untuk akurasi laporan.';
                    }, { enableHighAccuracy: true, timeout: 10000 });
                }
            }
        }
    </script>
</x-pwa-layout>
