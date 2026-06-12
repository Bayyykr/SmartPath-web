<x-pwa-layout title="Login PWA">
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
            margin-bottom: 42px;
        }

        .gc-auth-title {
            margin: 0;
            color: #2b2b2f;
            font-size: 31px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.04em;
        }

        .gc-auth-subtitle {
            max-width: 260px;
            margin: 12px 0 0;
            color: #666b73;
            font-size: 12px;
            line-height: 1.45;
            letter-spacing: -.015em;
        }

        .gc-auth-form {
            display: flex;
            flex-direction: column;
        }

        .gc-field {
            margin-bottom: 18px;
        }

        .gc-label {
            display: block;
            margin-bottom: 8px;
            color: #3f3f46;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: -.01em;
        }

        .gc-input-wrap {
            position: relative;
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

        .gc-input-password {
            padding-right: 42px;
        }

        .gc-password-toggle {
            position: absolute;
            top: 0;
            right: 0;
            display: grid;
            width: 40px;
            height: 39px;
            place-items: center;
            border: 0;
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
        }

        .gc-password-toggle svg {
            width: 15px;
            height: 15px;
        }

        .gc-forgot {
            display: block;
            margin-top: 10px;
            color: #555b64;
            font-size: 10px;
            font-weight: 500;
            text-align: right;
            text-decoration: none;
        }

        .gc-form-bottom {
            margin-top: 20px;
            padding-bottom: 6px;
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
            margin: 12px 0 0;
            color: #666b73;
            font-size: 10px;
            text-align: center;
        }

        .gc-auth-switch a {
            color: #253aa8;
            font-weight: 700;
            text-decoration: none;
        }

        .gc-status {
            margin: -24px 0 18px;
            color: #166534;
            font-size: 12px;
        }

        .gc-error,
        .gc-error ul,
        .gc-error li,
        .gc-field ul {
            margin: 6px 0 0;
            padding: 0;
            list-style: none;
            color: #dc2626;
            font-size: 11px;
            line-height: 1.35;
        }

        @media (max-width: 380px) {
            .gc-auth { padding-right: 32px; padding-left: 32px; }
        }

        @media (max-height: 700px) {
            .gc-auth { padding-top: 42px; }
            .gc-auth-heading { margin-bottom: 28px; }
            .gc-auth-form { min-height: calc(100vh - 150px); }
        }
    </style>

    <main class="gc-auth">
        <div class="gc-auth-heading">
            <h1 class="gc-auth-title">Helloo!</h1>
            <p class="gc-auth-subtitle">Selamat datang kembali. Anda telah dirindukan selama ini</p>
        </div>

        <x-auth-session-status class="gc-status" :status="session('status')" />

        @if(session('success'))
            <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('pwa.login.store') }}" class="gc-auth-form">
            @csrf

            <div>
                <div class="gc-field">
                    <label for="email" class="gc-label">Email / Username</label>
                    <input id="email" class="gc-input" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="gc-error" />
                </div>

                <div class="gc-field">
                    <label for="password" class="gc-label">Sandi</label>
                    <div class="gc-input-wrap">
                        <input id="password" class="gc-input gc-input-password" type="password" name="password" required autocomplete="current-password" />
                        <button class="gc-password-toggle" type="button" data-password-toggle="password" aria-label="Tampilkan sandi">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M2.75 12s3.25-5.5 9.25-5.5S21.25 12 21.25 12 18 17.5 12 17.5 2.75 12 2.75 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 14.75a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Z" stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="gc-error" />

                    @if (Route::has('pwa.password.request'))
                        <a class="gc-forgot" href="{{ route('pwa.password.request') }}">Lupa Kata Sandi?</a>
                    @endif
                </div>
            </div>

            <div class="gc-form-bottom">
                <button class="gc-button" type="submit">Masuk</button>
                <p class="gc-auth-switch">Tidak punya akun? <a href="{{ route('pwa.register') }}">Daftar</a></p>
            </div>
        </form>
    </main>

    <script>
        (() => {
            document.querySelectorAll('[data-password-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.passwordToggle);
                    if (!input) return;

                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });
        })();
    </script>
</x-pwa-layout>
