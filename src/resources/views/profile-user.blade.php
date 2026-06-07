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
            margin-bottom: 25px;
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
            <div id="section-tentang-saya" class="content-section">
                <h1>Tentang Saya</h1>

                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    <div class="form-list">
                        <div class="field-card" onclick="this.querySelector('input').focus();">
                            <div class="field-text">
                                <small>Nama Lengkap</small>
                                <input type="text" name="name" class="profile-input" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                        </div>

                        <div class="field-card" onclick="this.querySelector('input').focus();">
                            <div class="field-text">
                                <small>E-Mail</small>
                                <input type="email" name="email" class="profile-input" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                        </div>

                        <div class="field-card" onclick="this.querySelector('input').focus();">
                            <div class="field-text">
                                <small>No Telepon</small>
                                <input type="text" name="no_hp" class="profile-input" value="{{ old('no_hp', $user->no_hp) }}" required>
                            </div>
                            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                        </div>

                        <div class="field-card" onclick="this.querySelector('input').focus();">
                            <div class="field-text">
                                <small>Alamat</small>
                                <input type="text" name="alamat" class="profile-input" value="{{ old('alamat', $user->alamat) }}" placeholder="Belum mengatur alamat">
                            </div>
                            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                        </div>

                        <div class="field-card" onclick="this.querySelector('input').focus();">
                            <div class="field-text">
                                <small>Password</small>
                                <input type="password" name="password" class="profile-input" placeholder="Kosongkan jika tidak ingin mengubah password">
                            </div>
                            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                        </div>
                    </div>

                    <button type="submit" class="save-btn">Simpan Perubahan</button>
                </form>
            </div>

            <!-- SECTION 2: RIWAYAT BOOKING -->
            <div id="section-riwayat-booking" class="content-section">
                <h1>Riwayat Booking</h1>

                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Cari booking..." onkeyup="searchBookings()">
                </div>

                <div class="booking-list">
                    @forelse($bookings as $booking)
                        <a href="{{ route('user.booking.detail', $booking->id_booking) }}" onclick="showBookingDetail(event, {{ $booking->id_booking }})" class="booking-card">
                            <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $booking->property->nama_properti ?? 'Property' }}">

                            <div class="booking-info">
                                <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                                <p>{{ $booking->property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                                <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                            </div>

                            @if($booking->status_booking === 'pending')
                                <div class="status process">Pending</div>
                            @elseif($booking->status_booking === 'confirmed')
                                <div class="status success">Disetujui</div>
                            @elseif($booking->status_booking === 'completed')
                                <div class="status completed">Selesai</div>
                            @else
                                <div class="status" style="background:#fee2e2;color:#991b1b;">Ditolak</div>
                            @endif
                        </a>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                            Anda belum memiliki riwayat booking.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECTION 3: SAVED PROPERTIES -->
            <div id="section-saved-properti" class="content-section">
                <h1>Saved Properti</h1>

                <div class="booking-list">
                    @forelse($wishlists as $wishlist)
                        @if($wishlist->property)
                            <a href="{{ route('detail-properti', $wishlist->property->id_properti) }}" class="booking-card">
                                <img src="{{ $wishlist->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $wishlist->property->nama_properti }}">

                                <div class="booking-info">
                                    <h3>{{ $wishlist->property->nama_properti }}</h3>
                                    <p>{{ $wishlist->property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                                    <strong>Rp {{ number_format($wishlist->property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                                </div>

                                <div style="display: flex; align-items: center; justify-content: flex-end; padding-right: 15px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 28px; height: 28px; color: #ef4444; fill: #ef4444;">
                                        <path d="M15 8C8.925 8 4 12.925 4 19c0 11 13 21 20 23.326C31 40 44 30 44 19c0-6.075-4.925-11-11-11c-3.72 0-7.01 1.847-9 4.674A10.99 10.99 0 0 0 15 8" />
                                    </svg>
                                </div>
                            </a>
                        @endif
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                            Anda belum menyimpan properti apa pun.
                        </div>
                    @endforelse
                </div>
            </div>
            <!-- SECTION 4: DETAIL BOOKING -->
            <div id="section-detail-booking" class="content-section">
                <h1>Detail Booking</h1>

                <div id="detailLoading" class="modal-loader-container">
                    <div class="modal-spinner"></div>
                    <p>Memuat detail booking...</p>
                </div>

                <div id="detailBody" style="display: none;">
                    <div class="detail-card">
                        <img id="detailBanner" src="" class="detail-banner" alt="Property Banner">

                        <div class="detail-info">
                            <h2 id="detailPropertyName"></h2>

                            <div class="info-grid">
                                <div class="info-group">
                                    <strong>Status Booking</strong>
                                    <p id="detailStatusBooking"></p>
                                </div>

                                <div class="info-group">
                                    <strong>Status Pembayaran</strong>
                                    <p id="detailStatusPembayaran"></p>
                                </div>

                                <div class="info-group">
                                    <strong>Total Harga</strong>
                                    <p id="detailTotalPrice"></p>
                                </div>

                                <div class="info-group">
                                    <strong>Rentang Hari</strong>
                                    <p id="detailRentangHari"></p>
                                </div>

                                <div class="info-group">
                                    <strong>Pemilik Properti</strong>
                                    <p id="detailPemilik"></p>
                                </div>
                            </div>

                            <span id="detailStatusBadge" class="booking-status"></span>
                        </div>
                    </div>

                    <a href="/riwayat-booking" onclick="event.preventDefault(); navigateTo('/riwayat-booking');" class="back-btn">
                        ← Kembali ke Riwayat
                    </a>
                </div>
            </div>
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

            const menuItems = [
                { path: '/profile-user', sectionId: 'section-tentang-saya', title: 'Profile User - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-booking', sectionId: 'section-riwayat-booking', title: 'Riwayat Booking - SpotRent', menuEl: menuRiwayatBooking },
                { path: '/saved-properti', sectionId: 'section-saved-properti', title: 'Saved Properti - SpotRent', menuEl: menuSavedProperti },
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

        function searchBookings() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.booking-card');
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const city = card.querySelector('p').textContent.toLowerCase();
                if (title.includes(query) || city.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
