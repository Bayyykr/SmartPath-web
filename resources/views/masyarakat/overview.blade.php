<x-pwa-layout title="Overview">
    <main class="relative min-h-screen overflow-hidden px-7 py-7" x-data="{ slide: 0, total: 4, ready: true }">
        <div class="mb-7 flex items-center gap-2 text-sm font-extrabold text-[#3159d4]">
            <span class="grid h-8 w-8 place-items-center rounded-xl bg-blue-50">▦</span>
            <span>GeoCrime</span>
        </div>

        <div class="overflow-hidden" :class="ready ? '' : 'hidden'">
            <div class="flex transition-transform duration-500 ease-out" :style="`transform: translateX(-${slide * 100}%);`">
                @foreach ([
                    ['title' => 'Pelacakan', 'desc' => 'Lacak area rawan kejahatan dan kecelakaan secara real-time lewat peta GIS.', 'art' => '🗺️'],
                    ['title' => 'Informasi', 'desc' => 'Membaca laporan dan mendapatkan sebaran informasi mengenai kejahatan dan kecelakaan.', 'art' => '📚'],
                    ['title' => 'SOS Button', 'desc' => 'Tekan tombol darurat saat Anda butuh bantuan secepatnya.', 'art' => '👮'],
                    ['title' => 'Selamat datang!', 'desc' => 'Terlindungi dengan bantuan dan layanan GeoCrime untuk masyarakat.', 'art' => '🚓'],
                ] as $item)
                    <section class="w-full flex-none pt-4">
                        <div class="grid h-[360px] w-full place-items-center rounded-[2rem] bg-gradient-to-br from-blue-50 via-white to-rose-50 text-8xl">
                            {{ $item['art'] }}
                        </div>
                        <h1 class="mt-8 text-3xl font-extrabold text-slate-950">{{ $item['title'] }}</h1>
                        <p class="mt-3 max-w-xs text-sm leading-6 text-slate-500">{{ $item['desc'] }}</p>
                    </section>
                @endforeach
            </div>
        </div>

        <div class="absolute bottom-8 left-7 right-7 flex items-center justify-between">
            <div class="flex gap-2">
                <template x-for="i in total" :key="i">
                    <button type="button" class="h-1.5 rounded-full transition-all" :class="slide === i - 1 ? 'w-7 bg-[#3159d4]' : 'w-1.5 bg-slate-300'" @click="slide = i - 1"></button>
                </template>
            </div>
            <template x-if="slide < total - 1">
                <button type="button" class="grid h-11 w-11 place-items-center rounded-full bg-[#3159d4] text-white shadow-lg" @click="slide++">→</button>
            </template>
            <template x-if="slide === total - 1">
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-bold text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl px-4 py-3 text-sm font-bold text-slate-600">Daftar</a>
                </div>
            </template>
            <noscript>
                <a href="{{ route('login') }}" class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-bold text-white">Masuk</a>
            </noscript>
        </div>
    </main>
</x-pwa-layout>
