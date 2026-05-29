<x-pwa-layout title="Login">
    <main class="min-h-screen px-7 py-10">
        <div class="mb-14 mt-10">
            <h1 class="text-3xl font-extrabold">Helloo!</h1>
            <p class="mt-2 text-sm text-slate-500">Selamat datang kembali. Anda telah dirindukan selama ini</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="text-sm font-semibold text-slate-700">Email / Username</label>
                <input id="email" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="text" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label for="password" class="text-sm font-semibold text-slate-700">Sandi</label>
                <input id="password" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                @if (Route::has('password.request'))
                    <a class="mt-2 block text-right text-xs font-semibold text-slate-500" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                @endif
            </div>

            <div class="pt-28">
                <button class="w-full rounded-xl bg-slate-900 py-3.5 text-sm font-extrabold text-white">Masuk</button>
                <p class="mt-4 text-center text-xs text-slate-500">Tidak punya akun? <a href="{{ route('register') }}" class="font-bold text-[#3159d4]">Daftar</a></p>
            </div>
        </form>
    </main>
</x-pwa-layout>
