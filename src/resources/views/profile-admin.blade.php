<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Dashboard Admin - SpotRent</title>
    <link rel="icon" href="/images/logo.png" type="image/png">
    <script src="{{ asset('js/modal-helpers.js') }}"></script>
    <script src="{{ asset('js/spa-router.js') }}"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-admin-custom.css') }}">

</head>

<body>
    <main class="profile-page">

        <aside class="sidebar">
            <div>
                <div class="logo" onclick="window.location.href='/'">
                    <img src="/images/logo.png" alt="SpotRent Logo">
                    <span>SpotRent</span>
                </div>

                <h2 class="side-title">Profil Saya</h2>

                <nav class="menu">
                    <a href="/profile-admin" id="menu-log-aktivitas" class="menu-item active">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Log Aktivitas">
                        <span>Log Aktivitas</span>
                        @if(count($pendingProperties) > 0)
                            <span class="notification-bubble">{{ count($pendingProperties) }}</span>
                        @endif
                    </a>

                    <a href="/admin/list-properti" id="menu-list-properti" class="menu-item">
                        <img src="/images/profile/property.png" class="menu-icon" alt="List Properti">
                        <span>List Properti</span>
                    </a>

                    <a href="/admin/manage-comments" id="menu-manage-comments" class="menu-item">
                        <img src="/icons/chat_icon.svg" class="menu-icon" alt="Kelola Komentar">
                        <span>Kelola Komentar</span>
                    </a>

                    <a href="/admin/manage-users" id="menu-manage-users" class="menu-item">
                        <img src="/icons/members.svg" class="menu-icon" alt="Manajemen Pengguna">
                        <span>Manajemen Pengguna</span>
                    </a>

                    <a href="/admin/stats" id="menu-stats" class="menu-item">
                        <img src="/icons/stats_icon.svg" class="menu-icon" alt="Statistik">
                        <span>Statistik</span>
                    </a>
                </nav>
            </div>

            <div>
                <a href="/" class="home-link" style="margin-bottom: 12px;">
                    <img src="/images/profile/home.png" alt="Beranda Icon">
                    <span>Ke Beranda</span>
                </a>

                <a href="#" class="home-link" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/icons/logout.svg" alt="Logout Icon" style="width: 28px; height: 28px; filter: invert(34%) sepia(82%) saturate(3685%) hue-rotate(338deg) brightness(96%) contrast(96%);">
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <section class="content">
            @if(session('success'))
                <div id="flash-message-container">
                    <div class="flash-alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- BAGIAN 1: LOG AKTIVITAS (DASHBOARD) -->
            @include('partials.admin.log-aktivitas')

            <!-- BAGIAN 4: LIST PROPERTI -->
            @include('partials.admin.list-properti')

            <!-- BAGIAN 5: KELOLA KOMENTAR -->
            @include('partials.admin.manage-comments')

            <!-- BAGIAN 6: MANAJEMEN PENGGUNA -->
            @include('partials.admin.manage-users')

            <!-- BAGIAN 7: STATISTIK -->
            @include('partials.admin.stats-summary')
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        // Data seluruh pemesanan untuk modal detail
        window.allBookings = @json($bookings);
    </script>
    <script src="{{ asset('js/admin/comments.js') }}"></script>
    <script src="{{ asset('js/admin/bookings.js') }}"></script>
    <script src="{{ asset('js/admin/users.js') }}"></script>
    <script src="{{ asset('js/profile-admin.js') }}"></script>
</body>

</html>
