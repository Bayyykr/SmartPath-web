<x-admin-layout>
    <x-slot name="header">Riwayat Laporan</x-slot>

    @php
        $statusClass = [
            'selesai' => 'bg-gray-900 text-white',
            'arsip' => 'bg-gray-200 text-gray-800',
        ];
    @endphp

    <div class="report-page">
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-800">{{ session('success') }}</div>
        @endif

        <div class="report-hero">
            <div>
                <p class="report-eyebrow">Audit Trail</p>
                <h1>Riwayat Laporan</h1>
                <p>Arsip permanen laporan reguler yang sudah selesai dan laporan darurat yang telah ditangani. Data ini menjadi bahan evaluasi, laporan bulanan, dan analisis infografik.</p>
            </div>
            <div class="report-hero-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h7l5 5v11a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" /></svg>
            </div>
        </div>

        <div class="report-summary-grid">
            <div class="report-stat-card"><span>Total Arsip</span><strong>{{ number_format($summary['total']) }}</strong><small>Reguler selesai + SOS selesai</small></div>
            <div class="report-stat-card"><span>Masih Pending</span><strong>{{ number_format($summary['pending']) }}</strong><small>Masih di konfirmasi</small></div>
            <div class="report-stat-card"><span>Dikonfirmasi</span><strong>{{ number_format($summary['confirmed']) }}</strong><small>Dalam proses lapangan</small></div>
            <div class="report-stat-card"><span>Reguler Selesai</span><strong>{{ number_format($summary['done']) }}</strong><small>Masuk audit trail</small></div>
        </div>

        <form class="report-filter-card" method="GET" action="{{ route('admin.laporan.riwayat') }}">
            <div>
                <label class="form-label" for="search">Cari Arsip</label>
                <input id="search" class="form-input" name="search" value="{{ request('search') }}" placeholder="Kode, judul, pelapor, kategori, lokasi...">
            </div>
            <div>
                <label class="form-label" for="jenis">Jenis</label>
                <select id="jenis" class="form-select" name="jenis">
                    <option value="">Semua Jenis</option>
                    <option value="kejahatan" @selected(request('jenis') === 'kejahatan')>Kejahatan</option>
                    <option value="kecelakaan" @selected(request('jenis') === 'kecelakaan')>Kecelakaan</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="kategori_id">Kategori</label>
                <select id="kategori_id" class="form-select" name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) request('kategori_id') === (string) $category->id)>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="tanggal_mulai">Dari Tanggal</label>
                <input id="tanggal_mulai" class="form-input" type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
            </div>
            <div>
                <label class="form-label" for="tanggal_selesai">Sampai Tanggal</label>
                <input id="tanggal_selesai" class="form-input" type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="report-filter-actions">
                <a class="btn-secondary" href="{{ route('admin.laporan.riwayat') }}">Reset</a>
                <button class="btn-primary" type="submit">Terapkan</button>
            </div>
        </form>

        <div class="report-table-card">
            <div class="report-section-header">
                <div>
                    <h2>Audit Trail Laporan Reguler</h2>
                    <p>Laporan dari masyarakat yang sudah melewati konfirmasi dan selesai ditangani.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>Waktu</th>
                            <th>Pelapor</th>
                            <th>Kejadian & Lokasi</th>
                            <th>Status Akhir</th>
                            <th>Petugas / Polsek</th>
                            <th width="90">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            @php($kodeLaporan = 'REP-' . $item->created_at?->format('Ym') . '-' . str_pad((string) $item->id, 3, '0', STR_PAD_LEFT))
                            <tr>
                                <td><strong>{{ $kodeLaporan }}</strong></td>
                                <td>
                                    <div><span class="text-gray-500">Melapor:</span> {{ $item->created_at?->format('d/m/Y H:i') }}</div>
                                    <div class="text-xs text-gray-500">Kejadian: {{ $item->created_at?->format('d/m/Y H:i') }} <span class="italic">(field khusus belum tersedia)</span></div>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ $item->user?->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user?->telepon ?? $item->user?->email ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ $item->kategori?->nama_kategori ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->lokasi?->nama_lokasi ?? '-' }} • {{ $item->polsek?->nama ?? '-' }}</div>
                                    <div class="max-w-[260px] truncate text-xs text-gray-500">{{ $item->deskripsi ?: '-' }}</div>
                                </td>
                                <td><span class="rounded-full px-2 py-1 text-xs font-bold {{ $statusClass[$item->status] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($item->status) }}</span></td>
                                <td>
                                    <div>{{ $item->konfirmasi?->petugas?->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->konfirmasi?->dikonfirmasi_pada?->format('d/m/Y H:i') ?? '-' }}</div>
                                </td>
                                <td><button class="btn-edit" type="button" data-modal-target="riwayat-detail-{{ $item->id }}">◉</button></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-gray-500">Belum ada laporan reguler yang selesai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $items->links() }}</div>
        </div>

        <div class="report-table-card mt-6">
            <div class="report-section-header">
                <div>
                    <h2>Arsip Laporan Darurat / SOS</h2>
                    <p>SOS yang telah diselesaikan petugas otomatis menetap di sini sebagai rekam jejak.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th>ID Darurat</th>
                            <th>Waktu SOS</th>
                            <th>Pelapor</th>
                            <th>Koordinat & Polsek</th>
                            <th>Response</th>
                            <th>Catatan Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($emergencyArchives as $item)
                            <tr>
                                <td><strong class="text-gray-950">{{ $item->kode_darurat }}</strong></td>
                                <td>
                                    <div>{{ $item->waktu_sos?->format('d/m/Y H:i:s') ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">Selesai: {{ $item->waktu_selesai?->format('d/m/Y H:i:s') ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ $item->user?->name ?? 'Pelapor tidak login' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user?->telepon ?? $item->user?->email ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="font-mono text-xs">{{ $item->latitude }}, {{ $item->longitude }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->nearestPolsek?->nama ?? '-' }} {{ $item->jarak_polsek_km !== null ? '• ' . $item->jarak_polsek_km . ' km' : '' }}</div>
                                </td>
                                <td>
                                    <div>{{ $item->response_time_minutes !== null ? $item->response_time_minutes . ' menit' : '-' }}</div>
                                    <div class="text-xs text-gray-500">Petugas: {{ $item->petugas_penanganan ?: '-' }}</div>
                                </td>
                                <td><div class="max-w-[320px] whitespace-pre-line text-sm">{{ $item->catatan_petugas ?: '-' }}</div></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-gray-500">Belum ada arsip laporan darurat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($items as $item)
        @php($kodeLaporan = 'REP-' . $item->created_at?->format('Ym') . '-' . str_pad((string) $item->id, 3, '0', STR_PAD_LEFT))
        <div id="riwayat-detail-{{ $item->id }}" class="modal-backdrop" hidden>
            <div class="modal-card">
                <div class="modal-header">
                    <h2>Detail Audit {{ $kodeLaporan }}</h2>
                    <button type="button" data-modal-close="riwayat-detail-{{ $item->id }}">×</button>
                </div>
                <div class="modal-body space-y-4 text-sm text-gray-700">
                    @if ($item->foto_kejadian)
                        <img class="max-h-72 w-full rounded-xl object-cover" src="{{ asset('storage/' . $item->foto_kejadian) }}" alt="File bukti laporan">
                    @endif
                    <div class="grid gap-4 md:grid-cols-2">
                        <p><strong>ID Laporan:</strong><br>{{ $kodeLaporan }}</p>
                        <p><strong>Waktu Melapor:</strong><br>{{ $item->created_at?->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Nama Pelapor:</strong><br>{{ $item->user?->name ?? '-' }}<br><span class="text-gray-500">{{ $item->user?->telepon ?? $item->user?->email ?? '-' }}</span></p>
                        <p><strong>Kategori Kejadian:</strong><br>{{ $item->kategori?->nama_kategori ?? '-' }}<br><span class="capitalize text-gray-500">{{ $item->kategori?->jenis ?? '-' }}</span></p>
                        <p><strong>Lokasi Administratif:</strong><br>{{ $item->lokasi?->nama_lokasi ?? '-' }}<br><span class="text-gray-500">{{ $item->polsek?->nama ?? '-' }}</span></p>
                        <p><strong>Koordinat Geografis:</strong><br>{{ $item->latitude ?? '-' }}, {{ $item->longitude ?? '-' }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-50 p-4">
                        <strong>{{ $item->judul_laporan }}</strong>
                        <p class="mt-1 whitespace-pre-line">{{ $item->deskripsi ?: '-' }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-100 p-4 text-gray-900">
                        <strong>Status & Log Penanganan</strong>
                        <p class="mt-1">Status akhir: {{ ucfirst($item->status) }}</p>
                        <p>Petugas: {{ $item->konfirmasi?->petugas?->name ?? '-' }}</p>
                        <p>Catatan akhir: {{ $item->konfirmasi?->catatan ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('click', function (event) {
            const targetId = event.target.closest('[data-modal-target]')?.dataset.modalTarget;
            if (targetId) document.getElementById(targetId)?.removeAttribute('hidden');

            const closeId = event.target.closest('[data-modal-close]')?.dataset.modalClose;
            if (closeId) document.getElementById(closeId)?.setAttribute('hidden', true);

            if (event.target.classList.contains('modal-backdrop')) event.target.setAttribute('hidden', true);
        });
    </script>
</x-admin-layout>
