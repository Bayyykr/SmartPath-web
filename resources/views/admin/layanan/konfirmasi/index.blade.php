<x-admin-layout>
    <x-slot name="header">Konfirmasi Laporan</x-slot>

    @php
        $toastType = session('success') ? 'success' : (session('error') || $errors->any() ? 'error' : null);
        $toastMessage = session('success') ?: session('error') ?: ($errors->any() ? $errors->first() : null);
        $statusClass = [
            'pending' => 'bg-yellow-100 text-yellow-700',
            'dikonfirmasi' => 'bg-green-100 text-green-700',
            'ditolak' => 'bg-red-100 text-red-700',
            'selesai' => 'bg-blue-100 text-blue-700',
        ];
    @endphp

    @if ($toastType && $toastMessage)
        <div class="toast-notification {{ $toastType }}" data-toast>
            <div class="toast-icon">{{ $toastType === 'success' ? '✓' : '!' }}</div>
            <div>
                <p class="toast-title">{{ $toastType === 'success' ? 'Berhasil' : 'Gagal' }}</p>
                <p class="toast-message">{{ $toastMessage }}</p>
            </div>
            <button type="button" data-toast-close aria-label="Tutup notifikasi">×</button>
        </div>
    @endif

    <div class="master-page">
        <div class="master-toolbar">
            <form id="konfirmasi-search-form" class="flex flex-wrap gap-2" method="GET" action="{{ route('admin.konfirmasi-laporan.index') }}">
                <input id="konfirmasi-search-input" class="master-search" name="search" value="{{ request('search') }}" placeholder="Cari" autocomplete="off">
                <select id="konfirmasi-status-filter" class="form-select min-w-40" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="dikonfirmasi" @selected(request('status') === 'dikonfirmasi')>Dikonfirmasi</option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                    <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                </select>
            </form>
            <a class="btn-primary" href="{{ route('admin.konfirmasi-laporan.export', request()->query()) }}">Export</a>
        </div>

        <div id="konfirmasi-results">
            <table class="master-table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Pengirim</th>
                        <th>Kategori</th>
                        <th>No HP</th>
                        <th>Kecamatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="font-semibold">{{ $item->user?->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $item->user?->email ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="font-semibold">{{ $item->kategori?->nama_kategori ?? '-' }}</div>
                                <div class="max-w-[220px] truncate text-xs text-gray-500">{{ $item->judul_laporan }}</div>
                            </td>
                            <td>{{ $item->user?->telepon ?? '-' }}</td>
                            <td>{{ $item->lokasi?->nama_lokasi ?? $item->polsek?->nama ?? '-' }}</td>
                            <td>{{ $item->created_at?->format('d/m/Y, h:i A') }}</td>
                            <td>
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="space-x-1 whitespace-nowrap">
                                <button class="btn-edit" type="button" title="Detail" data-modal-target="detail-laporan-modal-{{ $item->id }}">◉</button>
                                <button class="btn-edit" type="button" title="Konfirmasi" data-modal-target="konfirmasi-laporan-modal-{{ $item->id }}">✓</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-gray-500">Data laporan belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-4">{{ $items->links() }}</div>

            @foreach ($items as $item)
                <div id="detail-laporan-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card">
                        <div class="modal-header">
                            <h2>Detail Laporan</h2>
                            <button type="button" data-modal-close="detail-laporan-modal-{{ $item->id }}">×</button>
                        </div>
                        <div class="modal-body space-y-3 text-sm text-gray-700">
                            @if ($item->foto_kejadian)
                                <img class="max-h-64 w-full rounded-lg object-cover" src="{{ asset('storage/' . $item->foto_kejadian) }}" alt="Foto kejadian">
                            @endif
                            <div class="grid gap-3 md:grid-cols-2">
                                <p><strong>Pengirim:</strong><br>{{ $item->user?->name ?? '-' }} ({{ $item->user?->email ?? '-' }})</p>
                                <p><strong>No HP:</strong><br>{{ $item->user?->telepon ?? '-' }}</p>
                                <p><strong>Kategori:</strong><br>{{ $item->kategori?->nama_kategori ?? '-' }}</p>
                                <p><strong>Kecamatan:</strong><br>{{ $item->lokasi?->nama_lokasi ?? '-' }}</p>
                                <p><strong>Polsek:</strong><br>{{ $item->polsek?->nama ?? '-' }}</p>
                                <p><strong>Koordinat:</strong><br>{{ $item->latitude ?? '-' }}, {{ $item->longitude ?? '-' }}</p>
                            </div>
                            <div>
                                <strong>{{ $item->judul_laporan }}</strong>
                                <p class="mt-1 whitespace-pre-line">{{ $item->deskripsi ?: '-' }}</p>
                            </div>
                            @if ($item->konfirmasi)
                                <div class="rounded-lg bg-gray-50 p-3">
                                    <strong>Catatan konfirmasi:</strong>
                                    <p>{{ $item->konfirmasi->catatan ?: '-' }}</p>
                                    <p class="mt-1 text-xs text-gray-500">Petugas: {{ $item->konfirmasi->petugas?->name ?? '-' }} • {{ $item->konfirmasi->dikonfirmasi_pada?->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div id="konfirmasi-laporan-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Konfirmasi Laporan</h2>
                            <button type="button" data-modal-close="konfirmasi-laporan-modal-{{ $item->id }}">×</button>
                        </div>
                        <form class="modal-body space-y-4" method="POST" action="{{ route('admin.konfirmasi-laporan.update', $item) }}">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="form-label" for="status-{{ $item->id }}">Status</label>
                                <select id="status-{{ $item->id }}" class="form-select" name="status" required>
                                    <option value="dikonfirmasi" @selected($item->status === 'dikonfirmasi')>Dikonfirmasi</option>
                                    <option value="ditolak" @selected($item->status === 'ditolak')>Ditolak</option>
                                    <option value="selesai" @selected($item->status === 'selesai')>Selesai</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="catatan-{{ $item->id }}">Catatan</label>
                                <textarea id="catatan-{{ $item->id }}" class="form-input" name="catatan" rows="4">{{ old('catatan', $item->konfirmasi?->catatan) }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn-secondary" type="button" data-modal-close="konfirmasi-laporan-modal-{{ $item->id }}">Batal</button>
                                <button class="btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function resetAndCloseModal(modal) {
            if (!modal) return;
            modal.querySelectorAll('form').forEach((form) => form.reset());
            modal.setAttribute('hidden', true);
        }

        const konfirmasiSearchForm = document.getElementById('konfirmasi-search-form');
        const konfirmasiSearchInput = document.getElementById('konfirmasi-search-input');
        const konfirmasiStatusFilter = document.getElementById('konfirmasi-status-filter');
        let konfirmasiSearchTimer;
        let konfirmasiSearchController;

        async function loadKonfirmasiUrl(url, pushState = true) {
            konfirmasiSearchController?.abort();
            konfirmasiSearchController = new AbortController();
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: konfirmasiSearchController.signal });
            const html = await response.text();
            const nextResults = new DOMParser().parseFromString(html, 'text/html').getElementById('konfirmasi-results');
            const currentResults = document.getElementById('konfirmasi-results');
            if (nextResults && currentResults) currentResults.innerHTML = nextResults.innerHTML;
            if (pushState) window.history.replaceState({}, '', url);
        }

        function buildKonfirmasiUrl() {
            const url = new URL(konfirmasiSearchForm.action, window.location.origin);
            const searchValue = konfirmasiSearchInput.value.trim();
            const statusValue = konfirmasiStatusFilter.value;
            if (searchValue) url.searchParams.set('search', searchValue);
            if (statusValue) url.searchParams.set('status', statusValue);
            return url.toString();
        }

        konfirmasiSearchForm?.addEventListener('submit', (event) => event.preventDefault());
        konfirmasiSearchInput?.addEventListener('input', function () {
            clearTimeout(konfirmasiSearchTimer);
            konfirmasiSearchTimer = setTimeout(() => loadKonfirmasiUrl(buildKonfirmasiUrl()).catch((error) => {
                if (error.name !== 'AbortError') console.error(error);
            }), 300);
        });
        konfirmasiStatusFilter?.addEventListener('change', () => loadKonfirmasiUrl(buildKonfirmasiUrl()).catch((error) => {
            if (error.name !== 'AbortError') console.error(error);
        }));

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('#konfirmasi-results nav a');
            if (paginationLink) {
                event.preventDefault();
                loadKonfirmasiUrl(paginationLink.href).catch((error) => {
                    if (error.name !== 'AbortError') console.error(error);
                });
                return;
            }
            const targetId = event.target.closest('[data-modal-target]')?.dataset.modalTarget;
            if (targetId) document.getElementById(targetId)?.removeAttribute('hidden');
            const closeId = event.target.closest('[data-modal-close]')?.dataset.modalClose;
            if (closeId) resetAndCloseModal(document.getElementById(closeId));
            if (event.target.classList.contains('modal-backdrop')) resetAndCloseModal(event.target);
            if (event.target.closest('[data-toast-close]')) event.target.closest('[data-toast]')?.remove();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') document.querySelectorAll('.modal-backdrop:not([hidden])').forEach(resetAndCloseModal);
        });
        document.querySelectorAll('[data-toast]').forEach((toast) => setTimeout(() => toast.remove(), 4500));
    </script>
</x-admin-layout>
