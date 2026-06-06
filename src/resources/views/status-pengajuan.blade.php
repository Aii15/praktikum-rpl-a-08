<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Properti
    </title>

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

        .next-btn {
            float: right;
            margin-top: 25px;

            display: flex;
            align-items: center;
            gap: 8px;

            text-decoration: none;
            color: #555;

            font-size: 14px;
            font-weight: 500;
        }

        .next-btn img {
            width: 16px;
            height: 16px;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .status-card {
            background: #e7e7e7;
            border-radius: 8px;
            padding: 12px 16px;

            display: flex;
            align-items: center;
            gap: 14px;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);

            text-decoration: none;
            color: #222;

            transition: .2s;
        }

        .status-card:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: #222;
        }

        .status-card:visited {
            color: #222;
        }

        .status-card * {
            text-decoration: none;
        }

        .status-card img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
        }

        .status-info {
            flex: 1;
        }

        .status-info h3 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .status-info p {
            font-size: 12px;
            color: #555;
        }

        .status-right {
            text-align: right;
        }

        .status-right small {
            display: block;
            margin-top: 6px;
            color: #666;
            font-size: 11px;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .pending {
            background: #fef3c7;
            color: #b45309;
        }

        .rejected {
            background: #fee2e2;
            color: #dc2626;
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

                    <a href="/riwayat-penyewaan" class="menu-item">
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

                    <a href="/status-pengajuan" class="menu-item active">
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
            <h1>Status Pengajuan</h1>

            <div class="status-list">

                <a href="/detail-status-pengajuan" class="status-card">
                    <img src="/images/property/property1.png" alt="">

                    <div class="status-info">
                        <h3>Villa Ubud</h3>
                        <p>Bali</p>
                    </div>

                    <div class="status-right">
                        <span class="status approved">Disetujui</span>
                    </div>
                </a>

                <a href="/detail-status-pengajuan" class="status-card">
                    <img src="/images/property/property2.png" alt="">

                    <div class="status-info">
                        <h3>Lawang Sewu</h3>
                        <p>Semarang</p>
                    </div>

                    <div class="status-right">
                        <span class="status pending">Menunggu</span>
                    </div>
                </a>

                <a href="/detail-status-pengajuan" class="status-card">
                    <img src="/images/property/property3.png" alt="">

                    <div class="status-info">
                        <h3>Villa Batu</h3>
                        <p>Malang</p>
                    </div>

                    <div class="status-right">
                        <span class="status rejected">Ditolak</span>
                    </div>
                </a>

                <a href="/detail-status-pengajuan" class="status-card">
                    <img src="/images/property/property4.png" alt="">

                    <div class="status-info">
                        <h3>Apartment Solo</h3>
                        <p>Surakarta</p>
                    </div>

                    <div class="status-right">
                        <span class="status approved">Disetujui</span>
                    </div>
                </a>
            </div>

            </div>
        </section>
    </main>
</body>

</html>
