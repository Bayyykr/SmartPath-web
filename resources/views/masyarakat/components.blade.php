@php
    $navItems = [
        ['route' => 'masyarakat.home', 'icon' => 'home', 'label' => 'Home'],
        ['route' => 'masyarakat.laporan.index', 'icon' => 'report', 'label' => 'Lapor'],
        ['route' => 'masyarakat.sos', 'icon' => 'sos', 'label' => 'SOS', 'center' => true],
        ['route' => 'masyarakat.berita.index', 'icon' => 'news', 'label' => 'News'],
        ['route' => 'masyarakat.profile', 'icon' => 'profile', 'label' => 'Profil'],
    ];
@endphp

<style>
    .hidden { display: none !important; }

    .gc-bottom-nav,
    .gc-bottom-nav * { box-sizing: border-box; }

    .gc-bottom-nav {
        position: fixed;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 40;
        max-width: 430px;
        margin: 0 auto;
        border-top: 1px solid #f1f5f9;
        background: rgba(255, 255, 255, .96);
        padding: 10px 36px calc(env(safe-area-inset-bottom) + 12px);
        backdrop-filter: blur(12px);
    }

    .gc-bottom-nav-list {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .gc-bottom-nav-item {
        display: grid;
        width: 34px;
        height: 34px;
        place-items: center;
        border-radius: 999px;
        color: #111827;
        text-decoration: none;
    }

    .gc-bottom-nav-item svg {
        width: 17px;
        height: 17px;
    }

    .gc-bottom-nav-item.is-active {
        color: #253aa8;
    }

    .gc-bottom-nav-item.is-center {
        width: 38px;
        height: 38px;
        background: #253aa8;
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(37, 58, 168, .22);
    }
</style>

<nav class="gc-bottom-nav" aria-label="Navigasi PWA">
    <div class="gc-bottom-nav-list">
        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}" class="gc-bottom-nav-item{{ $active ? ' is-active' : '' }}{{ !empty($item['center']) ? ' is-center' : '' }}" aria-label="{{ $item['label'] }}">
                @switch($item['icon'])
                    @case('home')
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 10.8 12 4l8 6.8V20a1 1 0 0 1-1 1h-4.5v-6h-5v6H5a1 1 0 0 1-1-1v-9.2Z" /></svg>
                        @break
                    @case('report')
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 4h10a1.5 1.5 0 0 1 1.5 1.5v13A1.5 1.5 0 0 1 17 20H7a1.5 1.5 0 0 1-1.5-1.5v-13A1.5 1.5 0 0 1 7 4Z" stroke="currentColor" stroke-width="2"/><path d="M8.8 8h6.4M8.8 12h6.4M8.8 16h3.2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        @break
                    @case('sos')
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                        @break
                    @case('news')
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 5h14v14H5z" stroke="currentColor" stroke-width="2"/><path d="M8 9h8M8 13h8M8 17h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        @break
                    @default
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 8a7 7 0 0 1 14 0H5Z" /></svg>
                @endswitch
            </a>
        @endforeach
    </div>
</nav>
