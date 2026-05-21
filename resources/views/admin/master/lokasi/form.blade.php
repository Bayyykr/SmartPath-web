<x-admin-layout>
    <x-slot name="header">{{ $item->exists ? 'Edit Lokasi' : 'Tambah Lokasi' }}</x-slot>
    <div class="master-page"><form class="form-card space-y-4" method="POST" action="{{ $item->exists ? route('admin.locations.update', $item) : route('admin.locations.store') }}">
        @csrf @if ($item->exists) @method('PUT') @endif
        <div><label class="form-label">Nama Lokasi</label><input class="form-input" name="nama" value="{{ old('nama', $item->nama) }}" required>@error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
        <div><label class="form-label">Alamat</label><input class="form-input" name="alamat" value="{{ old('alamat', $item->alamat) }}">@error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div>
        <div class="grid grid-cols-2 gap-4"><div><label class="form-label">Latitude</label><input class="form-input" name="latitude" value="{{ old('latitude', $item->latitude) }}">@error('latitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div><div><label class="form-label">Longitude</label><input class="form-input" name="longitude" value="{{ old('longitude', $item->longitude) }}">@error('longitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror</div></div>
        <div class="flex gap-2 pt-2"><button class="btn-primary">Simpan</button><a class="btn-secondary" href="{{ route('admin.locations.index') }}">Kembali</a></div>
    </form></div>
</x-admin-layout>
