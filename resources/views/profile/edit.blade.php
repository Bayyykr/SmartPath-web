<x-admin-layout>
    <x-slot name="header">Profile</x-slot>

    <div class="master-page">
        <div class="master-toolbar">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Pengaturan Profil</h2>
                <p class="text-sm text-gray-500">Kelola informasi akun, foto profil, dan keamanan password.</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="form-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="form-card">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-admin-layout>
