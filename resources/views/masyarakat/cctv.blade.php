<x-pwa-layout title="CCTV">
    <main class="min-h-screen px-6 pb-28 pt-7">
        <a href="{{ route('masyarakat.home') }}" class="text-sm font-bold text-slate-500">‹ Kembali</a>
        <h1 class="mt-4 text-2xl font-extrabold">Semua CCTV</h1>
        <p class="text-sm text-slate-500">Lihat CCTV Kota Jember</p>

        <label class="mt-5 block rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-400">🔎 Search here</label>

        <div class="mt-5 space-y-3">
            @forelse ($cctvs as $cctv)
                <article class="rounded-[1.5rem] bg-white p-4 shadow-sm ring-1 ring-slate-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-full {{ $cctv->aktif ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <div>
                                <p class="font-bold">{{ $cctv->aktif ? 'Online' : 'Offline' }}</p>
                                <p class="text-xs text-slate-500">{{ $cctv->nama }}</p>
                            </div>
                        </div>
                        <span class="text-slate-400">›</span>
                    </div>
                    @if ($cctv->embed_url)
                        <iframe class="mt-4 aspect-video w-full rounded-2xl bg-slate-100" src="{{ $cctv->embed_url }}" title="{{ $cctv->nama }}" allowfullscreen></iframe>
                    @elseif ($cctv->url_stream)
                        <a href="{{ $cctv->url_stream }}" target="_blank" class="mt-4 block rounded-2xl bg-slate-900 px-4 py-3 text-center text-sm font-bold text-white">Buka Stream</a>
                    @endif
                </article>
            @empty
                <div class="grid h-72 place-items-center text-center">
                    <div>
                        <div class="text-7xl">📹</div>
                        <p class="mt-4 font-bold">Tidak Ada Data</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>
    @include('masyarakat.components')
</x-pwa-layout>
