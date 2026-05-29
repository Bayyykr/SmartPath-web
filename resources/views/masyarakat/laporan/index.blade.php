<x-pwa-layout title="Laporan">
    <main class="min-h-screen px-6 pb-28 pt-7">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold">Laporan Anda</h1>
                <p class="text-sm text-slate-500">Daftar laporan Anda. <a href="{{ route('masyarakat.laporan.create') }}" class="font-bold text-[#3159d4]">Buat di sini</a></p>
            </div>
            <a href="{{ route('masyarakat.laporan.create') }}" class="grid h-11 w-11 place-items-center rounded-2xl bg-[#3159d4] text-white">＋</a>
        </div>

        @if (session('status'))
            <div class="mt-5 rounded-2xl bg-green-50 p-4 text-sm font-semibold text-green-700">{{ session('status') }}</div>
        @endif

        <div class="mt-6 space-y-4">
            @forelse ($laporans as $laporan)
                <article class="flex items-center gap-4 rounded-[1.5rem] bg-white p-3 shadow-sm ring-1 ring-slate-100">
                    <div class="h-16 w-16 overflow-hidden rounded-2xl bg-slate-100">
                        @if ($laporan->foto_kejadian)
                            <img src="{{ asset('storage/'.$laporan->foto_kejadian) }}" class="h-full w-full object-cover" alt="{{ $laporan->judul_laporan }}">
                        @else
                            <div class="grid h-full w-full place-items-center text-3xl">🚨</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-bold">{{ $laporan->judul_laporan }}</p>
                        <p class="text-xs text-slate-500">{{ $laporan->created_at->format('d-m-Y H:i') }}</p>
                        <span class="mt-2 inline-flex rounded-full px-2 py-1 text-[10px] font-bold {{ $laporan->status === 'ditolak' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-[#3159d4]' }}">{{ str_replace('_', ' ', $laporan->status) }}</span>
                    </div>
                    <span class="text-slate-400">›</span>
                </article>
            @empty
                <div class="grid h-80 place-items-center text-center">
                    <div>
                        <div class="text-8xl">📝</div>
                        <p class="mt-5 font-bold text-slate-500">Tidak Ada Data</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>
    @include('masyarakat.components')
</x-pwa-layout>
