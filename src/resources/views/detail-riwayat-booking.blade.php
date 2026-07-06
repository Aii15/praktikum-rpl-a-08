<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking - SpotRent</title>

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

        .menu-item .active-dot {
            width: 24px;
            height: 24px;
            background: #9ca3af;
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
            transition: transform 0.25s ease;
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
            padding-top: 35px;
            max-width: 900px;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 18px;
            letter-spacing: .5px;
        }

        .detail-card {
            width: 100%;
            max-width: 650px;
            background: #f9fafb;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            border: 1px solid #e5e7eb;
        }

        .detail-banner {
            width: 100%;
            height: 180px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .detail-info {
            padding: 22px;
        }

        .detail-info h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 30px;
        }

        .info-group {
            margin: 0;
        }

        .info-group strong {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-group p {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0;
            line-height: 1.5;
        }

        .booking-status {
            display: inline-block;
            margin-top: 15px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .booking-status.approved {
            background: #dcfce7;
            color: #15803d;
        }

        .booking-status.process {
            background: #fef3c7;
            color: #b45309;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 10px;
            background: #f3f4f6;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: #e5e7eb;
            color: #111827;
            transform: translateX(-4px);
        }

        .back-btn:active {
            transform: translateX(0);
        }

        .menu-item img[src*="upgrade.svg"] {
            filter: none !important;
        }
    </style>
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
                    <a href="/profile-user" class="menu-item">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Profil Icon">
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-booking" class="menu-item active">
                        <img src="/images/profile/history.png" class="menu-icon" alt="Riwayat Booking Icon">
                        <span>Riwayat Booking</span>
                    </a>

                    <a href="/saved-properti" class="menu-item">
                        <img src="/icons/love.svg" class="menu-icon" alt="Saved Properti Icon">
                        <span>Saved Properti</span>
                    </a>

                    @if(!Auth::user()->isMitra())
                    <a href="/upgrade-mitra" class="menu-item">
                        <img src="/icons/upgrade.svg" class="menu-icon" alt="Upgrade Icon">
                        <span>Upgrade ke Mitra</span>
                    </a>
                    @endif
                </nav>
            </div>

            <a href="/" class="home-link">
                <img src="/images/profile/home.png" alt="Beranda Icon">
                <span>Ke Beranda</span>
            </a>
        </aside>

        <section class="content">
            <h1>Detail Booking</h1>

            <div class="detail-card">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/profile/villa_ubud.png' }}" class="detail-banner" alt="{{ $booking->property->nama_properti ?? 'Property Image' }}" style="object-position: {{ $booking->property->coverPhoto->position_style ?? 'center 50%' }};">

                <div class="detail-info">
                    <h2>{{ $booking->property->nama_properti ?? 'Detail Booking' }}</h2>

                    <div class="info-grid">
                        <div class="info-group">
                            <strong>Status Booking</strong>
                            <p>
                                @if($booking->status_booking === 'pending')
                                    Pending
                                @elseif($booking->status_booking === 'confirmed')
                                    Disetujui
                                @elseif($booking->status_booking === 'completed')
                                    Selesai
                                @else
                                    Ditolak
                                @endif
                            </p>
                        </div>

                        <div class="info-group">
                            <strong>Status Pembayaran</strong>
                            <p>
                                @if(in_array($booking->status_booking, ['confirmed', 'completed']))
                                    Lunas
                                @elseif($booking->status_booking === 'pending')
                                    Menunggu Konfirmasi
                                @else
                                    Booking Ditolak
                                @endif
                            </p>
                        </div>

                        <div class="info-group">
                            <strong>Total Harga</strong>
                            <p>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>

                        <div class="info-group">
                            <strong>Rentang Hari</strong>
                            <p>{{ $booking->rentang_hari }}</p>
                        </div>

                        <div class="info-group">
                            <strong>Email Mitra</strong>
                            <p>{{ $booking->property->mitra->email ?? 'Tidak Diketahui' }}</p>
                        </div>

                        <div class="info-group">
                            <strong>Pemilik Properti</strong>
                            <p>{{ $booking->property->mitra->name ?? 'Tidak Diketahui' }}</p>
                        </div>
                    </div>

                    @if($booking->status_booking === 'pending')
                        <span class="booking-status process">Booking Pending</span>
                    @elseif($booking->status_booking === 'confirmed')
                        <span class="booking-status approved">Booking Disetujui</span>
                    @elseif($booking->status_booking === 'completed')
                        <span class="booking-status approved">Booking Selesai</span>
                    @else
                        <span class="booking-status" style="background:#fee2e2;color:#991b1b;">Booking Ditolak</span>
                    @endif
                </div>
            </div>

            <a href="/riwayat-booking" class="back-btn">← Kembali ke Riwayat</a>
        </section>

    </main>
</body>

</html>
