@php
    $navItems = [
        ['route' => 'masyarakat.home', 'icon' => '⌂', 'label' => 'Home'],
        ['route' => 'masyarakat.laporan.index', 'icon' => '▣', 'label' => 'Lapor'],
        ['route' => 'masyarakat.sos', 'icon' => '✚', 'label' => 'SOS', 'center' => true],
        ['route' => 'masyarakat.berita.index', 'icon' => '▤', 'label' => 'News'],
        ['route' => 'masyarakat.profile', 'icon' => '♟', 'label' => 'Profil'],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-40 mx-auto max-w-md border-t border-slate-100 bg-white/95 px-6 pb-[calc(env(safe-area-inset-bottom)+14px)] pt-3 backdrop-blur">
    <div class="flex items-center justify-between">
        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}" class="flex h-11 w-11 items-center justify-center rounded-2xl text-xs font-bold transition {{ !empty($item['center']) ? 'bg-[#3159d4] text-white shadow-lg shadow-blue-200' : ($active ? 'bg-blue-50 text-[#3159d4]' : 'text-slate-900') }}" aria-label="{{ $item['label'] }}">
                {{ $item['icon'] }}
            </a>
        @endforeach
    </div>
</nav>
