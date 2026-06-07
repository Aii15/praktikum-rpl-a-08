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
            padding-top: 55px;
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

        .process {
            background: #fef3c7;
            color: #b45309;
        }

        .menu-item img[src*="upgrade.svg"] {
            filter: none !important;
        }

        /* Detail Booking Modal Styles */
        .booking-modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeInModal 0.25s ease forwards;
        }

        .booking-modal-content {
            background: #ffffff;
            border-radius: 24px;
            width: 90%;
            max-width: 580px;
            padding: 28px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            position: relative;
            animation: popInModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            border: 1px solid #e5e7eb;
        }

        .booking-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 26px;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            transition: color 0.2s ease, transform 0.2s ease;
            line-height: 1;
        }

        .booking-modal-close:hover {
            color: #111827;
            transform: scale(1.1);
        }

        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
            letter-spacing: 0.3px;
        }

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

        .modal-banner-container {
            width: 100%;
            height: 180px;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .modal-banner-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-info-section h3 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 24px;
        }

        .modal-info-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .modal-info-group span {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            font-weight: 500;
        }

        .modal-info-group strong {
            font-size: 14px;
            color: #374151;
            font-weight: 600;
        }

        /* Modal status styling */
        .modal-status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            width: fit-content;
        }

        .modal-status-badge.process {
            background: #fef3c7;
            color: #b45309;
        }

        .modal-status-badge.success {
            background: #dcfce7;
            color: #15803d;
        }

        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes popInModal {
            from { transform: scale(0.9) translateY(10px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
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
                                <div class="status success">Selesai</div>
                            @else
                                <div class="status" style="background:#fee2e2;color:#991b1b;">{{ ucfirst($booking->status_booking) }}</div>
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
        </section>

    </main>

    <!-- Detail Booking Modal -->
    <div id="bookingDetailModal" class="booking-modal-overlay">
        <div class="booking-modal-content">
            <span class="booking-modal-close" onclick="closeBookingDetail()">&times;</span>
            <h2 class="modal-title">Detail Booking</h2>
            
            <div id="modalLoading" class="modal-loader-container">
                <div class="modal-spinner"></div>
                <p>Memuat detail booking...</p>
            </div>
            
            <div id="modalBody" style="display: none;">
                <div class="modal-banner-container">
                    <img id="modalBanner" src="" alt="Property Banner">
                </div>
                
                <div class="modal-info-section">
                    <h3 id="modalPropertyName"></h3>
                    
                    <div class="modal-grid">
                       <div class="modal-info-group">
                           <span>Status Booking</span>
                           <strong id="modalStatusBooking"></strong>
                       </div>
                       <div class="modal-info-group">
                           <span>Status Pembayaran</span>
                           <strong id="modalStatusPembayaran"></strong>
                       </div>
                       <div class="modal-info-group">
                           <span>Total Harga</span>
                           <strong id="modalTotalPrice"></strong>
                       </div>
                       <div class="modal-info-group">
                           <span>Rentang Hari</span>
                           <strong id="modalRentangHari"></strong>
                       </div>
                       <div class="modal-info-group">
                           <span>Pemilik Properti</span>
                           <strong id="modalPemilik"></strong>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global booking ID passed from server for direct loads
        window.activeBookingId = @json($activeBookingId ?? null);

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

            // SPA Routing logic
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatBooking = document.getElementById('menu-riwayat-booking');
            const menuSavedProperti = document.getElementById('menu-saved-properti');

            const menuItems = [
                { path: '/profile-user', sectionId: 'section-tentang-saya', title: 'Profile User - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-booking', sectionId: 'section-riwayat-booking', title: 'Riwayat Booking - SpotRent', menuEl: menuRiwayatBooking },
                { path: '/saved-properti', sectionId: 'section-saved-properti', title: 'Saved Properti - SpotRent', menuEl: menuSavedProperti }
            ];

            function navigateTo(path, pushState = true) {
                let isDetail = path.match(/^\/detail-riwayat-booking\/(\d+)$/);
                let matchedPath = isDetail ? '/riwayat-booking' : path;

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
                            if (item.menuEl) item.menuEl.classList.remove('active');
                        }
                    }
                });

                document.title = isDetail ? 'Detail Booking - SpotRent' : matched.title;

                if (pushState) {
                    history.pushState({ path: path }, '', path);
                }

                if (isDetail) {
                    const id = isDetail[1];
                    showBookingDetail(null, id, false);
                } else {
                    closeBookingDetail(false);
                }
            }

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

        window.showBookingDetail = function(event, id, shouldPushState = true) {
            if (event) event.preventDefault();
            
            const modal = document.getElementById('bookingDetailModal');
            const loader = document.getElementById('modalLoading');
            const body = document.getElementById('modalBody');
            
            modal.style.display = 'flex';
            loader.style.display = 'flex';
            body.style.display = 'none';

            if (shouldPushState) {
                history.pushState({ path: `/detail-riwayat-booking/${id}` }, '', `/detail-riwayat-booking/${id}`);
                document.title = 'Detail Booking - SpotRent';
            }
            
            fetch(`/detail-riwayat-booking/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const booking = data.booking;
                    
                    document.getElementById('modalBanner').src = booking.cover_photo;
                    document.getElementById('modalPropertyName').textContent = booking.nama_properti;
                    
                    const statusText = booking.status_booking.charAt(0).toUpperCase() + booking.status_booking.slice(1);
                    const statusEl = document.getElementById('modalStatusBooking');
                    statusEl.textContent = statusText;
                    statusEl.className = 'modal-status-badge ' + (booking.status_booking === 'pending' ? 'process' : 'success');
                    
                    document.getElementById('modalStatusPembayaran').textContent = booking.status_pembayaran;
                    document.getElementById('modalTotalPrice').textContent = booking.total_price_formatted;
                    document.getElementById('modalRentangHari').textContent = booking.rentang_hari;
                    document.getElementById('modalPemilik').textContent = booking.pemilik;
                    
                    loader.style.display = 'none';
                    body.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                loader.innerHTML = '<p style="color: #dc3545; font-size: 14px; font-weight: 500;">Gagal memuat detail booking. Silakan coba lagi.</p>';
            });
        };

        window.closeBookingDetail = function(shouldPushState = true) {
            document.getElementById('bookingDetailModal').style.display = 'none';
            if (shouldPushState) {
                history.pushState({ path: '/riwayat-booking' }, '', '/riwayat-booking');
                document.title = 'Riwayat Booking - SpotRent';
            }
        };

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('bookingDetailModal');
            if (event.target === modal) {
                closeBookingDetail();
            }
        });
    </script>
</body>

</html>
