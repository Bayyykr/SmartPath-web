<x-pwa-layout title="Detail Berita">
    <main class="min-h-screen px-6 pb-10 pt-7">
        <a href="{{ route('masyarakat.berita.index') }}" class="text-sm font-bold text-slate-500">‹ Kembali</a>
        <div class="mt-5 h-52 overflow-hidden rounded-[1.5rem] bg-gradient-to-br from-blue-100 to-orange-100">
            @if ($berita->foto)
                <img src="{{ asset('storage/'.$berita->foto) }}" class="h-full w-full object-cover" alt="{{ $berita->judul }}">
            @else
                <div class="grid h-full place-items-center text-7xl">📰</div>
            @endif
        </div>
        <h1 class="mt-5 text-2xl font-extrabold leading-tight">{{ $berita->judul }}</h1>
        <p class="mt-2 text-xs text-slate-500">Dibuat {{ optional($berita->published_at ?? $berita->created_at)->format('d M Y, H:i') }}</p>
        <article class="prose prose-sm mt-5 max-w-none leading-7 text-slate-600">{!! nl2br(e($berita->isi_berita)) !!}</article>
    </main>
</x-pwa-layout>
