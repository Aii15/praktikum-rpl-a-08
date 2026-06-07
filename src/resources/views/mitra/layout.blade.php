<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent Mitra</title>
    <link class="js-favicon" rel="icon" href="/images/logo.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            width: 100%;
            min-height: 100vh;
            background: #fff;
        }

        .profile-page {
            width: 100%;
            min-height: 100vh;
            background: #fff;
            padding: 70px 90px;
            display: grid;
            grid-template-columns: 330px 1fr;
            gap: 90px;
        }

        .sidebar {
            border-right: 4px solid #e5e7eb;
            padding-right: 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 70px;
            height: calc(100vh - 140px);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 65px;
            cursor: pointer;
        }

        .logo img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .logo span {
            font-size: 22px;
            font-weight: 700;
            color: #333;
        }

        .side-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 500;
            color: #4b5563;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 12px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .menu-item:hover {
            background: #f3f4f6;
            color: #111827;
            transform: translateX(6px);
        }

        .menu-item.active {
            background: #fef9c3;
            color: #a16207;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.15);
        }

        .menu-item.active .menu-icon {
            filter: sepia(100%) saturate(300%) hue-rotate(5deg);
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
            transition: transform 0.25s ease, filter 0.25s ease;
        }

        .menu-item:hover .menu-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .home-link {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            color: #374151;
            padding: 12px 18px;
            border-radius: 12px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .home-link img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            transition: transform 0.25s ease, filter 0.25s ease;
        }

        .home-link:hover {
            background: transparent;
            color: #d97706;
            transform: translateY(-2px);
        }

        .home-link:hover img {
            transform: scale(1.1) rotate(-5deg);
            filter: sepia(100%) saturate(300%) hue-rotate(5deg);
        }

        .home-link:active {
            transform: translateY(0) scale(0.97);
        }

        .content {
            padding-top: 0px;
            max-width: 900px;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: 0.5px;
        }

        /* Flash wrapper styles */
        #flash-message-container {
            margin-bottom: 20px;
        }
    </style>
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
