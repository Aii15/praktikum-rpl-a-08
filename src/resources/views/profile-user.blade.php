<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile User</title>

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
            max-width: 780px;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: 1px;
        }

        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            height: 58px;
            background: #e7e7e7;
            border-radius: 8px;
            padding: 9px 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.16);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .field-text small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 4px;
        }

        .field-text span {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #222;
        }

        .edit-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
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
                    <a href="/profile-user" class="menu-item active">
                        <span class="active-dot">P</span>
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-booking" class="menu-item">
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
            <h1>Tentang Saya</h1>

            <div class="form-list">
                <div class="field-card">
                    <div class="field-text">
                        <small>Nama Lengkap</small>
                        <span>Nama Lengkap</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="">
                </div>

                <div class="field-card">
                    <div class="field-text">
                        <small>E-Mail</small>
                        <span>E-Mail</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="">
                </div>

                <div class="field-card">
                    <div class="field-text">
                        <small>No Telepon</small>
                        <span>No Telepon</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="">
                </div>

                <div class="field-card">
                    <div class="field-text">
                        <small>Alamat</small>
                        <span>Alamat</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="">
                </div>

                <div class="field-card">
                    <div class="field-text">
                        <small>Password</small>
                        <span>Password</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="">
                </div>
            </div>
        </section>

    </main>
</body>

</html>
