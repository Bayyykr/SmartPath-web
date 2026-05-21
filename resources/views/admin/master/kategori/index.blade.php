<x-admin-layout>
    <x-slot name="header">Kategori</x-slot>

    <div class="master-page">
        @if (session('success')) <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">{{ session('success') }}</div> @endif
        <div class="mb-5 flex gap-2">
            <a class="tab-link {{ $tipe === 'kejahatan' ? 'active' : '' }}" href="{{ route('admin.categories.index', ['tipe' => 'kejahatan']) }}">Kejahatan</a>
            <a class="tab-link {{ $tipe === 'kecelakaan' ? 'active' : '' }}" href="{{ route('admin.categories.index', ['tipe' => 'kecelakaan']) }}">Kecelakaan</a>
        </div>
        <div class="master-toolbar">
            <form method="GET"><input type="hidden" name="tipe" value="{{ $tipe }}"><input class="master-search" name="search" value="{{ request('search') }}" placeholder="Cari"></form>
            <a class="btn-primary" href="{{ route('admin.categories.create', ['tipe' => $tipe]) }}">Tambah</a>
        </div>
        <table class="master-table">
            <thead><tr><th width="60">No</th><th>Nama Kategori</th><th>Tipe</th><th>Tanggal</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                @forelse ($items as $item)
                    <tr><td>{{ $items->firstItem() + $loop->index }}</td><td>{{ $item->nama }}</td><td>{{ ucfirst($item->tipe) }}</td><td>{{ $item->created_at?->format('n/j/Y, g:i:s A') }}</td><td class="space-x-1"><a class="btn-edit" href="{{ route('admin.categories.edit', $item) }}">✎</a><form class="inline" method="POST" action="{{ route('admin.categories.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn-delete">■</button></form></td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-gray-500">Data belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $items->links() }}</div>
    </div>
</x-admin-layout>
