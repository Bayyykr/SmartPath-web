<x-pwa-layout title="Edit Profil">
    <style>
        .hidden { display: none !important; }
        .gc-form-page, .gc-form-page * { box-sizing: border-box; }
        .gc-form-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 28px 32px;
            color: #111827;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-back { display: inline-flex; align-items: center; gap: 8px; color: #4b5563; font-size: 11px; font-weight: 800; text-decoration: none; }
        .gc-back svg { width: 14px; height: 14px; }
        .gc-title { margin: 20px 0 0; color: #2b2b2f; font-size: 21px; font-weight: 800; line-height: 1; letter-spacing: -.04em; }
        .gc-subtitle { max-width: 295px; margin: 8px 0 0; color: #6b7280; font-size: 11px; line-height: 1.45; }

        .gc-section-title {
            margin: 28px 0 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
            color: #111827;
            font-size: 14px;
            font-weight: 800;
        }

        .gc-form { margin-top: 16px; }
        .gc-field { margin-bottom: 18px; }
        .gc-label { display: block; margin-bottom: 8px; color: #4b5563; font-size: 10.5px; font-weight: 800; letter-spacing: -.01em; }
        .gc-required { color: #ef4444; }

        .gc-photo-uploader {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }
        .gc-photo-preview {
            width: 64px;
            height: 64px;
            border-radius: 9999px;
            object-cover;
            border: 2px solid #e2e8f0;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #64748b;
            overflow: hidden;
        }
        .gc-photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gc-photo-btn {
            font-size: 11px;
            font-weight: 700;
            padding: 8px 12px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            color: #475569;
            transition: all 0.2s;
        }
        .gc-photo-btn:hover {
            background: #e2e8f0;
        }

        .gc-input {
            display: block;
            width: 100%;
            border: 1px solid #dedfe3;
            border-radius: 4px;
            background: #f4f4f5;
            color: #111827;
            font-size: 12px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
            height: 39px;
            padding: 0 12px;
        }
        .gc-input:focus { border-color: #a8adb7; background: #fff; box-shadow: 0 0 0 3px rgba(37, 58, 168, .08); }
        .gc-error { margin: 6px 0 0; color: #dc2626; font-size: 10px; line-height: 1.35; }

        .gc-submit { display: block; width: 100%; height: 40px; margin-top: 16px; border: 0; border-radius: 4px; background: #242424; color: #fff; font-size: 10.5px; font-weight: 800; letter-spacing: .02em; cursor: pointer; box-shadow: 0 6px 12px rgba(15, 23, 42, .08); transition: opacity .2s; }
        .gc-submit:active { opacity: 0.8; }

        .gc-alert {
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 11px;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .gc-alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>

    <main class="gc-form-page">
        <a href="{{ route('masyarakat.profile') }}" class="gc-back">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Kembali
        </a>

        <h1 class="gc-title">Edit Profil</h1>
        <p class="gc-subtitle">Perbarui data profil akun Anda di aplikasi GeoCrime</p>

        @if (session('status') === 'profile-updated')
            <div class="gc-alert gc-alert-success">
                Profil berhasil diperbarui.
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="gc-alert gc-alert-success">
                Password berhasil diperbarui.
            </div>
        @endif

        <form method="POST" action="{{ route('masyarakat.profile.update') }}" enctype="multipart/form-data" class="gc-form">
            @csrf
            @method('patch')

            <h2 class="gc-section-title">Informasi Akun</h2>

            <div class="gc-photo-uploader">
                <div class="gc-photo-preview" id="photoPreview">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" id="photoImg">
                    @else
                        <span id="photoPlaceholder">👤</span>
                    @endif
                </div>
                <div>
                    <label for="profile_photo" class="gc-photo-btn">Pilih Foto</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewImage(this)">
                    <p style="font-size: 9px; color: #64748b; margin-top: 6px;">Format: JPG, PNG. Max: 2MB</p>
                </div>
            </div>
            @error('profile_photo')<p class="gc-error" style="margin-top: -10px; margin-bottom: 12px;">{{ $message }}</p>@enderror

            <div class="gc-field">
                <label for="name" class="gc-label">Nama Lengkap<span class="gc-required">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="gc-input" />
                @error('name')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="email" class="gc-label">Alamat Email<span class="gc-required">*</span></label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="gc-input" />
                @error('email')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="alamat" class="gc-label">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" class="gc-input" style="height: 80px; padding: 8px 12px; resize: none; font-family: inherit;">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <button class="gc-submit" type="submit">SIMPAN PERUBAHAN</button>
        </form>

        <form method="POST" action="{{ route('masyarakat.profile.password') }}" class="gc-form" style="margin-top: 32px;">
            @csrf
            @method('put')

            <h2 class="gc-section-title">Ubah Password</h2>

            <div class="gc-field">
                <label for="current_password" class="gc-label">Password Saat Ini<span class="gc-required">*</span></label>
                <input id="current_password" name="current_password" type="password" required class="gc-input" autocomplete="current-password" />
                @error('current_password', 'updatePassword')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="password" class="gc-label">Password Baru<span class="gc-required">*</span></label>
                <input id="password" name="password" type="password" required class="gc-input" autocomplete="new-password" />
                @error('password', 'updatePassword')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <div class="gc-field">
                <label for="password_confirmation" class="gc-label">Konfirmasi Password Baru<span class="gc-required">*</span></label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="gc-input" autocomplete="new-password" />
                @error('password_confirmation', 'updatePassword')<p class="gc-error">{{ $message }}</p>@enderror
            </div>

            <button class="gc-submit" type="submit">GANTI PASSWORD</button>
        </form>
    </main>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('photoPreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" id="photoImg">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-pwa-layout>
