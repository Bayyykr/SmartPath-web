<x-admin-layout>
    <x-slot name="header">{{ $item->exists ? 'Edit CCTV' : 'Tambah CCTV' }}</x-slot>

    <div class="master-page">
        <form class="form-card space-y-4" method="POST" action="{{ $item->exists ? route('admin.cctvs.update', $item) : route('admin.cctvs.store') }}">
            @csrf
            @if ($item->exists) @method('PUT') @endif

            <div>
                <label class="form-label">Nama CCTV</label>
                <input class="form-input" name="nama" value="{{ old('nama', $item->nama) }}" placeholder="Contoh: CCTV Alun-Alun Lumajang" required>
                @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Wilayah Master Lokasi</label>
                <select class="form-select" name="lokasi_id">
                    <option value="">Pilih wilayah lokasi</option>
                    @foreach (($locations ?? collect()) as $location)
                        <option value="{{ $location->id }}" @selected((string) old('lokasi_id', $item->lokasi_id) === (string) $location->id)>{{ $location->nama_lokasi }}</option>
                    @endforeach
                </select>
                @error('lokasi_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Keterangan Posisi CCTV</label>
                <textarea class="form-input min-h-[90px]" name="keterangan" placeholder="Contoh: Menghadap pintu masuk sisi utara Alun-Alun Lumajang">{{ old('keterangan', $item->keterangan) }}</textarea>
                <p class="mt-2 text-sm text-gray-500">Isi keterangan singkat tentang posisi atau arah pantau CCTV.</p>
                @error('keterangan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">URL Live Streaming YouTube</label>
                <input class="form-input" name="url_stream" value="{{ old('url_stream', $item->url_stream) }}" placeholder="https://www.youtube.com/watch?v=... atau https://www.youtube.com/live/...">
                <p class="mt-2 text-sm text-gray-500">Masukkan URL livestream YouTube. Sistem akan otomatis menampilkan player live streaming.</p>
                @error('url_stream') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $item->aktif))>
                <span>Aktif</span>
            </label>

            <div class="flex gap-2 pt-2">
                <button class="btn-primary">Simpan</button>
                <a class="btn-secondary" href="{{ route('admin.cctvs.index') }}">Kembali</a>
            </div>
        </form>
    </div>
</x-admin-layout>
