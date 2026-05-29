<x-pwa-layout title="Register">
    <main class="min-h-screen px-7 py-10">
        <div class="mb-10 mt-6">
            <h1 class="text-3xl font-extrabold">Helloo!</h1>
            <p class="mt-2 text-sm text-slate-500">Nikmati Beragam Fitur dan Layanan!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="text-sm font-semibold text-slate-700">Nama</label>
                <input id="name" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <label for="username" class="text-sm font-semibold text-slate-700">Username</label>
                <input id="username" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>
            <div>
                <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                <input id="email" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <label for="password" class="text-sm font-semibold text-slate-700">Sandi</label>
                <input id="password" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Sandi</label>
                <input id="password_confirmation" class="mt-2 w-full rounded-xl border-slate-200 bg-slate-50" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            <button class="mt-6 w-full rounded-xl bg-slate-900 py-3.5 text-sm font-extrabold text-white">Daftar</button>
            <p class="mt-4 text-center text-xs text-slate-500">Sudah memiliki akun? <a href="{{ route('login') }}" class="font-bold text-[#3159d4]">Masuk</a></p>
        </form>
    </main>
</x-pwa-layout>
