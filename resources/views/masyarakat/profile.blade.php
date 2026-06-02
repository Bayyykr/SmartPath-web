<x-pwa-layout title="Profile">
    <main class="min-h-screen pb-28">
        <div class="relative">
            <div class="h-[120px] bg-cover bg-center" style="background-image: url('https://picsum.photos/seed/pier/1000/120');"></div>
            <div class="absolute bottom-[-40px] left-6 h-20 w-20 overflow-hidden rounded-full border-2 border-white bg-blue-100 text-3xl shadow-md">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/'.$user->profile_photo) }}" class="h-full w-full object-cover" alt="{{ $user->name }}">
                @else
                    <div class="grid h-full w-full place-items-center text-gray-700">👤</div>
                @endif
            </div>
        </div>
        <section class="px-6 pt-12">
            <h1 class="text-xl font-bold text-black">{{ $user->name }}</h1>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>

            <div class="mt-8 space-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between h-14 w-full text-black">
                    <div class="flex items-center space-x-4">
                        <span class="text-xl">❓</span>
                        <div>
                            <span class="font-medium">Bantuan</span>
                            <p class="text-xs text-gray-500">Pusat bantuan, hubungi kami</p>
                        </div>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center justify-between h-14 w-full text-black text-left">
                        <div class="flex items-center space-x-4">
                            <span class="text-xl">↪</span>
                            <span class="font-medium">Keluar</span>
                        </div>
                        <span class="text-xl text-gray-400">›</span>
                    </button>
                </form>
            </div>
        </section>
    </main>
    @include('masyarakat.components')
</x-pwa-layout>
