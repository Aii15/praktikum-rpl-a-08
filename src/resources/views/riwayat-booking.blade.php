<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking</title>

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
        }

        .menu-item.active {
            font-weight: 600;
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
            color: #fff;
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
            font-weight: 600;
            text-decoration: none;
            color: #222;
        }

        .home-link img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .content {
            padding-top: 55px;
            max-width: 850px;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            height: 50px;
            border: none;
            background: #f2f2f2;
            border-radius: 10px;
            padding: 0 18px;
            font-size: 14px;
            outline: none;
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: #f8f8f8;
            border-radius: 12px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .booking-card img {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .booking-info {
            flex: 1;
        }

        .booking-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .booking-info p {
            color: #666;
            margin-bottom: 6px;
        }

        .booking-info strong {
            font-size: 14px;
            font-weight: 400;
            color: #444;
        }

        .status {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .success {
            background: #dcfce7;
            color: #15803d;
        }

        .process {
            background: #fef3c7;
            color: #b45309;
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
                    <a href="/profile-user" class="menu-item">
                        <span class="active-dot">P</span>
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-booking" class="menu-item active">
                        <img src="/images/profile/history.png" class="menu-icon" alt="">
                        <span>Riwayat Booking</span>
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

            <div class="search-box">
                <input type="text" placeholder="Cari booking...">
            </div>

            <div class="booking-list">

                <div class="booking-card">
                    <img src="/images/landing/property.png" alt="Property">

                    <div class="booking-info">
                        <h3>Lawang Sewu</h3>
                        <p>Semarang</p>
                        <strong>IDR 150.000.000</strong>
                    </div>

                    <div class="status success">Selesai</div>
                </div>

                <div class="booking-card">
                    <img src="/images/landing/property.png" alt="Property">

                    <div class="booking-info">
                        <h3>Villa Ubud</h3>
                        <p>Bali</p>
                        <strong>IDR 3.500.000</strong>
                    </div>

                    <div class="status process">Berlangsung</div>
                </div>

            </div>
        </section>

    </main>
</body>

</html>
