<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Daftar Akun SmartPath - Keamanan Wilayah</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --page-bg: #eef7fa;
                --border: #e5e7eb;
                --text: #111827;
                --muted: #6b7280;
                --accent: #2563eb;
                --accent-hover: #1d4ed8;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background-color: var(--page-bg);
                color: var(--text);
            }

            .admin-form-input {
                width: 100%;
                border: 1px solid #d1d5db;
                border-radius: 7px;
                padding: 10px 12px;
                font-size: 14px;
                color: var(--text);
                background-color: #ffffff;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }

            .admin-form-input:focus {
                outline: none;
                border-color: var(--accent);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            }

            .btn-admin-submit {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                background: var(--accent);
                color: #ffffff;
                border-radius: 6px;
                padding: 10px 16px;
                font-size: 14px;
                font-weight: 600;
                transition: background 0.15s ease;
            }

            .btn-admin-submit:hover {
                background: var(--accent-hover);
            }

            .bg-login-panel {
                background: linear-gradient(135deg, #eef7fa 0%, #f4f9fb 100%);
            }

            .gradient-left-light {
                background: linear-gradient(135deg, #ffffff 0%, #eef7fa 100%);
            }
        </style>
    </head>
    <body class="h-full min-h-screen antialiased overflow-x-hidden">

        <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12">
            
            <div class="hidden lg:flex lg:col-span-5 gradient-left-light text-gray-900 p-12 flex-col justify-between relative overflow-hidden border-r border-gray-200">
                <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#000_1px,transparent_1px),linear-gradient(to_bottom,#000_1px,transparent_1px)] bg-[size:24px_24px]"></div>
                <div class="absolute w-80 h-80 bg-blue-500/10 rounded-full blur-[100px] -bottom-10 -left-10"></div>
                <div class="absolute w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px] -top-10 -right-10"></div>

                <div class="relative z-10">
                    <a href="/" class="inline-flex items-center gap-3">
                        <img src="/icons/icon_app.png" alt="SmartPath Logo" class="h-6 w-6 object-contain">
                        <span class="text-xl font-extrabold tracking-tight text-gray-950">Smart<span class="text-blue-600">Path</span></span>
                    </a>
                </div>

                <div class="relative z-10 space-y-6 max-w-sm my-auto">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Portal Pelaporan Masyarakat</span>
                    <h2 class="text-3xl font-extrabold leading-tight text-gray-950">
                        Bergabung Bersama Mengamankan Wilayah
                    </h2>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Buat akun masyarakat Anda untuk dapat melaporkan kejadian kriminal, kecelakaan, dan memantau kondisi keamanan sekitar secara real-time.
                    </p>
                </div>

                <div class="relative z-10 text-xs text-gray-400">
                    &copy; {{ date('Y') }} SmartPath. Hak Cipta Dilindungi.
                </div>
            </div>

            <div class="col-span-12 lg:col-span-7 bg-login-panel flex flex-col justify-between p-8 sm:p-12 md:p-16">

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Login
                    </a>
                </div>

                <div class="max-w-2xl w-full mx-auto my-auto py-10 space-y-8">

                    <div class="space-y-2 text-left">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-950">Daftar Akun</h1>
                        <p class="text-sm text-gray-500">Silakan lengkapi formulir di bawah untuk mendaftarkan akun baru Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama -->
                            <div class="space-y-1.5">
                                <label for="name" class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                                <input id="name" class="admin-form-input" type="text" name="name" placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>

                            <!-- Username -->
                            <div class="space-y-1.5">
                                <label for="username" class="text-sm font-bold text-gray-700">Username</label>
                                <input id="username" class="admin-form-input" type="text" name="username" placeholder="Username unik" value="{{ old('username') }}" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('username')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5">
                                <label for="email" class="text-sm font-bold text-gray-700">Alamat Email</label>
                                <input id="email" class="admin-form-input" type="email" name="email" placeholder="nama@gmail.com" value="{{ old('email') }}" required autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="space-y-1.5">
                                <label for="telepon" class="text-sm font-bold text-gray-700">Nomor Telepon</label>
                                <input id="telepon" class="admin-form-input" type="tel" name="telepon" placeholder="Contoh: 081234567890" value="{{ old('telepon') }}" required pattern="[0-9]{10,13}" maxlength="13" title="Nomor telepon harus berupa angka 10-13 digit" />
                                <x-input-error :messages="$errors->get('telepon')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>

                            <!-- Password -->
                            <div class="space-y-1.5">
                                <label for="password" class="text-sm font-bold text-gray-700">Kata Sandi</label>
                                <input id="password" class="admin-form-input" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" minlength="8" />
                                <x-input-error :messages="$errors->get('password')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="text-sm font-bold text-gray-700">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" class="admin-form-input" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" minlength="8" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="text-xs text-rose-600 font-semibold mt-1" />
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-admin-submit">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                </div>

                <div class="text-center text-xs text-gray-400 block lg:hidden pt-4">
                    &copy; {{ date('Y') }} SmartPath. Hak Cipta Dilindungi.
                </div>

            </div>

        </div>

    </body>
</html>
