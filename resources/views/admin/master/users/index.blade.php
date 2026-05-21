<x-admin-layout>
    <x-slot name="header">Users</x-slot>

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
        <div class="master-toolbar">
            <form id="users-search-form" method="GET" action="{{ route('admin.users.index') }}">
                <input
                    id="users-search-input"
                    class="master-search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari user..."
                    autocomplete="off"
                    data-realtime-search>
            </form>
            <button class="btn-primary" type="button" data-modal-target="create-user-modal">Tambah User</button>
        </div>

        <div id="users-results">
        <table class="master-table">
            <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $items->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="font-semibold">{{ $item->name }}</div>
                            <div class="max-w-[220px] truncate text-xs text-gray-500">{{ $item->alamat ?: '-' }}</div>
                        </td>
                        <td>{{ $item->username ?: '-' }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telepon ?: '-' }}</td>
                        <td><span class="user-role-badge">{{ ucfirst($item->role ?? 'user') }}</span></td>
                        <td>
                            <span class="status-badge {{ $item->aktif ? 'active' : 'inactive' }}">
                                {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="space-x-1 whitespace-nowrap">
                            <button class="btn-edit" type="button" data-modal-target="edit-user-modal-{{ $item->id }}">✎</button>
                            <button class="btn-delete" type="button" data-modal-target="delete-user-modal-{{ $item->id }}">×</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-gray-500">Data user belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $items->links() }}</div>

    <div id="create-user-modal" class="modal-backdrop" hidden>
        <div class="modal-card">
            <div class="modal-header">
                <h2>Tambah User</h2>
                <button type="button" data-modal-close="create-user-modal">×</button>
            </div>
            <form class="modal-body space-y-4" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @include('admin.master.users.partials.fields', ['item' => null, 'passwordRequired' => true])
                <div class="modal-footer">
                    <button class="btn-secondary" type="button" data-modal-close="create-user-modal">Batal</button>
                    <button class="btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($items as $item)
        <div id="edit-user-modal-{{ $item->id }}" class="modal-backdrop" hidden>
            <div class="modal-card">
                <div class="modal-header">
                    <h2>Edit User</h2>
                    <button type="button" data-modal-close="edit-user-modal-{{ $item->id }}">×</button>
                </div>
                <form class="modal-body space-y-4" method="POST" action="{{ route('admin.users.update', $item) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.master.users.partials.fields', ['item' => $item, 'passwordRequired' => false])
                    <div class="modal-footer">
                        <button class="btn-secondary" type="button" data-modal-close="edit-user-modal-{{ $item->id }}">Batal</button>
                        <button class="btn-primary" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="delete-user-modal-{{ $item->id }}" class="modal-backdrop" hidden>
            <div class="modal-card modal-card-sm">
                <div class="modal-header">
                    <h2>Hapus User</h2>
                    <button type="button" data-modal-close="delete-user-modal-{{ $item->id }}">×</button>
                </div>
                <div class="modal-body">
                    <p class="text-sm text-gray-600">Yakin ingin menghapus user <strong>{{ $item->name }}</strong>?</p>
                    <form class="modal-footer" method="POST" action="{{ route('admin.users.destroy', $item) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-secondary" type="button" data-modal-close="delete-user-modal-{{ $item->id }}">Batal</button>
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

        const usersSearchForm = document.getElementById('users-search-form');
        const usersSearchInput = document.getElementById('users-search-input');
        let usersSearchTimer;
        let usersSearchController;

        async function loadUsersUrl(url, pushState = true) {
            usersSearchController?.abort();
            usersSearchController = new AbortController();

            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: usersSearchController.signal,
            });

            const html = await response.text();
            const nextDocument = new DOMParser().parseFromString(html, 'text/html');
            const nextResults = nextDocument.getElementById('users-results');
            const currentResults = document.getElementById('users-results');

            if (nextResults && currentResults) {
                currentResults.innerHTML = nextResults.innerHTML;
            }

            if (pushState) {
                window.history.replaceState({}, '', url);
            }
        }

        usersSearchForm?.addEventListener('submit', function (event) {
            event.preventDefault();
        });

        usersSearchInput?.addEventListener('input', function () {
            clearTimeout(usersSearchTimer);

            usersSearchTimer = setTimeout(() => {
                const url = new URL(usersSearchForm.action, window.location.origin);
                const searchValue = usersSearchInput.value.trim();

                if (searchValue) {
                    url.searchParams.set('search', searchValue);
                }

                loadUsersUrl(url.toString()).catch((error) => {
                    if (error.name !== 'AbortError') console.error(error);
                });
            }, 300);
        });

        document.addEventListener('click', function (event) {
            const paginationLink = event.target.closest('#users-results nav a');
            if (paginationLink) {
                event.preventDefault();
                loadUsersUrl(paginationLink.href).catch((error) => {
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
