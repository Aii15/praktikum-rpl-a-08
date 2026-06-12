<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile User - SpotRent</title>
    <link rel="icon" href="/images/logo.png" type="image/png">

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

        /* SPA Section Display and Fade Transitions */
        .content-section {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .content-section h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: 1px;
        }

        /* Tentang Saya Section Input Card Styles */
        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            height: 64px;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .field-card:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .field-card:focus-within {
            background: #ffffff;
            border-color: #f7c948;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.18);
            transform: translateY(-2px);
        }

        .field-text {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .field-text small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }

        .profile-input {
            border: none;
            background: transparent;
            font-size: 15px;
            font-weight: 500;
            color: #222;
            width: 100%;
            outline: none;
            padding: 0;
            margin-top: 2px;
            font-family: 'Poppins', sans-serif;
        }

        .edit-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .field-card:hover .edit-icon {
            opacity: 1;
            transform: scale(1.1);
        }

        .save-btn {
            background: #25943a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(37, 148, 58, 0.3);
            display: inline-block;
            margin-top: 25px;
            float: right;
            outline: none;
        }

        .save-btn:hover {
            background: #1e7e30;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(37, 148, 58, 0.4);
        }

        .save-btn:active {
            transform: translateY(-1px) scale(0.98);
            box-shadow: 0 4px 12px rgba(37, 148, 58, 0.2);
        }

        /* Riwayat Booking Section Styles */
        .search-box {
            margin-bottom: 0;
            width: 100%;
        }

        .search-box input {
            width: 100%;
            height: 50px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 14px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            background: #fff;
            border-color: #f7c948;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.15);
        }

        .filter-controls-container {
            display: grid;
            gap: 16px;
            margin-bottom: 25px;
            position: relative;
            z-index: 20;
        }

        #section-riwayat-booking .filter-controls-container {
            grid-template-columns: 2fr 1fr;
        }

        #section-riwayat-transaksi .filter-controls-container {
            grid-template-columns: 2fr 1fr 1fr;
        }

        @media (max-width: 768px) {
            #section-riwayat-booking .filter-controls-container,
            #section-riwayat-transaksi .filter-controls-container {
                grid-template-columns: 1fr;
            }
        }

        .filter-card {
            height: 50px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .filter-card:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .filter-card:focus-within {
            background: #fff;
            border-color: #f7c948;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.15);
        }

        .filter-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            flex: 1;
        }

        .filter-text small {
            display: block;
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
            line-height: 1;
            margin-bottom: 2px;
        }

        .filter-display {
            font-size: 13px;
            font-weight: 600;
            color: #222;
            line-height: 1.2;
        }

        .dropdown-menu-list {
            display: none;
            position: absolute;
            top: 55px;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            padding: 8px;
        }

        .dropdown-item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s ease;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
        }

        .dropdown-item-row:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .status-badge-inline {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge-inline.success {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge-inline.process {
            background: #fef3c7;
            color: #b45309;
        }

        .status-badge-inline.completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status-badge-inline.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: #f3f4f6bf;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
            text-decoration: none;
            color: #222;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #07070764;
        }

        .booking-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
            border-color: #f7c948;
            background: #ffffff;
        }

        .booking-card:active {
            transform: translateY(-1px) scale(0.99);
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
            font-weight: 600;
        }

        .booking-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .booking-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .status {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #15803d;
        }

        .completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .process {
            background: #fef3c7;
            color: #b45309;
        }

        .menu-item img[src*="upgrade.svg"] {
            filter: none !important;
        }

        /* Detail Booking Styles */
        .detail-card {
            width: 100%;
            max-width: 650px;
            background: #f9fafb;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            margin-bottom: 12px;
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

        .booking-status.success {
            background: #dcfce7;
            color: #15803d;
        }

        .booking-status.completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .booking-status.process {
            background: #fef3c7;
            color: #b45309;
        }

        .booking-status.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .back-btn {
            display: inline-block;
            margin-top: 8px;
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

        /* Loader inside section */
        .modal-loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
            gap: 12px;
        }

        .modal-spinner {
            width: 36px;
            height: 36px;
            border: 3px solid rgba(0, 0, 0, 0.08);
            border-top-color: #f7c948;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .modal-loader-container p {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom Confirmation Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .custom-modal-overlay.active {
            opacity: 1;
        }

        .custom-modal-box {
            background: #ffffff;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .custom-modal-overlay.active .custom-modal-box {
            transform: scale(1);
        }

        .custom-modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin: 0 auto 18px;
        }

        .custom-modal-icon.success {
            background: #dcfce7;
            color: #15803d;
        }

        .custom-modal-icon.danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .custom-modal-box h3 {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .custom-modal-box p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .custom-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .custom-modal-btn {
            flex: 1;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }

        .custom-modal-btn.ok-btn {
            background: #f7c948;
            color: #111111;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.2);
        }

        .custom-modal-btn.ok-btn:hover {
            background: #f5b91b;
            box-shadow: 0 6px 16px rgba(247, 201, 72, 0.3);
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
                    <a href="/profile-user" id="menu-tentang-saya" class="menu-item">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Profil Icon">
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-booking" id="menu-riwayat-booking" class="menu-item">
                        <img src="/images/profile/history.png" class="menu-icon" alt="Riwayat Booking Icon">
                        <span>Riwayat Booking</span>
                    </a>

                    <a href="/saved-properti" id="menu-saved-properti" class="menu-item">
                        <img src="/icons/love.svg" class="menu-icon" alt="Saved Properti Icon">
                        <span>Saved Properti</span>
                    </a>

                    <a href="/riwayat-transaksi" id="menu-riwayat-transaksi" class="menu-item">
                        <img src="/icons/transaction.svg" class="menu-icon" alt="Riwayat Transaksi Icon">
                        <span>Riwayat Transaksi</span>
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
            <div id="flash-message-container">
                @include('partials.flash')
            </div>

            <!-- SECTION 1: TENTANG SAYA -->
            @include('partials.user.tentang-saya')

            <!-- SECTION 2: RIWAYAT BOOKING -->
            @include('partials.user.riwayat-booking')

            <!-- SECTION 3: SAVED PROPERTIES -->
            @include('partials.user.saved-properti')

            <!-- SECTION 5: RIWAYAT TRANSAKSI -->
            @include('partials.user.riwayat-transaksi')

            <!-- SECTION 4: DETAIL BOOKING -->
            @include('partials.user.detail-booking')
        </section>

    </main>

    <script>
        // Global booking ID passed from server for direct loads
        window.activeBookingId = @json($activeBookingId ?? null);

        // Define functions globally so they are hoisted and available everywhere
        function navigateTo(path, pushState = true) {
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatBooking = document.getElementById('menu-riwayat-booking');
            const menuSavedProperti = document.getElementById('menu-saved-properti');
            const menuRiwayatTransaksi = document.getElementById('menu-riwayat-transaksi');

            const menuItems = [
                { path: '/profile-user', sectionId: 'section-tentang-saya', title: 'Profile User - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-booking', sectionId: 'section-riwayat-booking', title: 'Riwayat Booking - SpotRent', menuEl: menuRiwayatBooking },
                { path: '/saved-properti', sectionId: 'section-saved-properti', title: 'Saved Properti - SpotRent', menuEl: menuSavedProperti },
                { path: '/riwayat-transaksi', sectionId: 'section-riwayat-transaksi', title: 'Riwayat Transaksi - SpotRent', menuEl: menuRiwayatTransaksi },
                { path: '/detail-riwayat-booking', sectionId: 'section-detail-booking', title: 'Detail Booking - SpotRent', menuEl: menuRiwayatBooking }
            ];

            let isDetail = path.match(/^\/detail-riwayat-booking\/(\d+)$/);
            let matchedPath = isDetail ? '/detail-riwayat-booking' : path;

            let matched = menuItems.find(item => item.path === matchedPath);
            if (!matched) {
                matched = menuItems[0];
            }

            menuItems.forEach(item => {
                const sec = document.getElementById(item.sectionId);
                if (sec) {
                    if (item === matched) {
                        sec.style.display = 'block';
                        sec.offsetHeight; // force reflow
                        sec.classList.add('active');
                        if (item.menuEl) item.menuEl.classList.add('active');
                    } else {
                        sec.classList.remove('active');
                        sec.style.display = 'none';
                        if (item.menuEl && item.menuEl !== matched.menuEl) {
                            item.menuEl.classList.remove('active');
                        }
                    }
                }
            });

            document.title = matched.title;

            if (pushState) {
                history.pushState({ path: path }, '', path);
            }

            if (isDetail) {
                const id = isDetail[1];
                showBookingDetail(null, id, false);
            }
        }
        window.navigateTo = navigateTo;

        function showBookingDetail(event, id, shouldPushState = true) {
            if (event) event.preventDefault();
            
            const loader = document.getElementById('detailLoading');
            const body = document.getElementById('detailBody');
            
            if (loader) loader.style.display = 'flex';
            if (body) body.style.display = 'none';

            if (shouldPushState) {
                navigateTo(`/detail-riwayat-booking/${id}`);
                return;
            }
            
            window.currentDetailBookingId = id;
            
            fetch(`/detail-riwayat-booking/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && body && loader) {
                    const booking = data.booking;
                    
                    document.getElementById('detailBanner').src = booking.cover_photo;
                    document.getElementById('detailPropertyName').textContent = booking.nama_properti;
                    
                    let statusLabel = 'Ditolak';
                    if (booking.status_booking === 'pending') statusLabel = 'Pending';
                    else if (booking.status_booking === 'confirmed') statusLabel = 'Disetujui';
                    else if (booking.status_booking === 'completed') statusLabel = 'Selesai';
                    else if (booking.status_booking === 'cancelled') statusLabel = 'Dibatalkan';
                    
                    document.getElementById('detailStatusBooking').textContent = statusLabel;
                    document.getElementById('detailStatusPembayaran').textContent = booking.status_pembayaran;
                    document.getElementById('detailTotalPrice').textContent = booking.total_price_formatted;
                    document.getElementById('detailRentangHari').textContent = booking.rentang_hari;
                    document.getElementById('detailPemilik').textContent = booking.pemilik;

                    const statusBadge = document.getElementById('detailStatusBadge');
                    statusBadge.textContent = 'Booking ' + statusLabel;
                    if (booking.status_booking === 'pending') {
                        statusBadge.className = 'booking-status process';
                    } else if (booking.status_booking === 'confirmed') {
                        statusBadge.className = 'booking-status success';
                    } else if (booking.status_booking === 'completed') {
                        statusBadge.className = 'booking-status completed';
                    } else {
                        statusBadge.className = 'booking-status danger';
                    }

                    // Handle Cancel Booking Section
                    const cancelSection = document.getElementById('bookingCancelSection');
                    if (cancelSection) {
                        if (booking.status_booking === 'pending') {
                            cancelSection.style.display = 'block';
                        } else {
                            cancelSection.style.display = 'none';
                        }
                    }
                    
                    // Handle Review Display & Form
                    const reviewSection = document.getElementById('detailReviewSection');
                    const reviewForm = document.getElementById('reviewForm');
                    const existingReview = document.getElementById('existingReview');
                    
                    if (booking.status_booking === 'confirmed' || booking.status_booking === 'completed') {
                        reviewSection.style.display = 'block';
                        
                        if (booking.review) {
                            // Review exists
                            reviewForm.style.display = 'none';
                            existingReview.style.display = 'block';
                            
                            // Render stars
                            let starsHtml = '';
                            for (let i = 1; i <= 5; i++) {
                                if (i <= booking.review.rating) {
                                    starsHtml += '★';
                                } else {
                                    starsHtml += '☆';
                                }
                            }
                            document.getElementById('displayReviewStars').textContent = starsHtml;
                            document.getElementById('displayReviewDate').textContent = booking.review.tanggal_review;
                            document.getElementById('displayReviewText').textContent = booking.review.komentar || 'Tidak ada komentar tertulis.';
                            
                            // Handle Mitra Reply
                            const mitraReply = document.getElementById('displayMitraReply');
                            if (booking.review.balasan_mitra) {
                                mitraReply.style.display = 'block';
                                document.getElementById('mitraReplyAuthor').textContent = booking.pemilik + ' (Pemilik Properti)';
                                document.getElementById('mitraReplyDate').textContent = booking.review.tanggal_balasan;
                                document.getElementById('mitraReplyText').textContent = booking.review.balasan_mitra;
                            } else {
                                mitraReply.style.display = 'none';
                            }
                        } else {
                            // Review doesn't exist yet, show form
                            reviewForm.style.display = 'block';
                            existingReview.style.display = 'none';
                            
                            // Reset form
                            document.getElementById('ratingValue').value = '';
                            document.getElementById('reviewKomentar').value = '';
                            setRating(0);
                        }
                    } else {
                        reviewSection.style.display = 'none';
                    }
                    
                    loader.style.display = 'none';
                    body.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                if (loader) {
                    loader.innerHTML = '<p style="color: #dc3545; font-size: 14px; font-weight: 500;">Gagal memuat detail booking. Silakan coba lagi.</p>';
                }
            });
        }
        window.showBookingDetail = showBookingDetail;

        let currentRating = 0;
        function setRating(rating) {
            currentRating = rating;
            document.getElementById('ratingValue').value = rating;
            const stars = document.querySelectorAll('.star-input');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = '#f7c948'; // Gold
                } else {
                    star.style.color = '#d1d5db'; // Grey
                }
            });
        }
        window.setRating = setRating;

        // Custom Alert Modal Function
        function showCustomAlert(message, alertType = 'success') {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'custom-modal-overlay';
                
                overlay.innerHTML = `
                    <div class="custom-modal-box">
                        <div class="custom-modal-icon ${alertType}">
                            ${alertType === 'success' ? '✓' : '!'}
                        </div>
                        <h3>${alertType === 'success' ? 'Sukses' : 'Gagal'}</h3>
                        <p>${message}</p>
                        <div class="custom-modal-actions" style="justify-content: center;">
                            <button class="custom-modal-btn ok-btn">OK</button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 10);
                
                const okBtn = overlay.querySelector('.ok-btn');
                
                function close() {
                    overlay.classList.remove('active');
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }
                
                okBtn.onclick = () => {
                    close();
                    resolve();
                };
                
                overlay.onclick = (e) => {
                    if (e.target === overlay) {
                        close();
                        resolve();
                    }
                };
            });
        }
        window.showCustomAlert = showCustomAlert;

        function submitReview(event) {
            event.preventDefault();
            const rating = document.getElementById('ratingValue').value;
            const komentar = document.getElementById('reviewKomentar').value;

            if (!rating) {
                showCustomAlert('Silakan pilih rating bintang terlebih dahulu.', 'danger');
                return;
            }

            const bookingId = window.currentDetailBookingId;
            
            fetch(`/booking/${bookingId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    rating: rating,
                    komentar: komentar
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        showBookingDetail(null, bookingId, false);
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal mengirim ulasan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting review:', error);
                showCustomAlert('Terjadi kesalahan saat mengirim ulasan.', 'danger');
            });
        }
        window.submitReview = submitReview;

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

            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatBooking = document.getElementById('menu-riwayat-booking');
            const menuSavedProperti = document.getElementById('menu-saved-properti');
            const menuRiwayatTransaksi = document.getElementById('menu-riwayat-transaksi');

            if (menuTentangSaya) {
                menuTentangSaya.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-user');
                });
            }

            if (menuRiwayatBooking) {
                menuRiwayatBooking.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/riwayat-booking');
                });
            }

            if (menuSavedProperti) {
                menuSavedProperti.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/saved-properti');
                });
            }

            if (menuRiwayatTransaksi) {
                menuRiwayatTransaksi.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/riwayat-transaksi');
                });
            }

            // Initial load check (could be loaded with activeBookingId from server)
            const currentPath = window.location.pathname;
            if (window.activeBookingId) {
                navigateTo(`/detail-riwayat-booking/${window.activeBookingId}`, false);
            } else {
                navigateTo(currentPath, false);
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                const path = (e.state && e.state.path) ? e.state.path : window.location.pathname;
                navigateTo(path, false);
            });
        });

        function showCustomConfirm(message, actionType = 'confirm') {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'custom-modal-overlay';
                
                let confirmBtnStyle = 'background: #f7c948; color: #111111;';
                if (actionType === 'danger') {
                    confirmBtnStyle = 'background: #e11d48; color: #ffffff;';
                }
                
                overlay.innerHTML = `
                    <div class="custom-modal-box">
                        <div class="custom-modal-icon ${actionType === 'danger' ? 'danger' : 'success'}">
                            ${actionType === 'danger' ? '!' : '?'}
                        </div>
                        <h3>Konfirmasi</h3>
                        <p>${message}</p>
                        <div class="custom-modal-actions" style="display: flex; gap: 12px; justify-content: center;">
                            <button class="custom-modal-btn cancel-btn" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db;">Batal</button>
                            <button class="custom-modal-btn confirm-btn" style="${confirmBtnStyle}">Ya, Lanjutkan</button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 10);
                
                const cancelBtn = overlay.querySelector('.cancel-btn');
                const confirmBtn = overlay.querySelector('.confirm-btn');
                
                function close() {
                    overlay.classList.remove('active');
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }
                
                cancelBtn.onclick = () => {
                    close();
                    resolve(false);
                };
                
                confirmBtn.onclick = () => {
                    close();
                    resolve(true);
                };
                
                overlay.onclick = (e) => {
                    if (e.target === overlay) {
                        close();
                        resolve(false);
                    }
                };
            });
        }

        async function confirmCancelBooking() {
            const bookingId = window.currentDetailBookingId;
            if (!bookingId) return;

            const confirmed = await showCustomConfirm('Apakah Anda yakin ingin membatalkan booking ini?', 'danger');
            if (!confirmed) return;

            fetch(`/booking/${bookingId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        // Refresh booking details
                        showBookingDetail(null, bookingId, false);
                        
                        // Also update status inside the list of bookings on the left side
                        const card = document.querySelector(`.booking-card[href*="/detail-riwayat-booking/${bookingId}"]`);
                        if (card) {
                            const statusDiv = card.querySelector('.status');
                            if (statusDiv) {
                                statusDiv.className = 'status';
                                statusDiv.style.cssText = 'background:#fee2e2;color:#991b1b;';
                                statusDiv.textContent = 'Dibatalkan';
                            }
                        }
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal membatalkan booking.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error cancelling booking:', error);
                showCustomAlert('Terjadi kesalahan saat membatalkan booking.', 'danger');
            });
        }
        window.confirmCancelBooking = confirmCancelBooking;

        function toggleDropdown(dropdownId, event) {
            if (event) event.stopPropagation();
            const dropdown = document.getElementById(dropdownId);
            const isVisible = dropdown.style.display === 'block';
            
            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu-list').forEach(d => {
                d.style.display = 'none';
            });
            
            if (!isVisible) {
                dropdown.style.display = 'block';
            }
        }
        window.toggleDropdown = toggleDropdown;

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu-list').forEach(d => {
                d.style.display = 'none';
            });
        });

        function selectBookingFilter(statusValue, statusText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-booking-status-value').value = statusValue;
            document.getElementById('booking-status-display').textContent = statusText;
            document.getElementById('booking-status-dropdown').style.display = 'none';
            searchBookings();
        }
        window.selectBookingFilter = selectBookingFilter;

        function searchBookings() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filter-booking-status-value').value;
            const cards = document.querySelectorAll('#section-riwayat-booking .booking-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const city = card.querySelector('p').textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                
                const matchesQuery = title.includes(query) || city.includes(query);
                const matchesStatus = (statusFilter === 'all') || (status === statusFilter);
                
                if (matchesQuery && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        window.searchBookings = searchBookings;

        function selectTransactionFilter(statusValue, statusText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-transaction-status-value').value = statusValue;
            document.getElementById('transaction-status-display').textContent = statusText;
            document.getElementById('transaction-status-dropdown').style.display = 'none';
            searchTransactions();
        }
        window.selectTransactionFilter = selectTransactionFilter;

        function selectTransactionSortFilter(sortValue, sortText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-transaction-sort-value').value = sortValue;
            document.getElementById('transaction-sort-display').textContent = sortText;
            document.getElementById('transaction-sort-dropdown').style.display = 'none';
            searchTransactions();
        }
        window.selectTransactionSortFilter = selectTransactionSortFilter;

        function searchTransactions() {
            const query = document.getElementById('transactionSearchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filter-transaction-status-value').value;
            const sortFilter = document.getElementById('filter-transaction-sort-value').value;
            const container = document.querySelector('#section-riwayat-transaksi .booking-list');
            const cards = Array.from(document.querySelectorAll('#section-riwayat-transaksi .transaction-card'));
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const text = card.textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                
                const matchesQuery = title.includes(query) || text.includes(query);
                const matchesStatus = (statusFilter === 'all') || (status === statusFilter);
                
                if (matchesQuery && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            // Sort cards
            cards.sort((a, b) => {
                const timeA = parseInt(a.getAttribute('data-timestamp'));
                const timeB = parseInt(b.getAttribute('data-timestamp'));
                if (sortFilter === 'newest') {
                    return timeB - timeA;
                } else {
                    return timeA - timeB;
                }
            });

            // Re-append cards in sorted order
            cards.forEach(card => container.appendChild(card));
        }
        window.searchTransactions = searchTransactions;
    </script>
</body>

</html>
