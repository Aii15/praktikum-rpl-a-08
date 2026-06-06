<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penyewaan</title>

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
            border-right: 2px solid #777;
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
            gap: 26px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 500;
            color: #222;
            text-decoration: none;
            transition: .2s;
        }

        .menu-item:hover {
            opacity: .75;
        }

        .menu-item.active {
            font-weight: 500;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .active-dot {
            width: 24px;
            height: 24px;
            background: #25943a;
            color: white;
            border-radius: 50%;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 13px;
            font-weight: 700;
        }

        .home-link {
            display: flex;
            align-items: center;
            gap: 14px;

            font-size: 15px;
            font-weight: 500;

            text-decoration: none;
            color: #222;
        }

        .home-link img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .content {
            padding-top: 0px;
            max-width: 900px;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: .5px;
        }

        .rental-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .rental-card {
            background: #e7e7e7;
            border-radius: 8px;
            padding: 12px 16px;

            display: flex;
            align-items: center;
            gap: 14px;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        }

        .rental-card img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
        }

        .rental-info {
            flex: 1;
        }

        .rental-info h3 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .rental-info p {
            font-size: 12px;
            color: #555;
        }

        .rental-date {
            text-align: right;
        }

        .rental-date small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 4px;
        }

        .rental-date span {
            font-size: 11px;
            color: #444;
        }

        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            height: 68px;

            background: #e7e7e7;
            border-radius: 8px;

            padding: 10px 18px;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .field-text small {
            display: block;
            font-size: 11px;
            color: #666;
            margin-bottom: 3px;
        }

        .field-text span {
            display: block;
            font-size: 15px;
            font-weight: 500;
            color: #222;
        }

        .edit-icon {
            width: 22px;
            height: 22px;
            object-fit: contain;
            cursor: pointer;
        }

        .save-btn {
            float: right;

            margin-top: 25px;

            padding: 10px 18px;

            border: none;
            border-radius: 8px;

            background: #22a63a;
            color: white;

            font-size: 13px;
            font-weight: 600;

            cursor: pointer;
        }

        .save-btn:hover {
            opacity: .9;
        }

        .menu-item.active span {
            font-weight: 700;
        }

        .detail-card {
            width: 620px;
            background: #e7e7e7;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
        }

        .detail-banner {
            width: 100%;
            height: 170px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .detail-info {
            padding: 22px 26px 28px;
        }

        .detail-info h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 28px;
        }

        .info-group {
            margin: 0;
        }

        .info-group strong {
            display: block;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .info-group p {
            font-size: 14px;
            color: #444;
            margin: 0;
            line-height: 1.5;
        }

        .booking-status {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 18px;
            border-radius: 20px;
            background: #d8f3dc;
            color: #15803d;
            font-size: 13px;
            font-weight: 600;
        }

        .detail-info p {
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 16px;
            color: #222;
        }

        .status-box {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .back-btn {
            display: inline-block;
            margin-top: 16px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <main class="profile-page">

        <aside class="sidebar">
            <div>
                <div class="logo">
                    <img src="/images/logo.png" alt="SpotRent Logo">
                    <span>SpotRent</span>
                </div>

                <h2 class="side-title">Profil Saya</h2>

                <nav class="menu">
                    <a href="/profile-mitra" class="menu-item">
                        <span class="active-dot">P</span>
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-penyewaan" class="menu-item active">
                        <img src="/images/profile/history.png" class="menu-icon">
                        <span>Riwayat Penyewaan</span>
                    </a>

                    <a href="/properti-saya" class="menu-item">
                        <img src="/images/profile/property.png" class="menu-icon">
                        <span>Properti Saya</span>
                    </a>

                    <a href="/tambah-properti" class="menu-item">
                        <img src="/images/profile/add.png" class="menu-icon">
                        <span>Tambah Properti</span>
                    </a>

                    <a href="/status-pengajuan" class="menu-item">
                        <img src="/images/profile/status.png" class="menu-icon">
                        <span>Status Pengajuan</span>
                    </a>
                </nav>
            </div>

            <a href="/" class="home-link">
                <img src="/images/profile/home.png" alt="">
                <span>Ke Beranda</span>
            </a>
        </aside>

        <section class="content">
            <h1>Riwayat Booking</h1>

            <div class="detail-card">
                <img src="/images/profile/villa_ubud.png" class="detail-banner" alt="">

                <div class="detail-info">
                    <h2>Villa Ubud</h2>

                    <div class="info-grid">
                        <div class="info-group">
                            <strong>Status Booking</strong>
                            <p>Selesai</p>
                        </div>

                        <div class="info-group">
                            <strong>Status Pembayaran</strong>
                            <p>Lunas</p>
                        </div>

                        <div class="info-group">
                            <strong>Total Harga</strong>
                            <p>Rp 3.500.000</p>
                        </div>

                        <div class="info-group">
                            <strong>Rentang Hari</strong>
                            <p>20 Mei 2026 - 23 Mei 2026</p>
                        </div>
                    </div>

                    <span class="booking-status">Booking Selesai</span>
                </div>
            </div>

            <a href="/riwayat-booking" class="back-btn">← Kembali</a>
        </section>

    </main>
</body>

</html>
