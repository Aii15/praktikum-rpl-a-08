@php
    $pendingBookingCount = \App\Models\Booking::where('status_booking', 'pending')
        ->whereHas('property', function ($query) {
            $query->where('id_mitra', Auth::id());
        })
        ->count();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent Mitra</title>
    <link class="js-favicon" rel="icon" href="/images/logo.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-mitra-custom.css') }}">
    @yield('styles')
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
                    <a href="{{ route('mitra.profile') }}" id="menu-tentang-saya" class="menu-item {{ request()->routeIs('mitra.profile') ? 'active' : '' }}">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Profil Icon">
                        <span>Tentang Saya</span>
                    </a>

                    <a href="{{ route('mitra.bookings') }}" id="menu-riwayat-penyewaan" class="menu-item {{ request()->routeIs('mitra.bookings') || request()->routeIs('mitra.booking.detail') ? 'active' : '' }}">
                        <img src="/images/profile/history.png" class="menu-icon" alt="Riwayat Penyewaan Icon">
                        <span>Riwayat Penyewaan</span>
                        @if($pendingBookingCount > 0)
                            <span class="notification-bubble">{{ $pendingBookingCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('mitra.properties') }}" id="menu-properti-saya" class="menu-item {{ request()->routeIs('mitra.properties') || request()->routeIs('mitra.property.detail') ? 'active' : '' }}">
                        <img src="/images/profile/property.png" class="menu-icon" alt="Properti Saya Icon">
                        <span>Properti Saya</span>
                    </a>

                    <a href="{{ route('mitra.property.create') }}" id="menu-tambah-properti" class="menu-item {{ request()->routeIs('mitra.property.create') ? 'active' : '' }}">
                        <img src="/images/profile/add.png" class="menu-icon" alt="Tambah Properti Icon">
                        <span>Tambah Properti</span>
                    </a>

                    <a href="{{ route('mitra.status') }}" id="menu-status-pengajuan" class="menu-item {{ request()->routeIs('mitra.status') || request()->routeIs('mitra.status.detail') ? 'active' : '' }}">
                        <img src="/images/profile/status.png" class="menu-icon" alt="Status Pengajuan Icon">
                        <span>Status Pengajuan</span>
                    </a>
                </nav>
            </div>

            <a href="/" class="home-link">
                <img src="/images/profile/home.png" alt="Beranda Icon">
                <span>Ke Beranda</span>
            </a>
        </aside>

        <section class="content">
            <div id="flash-message-container">
                @include('partials.flash')
            </div>

            @yield('content')
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash message logic
            const flashContainer = document.getElementById('flash-message-container');
            if (flashContainer && flashContainer.innerText.trim() !== '') {
                setTimeout(() => {
                    flashContainer.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    flashContainer.style.opacity = '0';
                    flashContainer.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        flashContainer.style.display = 'none';
                    }, 500);
                }, 4000); // fades out after 4 seconds
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
