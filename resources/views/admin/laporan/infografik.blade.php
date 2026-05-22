<x-admin-layout>
    <x-slot name="header">Infografik</x-slot>

    <div class="infographic-page">
        <section class="infographic-section">
            <form class="infographic-filter" method="GET" action="{{ route('admin.laporan.infografik') }}">
                <label for="bulan">Filter Bulan</label>
                <input id="bulan" name="bulan" type="month" value="{{ $selectedMonth }}">
                <input type="hidden" name="tanggal_mulai" value="{{ $startDate }}">
                <input type="hidden" name="tanggal_selesai" value="{{ $endDate }}">
                <button type="submit" title="Terapkan filter bulan">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
                </button>
            </form>

            <h2 class="infographic-title">Statistik</h2>
            <div class="infographic-chart infographic-line-chart">
                <canvas id="infografikStatistikChart"></canvas>
            </div>
        </section>

        <section class="infographic-section">
            <form class="infographic-filter" method="GET" action="{{ route('admin.laporan.infografik') }}">
                <label>Filter Tahun</label>
                <input type="hidden" name="bulan" value="{{ $selectedMonth }}">
                <input name="tanggal_mulai" type="date" value="{{ $startDate }}">
                <span class="text-gray-400">-</span>
                <input name="tanggal_selesai" type="date" value="{{ $endDate }}">
                <button type="submit" title="Terapkan filter tanggal">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" /></svg>
                </button>
            </form>

            <h2 class="infographic-title">Laporan per Kecamatan</h2>
            <div class="infographic-chart infographic-kecamatan-chart">
                <canvas id="infografikKecamatanChart"></canvas>
            </div>
        </section>

        <section class="infographic-section">
            <h2 class="infographic-title">Akumulasi Kasus per Kategori</h2>
            <div class="infographic-chart infographic-category-chart">
                <canvas id="infografikKategoriChart"></canvas>
            </div>
        </section>
    </div>

    <script id="infografik-chart-data" type="application/json">@json($chartData)</script>
</x-admin-layout>
