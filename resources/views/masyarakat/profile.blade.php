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
            @if($user->alamat)
                <p class="text-xs text-gray-500 mt-1 flex items-start gap-1">
                    <span class="inline-block mt-0.5">📍</span>
                    <span>{{ $user->alamat }}</span>
                </p>
            @endif

            <div class="mt-8 space-y-2">
                <!-- Edit Profil -->
                <a href="{{ route('masyarakat.profile.edit') }}" class="flex items-center justify-between h-14 w-full text-black">
                    <div class="flex items-center space-x-4">
                        <span class="text-xl">⚙️</span>
                        <div>
                            <span class="font-medium">Edit Profil</span>
                            <p class="text-xs text-gray-500">Ubah data diri dan password Anda</p>
                        </div>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </a>

                <!-- Bantuan -->
                <a href="{{ route('masyarakat.bantuan') }}" class="flex items-center justify-between h-14 w-full text-black">
                    <div class="flex items-center space-x-4">
                        <span class="text-xl">❓</span>
                        <div>
                            <span class="font-medium">Bantuan</span>
                            <p class="text-xs text-gray-500">Pusat bantuan, hubungi kami</p>
                        </div>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </a>

                <!-- Keluar -->
                <button type="button" onclick="showLogoutModal()" class="flex items-center justify-between h-14 w-full text-black text-left">
                    <div class="flex items-center space-x-4">
                        <span class="text-xl">↪</span>
                        <span class="font-medium">Keluar</span>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </button>
            </div>
        </section>
    </main>

    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="fixed inset-0 z-50 flex items-end justify-center hidden bg-black/55 backdrop-blur-sm transition-opacity duration-300">
        <!-- Modal Card -->
        <div class="w-full max-w-md bg-white rounded-t-2xl p-6 shadow-2xl transition-transform duration-300 translate-y-full transform" id="logout-modal-card">
            <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-4"></div>
            
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-600 text-2xl mb-4">
                    ⚠️
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Keluar</h3>
                <p class="text-xs text-gray-500 mt-2">Apakah Anda yakin ingin keluar dari akun Anda?</p>
            </div>

            <div class="mt-6 flex flex-col gap-2">
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 bg-red-600 text-white rounded-xl font-bold text-xs shadow-md shadow-red-200 hover:bg-red-700 transition">
                        Ya, Keluar
                    </button>
                </form>
                <button type="button" onclick="hideLogoutModal()" class="w-full py-3 px-4 bg-gray-100 text-gray-700 rounded-xl font-bold text-xs hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            const modal = document.getElementById('logout-modal');
            const card = document.getElementById('logout-modal-card');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('translate-y-full');
            }, 10);
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logout-modal');
            const card = document.getElementById('logout-modal-card');
            
            card.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    @include('masyarakat.components')
</x-pwa-layout>
