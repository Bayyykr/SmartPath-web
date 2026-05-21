<x-admin-layout>
    <x-slot name="header">CCTV Real-time Lumajang</x-slot>

    <div class="cctv-page">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">{{ session('success') }}</div>
        @endif

        <div class="cctv-topbar">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Master Data</p>
                <h1 class="mt-1 text-xl font-bold text-gray-950">Daftar CCTV Real-time Kabupaten Lumajang</h1>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-2">
                <form class="cctv-search" method="GET">
                    <input name="search" value="{{ request('search') }}" placeholder="Search">
                    <button type="submit" aria-label="Cari CCTV">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                        </svg>
                    </button>
                </form>
                <a class="cctv-action-btn" href="{{ route('admin.cctvs.index') }}">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 0 1 1-1h12a1 1 0 0 1 .8 1.6L12 11v4a1 1 0 0 1-.553.894l-3 1.5A1 1 0 0 1 7 16.5V11L3.2 4.6A1 1 0 0 1 3 4Z" />
                    </svg>
                    Filter
                </a>
                <a class="cctv-action-btn secondary" href="{{ route('admin.cctvs.create') }}">+ Unit kerja</a>
            </div>
        </div>

        <div class="cctv-grid">
            @forelse ($items as $item)
                <article class="cctv-card">
                    <div class="cctv-stream">
                        @if ($item->embed_url)
                            <iframe
                                src="{{ $item->embed_url }}"
                                title="Live Streaming {{ $item->nama }}"
                                loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="cctv-empty-preview">
                                <svg width="34" height="34" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l5-3v10l-5-3v-4ZM4 7h11v10H4z" />
                                </svg>
                                <span>Link live streaming belum diisi</span>
                            </div>
                        @endif

                        <span class="cctv-live-badge">
                            <span></span>
                            LIVE
                        </span>
                        <span class="cctv-time">{{ now()->format('d/m/Y, h:i:s A') }}</span>
                    </div>

                    <div class="cctv-card-footer">
                        <div class="min-w-0">
                            <a class="cctv-title-link" href="{{ route('admin.cctvs.show', $item) }}">{{ $item->nama }}</a>
                            <p>{{ $item->aktif ? 'Online' : 'Nonaktif' }}</p>
                        </div>
                        <div class="cctv-card-actions">
                            <a href="{{ route('admin.cctvs.edit', $item) }}" title="Edit CCTV">✎</a>
                            <form method="POST" action="{{ route('admin.cctvs.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button title="Hapus CCTV">×</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="cctv-empty-state">
                    <h2>Data CCTV belum tersedia</h2>
                    <p>Tambahkan data CCTV terlebih dahulu, lalu isi URL live streaming pada form CCTV.</p>
                    <a class="btn-primary" href="{{ route('admin.cctvs.create') }}">Tambah CCTV</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    </div>
</x-admin-layout>
