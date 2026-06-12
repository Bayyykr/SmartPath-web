<x-pwa-layout title="Lupa Kata Sandi">
    <style>
        .hidden { display: none !important; }

        .gc-auth,
        .gc-auth * {
            box-sizing: border-box;
        }

        .gc-auth {
            display: flex;
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            flex-direction: column;
            background: #ffffff;
            padding: 58px 44px 28px;
            color: #27272a;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .gc-auth-heading {
            margin-bottom: 32px;
        }

        .gc-auth-title {
            margin: 0;
            color: #2b2b2f;
            font-size: 26px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.03em;
        }

        .gc-auth-subtitle {
            max-width: 280px;
            margin: 10px 0 0;
            color: #666b73;
            font-size: 11.5px;
            line-height: 1.5;
        }

        .gc-auth-form {
            display: flex;
            flex-direction: column;
        }

        .gc-field {
            margin-bottom: 20px;
        }

        .gc-label {
            display: block;
            margin-bottom: 8px;
            color: #3f3f46;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: -.01em;
        }

        .gc-input {
            display: block;
            width: 100%;
            height: 39px;
            border: 1px solid #d9d9dc;
            border-radius: 4px;
            background: #f3f3f4;
            padding: 0 13px;
            color: #27272a;
            font-size: 13px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .gc-input:focus {
            border-color: #a8adb7;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 58, 168, .08);
        }

        .gc-button {
            display: block;
            width: 100%;
            height: 42px;
            border: 0;
            border-radius: 4px;
            background: #242424;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(15, 23, 42, .08);
        }

        .gc-auth-switch {
            margin: 16px 0 0;
            color: #666b73;
            font-size: 11px;
            text-align: center;
        }

        .gc-auth-switch a {
            color: #253aa8;
            font-weight: 700;
            text-decoration: none;
        }

        .gc-status {
            margin-bottom: 18px;
            padding: 10px 12px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .gc-error {
            margin: 6px 0 0;
            color: #dc2626;
            font-size: 11px;
            line-height: 1.35;
        }

        @media (max-width: 380px) {
            .gc-auth { padding-right: 32px; padding-left: 32px; }
        }
    </style>

    <main class="gc-auth">
        <div class="gc-auth-heading">
            <h1 class="gc-auth-title">Lupa Kata Sandi?</h1>
            <p class="gc-auth-subtitle">Masukkan alamat email Anda. Kami akan mengirimkan tautan reset kata sandi agar Anda dapat membuat yang baru.</p>
        </div>

        @if (session('status'))
            <div class="gc-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pwa.password.email') }}" class="gc-auth-form">
            @csrf

            <div class="gc-field">
                <label for="email" class="gc-label">Alamat Email</label>
                <input id="email" class="gc-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="gc-error" />
            </div>

            <div style="margin-top: 12px;">
                <button class="gc-button" type="submit">Kirim Tautan Reset</button>
                <p class="gc-auth-switch">Kembali ke <a href="{{ route('pwa.login') }}">Masuk</a></p>
            </div>
        </form>
    </main>
</x-pwa-layout>
