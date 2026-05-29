<x-pwa-layout title="Home">
    <main class="min-h-screen pb-28">
        <section class="px-6 pt-7">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 overflow-hidden rounded-full bg-blue-100 text-2xl">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" class="h-full w-full object-cover" alt="Profil">
                        @else
                            <span class="grid h-full w-full place-items-center">👤</span>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold">Hello, {{ Str::of(Auth::user()->name)->before(' ') }}!</h1>
                        <p class="text-xs text-slate-500">Pantau kondisi lingkungan Anda, tetap aman.</p>
                    </div>
                </div>
                <span class="grid h-10 w-10 place-items-center rounded-2xl bg-slate-50">🔔</span>
            </div>

            <div class="mt-7 flex items-center justify-between">
                <h2 class="font-bold">Daerah Rawan</h2>
                <a href="#peta" class="text-xs font-bold text-[#3159d4]">Lihat peta</a>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-4">
                @forelse ($categories->take(2) as $category)
                    <div class="rounded-[1.6rem] bg-slate-50 p-4">
                        <p class="font-bold">{{ $category->nama_kategori }}</p>
                        <div class="mt-4 grid h-24 place-items-center rounded-2xl bg-blue-50 text-5xl">{{ $category->jenis === 'kecelakaan' ? '🚧' : '🚨' }}</div>
                    </div>
                @empty
                    <div class="col-span-2 rounded-3xl bg-slate-50 p-5 text-sm text-slate-500">Belum ada kategori. Tambahkan kategori melalui admin.</div>
                @endforelse
            </div>

            <div class="mt-7 flex items-center justify-between">
                <h2 class="font-bold">Lokasi CCTV</h2>
                <a href="{{ route('masyarakat.cctv') }}" class="text-xs font-bold text-[#3159d4]">Lihat Semua</a>
            </div>
            <div class="mt-3 space-y-3">
                @forelse ($cctvs->take(4) as $cctv)
                    <a href="{{ route('masyarakat.cctv') }}" class="flex items-center justify-between rounded-2xl bg-white p-3 shadow-sm ring-1 ring-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full {{ $cctv->aktif ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <div>
                                <p class="text-sm font-bold">{{ $cctv->aktif ? 'Online' : 'Offline' }}</p>
                                <p class="text-xs text-slate-500">{{ $cctv->nama }}</p>
                            </div>
                        </div>
                        <span class="text-slate-400">›</span>
                    </a>
                @empty
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">Belum ada CCTV terdaftar.</div>
                @endforelse
            </div>
        </section>

        <section id="peta" class="mt-7 px-6">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="font-bold">Street Maps</h2>
                <span class="text-xs text-slate-400">GIS interaktif</span>
            </div>
            <div id="public-map" class="h-80 overflow-hidden rounded-[1.6rem] bg-slate-100"></div>
            <script type="application/json" id="public-map-data">@json($mapPoints)</script>
        </section>
    </main>

    @include('masyarakat.components')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapElement = document.getElementById('public-map');
            if (!mapElement || !window.L) return;

            const points = JSON.parse(document.getElementById('public-map-data')?.textContent || '[]');
            const map = L.map('public-map').setView([-8.1322, 113.2245], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);

            const layers = [];
            points.forEach((point) => {
                if (!point.lat || !point.lng) return;
                const marker = L.circleMarker([point.lat, point.lng], {
                    radius: 8,
                    color: point.color || '#3159d4',
                    fillColor: point.color || '#3159d4',
                    fillOpacity: .75,
                    weight: 2,
                }).addTo(map).bindPopup(`<strong>${point.title}</strong><br><small>${point.category} • ${point.status}</small>`);
                layers.push(marker);
            });

            if (layers.length) map.fitBounds(L.featureGroup(layers).getBounds(), { padding: [24, 24], maxZoom: 14 });
        });
    </script>
</x-pwa-layout>
