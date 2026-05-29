<x-pwa-layout title="Profile">
    <main class="min-h-screen pb-28">
        <div class="h-40 bg-gradient-to-br from-slate-800 to-blue-400"></div>
        <section class="px-6">
            <div class="-mt-12 h-24 w-24 overflow-hidden rounded-full border-4 border-white bg-blue-100 text-5xl shadow-lg">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/'.$user->profile_photo) }}" class="h-full w-full object-cover" alt="{{ $user->name }}">
                @else
                    <div class="grid h-full w-full place-items-center">👤</div>
                @endif
            </div>
            <h1 class="mt-4 text-xl font-extrabold">{{ $user->name }}</h1>
            <p class="text-sm text-slate-500">{{ $user->email }}</p>

            <div class="mt-8 space-y-3">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                    <span class="font-bold">⚙️ Pengaturan akun</span><span>›</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center justify-between rounded-2xl bg-white p-4 text-left shadow-sm ring-1 ring-slate-100">
                        <span class="font-bold">↪ Keluar</span><span>›</span>
                    </button>
                </form>
            </div>
        </section>
    </main>
    @include('masyarakat.components')
</x-pwa-layout>
