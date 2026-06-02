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

        .gc-art svg {
            display: block;
            width: 100%;
            max-width: 320px;
            height: 100%;
            max-height: 340px;
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
                <svg class="h-5 w-5" viewBox="0 0 28 28" fill="none" aria-hidden="true">
                    <path d="M6 5.5h16a1.5 1.5 0 0 1 1.5 1.5v15A1.5 1.5 0 0 1 22 23.5H6A1.5 1.5 0 0 1 4.5 22V7A1.5 1.5 0 0 1 6 5.5Z" stroke="#253269" stroke-width="2.2" />
                    <path d="M9 9.5h6.3c2.4 0 4.2 1.8 4.2 4.2 0 2.5-1.9 4.5-4.4 4.5H9v-3.1h5.7c.8 0 1.4-.6 1.4-1.4 0-.8-.6-1.3-1.4-1.3H12v1.5H9V9.5Z" fill="#253269" />
                </svg>
            </span>
            <span>GeoCrime</span>
        </header>

        <div class="gc-slider-window">
            <div class="gc-slider-track" data-slider-track>
                @foreach ($slides as $index => $item)
                    <section class="gc-slide">
                        <div class="gc-art">
                            @switch($item['type'])
                                @case('map')
                                    <svg class="h-full max-h-[340px] w-full max-w-[310px] drop-shadow-sm" viewBox="0 0 310 340" fill="none" aria-label="Ilustrasi peta pelacakan">
                                        <path d="M79 78 139 48l83 31 42-16v209l-64 27-82-33-65 31V99l26-21Z" fill="#EEEDE4" />
                                        <path d="m80 78 41 16 18-46 83 31-24 57 66-73v209l-64 27-31-78-51 45-65 31V99l27-21Z" fill="#E2E0D5" />
                                        <path d="M58 131c33 11 65 17 99 18 35 1 68-8 101-22" stroke="#C6C4B8" stroke-width="7" stroke-linecap="round" />
                                        <path d="M70 213c42-16 82-16 119 1 25 12 51 13 77 4" stroke="#C6C4B8" stroke-width="7" stroke-linecap="round" />
                                        <path d="M117 78c24 37 32 76 25 119-5 28-3 57 8 86" stroke="#C6C4B8" stroke-width="7" stroke-linecap="round" />
                                        <path d="M203 80c-14 33-22 66-24 100-2 38 4 75 19 111" stroke="#C6C4B8" stroke-width="7" stroke-linecap="round" />
                                        <rect x="93" y="59" width="36" height="68" rx="5" transform="rotate(20 93 59)" fill="#FFC72C" />
                                        <rect x="102" y="51" width="36" height="68" rx="5" transform="rotate(20 102 51)" fill="#FFB62E" />
                                        <rect x="107" y="115" width="86" height="37" rx="6" transform="rotate(4 107 115)" fill="#FDBA38" />
                                        <path d="M128 132h45" stroke="#FFE9A8" stroke-width="5" stroke-linecap="round" stroke-dasharray="2 9" />
                                        <rect x="219" y="81" width="31" height="85" rx="4" transform="rotate(8 219 81)" fill="#EF6F9A" />
                                        <rect x="233" y="100" width="29" height="88" rx="4" transform="rotate(8 233 100)" fill="#D94778" />
                                        <rect x="45" y="178" width="38" height="77" rx="4" transform="rotate(18 45 178)" fill="#F16A82" />
                                        <rect x="67" y="189" width="40" height="83" rx="4" transform="rotate(18 67 189)" fill="#E84968" />
                                        <rect x="207" y="189" width="43" height="71" rx="4" transform="rotate(-18 207 189)" fill="#5E78C9" />
                                        <rect x="226" y="183" width="43" height="71" rx="4" transform="rotate(-18 226 183)" fill="#324B9F" />
                                        <path d="M178 54h35" stroke="#4356A5" stroke-width="7" stroke-linecap="round" />
                                        <path d="M52 256h86" stroke="#33427F" stroke-width="8" stroke-linecap="round" />
                                        <path d="M62 272h80" stroke="#33427F" stroke-width="8" stroke-linecap="round" />
                                        <path d="M71 146c0 26-31 57-31 57S9 172 9 146a31 31 0 1 1 62 0Z" fill="#E84632" />
                                        <circle cx="40" cy="145" r="10" fill="white" />
                                    </svg>
                                    @break

                                @case('info')
                                    <svg class="h-full max-h-[340px] w-full max-w-[310px] drop-shadow-sm" viewBox="0 0 310 340" fill="none" aria-label="Ilustrasi informasi">
                                        <ellipse cx="156" cy="260" rx="92" ry="20" fill="#E9EDF7" />
                                        <rect x="94" y="70" width="112" height="132" rx="55" fill="#F7C23B" />
                                        <rect x="113" y="88" width="74" height="96" rx="37" fill="#fff" />
                                        <path d="M105 175c-11 23-23 45-41 67" stroke="#E7D9C8" stroke-width="28" stroke-linecap="round" />
                                        <path d="M211 162c24 20 36 43 38 74" stroke="#EF714F" stroke-width="29" stroke-linecap="round" />
                                        <path d="M88 242c20 13 41 23 64 29" stroke="#654FE4" stroke-width="34" stroke-linecap="round" />
                                        <path d="M81 228c22 17 45 29 72 36" stroke="#FFBE4D" stroke-width="16" stroke-linecap="round" />
                                        <path d="M151 272c22-4 43-1 64 10" stroke="#5F58E8" stroke-width="33" stroke-linecap="round" />
                                        <path d="M151 260c24-4 46-1 67 10" stroke="#B9B7FF" stroke-width="15" stroke-linecap="round" />
                                        <circle cx="214" cy="78" r="24" fill="#F37255" />
                                        <path d="M197 76c14-17 32-19 51-9" stroke="#24356C" stroke-width="7" stroke-linecap="round" />
                                        <path d="M219 101c-4 16-2 31 7 45" stroke="#24356C" stroke-width="12" stroke-linecap="round" />
                                        <path d="M204 121c30-2 55 8 76 29" stroke="#384DA8" stroke-width="24" stroke-linecap="round" />
                                        <path d="M214 118c25 3 47 14 67 33" stroke="#F7C23B" stroke-width="9" stroke-linecap="round" />
                                        <path d="M234 46h18v18h-18z" fill="#62C65B" transform="rotate(-9 234 46)" />
                                        <path d="M64 76h22v22H64z" fill="#96D151" transform="rotate(-8 64 76)" />
                                        <path d="M247 43h35v55h-35z" fill="#C6BBFF" transform="rotate(-7 247 43)" />
                                        <path d="M263 48h17v45h-17z" fill="#8977EA" transform="rotate(-7 263 48)" />
                                    </svg>
                                    @break

                                @case('sos')
                                    <svg class="h-full max-h-[340px] w-full max-w-[330px] drop-shadow-sm" viewBox="0 0 330 340" fill="none" aria-label="Ilustrasi SOS polisi">
                                        <ellipse cx="156" cy="266" rx="110" ry="21" fill="#E9EDF7" />
                                        <path d="M71 202c12-65 59-105 123-113 39-5 72 12 99 40" stroke="#2267BC" stroke-width="18" stroke-linecap="round" />
                                        <path d="M86 211h145c7 0 12 5 12 12v31H57v-14c0-16 13-29 29-29Z" fill="#3D92D9" />
                                        <path d="M111 139h69c24 0 45 15 53 38l9 27H82l12-44c2-12 8-21 17-21Z" fill="#2D7AC7" />
                                        <path d="M124 151h47c18 0 33 10 41 26l9 19H96l10-32c3-8 10-13 18-13Z" fill="#D9F2FF" />
                                        <circle cx="93" cy="254" r="32" fill="#2B5393" />
                                        <circle cx="93" cy="254" r="16" fill="#EEF2F7" />
                                        <circle cx="226" cy="254" r="32" fill="#2B5393" />
                                        <circle cx="226" cy="254" r="16" fill="#EEF2F7" />
                                        <path d="M55 169h-15" stroke="#EF4D54" stroke-width="9" stroke-linecap="round" />
                                        <path d="M49 154 36 143" stroke="#5676CE" stroke-width="9" stroke-linecap="round" />
                                        <path d="m60 190-13 12" stroke="#5676CE" stroke-width="9" stroke-linecap="round" />
                                        <path d="M173 122c14 3 27 1 39-6l8 24c-17 11-36 14-58 8l11-26Z" fill="#E94C48" />
                                        <circle cx="171" cy="110" r="22" fill="#F26355" />
                                        <path d="M152 104c6-23 25-29 49-19" stroke="#E94C48" stroke-width="12" stroke-linecap="round" />
                                        <path d="M215 113c31-3 53-18 66-45" stroke="#F15D50" stroke-width="16" stroke-linecap="round" />
                                        <path d="M286 77c18 29 27 64 27 105" stroke="#253269" stroke-width="25" stroke-linecap="round" />
                                        <path d="M282 68h38l8 22h-55l9-22Z" fill="#1F5DAE" />
                                        <path d="M279 95c10 15 25 19 43 10" stroke="#F1A18A" stroke-width="20" stroke-linecap="round" />
                                        <path d="M278 89c6-14 20-19 42-13" stroke="#253269" stroke-width="9" stroke-linecap="round" />
                                        <path d="M290 183c-7 30-18 57-35 81" stroke="#253269" stroke-width="24" stroke-linecap="round" />
                                        <path d="M306 184c-3 29-1 57 7 84" stroke="#253269" stroke-width="24" stroke-linecap="round" />
                                    </svg>
                                    @break

                                @default
                                    <svg class="h-full max-h-[325px] w-full max-w-[330px] drop-shadow-sm" viewBox="0 0 330 330" fill="none" aria-label="Ilustrasi selamat datang">
                                        <ellipse cx="160" cy="260" rx="106" ry="24" fill="#E9EDF7" />
                                        <path d="M49 162c27-51 71-82 132-92 45-8 85 4 121 34-31 8-52 30-63 66-13 42-44 67-94 74-45 6-78-4-96-31-10-15-10-32 0-51Z" fill="#9BE7DC" />
                                        <path d="M124 93h16v89h-16z" fill="#9FAFEB" />
                                        <path d="M151 65h26v117h-26z" fill="#5265C8" />
                                        <path d="M187 96h24v86h-24z" fill="#94A2E9" />
                                        <path d="M221 70h29v112h-29z" fill="#6B7DD6" />
                                        <path d="M258 116h21v66h-21z" fill="#B7BFF0" />
                                        <path d="M80 94c0 24-28 53-28 53S24 118 24 94a28 28 0 0 1 56 0Z" fill="#C84CE8" />
                                        <circle cx="52" cy="94" r="9" fill="white" />
                                        <path d="M277 92c13-9 26-9 39 0" stroke="#C84CE8" stroke-width="6" stroke-linecap="round" />
                                        <path d="M284 105c8-6 17-6 26 0" stroke="#C84CE8" stroke-width="5" stroke-linecap="round" />
                                        <path d="M118 220c19-32 51-48 96-48h47c19 0 34 15 34 34v24H128c-8 0-14-6-10-10Z" fill="#F7A146" />
                                        <path d="M159 180c18-22 44-34 78-34h16c12 0 23 6 29 17l16 27H146l13-10Z" fill="#F7C187" />
                                        <path d="M182 155h61c13 0 26 8 33 20l5 10H162l20-30Z" fill="#DDEEFF" />
                                        <path d="M105 228h208" stroke="#27366E" stroke-width="18" stroke-linecap="round" />
                                        <circle cx="154" cy="228" r="28" fill="#27366E" />
                                        <circle cx="154" cy="228" r="13" fill="#F7F9FC" />
                                        <circle cx="262" cy="228" r="28" fill="#27366E" />
                                        <circle cx="262" cy="228" r="13" fill="#F7F9FC" />
                                    </svg>
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
