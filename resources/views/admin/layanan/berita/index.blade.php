<x-admin-layout>
    <x-slot name="header">Kelola Berita</x-slot>

    @php
        $toastType = session('success') ? 'success' : (session('error') || $errors->any() ? 'error' : null);
        $toastMessage = session('success') ?: session('error') ?: ($errors->any() ? $errors->first() : null);
        $statusClass = ['published' => 'bg-green-100 text-green-700', 'draft' => 'bg-yellow-100 text-yellow-700'];
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

    <style>
        .berita-table {
            table-layout: fixed;
            width: 100%;
        }

        .berita-table th,
        .berita-table td {
            padding: 10px 8px;
            font-size: 12px;
            vertical-align: middle;
            overflow: hidden;
        }

        .berita-cell-ellipsis {
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .berita-cell-clamp {
            display: -webkit-box;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
        }

        .berita-table th:last-child,
        .berita-actions-cell {
            text-align: center;
            overflow: visible;
            white-space: normal;
        }

        .berita-actions {
            display: grid;
            grid-template-columns: repeat(2, 28px);
            justify-content: center;
            gap: 6px;
            width: max-content;
            margin: 0 auto;
        }

        .berita-actions form {
            display: contents;
        }

        .berita-actions .btn-edit,
        .berita-actions .btn-delete {
            width: 28px;
            height: 28px;
            padding: 0;
            flex: 0 0 28px;
            font-size: 12px;
            line-height: 1;
        }

        @media (max-width: 1024px) {
            .berita-table .hide-md {
                display: none;
            }
        }
    </style>

    <div class="master-page">
        <div class="master-toolbar">
            <button class="btn-primary" type="button" data-modal-target="create-berita-modal">+ Buat Berita Baru</button>

            <form id="berita-search-form" class="flex flex-wrap gap-2" method="GET" action="{{ route('admin.berita.index') }}">
                <input id="berita-search-input" class="master-search" name="search" value="{{ request('search') }}" placeholder="Cari judul..." autocomplete="off">
                <select id="berita-status-filter" class="form-select min-w-36" name="status">
                    <option value="">Status</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                </select>
            </form>
        </div>

        <div id="berita-results">
            <table class="master-table berita-table">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 27%;">
                    <col style="width: 13%;">
                    <col class="hide-md" style="width: 10%;">
                    <col style="width: 12%;">
                    <col style="width: 13%;">
                    <col style="width: 9%;">
                    <col style="width: 11%;">
                </colgroup>
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Judul Berita</th>
                        <th>Penulis</th>
                        <th class="hide-md">Kategori</th>
                        <th>Kecamatan</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="berita-cell-ellipsis font-semibold" title="{{ $item->judul }}">{{ $item->judul }}</div>
                                <div class="berita-cell-clamp text-xs text-gray-500" title="{{ $item->isi_berita }}">{{ $item->isi_berita }}</div>
                            </td>
                            <td><div class="berita-cell-ellipsis" title="{{ $item->penulis?->name ?? '-' }}">{{ $item->penulis?->name ?? '-' }}</div></td>
                            <td class="hide-md">Info Publik</td>
                            <td><div class="berita-cell-ellipsis" title="{{ $item->lokasi?->nama_lokasi ?? '-' }}">{{ $item->lokasi?->nama_lokasi ?? '-' }}</div></td>
                            <td>{{ $item->published_at?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="berita-actions-cell">
                                <div class="berita-actions">
                                    <button class="btn-edit" type="button" title="Edit Berita" data-modal-target="edit-berita-modal-{{ $item->id }}">✎</button>
                                    <button class="btn-edit" type="button" title="Lihat Detail" data-modal-target="detail-berita-modal-{{ $item->id }}">◉</button>
                                    @if ($item->status === 'published')
                                        <form method="POST" action="{{ route('admin.berita.draft', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn-edit" type="submit" title="Jadikan Draft">↺</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.berita.publish', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn-edit" type="submit" title="Publish">✓</button>
                                        </form>
                                    @endif
                                    <button class="btn-delete" type="button" title="Hapus" data-modal-target="delete-berita-modal-{{ $item->id }}">×</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-gray-500">Data berita belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $items->links() }}</div>

            <div id="create-berita-modal" class="modal-backdrop" hidden>
                <div class="modal-card">
                    <div class="modal-header">
                        <h2>Buat Berita Baru</h2>
                        <button type="button" data-modal-close="create-berita-modal">×</button>
                    </div>
                    <form class="modal-body space-y-4" method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('admin.layanan.berita.partials.fields', ['item' => $createItem])
                        <div class="modal-footer">
                            <button class="btn-secondary" type="button" data-modal-close="create-berita-modal">Batal</button>
                            <button class="btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            @foreach ($items as $item)
                <div id="edit-berita-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card">
                        <div class="modal-header">
                            <h2>Edit Berita</h2>
                            <button type="button" data-modal-close="edit-berita-modal-{{ $item->id }}">×</button>
                        </div>
                        <form class="modal-body space-y-4" method="POST" action="{{ route('admin.berita.update', $item) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.layanan.berita.partials.fields', ['item' => $item])
                            <div class="modal-footer">
                                <button class="btn-secondary" type="button" data-modal-close="edit-berita-modal-{{ $item->id }}">Batal</button>
                                <button class="btn-primary" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="detail-berita-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card">
                        <div class="modal-header">
                            <h2>{{ $item->judul }}</h2>
                            <button type="button" data-modal-close="detail-berita-modal-{{ $item->id }}">×</button>
                        </div>
                        <div class="modal-body space-y-3 text-sm text-gray-700">
                            @if ($item->foto)
                                <img class="max-h-64 w-full rounded-lg object-cover" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}">
                            @endif
                            <p class="text-xs text-gray-500">{{ $item->penulis?->name ?? '-' }} • {{ $item->lokasi?->nama_lokasi ?? '-' }} • {{ $item->published_at?->format('d/m/Y H:i') ?? 'Belum terbit' }}</p>
                            <p class="whitespace-pre-line">{{ $item->isi_berita }}</p>
                        </div>
                    </div>
                </div>

                <div id="delete-berita-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Hapus Berita</h2>
                            <button type="button" data-modal-close="delete-berita-modal-{{ $item->id }}">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="text-sm text-gray-600">Yakin ingin menghapus <strong>{{ $item->judul }}</strong>?</p>
                            <form class="modal-footer" method="POST" action="{{ route('admin.berita.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-secondary" type="button" data-modal-close="delete-berita-modal-{{ $item->id }}">Batal</button>
                                <button class="btn-delete-text" type="submit">Hapus</button>
                            </form>
                        </div>
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

        const beritaSearchForm = document.getElementById('berita-search-form');
        const beritaSearchInput = document.getElementById('berita-search-input');
        const beritaStatusFilter = document.getElementById('berita-status-filter');
        let beritaSearchTimer;
        let beritaSearchController;

        async function loadBeritaUrl(url, pushState = true) {
            beritaSearchController?.abort();
            beritaSearchController = new AbortController();
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: beritaSearchController.signal });
            const html = await response.text();
            const nextResults = new DOMParser().parseFromString(html, 'text/html').getElementById('berita-results');
            const currentResults = document.getElementById('berita-results');
            if (nextResults && currentResults) currentResults.innerHTML = nextResults.innerHTML;
            if (pushState) window.history.replaceState({}, '', url);
        }

        function buildBeritaUrl() {
            const url = new URL(beritaSearchForm.action, window.location.origin);
            const searchValue = beritaSearchInput.value.trim();
            const statusValue = beritaStatusFilter.value;
            if (searchValue) url.searchParams.set('search', searchValue);
            if (statusValue) url.searchParams.set('status', statusValue);
            return url.toString();
        }

        beritaSearchForm?.addEventListener('submit', (event) => event.preventDefault());
        beritaSearchInput?.addEventListener('input', function () {
            clearTimeout(beritaSearchTimer);
            beritaSearchTimer = setTimeout(() => loadBeritaUrl(buildBeritaUrl()).catch((error) => {
                if (error.name !== 'AbortError') console.error(error);
            }), 300);
        });
        beritaStatusFilter?.addEventListener('change', () => loadBeritaUrl(buildBeritaUrl()).catch((error) => {
            if (error.name !== 'AbortError') console.error(error);
        }));

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('#berita-results nav a');
            if (paginationLink) {
                event.preventDefault();
                loadBeritaUrl(paginationLink.href).catch((error) => {
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
