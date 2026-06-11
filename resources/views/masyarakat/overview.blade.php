<x-pwa-layout title="Overview">
    @php
        $slides = [
            [
                'title' => 'Pelacakan',
                'desc' => 'Melacak area yang rawan kejahatan dan kecelakaan serta melihat CCTV kota',
                'type' => 'map',
            ],
            [
                'title' => 'Informasi',
                'desc' => 'Membuat laporan dan mendapatkan semua informasi mengenai kejahatan dan kecelakaan',
                'type' => 'info',
            ],
            [
                'title' => 'SoS Button',
                'desc' => 'Siapkan tombol darurat Anda untuk dikirim ke polisi',
                'type' => 'sos',
            ],
            [
                'title' => 'Selamat datang!',
                'desc' => 'Terhubung dengan kami dan dapatkan waktu & hari kita di mana saja',
                'type' => 'welcome',
            ],
        ];
    @endphp

    <style>
        .hidden {
            display: none !important;
        }

        .gc-onboarding,
        .gc-onboarding * {
            box-sizing: border-box;
        }

        .gc-onboarding {
            position: relative;
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            overflow: hidden;
            background: #ffffff;
            padding: 32px 28px;
            color: #0f172a;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .gc-ring {
            pointer-events: none;
            position: absolute;
            border-radius: 999px;
            border-style: solid;
            border-color: rgba(241, 245, 249, .88);
        }

        .gc-ring-lg {
            left: -96px;
            top: 96px;
            width: 256px;
            height: 256px;
            border-width: 34px;
        }

        .gc-ring-sm {
            left: -48px;
            top: 160px;
            width: 144px;
            height: 144px;
            border-width: 22px;
        }

        .gc-brand {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: #1f2f63;
        }

        .gc-brand-icon {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            border: 2px solid #253269;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .08);
        }

        .gc-brand-icon svg {
            width: 20px;
            height: 20px;
        }

        .gc-slider-window {
            position: relative;
            z-index: 2;
            margin-top: 28px;
            overflow: hidden;
        }

        .gc-slider-track {
            display: flex;
            transition: transform .5s ease;
            will-change: transform;
        }

        .gc-slide {
            display: flex;
            flex: 0 0 100%;
            min-height: calc(100vh - 136px);
            flex-direction: column;
        }

        .gc-art {
            display: flex;
            height: 47vh;
            min-height: 315px;
            align-items: center;
            justify-content: center;
        }

        .gc-art svg,
        .gc-art img {
            display: block;
            width: 100%;
            max-width: 320px;
            height: 100%;
            max-height: 340px;
            object-fit: contain;
            filter: drop-shadow(0 1px 1px rgba(15, 23, 42, .04));
        }

        .gc-copy {
            margin-top: auto;
            padding-bottom: 96px;
        }

        .gc-copy.is-center {
            text-align: center;
        }

        .gc-title {
            margin: 0;
            color: #0f172a;
            font-size: 31px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.045em;
        }

        .gc-desc {
            max-width: 275px;
            margin: 12px 0 0;
            color: rgba(51, 65, 85, .82);
            font-size: 12px;
            line-height: 1.45;
            letter-spacing: -.02em;
        }

        .gc-copy.is-center .gc-desc {
            max-width: 230px;
            margin-right: auto;
            margin-left: auto;
        }

        .gc-bottom {
            position: absolute;
            right: 28px;
            bottom: 32px;
            left: 28px;
            z-index: 10;
        }

        .gc-nav {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .gc-dots {
            display: flex;
            height: 40px;
            align-items: center;
            gap: 6px;
        }

        .gc-dot {
            width: 6px;
            height: 6px;
            border: 0;
            border-radius: 999px;
            background: #cbd5e1;
            padding: 0;
            cursor: pointer;
            transition: width .25s ease, background .25s ease;
        }

        .gc-dot.is-active {
            width: 10px;
            background: #0f172a;
        }

        .gc-arrows {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .gc-arrow {
            display: grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border: 0;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            cursor: pointer;
            transition: opacity .2s ease, background .2s ease;
        }

        .gc-arrow svg {
            width: 16px;
            height: 16px;
        }

        .gc-arrow:disabled {
            pointer-events: none;
            opacity: 0;
        }

        .gc-arrow-next {
            background: #253aa8;
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(37, 58, 168, .18);
        }

        .gc-actions {
            display: none;
            gap: 12px;
        }

        .gc-actions.is-visible {
            display: block;
        }

        .gc-login,
        .gc-register {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            font-size: 12px;
        }

        .gc-login {
            border-radius: 6px;
            background: #242424;
            padding: 14px 16px;
            color: #ffffff;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(15, 23, 42, .10);
        }

        .gc-register {
            padding: 12px 16px 0;
            color: #475569;
            font-weight: 600;
        }

        .gc-hidden {
            display: none !important;
        }

        @media (max-height: 720px) {
            .gc-onboarding { padding-top: 22px; }
            .gc-slider-window { margin-top: 12px; }
            .gc-art { min-height: 260px; height: 42vh; }
            .gc-copy { padding-bottom: 82px; }
        }
    </style>

    <main class="gc-onboarding" data-onboarding>
        <div class="gc-ring gc-ring-lg"></div>
        <div class="gc-ring gc-ring-sm"></div>

        <header class="gc-brand">
            <span class="gc-brand-icon">
                <img src="/icons/icon_app.png" alt="SmartPath Logo" class="h-5 w-5 object-contain">
            </span>
            <span>SmartPath</span>
        </header>

        <div class="gc-slider-window">
            <div class="gc-slider-track" data-slider-track>
                @foreach ($slides as $index => $item)
                    <section class="gc-slide">
                        <div class="gc-art">
                            @switch($item['type'])
                                @case('map')
                                    <img src="{{ asset('overview_map.png') }}" alt="Ilustrasi peta pelacakan" class="h-full max-h-[340px] w-full max-w-[310px] drop-shadow-sm">
                                    @break

                                @case('info')
                                    <img src="{{ asset('overview_informasi.png') }}" alt="Ilustrasi informasi" class="h-full max-h-[340px] w-full max-w-[310px] drop-shadow-sm">
                                    @break

                                @case('sos')
                                    <img src="{{ asset('overview_sos.png') }}" alt="Ilustrasi SOS polisi" class="h-full max-h-[340px] w-full max-w-[330px] drop-shadow-sm">
                                    @break

                                @default
                                    <img src="{{ asset('overview_selamatdatang.png') }}" alt="Ilustrasi selamat datang" class="h-full max-h-[325px] w-full max-w-[330px] drop-shadow-sm">
                            @endswitch
                        </div>

                        <div class="gc-copy{{ $index === count($slides) - 1 ? ' is-center' : '' }}">
                            <h1 class="gc-title">{{ $item['title'] }}</h1>
                            <p class="gc-desc">{{ $item['desc'] }}</p>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>

        <div class="gc-bottom">
            <div class="gc-nav" data-slider-nav>
                <div class="gc-dots">
                    @foreach ($slides as $index => $item)
                        <button
                            type="button"
                            class="gc-dot{{ $index === 0 ? ' is-active' : '' }}"
                            data-slide-dot="{{ $index }}"
                            aria-label="Pindah ke slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>

                <div class="gc-arrows">
                    <button type="button" class="gc-arrow" data-slide-prev aria-label="Slide sebelumnya" disabled>
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button type="button" class="gc-arrow gc-arrow-next" data-slide-next aria-label="Slide berikutnya">
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="m7.5 5 5 5-5 5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="gc-actions" data-slider-actions>
                <a href="{{ route('pwa.login') }}" class="gc-login">Masuk</a>
                <a href="{{ route('pwa.register') }}" class="gc-register">Daftar</a>
            </div>

            <noscript>
                <div class="gc-actions is-visible">
                    <a href="{{ route('pwa.login') }}" class="gc-login">Masuk</a>
                    <a href="{{ route('pwa.register') }}" class="gc-register">Daftar</a>
                </div>
            </noscript>
        </div>
    </main>

    <script>
        (() => {
            const root = document.querySelector('[data-onboarding]');
            if (!root) return;

            const track = root.querySelector('[data-slider-track]');
            const nav = root.querySelector('[data-slider-nav]');
            const actions = root.querySelector('[data-slider-actions]');
            const dots = Array.from(root.querySelectorAll('[data-slide-dot]'));
            const prev = root.querySelector('[data-slide-prev]');
            const next = root.querySelector('[data-slide-next]');
            const total = dots.length;
            let slide = 0;

            const setSlide = (value) => {
                slide = Math.max(0, Math.min(value, total - 1));
                track.style.transform = `translateX(-${slide * 100}%)`;

                dots.forEach((dot, index) => {
                    dot.classList.toggle('is-active', index === slide);
                });

                if (prev) {
                    prev.disabled = slide === 0;
                }

                if (slide === total - 1) {
                    nav.classList.add('gc-hidden');
                    actions.classList.add('is-visible');
                } else {
                    nav.classList.remove('gc-hidden');
                    actions.classList.remove('is-visible');
                }
            };

            dots.forEach((dot) => {
                dot.addEventListener('click', () => setSlide(Number(dot.dataset.slideDot)));
            });

            prev?.addEventListener('click', () => setSlide(slide - 1));
            next?.addEventListener('click', () => setSlide(slide + 1));

            window.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowRight') setSlide(slide + 1);
                if (event.key === 'ArrowLeft') setSlide(slide - 1);
            });

            let touchStartX = 0;
            root.addEventListener('touchstart', (event) => {
                touchStartX = event.touches[0]?.clientX || 0;
            }, { passive: true });

            root.addEventListener('touchend', (event) => {
                const touchEndX = event.changedTouches[0]?.clientX || 0;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > 45) {
                    setSlide(slide + (diff > 0 ? 1 : -1));
                }
            }, { passive: true });

            setSlide(0);
        })();
    </script>
</x-pwa-layout>
