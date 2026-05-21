@php
    $user = $item;
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <label class="form-label">Nama Lengkap</label>
        <input class="form-input" name="name" value="{{ $user?->name }}" placeholder="Contoh: Budi Santoso" required>
    </div>
    <div>
        <label class="form-label">Username</label>
        <input class="form-input" name="username" value="{{ $user?->username }}" placeholder="Contoh: budi.santoso">
    </div>
    <div>
        <label class="form-label">Email</label>
        <input class="form-input" type="email" name="email" value="{{ $user?->email }}" placeholder="nama@email.com" required>
    </div>
    <div>
        <label class="form-label">No. Telepon</label>
        <input class="form-input" name="telepon" value="{{ $user?->telepon }}" placeholder="08xxxxxxxxxx">
    </div>
    <div>
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
            @foreach (['admin' => 'Admin', 'operator' => 'Operator', 'user' => 'User'] as $value => $label)
                <option value="{{ $value }}" @selected(($user?->role ?? 'user') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="form-label">Password {{ $passwordRequired ? '' : '(kosongkan jika tidak diubah)' }}</label>
        <input class="form-input" type="password" name="password" {{ $passwordRequired ? 'required' : '' }} minlength="8" autocomplete="new-password">
    </div>
</div>

<div>
    <label class="form-label">Alamat</label>
    <textarea class="form-input min-h-[86px]" name="alamat" placeholder="Alamat user">{{ $user?->alamat }}</textarea>
</div>

<label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
    <input type="checkbox" name="aktif" value="1" @checked($user?->aktif ?? true)>
    <span>User aktif</span>
</label>
