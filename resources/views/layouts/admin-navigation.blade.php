<nav class="sidebar">
    <div class="flex items-center gap-2 px-5 pt-8 pb-6">
        <div class="w-8 h-8 rounded border-2 border-gray-900 flex items-center justify-center">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16v16H4z" />
                <path d="M8 8h4a4 4 0 1 1 0 8H8z" />
                <path d="M8 12h8" />
            </svg>
        </div>
        <span class="text-sm font-bold text-gray-950">GeoCrime</span>
    </div>

    <div>
        <div class="category-title">Menu</div>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h14V10" /></svg>
            <span>Dashboard</span>
        </a>

        <details class="sidebar-dropdown" open>
            <summary class="category-title cursor-pointer select-none flex items-center justify-between">
                <span>Master Data</span>
                <span class="text-gray-400">▾</span>
            </summary>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-7 9a7 7 0 0 1 14 0" /></svg>
                <span>Users</span>
            </a>
            <a href="{{ route('admin.polseks.index') }}" class="sidebar-link {{ request()->routeIs('admin.polseks.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 21h16M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1" /></svg>
                <span>Polsek</span>
            </a>
            <a href="{{ route('admin.categories.index', ['tipe' => 'kejahatan']) }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.cctvs.index') }}" class="sidebar-link {{ request()->routeIs('admin.cctvs.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l5-3v10l-5-3v-4ZM4 7h11v10H4z" /></svg>
                <span>CCTV</span>
            </a>
            <a href="{{ route('admin.locations.index') }}" class="sidebar-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s7-4.438 7-11a7 7 0 1 0-14 0c0 6.562 7 11 7 11Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" /></svg>
                <span>Lokasi</span>
            </a>
        </details>

        <details class="sidebar-dropdown" open>
            <summary class="category-title cursor-pointer select-none flex items-center justify-between">
                <span>Layanan</span>
                <span class="text-gray-400">▾</span>
            </summary>
            <a href="#" class="sidebar-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" /></svg>
                <span>Konfirmasi</span>
            </a>
            <a href="#" class="sidebar-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10l6 6v8a2 2 0 0 1-2 2Z" /></svg>
                <span>Berita</span>
            </a>
        </details>


        <details class="sidebar-dropdown">
            <summary class="category-title cursor-pointer select-none flex items-center justify-between">
                <span>Laporan</span>
                <span class="text-gray-400">▾</span>
            </summary>
            <a href="#" class="sidebar-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V5m0 14h16M8 16V9m4 7V6m4 10v-4" /></svg>
                <span>Infografik</span>
            </a>
            <a href="#" class="sidebar-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v5l3 2M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z" /></svg>
                <span>Riwayat</span>
            </a>
            <a href="#" class="sidebar-link">
                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.72-1.36 3.486 0l6.518 11.59c.75 1.334-.213 2.986-1.743 2.986H3.482c-1.53 0-2.493-1.652-1.743-2.986l6.518-11.59ZM11 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-1-2a1 1 0 0 0 1-1V8a1 1 0 1 0-2 0v3a1 1 0 0 0 1 1Z" clip-rule="evenodd" /></svg>
                <span>Darurat</span>
            </a>
        </details>
    </div>
</nav>
