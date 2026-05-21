@php
    $selectedJenis = old('jenis', $item?->jenis ?? $jenis ?? 'kejahatan');
    $selectedColor = old('warna_marker', $item?->warna_marker ?? '#FF0000');
@endphp

<div>
    <label class="form-label">Nama Kategori</label>
    <input
        class="form-input"
        name="nama_kategori"
        value="{{ old('nama_kategori', $item?->nama_kategori) }}"
        placeholder="Contoh: Pembegalan / Perampokan Jalanan"
        required>
    @error('nama_kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">Jenis</label>
    <select class="form-select" name="jenis" required>
        <option value="kejahatan" @selected($selectedJenis === 'kejahatan')>Kejahatan</option>
        <option value="kecelakaan" @selected($selectedJenis === 'kecelakaan')>Kecelakaan</option>
    </select>
    @error('jenis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="form-label">Warna Marker Peta</label>
    <div class="flex items-center gap-3">
        <input
            class="h-10 w-14 cursor-pointer rounded border border-gray-300 bg-white p-1"
            type="color"
            value="{{ $selectedColor }}"
            data-color-picker>
        <input
            class="form-input"
            name="warna_marker"
            value="{{ $selectedColor }}"
            placeholder="#FF0000"
            pattern="^#[0-9A-Fa-f]{6}$"
            required
            data-color-text>
    </div>
    @error('warna_marker') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
