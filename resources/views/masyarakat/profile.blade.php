<x-pwa-layout title="Profile">
    <main class="min-h-screen pb-28">
        <div class="relative">
            <div class="h-[120px] bg-cover bg-center" style="background-image: url('https://picsum.photos/seed/pier/1000/120');"></div>
            <div class="absolute bottom-[-40px] left-6 h-20 w-20 overflow-hidden rounded-full border-2 border-white bg-blue-100 text-3xl shadow-md">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/'.$user->profile_photo) }}" class="h-full w-full object-cover" alt="{{ $user->name }}">
                @else
                    <div class="grid h-full w-full place-items-center bg-gray-200 text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>
        <section class="px-6 pt-12">
            <h1 class="text-xl font-bold text-black">{{ $user->name }}</h1>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>
            @if($user->alamat)
                <p class="text-xs text-gray-500 mt-1.5 flex items-start gap-1.5">
                    <span class="inline-block mt-0.5 text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                        </svg>
                    </span>
                    <span>{{ $user->alamat }}</span>
                </p>
            @endif

            <div class="mt-8 space-y-2">
                <!-- Edit Profil -->
                <a href="{{ route('masyarakat.profile.edit') }}" class="flex items-center justify-between h-14 w-full text-black">
                    <div class="flex items-center space-x-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.297 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869L9.594 3.94ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                        </span>
                        <div>
                            <span class="font-medium text-sm text-gray-800">Edit Profil</span>
                            <p class="text-xs text-gray-500">Ubah data diri dan password Anda</p>
                        </div>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </a>

                <!-- Bantuan -->
                <a href="{{ route('masyarakat.bantuan') }}" class="flex items-center justify-between h-14 w-full text-black">
                    <div class="flex items-center space-x-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"/>
                            </svg>
                        </span>
                        <div>
                            <span class="font-medium text-sm text-gray-800">Bantuan</span>
                            <p class="text-xs text-gray-500">Pusat bantuan, hubungi kami</p>
                        </div>
                    </div>
                    <span class="text-xl text-gray-400">›</span>
                </a>

                <!-- Keluar -->
                <button type="button" onclick="showLogoutModal()" class="flex items-center justify-between h-14 w-full text-black text-left">
                    <div class="flex items-center space-x-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm text-gray-800">Keluar</span>
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
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-50 text-red-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    </svg>
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
