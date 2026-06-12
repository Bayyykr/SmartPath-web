<x-pwa-layout title="Reset Kata Sandi">
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
            <h1 class="gc-auth-title">Reset Kata Sandi</h1>
            <p class="gc-auth-subtitle">Silakan buat kata sandi baru untuk mengamankan akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('pwa.password.store') }}" class="gc-auth-form">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="gc-field">
                <label for="email" class="gc-label">Alamat Email</label>
                <input id="email" class="gc-input" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="gc-error" />
            </div>

            <div class="gc-field">
                <label for="password" class="gc-label">Kata Sandi Baru</label>
                <div class="gc-input-wrap">
                    <input id="password" class="gc-input gc-input-password" type="password" name="password" required autocomplete="new-password" autofocus />
                    <button class="gc-password-toggle" type="button" data-password-toggle="password" aria-label="Tampilkan sandi">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M2.75 12s3.25-5.5 9.25-5.5S21.25 12 21.25 12 18 17.5 12 17.5 2.75 12 2.75 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14.75a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Z" stroke="currentColor" stroke-width="1.8" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="gc-error" />
            </div>

            <div class="gc-field">
                <label for="password_confirmation" class="gc-label">Konfirmasi Kata Sandi Baru</label>
                <div class="gc-input-wrap">
                    <input id="password_confirmation" class="gc-input gc-input-password" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <button class="gc-password-toggle" type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan sandi">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M2.75 12s3.25-5.5 9.25-5.5S21.25 12 21.25 12 18 17.5 12 17.5 2.75 12 2.75 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14.75a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Z" stroke="currentColor" stroke-width="1.8" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="gc-error" />
            </div>

            <div style="margin-top: 12px;">
                <button class="gc-button" type="submit">Reset Kata Sandi</button>
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
