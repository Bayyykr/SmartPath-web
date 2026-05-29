<x-pwa-layout title="SOS">
    <main class="min-h-screen px-6 pb-28 pt-7" x-data="sosPage()" x-init="detect()">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-extrabold">SoS Button</h1>
                <p class="text-sm text-slate-500">Kirimkan sinyal darurat</p>
            </div>
            <div class="flex gap-2 text-xl"><span>🚨</span><span>⚙️</span></div>
        </div>

        @if (session('status'))
            <div class="mt-6 rounded-2xl bg-green-50 p-4 text-sm font-semibold text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('masyarakat.sos.store') }}" class="mt-16 text-center">
            @csrf
            <input type="hidden" name="latitude" x-model="latitude">
            <input type="hidden" name="longitude" x-model="longitude">
            <input type="hidden" name="alamat_terdeteksi" x-model="address">
            <button type="submit" class="mx-auto grid h-44 w-44 place-items-center rounded-full bg-red-100 p-4" :disabled="!latitude || !longitude">
                <span class="grid h-32 w-32 place-items-center rounded-full bg-[#c95b5f] text-3xl font-extrabold text-white shadow-lg shadow-red-200">SOS</span>
            </button>
            <p class="mx-auto mt-8 max-w-[210px] text-sm leading-6 text-slate-500" x-text="message"></p>
            @error('latitude')<p class="mt-3 text-sm text-red-600">Aktifkan lokasi terlebih dahulu.</p>@enderror
        </form>

        @if ($latestEmergency)
            <section class="mt-10 rounded-[1.7rem] bg-slate-50 p-5">
                <p class="text-sm font-bold">Pengaturan / Status Terakhir</p>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between"><span class="text-slate-500">Kode</span><strong>{{ $latestEmergency->kode_darurat }}</strong></div>
                    <div class="flex items-center justify-between"><span class="text-slate-500">Status</span><strong>{{ str_replace('_', ' ', $latestEmergency->status) }}</strong></div>
                    <div class="flex items-center justify-between"><span class="text-slate-500">Polsek</span><strong>{{ $latestEmergency->nearestPolsek?->nama ?? '-' }}</strong></div>
                </div>
            </section>
        @endif

        <section class="mt-6 rounded-[1.7rem] bg-blue-50 p-5 text-sm text-blue-800">
            <p class="font-bold">Lokasi Anda</p>
            <p class="mt-2" x-text="latitude && longitude ? `${latitude}, ${longitude}` : 'Menunggu izin lokasi...' "></p>
        </section>
    </main>
    @include('masyarakat.components')

    <script>
        function sosPage() {
            return {
                latitude: '', longitude: '', address: '', message: 'Tekan tombol darurat dan bantuan akan segera datang',
                detect() {
                    if (!navigator.geolocation) {
                        this.message = 'GPS tidak didukung browser ini.';
                        return;
                    }
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.latitude = position.coords.latitude.toFixed(7);
                        this.longitude = position.coords.longitude.toFixed(7);
                        this.address = `Lat ${this.latitude}, Lng ${this.longitude}`;
                    }, () => {
                        this.message = 'Izinkan akses lokasi agar tombol SOS dapat dikirim.';
                    }, { enableHighAccuracy: true, timeout: 10000 });
                }
            }
        }
    </script>
</x-pwa-layout>
