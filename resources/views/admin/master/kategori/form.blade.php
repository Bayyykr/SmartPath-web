<x-admin-layout>
    <x-slot name="header">{{ $item->exists ? 'Edit Kategori' : 'Tambah Kategori' }}</x-slot>
    <div class="master-page">
        <form class="form-card space-y-4" method="POST" action="{{ $item->exists ? route('admin.categories.update', $item) : route('admin.categories.store') }}">
            @csrf @if ($item->exists) @method('PUT') @endif
            <div><label class="form-label">Nama Kategori</label><input class="form-input" name="nama" value="{{ old('nama', $item->nama) }}" required>@error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
            <div><label class="form-label">Tipe</label><select class="form-select" name="tipe" required><option value="kejahatan" @selected(old('tipe', $item->tipe) === 'kejahatan')>Kejahatan</option><option value="kecelakaan" @selected(old('tipe', $item->tipe) === 'kecelakaan')>Kecelakaan</option></select>@error('tipe') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
            <div class="flex gap-2 pt-2"><button class="btn-primary">Simpan</button><a class="btn-secondary" href="{{ route('admin.categories.index', ['tipe' => old('tipe', $item->tipe ?: 'kejahatan')]) }}">Kembali</a></div>
        </form>
    </div>
</x-admin-layout>
