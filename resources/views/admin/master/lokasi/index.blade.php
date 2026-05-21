<x-admin-layout>
    <x-slot name="header">Lokasi</x-slot>
    <div class="master-page">
        @if (session('success')) <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">{{ session('success') }}</div> @endif
        <div class="master-toolbar"><form method="GET"><input class="master-search" name="search" value="{{ request('search') }}" placeholder="Cari lokasi..."></form><a class="btn-primary" href="{{ route('admin.locations.create') }}">Tambah</a></div>
        <table class="master-table"><thead><tr><th width="60">No</th><th>Nama Lokasi</th><th>Alamat</th><th>Koordinat</th><th>Tanggal</th><th width="120">Aksi</th></tr></thead><tbody>
            @forelse ($items as $item)
                <tr><td>{{ $items->firstItem() + $loop->index }}</td><td>{{ $item->nama }}</td><td>{{ $item->alamat ?? '-' }}</td><td>{{ $item->latitude ?? '-' }}, {{ $item->longitude ?? '-' }}</td><td>{{ $item->created_at?->format('n/j/Y, g:i:s A') }}</td><td class="space-x-1"><a class="btn-edit" href="{{ route('admin.locations.edit', $item) }}">✎</a><form class="inline" method="POST" action="{{ route('admin.locations.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="btn-delete">■</button></form></td></tr>
            @empty
                <tr><td colspan="6" class="text-center text-gray-500">Data belum tersedia.</td></tr>
            @endforelse
        </tbody></table><div class="mt-4">{{ $items->links() }}</div>
    </div>
</x-admin-layout>
