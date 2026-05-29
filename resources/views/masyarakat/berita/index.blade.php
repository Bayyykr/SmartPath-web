<x-pwa-layout title="Berita">
    <main class="min-h-screen px-6 pb-28 pt-7">
        <h1 class="text-2xl font-extrabold">Berita</h1>
        <p class="text-sm text-slate-500">Dapatkan berita terkini</p>
        <div class="mt-5 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-400">🔎 Search here</div>

        <div class="mt-5 space-y-5">
            @forelse ($beritas as $berita)
                <a href="{{ route('masyarakat.berita.show', $berita) }}" class="block overflow-hidden rounded-[1.5rem] bg-white shadow-sm ring-1 ring-slate-100">
                    <div class="h-36 bg-gradient-to-br from-blue-100 to-orange-100">
                        @if ($berita->foto)
                            <img src="{{ asset('storage/'.$berita->foto) }}" class="h-full w-full object-cover" alt="{{ $berita->judul }}">
                        @else
                            <div class="grid h-full place-items-center text-6xl">📰</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="font-extrabold">{{ $berita->judul }}</h2>
                        <p class="mt-1 text-xs text-slate-500">{{ optional($berita->published_at ?? $berita->created_at)->format('d M Y, H:i') }}</p>
                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ Str::limit(strip_tags($berita->isi_berita), 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="grid h-72 place-items-center text-center"><div><div class="text-7xl">🗞️</div><p class="mt-4 font-bold text-slate-500">Belum ada berita</p></div></div>
            @endforelse
        </div>
    </main>
    @include('masyarakat.components')
</x-pwa-layout>
