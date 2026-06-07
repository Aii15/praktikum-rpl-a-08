<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Properti

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

        .admin-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 70px;
            width: 100%;
        }

        .admin-card:hover {
            transform: translateY(-2px);
        }

        .admin-card {
            width: 100%;
            height: 68px;

            background: #e7e7e7;
            border-radius: 8px;
            padding: 0 18px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            text-decoration: none;
            color: #222;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        }

        .admin-card span {
            font-size: 14px;
            font-weight: 500;
        }

        .admin-card img {
            width: 22px;
            height: 22px;
        }

        .pengajuan-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pengajuan-card {
            background: #e7e7e7;
            border-radius: 8px;
            padding: 14px;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        }

        .property-header {
            display: flex;
            align-items: center;
            gap: 14px;

            margin-bottom: 14px;
        }

        .property-header img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
        }

        .property-info {
            flex: 1;
        }

        .property-info h3 {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .property-info p {
            font-size: 12px;
            color: #666;
        }

        .property-status {
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        .review-box {
            background: #f4f4f4;
            border-radius: 8px;
            padding: 14px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .accept-btn {
            border: none;
            background: none;
            color: #16a34a;
            font-weight: 600;
            cursor: pointer;
        }

        .reject-btn {
            border: none;
            background: none;
            color: #dc2626;
            font-weight: 600;
            cursor: pointer;
        }

        .review-box textarea {
            width: 100%;
            height: 110px;

            border: none;
            border-radius: 8px;

            padding: 12px;
            resize: none;

            font-size: 13px;
        }

        .property-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .property-card {
            width: 100%;
            height: 78px;
            background: #e7e7e7;
            border-radius: 8px;
            padding: 10px 16px;

            display: flex;
            align-items: center;
            gap: 14px;

            text-decoration: none;
            color: #222;

            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);

            transition: .2s;
        }

        .property-card:hover {
            transform: translateY(-2px);
        }

        .property-card,
        .property-card * {
            text-decoration: none;
        }

        .property-card img {
            width: 58px;
            height: 58px;
            border-radius: 6px;
            object-fit: cover;
        }

        .property-info {
            flex: 1;
        }

        .property-info h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .property-info p {
            font-size: 12px;
            color: #555;
        }

        .property-card span {
            font-size: 12px;
            font-weight: 500;
            color: #444;
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
                    <a href="/profile-admin" class="menu-item">
                        <span class="active-dot">P</span>
                        <span>Log Aktivitas</span>
                    </a>

                    <a href="/list-properti" class="menu-item active">
                        <img src="/images/profile/property.png" class="menu-icon">
                        <span>List Properti</span>
                    </a>
                </nav>
            </div>

            <a href="/" class="home-link">
                <img src="/images/profile/home.png" alt="">
                <span>Ke Beranda</span>
            </a>
        </aside>

        <section class="content">
            <h1>List Properti</h1>

            <div class="property-list">

                <a href="/detail-list-properti" class="property-card">
                    <img src="/images/profile/villa_ubud.png" alt="">

                    <div class="property-info">
                        <h3>Villa Ubud</h3>
                        <p>Bali</p>
                    </div>

                    <span>Lihat Info Properti</span>
                </a>

                <a href="/detail-list-properti" class="property-card">
                    <img src="/images/landing/property.png" alt="">

                    <div class="property-info">
                        <h3>Lawang Sewu</h3>
                        <p>Semarang</p>
                    </div>

                    <span>Lihat Info Properti</span>
                </a>

                <a href="/detail-list-properti" class="property-card">
                    <img src="/images/profile/villa_ubud.png" alt="">

                    <div class="property-info">
                        <h3>Apartment Solo</h3>
                        <p>Surakarta</p>
                    </div>

                    <span>Lihat Info Properti</span>
                </a>

            </div>
        </section>

    </main>
</body>

</html>
