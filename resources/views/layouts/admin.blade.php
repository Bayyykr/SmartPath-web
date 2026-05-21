<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --sidebar-width: 180px;
                --page-bg: #eef7fa;
                --border: #e5e7eb;
                --text: #111827;
                --muted: #6b7280;
                --accent: #2563eb;
            }

            body {
                background: var(--page-bg);
                color: var(--text);
            }

            .admin-shell {
                min-height: 100vh;
                background: var(--page-bg);
            }

            .sidebar {
                width: var(--sidebar-width);
                height: 100vh;
                position: fixed;
                inset: 0 auto 0 0;
                z-index: 50;
                background: #ffffff;
                border-right: 1px solid var(--border);
                overflow-y: auto;
            }

            .content-area {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
                background: var(--page-bg);
            }

            .admin-header {
                height: 56px;
                background: #ffffff;
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 28px;
            }

            .page-title {
                font-size: 16px;
                font-weight: 600;
                color: #111827;
            }

            .sidebar-link {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 22px;
                color: #111827;
                font-size: 13px;
                font-weight: 500;
                line-height: 1.2;
                transition: color .15s ease, background .15s ease;
            }

            .sidebar-link:hover,
            .sidebar-link.active {
                color: #1d4ed8;
                background: #f8fafc;
            }

            .sidebar-link svg {
                width: 15px;
                height: 15px;
                flex-shrink: 0;
            }

            .category-title {
                padding: 16px 22px 7px;
                color: #9ca3af;
                font-size: 12px;
                font-weight: 600;
            }

            .sidebar-dropdown summary::-webkit-details-marker {
                display: none;
            }

            .sidebar-dropdown:not([open]) summary span:last-child {
                transform: rotate(-90deg);
            }

            .sidebar-dropdown summary span:last-child {
                transition: transform .15s ease;
            }

            .dashboard-content {
                position: relative;
                height: calc(100vh - 56px);
                overflow: hidden;
                background: #ffffff;
            }

            .map-panel {
                position: absolute;
                inset: 0;
                background: #ffffff;
                overflow: hidden;
            }

            #map {
                height: 100%;
                width: 100%;
                z-index: 1;
            }

            .map-filter {
                position: absolute;
                top: 12px;
                left: 12px;
                z-index: 500;
                width: 26px;
                height: 26px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #ffffff;
                border: 1px solid #d1d5db;
                border-radius: 2px;
                box-shadow: 0 1px 2px rgba(0,0,0,.12);
                color: #6b7280;
            }

            .stats-grid {
                position: absolute;
                left: 18px;
                right: 18px;
                bottom: 18px;
                z-index: 600;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
            }

            .card {
                background: #ffffff;
                border: 1px solid var(--border);
                border-radius: 2px;
                padding: 10px 12px 8px;
                min-height: 180px;
                box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
            }

            .card-title {
                color: #111827;
                font-size: 13px;
                font-weight: 700;
                margin: 0 0 6px;
            }

            .chart-box {
                height: 142px;
            }

            .avatar-dot {
                width: 28px;
                height: 28px;
                border-radius: 9999px;
                background: linear-gradient(135deg, #312e81, #c4b5fd);
                border: 2px solid #ffffff;
                box-shadow: 0 1px 4px rgba(0,0,0,.18);
            }

            .master-page {
                min-height: calc(100vh - 56px);
                background: #ffffff;
                padding: 24px 32px;
            }

            .master-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 16px;
                margin-bottom: 16px;
            }

            .master-search {
                width: 220px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                padding: 9px 12px;
                font-size: 14px;
            }

            .btn-primary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #4caf50;
                color: #ffffff;
                border-radius: 6px;
                padding: 9px 16px;
                font-size: 14px;
                font-weight: 600;
            }

            .btn-secondary {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: #e5e7eb;
                color: #111827;
                border-radius: 6px;
                padding: 9px 16px;
                font-size: 14px;
                font-weight: 600;
            }

            .btn-edit, .btn-delete {
                width: 30px;
                height: 30px;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                font-size: 13px;
                font-weight: 700;
            }

            .btn-edit { background: #f59e0b; }
            .btn-delete { background: #ef4444; }

            .master-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            .master-table th {
                text-align: left;
                color: #6b7280;
                font-weight: 600;
                border-bottom: 1px solid #e5e7eb;
                padding: 12px 14px;
            }

            .master-table td {
                border-bottom: 1px solid #e5e7eb;
                padding: 12px 14px;
                color: #111827;
            }

            .master-table tbody tr:nth-child(even) {
                background: #f3f4f6;
            }

            .tab-link {
                display: inline-flex;
                border-radius: 6px;
                padding: 9px 14px;
                font-size: 14px;
                font-weight: 600;
                color: #374151;
            }

            .tab-link.active {
                background: #293b91;
                color: #ffffff;
            }

            .form-card {
                max-width: 720px;
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 24px;
            }

            .form-label {
                display: block;
                color: #374151;
                font-size: 14px;
                font-weight: 600;
                margin-bottom: 7px;
            }

            .form-input, .form-select {
                width: 100%;
                border: 1px solid #d1d5db;
                border-radius: 7px;
                padding: 10px 12px;
                font-size: 14px;
            }

            .cctv-page {
                min-height: calc(100vh - 56px);
                background: #ffffff;
                padding: 24px 32px 32px;
            }

            .cctv-topbar {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 16px;
            }

            .cctv-search {
                display: flex;
                height: 36px;
                overflow: hidden;
                border: 1px solid #d1d5db;
                border-radius: 5px;
                background: #ffffff;
            }

            .cctv-search input {
                width: 210px;
                border: 0;
                padding: 0 12px;
                color: #111827;
                font-size: 13px;
                outline: none;
            }

            .cctv-search button,
            .cctv-action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                height: 36px;
                border-radius: 5px;
                font-size: 12px;
                font-weight: 700;
            }

            .cctv-search button {
                width: 38px;
                background: #2454c6;
                color: #ffffff;
            }

            .cctv-action-btn {
                border: 1px solid #d1d5db;
                background: #ffffff;
                color: #2454c6;
                padding: 0 12px;
            }

            .cctv-action-btn.secondary {
                color: #374151;
            }

            .cctv-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 14px;
            }

            .cctv-card {
                overflow: hidden;
                border-radius: 7px;
                background: #111827;
                box-shadow: 0 8px 18px rgba(15, 23, 42, .14);
            }

            .cctv-stream {
                position: relative;
                display: block;
                aspect-ratio: 16 / 10;
                overflow: hidden;
                background: linear-gradient(135deg, #111827, #1f2937);
            }

            .cctv-stream iframe {
                width: 100%;
                height: 100%;
                border: 0;
                display: block;
            }

            .cctv-empty-preview {
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 18px;
                color: #d1d5db;
                text-align: center;
                font-size: 12px;
                font-weight: 600;
            }

            .cctv-stream::after {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background: linear-gradient(180deg, rgba(0,0,0,.24), transparent 34%, rgba(0,0,0,.42));
            }

            .cctv-live-badge,
            .cctv-time {
                position: absolute;
                z-index: 2;
                top: 8px;
                color: #ffffff;
                text-shadow: 0 1px 2px rgba(0,0,0,.45);
            }

            .cctv-live-badge {
                left: 8px;
                display: inline-flex;
                align-items: center;
                gap: 4px;
                border-radius: 3px;
                background: #ef233c;
                padding: 3px 6px;
                font-size: 9px;
                font-weight: 800;
                line-height: 1;
            }

            .cctv-live-badge span {
                width: 5px;
                height: 5px;
                border-radius: 999px;
                background: #ffffff;
            }

            .cctv-time {
                right: 8px;
                font-size: 9px;
                font-weight: 700;
            }

            .cctv-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                min-height: 46px;
                padding: 8px 10px;
                color: #ffffff;
            }

            .cctv-title-link {
                display: block;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                font-size: 12px;
                font-weight: 800;
            }

            .cctv-title-link:hover {
                text-decoration: underline;
            }

            .cctv-card-footer p {
                margin-top: 2px;
                color: #86efac;
                font-size: 10px;
                font-weight: 700;
            }

            .cctv-card-actions {
                display: flex;
                align-items: center;
                gap: 5px;
                flex-shrink: 0;
            }

            .cctv-card-actions a,
            .cctv-card-actions button {
                width: 24px;
                height: 24px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: rgba(255,255,255,.12);
                color: #ffffff;
                font-size: 12px;
                font-weight: 800;
            }

            .cctv-card-actions a:hover,
            .cctv-card-actions button:hover {
                background: rgba(255,255,255,.24);
            }

            .cctv-empty-state {
                grid-column: 1 / -1;
                border: 1px dashed #cbd5e1;
                border-radius: 10px;
                background: #f8fafc;
                padding: 38px;
                text-align: center;
            }

            .cctv-empty-state h2 {
                color: #111827;
                font-size: 18px;
                font-weight: 800;
            }

            .cctv-empty-state p {
                margin: 8px auto 18px;
                max-width: 520px;
                color: #6b7280;
                font-size: 14px;
            }

            .toast-notification {
                position: fixed;
                top: 18px;
                right: 24px;
                z-index: 1200;
                display: grid;
                grid-template-columns: auto 1fr auto;
                align-items: flex-start;
                gap: 12px;
                width: min(380px, calc(100vw - 32px));
                border-radius: 12px;
                background: #ffffff;
                padding: 14px 14px 14px 16px;
                box-shadow: 0 18px 42px rgba(15, 23, 42, .2);
                animation: toast-slide-in .22s ease-out;
                overflow: hidden;
            }

            .toast-notification::after {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                height: 3px;
                animation: toast-progress 4.5s linear forwards;
            }

            .toast-notification.success {
                border-left: 4px solid #22c55e;
            }

            .toast-notification.success::after {
                background: #22c55e;
            }

            .toast-notification.error {
                border-left: 4px solid #ef4444;
            }

            .toast-notification.error::after {
                background: #ef4444;
            }

            .toast-icon {
                width: 28px;
                height: 28px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                color: #ffffff;
                font-size: 15px;
                font-weight: 900;
            }

            .toast-notification.success .toast-icon {
                background: #22c55e;
            }

            .toast-notification.error .toast-icon {
                background: #ef4444;
            }

            .toast-title {
                color: #111827;
                font-size: 14px;
                font-weight: 800;
                line-height: 1.2;
            }

            .toast-message {
                margin-top: 3px;
                color: #6b7280;
                font-size: 13px;
                line-height: 1.4;
            }

            .toast-notification button {
                color: #9ca3af;
                font-size: 22px;
                line-height: 1;
            }

            .toast-notification button:hover {
                color: #111827;
            }

            @keyframes toast-slide-in {
                from {
                    opacity: 0;
                    transform: translateX(18px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes toast-progress {
                from { width: 100%; }
                to { width: 0%; }
            }

            .modal-backdrop {
                position: fixed;
                inset: 0;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(15, 23, 42, .48);
                padding: 24px;
            }

            .modal-backdrop[hidden] {
                display: none;
            }

            .modal-card {
                width: min(760px, 100%);
                max-height: calc(100vh - 48px);
                overflow-y: auto;
                border-radius: 12px;
                background: #ffffff;
                box-shadow: 0 24px 60px rgba(15, 23, 42, .28);
            }

            .modal-card-sm {
                width: min(440px, 100%);
            }

            .modal-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-bottom: 1px solid #e5e7eb;
                padding: 18px 22px;
            }

            .modal-header h2 {
                color: #111827;
                font-size: 18px;
                font-weight: 800;
            }

            .modal-header button {
                width: 30px;
                height: 30px;
                border-radius: 999px;
                color: #6b7280;
                font-size: 24px;
                line-height: 1;
            }

            .modal-header button:hover {
                background: #f3f4f6;
                color: #111827;
            }

            .modal-body {
                padding: 22px;
            }

            .modal-footer {
                display: flex;
                justify-content: flex-end;
                gap: 10px;
                padding-top: 10px;
            }

            .btn-delete-text {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                background: #ef4444;
                color: #ffffff;
                padding: 9px 16px;
                font-size: 14px;
                font-weight: 700;
            }

            .status-badge,
            .user-role-badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 4px 9px;
                font-size: 12px;
                font-weight: 700;
            }

            .status-badge.active {
                background: #dcfce7;
                color: #166534;
            }

            .status-badge.inactive {
                background: #fee2e2;
                color: #991b1b;
            }

            .user-role-badge {
                background: #e0e7ff;
                color: #3730a3;
            }

            @media (max-width: 1280px) {
                .cctv-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            }

            @media (max-width: 1024px) {
                :root { --sidebar-width: 145px; }
                .stats-grid { grid-template-columns: 1fr; }
                .stats-grid { left: 12px; right: 12px; bottom: 12px; }
                .chart-box { height: 180px; }
                .cctv-topbar { flex-direction: column; }
                .cctv-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            }

            @media (max-width: 640px) {
                .cctv-page { padding: 18px; }
                .cctv-search input { width: 160px; }
                .cctv-grid { grid-template-columns: 1fr; }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="admin-shell">
            @include('layouts.admin-navigation')

            <div class="content-area">
                <header class="admin-header">
                    <div class="page-title">{{ $header ?? 'Dashboard' }}</div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="avatar-dot" aria-label="User menu"></button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
