<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-pwa-head />

        <title>Login SmartPath</title>

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
                padding: 10px 12px 10px 38px;
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

            /* Admin Button Styling */
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

            .admin-card {
                background: #ffffff;
                border: 1px solid var(--border);
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
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
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Portal Keamanan Internal</span>
                    <h2 class="text-3xl font-extrabold leading-tight text-gray-950">
                        Sistem Informasi Pengawasan & Respons Cepat Wilayah
                    </h2>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Halaman log masuk khusus bagi aparat kepolisian, admin polsek, dan operator sistem untuk memproses laporan masyarakat secara berkala dan realtime.
                    </p>
                    
                    <div class="admin-card p-5 space-y-3">
                        <div class="flex items-center justify-between text-xs text-gray-500 border-b border-gray-100 pb-2">
                            <span class="font-bold">ADMIN CONTROL</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">Hubungi call center pusat apabila Anda mengalami kendala akses kredensial akun operator.</p>
                    </div>
                </div>

                <div class="relative z-10 text-xs text-gray-400">
                    &copy; {{ date('Y') }} SmartPath. Aplikasi Pendukung Keamanan Masyarakat.
                </div>
            </div>

            <div class="col-span-12 lg:col-span-7 bg-login-panel flex flex-col justify-between p-8 sm:p-12 md:p-16">

                <div class="flex items-center justify-between">
                    <a href="/" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-gray-950 transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Home
                    </a>

                    <a href="/" class="flex lg:hidden items-center gap-2">
                        <span class="grid w-8 h-8 place-items-center border border-gray-300 rounded-lg bg-white shadow-sm">
                            <img src="/icons/icon_app.png" alt="SmartPath Logo" class="h-5 w-5 object-contain">
                        </span>
                        <span class="text-lg font-black tracking-tight text-gray-950">Smart<span class="text-blue-600">Path</span></span>
                    </a>
                </div>

                <div class="max-w-md w-full mx-auto my-auto py-10 space-y-8">

                    <div class="space-y-2 text-left">
                        <h1 class="text-3xl font-extrabold tracking-tight text-gray-950">Masuk Akun</h1>
                        <p class="text-sm text-gray-500">Gunakan akun admin atau operator terdaftar Anda untuk masuk.</p>
                    </div>

                    <x-auth-session-status class="text-sm font-medium text-emerald-600 bg-emerald-50 p-4 rounded-lg border border-emerald-100" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-1.5">
                            <label for="email" class="text-sm font-bold text-gray-700">Email / Username</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </span>
                                <input id="email" 
                                       class="admin-form-input" 
                                       type="text" 
                                       name="email" 
                                       placeholder="username@gmail.com" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-xs text-rose-600 font-semibold mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="password" class="text-sm font-bold text-gray-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </span>
                                <input id="password" 
                                       class="admin-form-input pr-10" 
                                       type="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required 
                                       autocomplete="current-password" />
                                <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-5 h-5" id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-xs text-rose-600 font-semibold mt-1" />
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500/25 focus:ring-offset-0">
                                <span class="ml-2 text-xs font-semibold text-gray-500">Ingat Saya</span>
                            </label>
                            @if (Route::has('register'))
                                <a class="text-xs font-bold text-blue-600 hover:text-blue-700 transition" href="{{ route('register') }}">
                                    Daftar Akun Baru
                                </a>
                            @endif
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn-admin-submit">
                                Masuk Aplikasi
                            </button>
                        </div>
                    </form>

                </div>

                <div class="text-center text-xs text-gray-400 block lg:hidden pt-4">
                    &copy; {{ date('Y') }} SmartPath. Hak Cipta Dilindungi.
                </div>

                <div class="hidden lg:block"></div>

            </div>

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const passwordInput = document.getElementById('password');
                const toggleButton = document.getElementById('toggle-password');
                const eyeIcon = document.getElementById('eye-icon');

                toggleButton.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    if (isPassword) {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        `;
                    } else {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        `;
                    }
                });
            });
        </script>
    </body>
</html>
