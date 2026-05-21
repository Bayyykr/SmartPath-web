<x-admin-layout>
    <x-slot name="header">Kategori</x-slot>

    @php
        $toastType = session('success') ? 'success' : (session('error') || $errors->any() ? 'error' : null);
        $toastMessage = session('success') ?: session('error') ?: ($errors->any() ? $errors->first() : null);
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
        <div class="mb-5 flex flex-wrap gap-2">
            <a class="tab-link {{ $jenis === 'kejahatan' ? 'active' : '' }}" href="{{ route('admin.categories.index', ['jenis' => 'kejahatan']) }}">Kejahatan</a>
            <a class="tab-link {{ $jenis === 'kecelakaan' ? 'active' : '' }}" href="{{ route('admin.categories.index', ['jenis' => 'kecelakaan']) }}">Kecelakaan</a>
        </div>

        <div class="master-toolbar">
            <form id="kategori-search-form" method="GET" action="{{ route('admin.categories.index') }}">
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <input
                    id="kategori-search-input"
                    class="master-search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kategori atau warna..."
                    autocomplete="off">
            </form>
            <button class="btn-primary" type="button" data-modal-target="create-kategori-modal">Tambah Kategori</button>
        </div>

        <div id="kategori-results">
            <table class="master-table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th>Jenis</th>
                        <th>Warna Marker</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $items->firstItem() + $loop->index }}</td>
                            <td class="font-semibold">{{ $item->nama_kategori }}</td>
                            <td>{{ ucfirst($item->jenis) }}</td>
                            <td>
                                <span class="inline-flex items-center gap-2">
                                    <input class="h-5 w-5 rounded border border-gray-300 bg-white p-0" type="color" value="{{ $item->warna_marker }}" disabled aria-label="Warna marker {{ $item->nama_kategori }}">
                                    <span>{{ $item->warna_marker }}</span>
                                </span>
                            </td>
                            <td class="space-x-1 whitespace-nowrap">
                                <button class="btn-edit" type="button" data-modal-target="edit-kategori-modal-{{ $item->id }}">✎</button>
                                <button class="btn-delete" type="button" data-modal-target="delete-kategori-modal-{{ $item->id }}">×</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-500">Data kategori belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $items->links() }}</div>

            <div id="create-kategori-modal" class="modal-backdrop" hidden>
                <div class="modal-card modal-card-sm">
                    <div class="modal-header">
                        <h2>Tambah Kategori</h2>
                        <button type="button" data-modal-close="create-kategori-modal">×</button>
                    </div>
                    <form class="modal-body space-y-4" method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        @include('admin.master.kategori.partials.fields', ['item' => null, 'jenis' => $jenis])
                        <div class="modal-footer">
                            <button class="btn-secondary" type="button" data-modal-close="create-kategori-modal">Batal</button>
                            <button class="btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            @foreach ($items as $item)
                <div id="edit-kategori-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Edit Kategori</h2>
                            <button type="button" data-modal-close="edit-kategori-modal-{{ $item->id }}">×</button>
                        </div>
                        <form class="modal-body space-y-4" method="POST" action="{{ route('admin.categories.update', $item) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.master.kategori.partials.fields', ['item' => $item, 'jenis' => $jenis])
                            <div class="modal-footer">
                                <button class="btn-secondary" type="button" data-modal-close="edit-kategori-modal-{{ $item->id }}">Batal</button>
                                <button class="btn-primary" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="delete-kategori-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Hapus Kategori</h2>
                            <button type="button" data-modal-close="delete-kategori-modal-{{ $item->id }}">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="text-sm text-gray-600">Yakin ingin menghapus <strong>{{ $item->nama_kategori }}</strong>?</p>
                            <form class="modal-footer" method="POST" action="{{ route('admin.categories.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-secondary" type="button" data-modal-close="delete-kategori-modal-{{ $item->id }}">Batal</button>
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

        function syncColorInputs(scope = document) {
            scope.querySelectorAll('[data-color-picker]').forEach((picker) => {
                const wrapper = picker.closest('div');
                const textInput = wrapper?.querySelector('[data-color-text]');

                if (!textInput) return;

                picker.addEventListener('input', () => {
                    textInput.value = picker.value.toUpperCase();
                });

                textInput.addEventListener('input', () => {
                    if (/^#[0-9A-Fa-f]{6}$/.test(textInput.value)) {
                        picker.value = textInput.value;
                    }
                });
            });
        }

        const kategoriSearchForm = document.getElementById('kategori-search-form');
        const kategoriSearchInput = document.getElementById('kategori-search-input');
        let kategoriSearchTimer;
        let kategoriSearchController;

        async function loadKategoriUrl(url, pushState = true) {
            kategoriSearchController?.abort();
            kategoriSearchController = new AbortController();

            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: kategoriSearchController.signal,
            });

            const html = await response.text();
            const nextDocument = new DOMParser().parseFromString(html, 'text/html');
            const nextResults = nextDocument.getElementById('kategori-results');
            const currentResults = document.getElementById('kategori-results');

            if (nextResults && currentResults) {
                currentResults.innerHTML = nextResults.innerHTML;
                syncColorInputs(currentResults);
            }

            if (pushState) {
                window.history.replaceState({}, '', url);
            }
        }

        kategoriSearchForm?.addEventListener('submit', function (event) {
            event.preventDefault();
        });

        kategoriSearchInput?.addEventListener('input', function () {
            clearTimeout(kategoriSearchTimer);

            kategoriSearchTimer = setTimeout(() => {
                const url = new URL(kategoriSearchForm.action, window.location.origin);
                const searchValue = kategoriSearchInput.value.trim();
                const jenisValue = kategoriSearchForm.querySelector('[name="jenis"]')?.value;

                if (jenisValue) {
                    url.searchParams.set('jenis', jenisValue);
                }

                if (searchValue) {
                    url.searchParams.set('search', searchValue);
                }

                loadKategoriUrl(url.toString()).catch((error) => {
                    if (error.name !== 'AbortError') console.error(error);
                });
            }, 300);
        });

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('#kategori-results nav a');
            if (paginationLink) {
                event.preventDefault();
                loadKategoriUrl(paginationLink.href).catch((error) => {
                    if (error.name !== 'AbortError') console.error(error);
                });
                return;
            }

            const targetId = event.target.closest('[data-modal-target]')?.dataset.modalTarget;
            if (targetId) {
                document.getElementById(targetId)?.removeAttribute('hidden');
            }

            const closeId = event.target.closest('[data-modal-close]')?.dataset.modalClose;
            if (closeId) {
                resetAndCloseModal(document.getElementById(closeId));
            }

            if (event.target.classList.contains('modal-backdrop')) {
                resetAndCloseModal(event.target);
            }

            if (event.target.closest('[data-toast-close]')) {
                event.target.closest('[data-toast]')?.remove();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.modal-backdrop:not([hidden])').forEach(resetAndCloseModal);
            }
        });

        document.querySelectorAll('[data-toast]').forEach((toast) => {
            setTimeout(() => toast.remove(), 4500);
        });

        syncColorInputs();
    </script>
</x-admin-layout>
