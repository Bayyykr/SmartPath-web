<x-admin-layout>
    <x-slot name="header">CCTV Real-time Lumajang</x-slot>

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

    <div class="cctv-page">
        <div class="cctv-topbar">
            <div>
                <h1 class="text-xl font-bold text-gray-950">Daftar CCTV Real-time Kabupaten Lumajang</h1>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-2">
                <form id="cctv-search-form" class="cctv-search" method="GET" action="{{ route('admin.cctvs.index') }}">
                    <input
                        id="cctv-search-input"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search"
                        autocomplete="off">
                    <button type="submit" aria-label="Cari CCTV">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                        </svg>
                    </button>
                </form>
                <a class="cctv-action-btn" href="{{ route('admin.cctvs.index') }}">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 0 1 1-1h12a1 1 0 0 1 .8 1.6L12 11v4a1 1 0 0 1-.553.894l-3 1.5A1 1 0 0 1 7 16.5V11L3.2 4.6A1 1 0 0 1 3 4Z" />
                    </svg>
                    Reset
                </a>
                <button class="cctv-action-btn secondary" type="button" data-modal-target="create-cctv-modal">+ CCTV</button>
            </div>
        </div>

        <div id="cctv-results">
            <div class="cctv-grid">
                @forelse ($items as $item)
                    <article class="cctv-card">
                        <div class="cctv-stream">
                            @if ($item->embed_url)
                                <iframe
                                    src="{{ $item->embed_url }}"
                                    title="Live Streaming {{ $item->nama }}"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            @else
                                <div class="cctv-empty-preview">
                                    <svg width="34" height="34" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l5-3v10l-5-3v-4ZM4 7h11v10H4z" />
                                    </svg>
                                    <span>Link live streaming belum diisi</span>
                                </div>
                            @endif

                            <span class="cctv-live-badge">
                                <span></span>
                                {{ $item->aktif ? 'LIVE' : 'OFF' }}
                            </span>
                            <span class="cctv-time">{{ now()->format('d/m/Y, h:i:s A') }}</span>
                        </div>

                        <div class="cctv-card-footer">
                            <div class="min-w-0">
                                <a class="cctv-title-link" href="{{ route('admin.cctvs.show', $item) }}">{{ $item->nama }}</a>
                                <p>{{ $item->keterangan ?: ($item->lokasi?->nama_lokasi ?? ($item->aktif ? 'Online' : 'Nonaktif')) }}</p>
                            </div>
                            <div class="cctv-card-actions">
                                <button type="button" title="Edit CCTV" data-modal-target="edit-cctv-modal-{{ $item->id }}">✎</button>
                                <button type="button" title="Hapus CCTV" data-modal-target="delete-cctv-modal-{{ $item->id }}">×</button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="cctv-empty-state">
                        <h2>Data CCTV belum tersedia</h2>
                        <p>Tambahkan data CCTV terlebih dahulu, lalu isi URL live streaming dan keterangan posisi CCTV.</p>
                        <button class="btn-primary" type="button" data-modal-target="create-cctv-modal">Tambah CCTV</button>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $items->links() }}</div>

            <div id="create-cctv-modal" class="modal-backdrop" hidden>
                <div class="modal-card modal-card-sm">
                    <div class="modal-header">
                        <h2>Tambah CCTV</h2>
                        <button type="button" data-modal-close="create-cctv-modal">×</button>
                    </div>
                    <form class="modal-body space-y-4" method="POST" action="{{ route('admin.cctvs.store') }}">
                        @csrf
                        @include('admin.master.cctv.partials.fields', ['item' => $createItem])
                        <div class="modal-footer">
                            <button class="btn-secondary" type="button" data-modal-close="create-cctv-modal">Batal</button>
                            <button class="btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            @foreach ($items as $item)
                <div id="edit-cctv-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Edit CCTV</h2>
                            <button type="button" data-modal-close="edit-cctv-modal-{{ $item->id }}">×</button>
                        </div>
                        <form class="modal-body space-y-4" method="POST" action="{{ route('admin.cctvs.update', $item) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.master.cctv.partials.fields', ['item' => $item])
                            <div class="modal-footer">
                                <button class="btn-secondary" type="button" data-modal-close="edit-cctv-modal-{{ $item->id }}">Batal</button>
                                <button class="btn-primary" type="submit">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="delete-cctv-modal-{{ $item->id }}" class="modal-backdrop" hidden>
                    <div class="modal-card modal-card-sm">
                        <div class="modal-header">
                            <h2>Hapus CCTV</h2>
                            <button type="button" data-modal-close="delete-cctv-modal-{{ $item->id }}">×</button>
                        </div>
                        <div class="modal-body">
                            <p class="text-sm text-gray-600">Yakin ingin menghapus <strong>{{ $item->nama }}</strong>?</p>
                            <form class="modal-footer" method="POST" action="{{ route('admin.cctvs.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-secondary" type="button" data-modal-close="delete-cctv-modal-{{ $item->id }}">Batal</button>
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

        const cctvSearchForm = document.getElementById('cctv-search-form');
        const cctvSearchInput = document.getElementById('cctv-search-input');
        let cctvSearchTimer;
        let cctvSearchController;

        async function loadCctvUrl(url, pushState = true) {
            cctvSearchController?.abort();
            cctvSearchController = new AbortController();

            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: cctvSearchController.signal,
            });

            const html = await response.text();
            const nextDocument = new DOMParser().parseFromString(html, 'text/html');
            const nextResults = nextDocument.getElementById('cctv-results');
            const currentResults = document.getElementById('cctv-results');

            if (nextResults && currentResults) {
                currentResults.innerHTML = nextResults.innerHTML;
            }

            if (pushState) {
                window.history.replaceState({}, '', url);
            }
        }

        cctvSearchForm?.addEventListener('submit', function (event) {
            event.preventDefault();

            const url = new URL(cctvSearchForm.action, window.location.origin);
            const searchValue = cctvSearchInput.value.trim();

            if (searchValue) {
                url.searchParams.set('search', searchValue);
            }

            loadCctvUrl(url.toString()).catch((error) => {
                if (error.name !== 'AbortError') console.error(error);
            });
        });

        cctvSearchInput?.addEventListener('input', function () {
            clearTimeout(cctvSearchTimer);

            cctvSearchTimer = setTimeout(() => {
                const url = new URL(cctvSearchForm.action, window.location.origin);
                const searchValue = cctvSearchInput.value.trim();

                if (searchValue) {
                    url.searchParams.set('search', searchValue);
                }

                loadCctvUrl(url.toString()).catch((error) => {
                    if (error.name !== 'AbortError') console.error(error);
                });
            }, 300);
        });

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('#cctv-results nav a');
            if (paginationLink) {
                event.preventDefault();
                loadCctvUrl(paginationLink.href).catch((error) => {
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
    </script>
</x-admin-layout>
