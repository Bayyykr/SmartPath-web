<x-admin-layout>
    <x-slot name="header">Dashboard</x-slot>

    <script id="dashboard-chart-data" type="application/json">@json($chartData)</script>
    <script id="dashboard-map-data" type="application/json">@json($mapData)</script>

    <div class="dashboard-content">
        <section class="map-panel">
            <button class="map-filter" type="button" aria-label="Filter map">
                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 0 1 1-1h12a1 1 0 0 1 .8 1.6L12 11v4a1 1 0 0 1-.553.894l-3 1.5A1 1 0 0 1 7 16.5V11L3.2 4.6A1 1 0 0 1 3 4Z" />
                </svg>
            </button>
            <div id="map"></div>
        </section>

        <section class="stats-grid">
            <div class="card">
                <h3 class="card-title">Tren Laporan Tahun Ini</h3>
                <div class="chart-box">
                    <canvas id="statistikChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">Lokasi Laporan Terbanyak</h3>
                <div class="chart-box">
                    <canvas id="laporanChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">Kategori Dominan</h3>
                <div class="chart-box">
                    <canvas id="kejahatanKecelakaanChart"></canvas>
                </div>
            </div>
        </section>
    </div>
</x-admin-layout>
