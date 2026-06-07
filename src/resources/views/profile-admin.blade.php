<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SpotRent</title>
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
            color: #d97706;
            transform: translateY(-2px);
        }

        .home-link:hover img {
            transform: scale(1.1) rotate(-5deg);
            filter: sepia(100%) saturate(300%) hue-rotate(5deg);
        }

        .content {
            padding-top: 0px;
            max-width: 900px;
            width: 100%;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: .5px;
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

        /* Log Aktivitas Dashboard Cards */
        .admin-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
            width: 100%;
        }

        .admin-card {
            width: 100%;
            height: 68px;
            background: #f3f4f6;
            border-radius: 12px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            cursor: pointer;
        }

        .admin-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            border-color: #f7c948;
        }

        .admin-card span {
            font-size: 16px;
            font-weight: 600;
        }

        .admin-card img {
            width: 22px;
            height: 22px;
            object-fit: contain;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .admin-card:hover img {
            opacity: 1;
        }

        /* List Items Cards (Properties & Bookings) */
        .item-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .item-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            width: 100%;
        }

        .item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .item-card img.item-thumb {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .item-info {
            flex: 1;
        }

        .item-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
            color: #111827;
        }

        .item-info p {
            color: #6b7280;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .item-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .item-action {
            font-size: 14px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            text-align: right;
            transition: color 0.2s ease;
            cursor: pointer;
        }

        .item-action:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Review Section Container (Screenshot 2) */
        .review-container {
            margin-bottom: 24px;
            background: #f9fafb;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
        }

        .review-box {
            background: #f3f4f6;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .review-header span {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-decision {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none;
        }

        .btn-decision.accept {
            background: #dcfce7;
            color: #16a34a;
        }

        .btn-decision.accept:hover {
            background: #bbf7d0;
            transform: translateY(-1px);
        }

        .btn-decision.reject {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-decision.reject:hover {
            background: #fecaca;
            transform: translateY(-1px);
        }

        .review-box textarea {
            width: 100%;
            height: 110px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            resize: none;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            background: #ffffff;
            transition: border-color 0.2s ease;
        }

        .review-box textarea:focus {
            border-color: #f7c948;
        }

        /* Back button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 30px;
            text-decoration: none;
            color: #4b5563;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease, transform 0.2s ease;
            cursor: pointer;
            background: none;
            border: none;
            outline: none;
        }

        .back-btn:hover {
            color: #111827;
            transform: translateX(-4px);
        }

        /* Status label styles */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        .status-badge.approved {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #b45309;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Flash alert style */
        .flash-alert {
            background: #d1fae5;
            color: #065f46;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(6, 95, 70, 0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #flash-message-container {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
                    <a href="/profile-admin" id="menu-log-aktivitas" class="menu-item active">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Log Aktivitas">
                        <span>Log Aktivitas</span>
                    </a>

                    <a href="/admin/list-properti" id="menu-list-properti" class="menu-item">
                        <img src="/images/profile/property.png" class="menu-icon" alt="List Properti">
                        <span>List Properti</span>
                    </a>
                </nav>
            </div>

            <div>
                <a href="/" class="home-link" style="margin-bottom: 12px;">
                    <img src="/images/profile/home.png" alt="Beranda Icon">
                    <span>Ke Beranda</span>
                </a>

                <a href="#" class="home-link" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/icons/logout.svg" alt="Logout Icon" style="width: 28px; height: 28px; filter: invert(34%) sepia(82%) saturate(3685%) hue-rotate(338deg) brightness(96%) contrast(96%);">
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <section class="content">
            @if(session('success'))
                <div id="flash-message-container">
                    <div class="flash-alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- SECTION 1: LOG AKTIVITAS (DASHBOARD) -->
            <div id="section-log-aktivitas" class="content-section">
                <h1>Log Aktivitas</h1>

                <div class="admin-list">
                    <a href="/admin/pengajuan-properti" class="admin-card" id="card-pengajuan-properti">
                        <span>Pengajuan Properti</span>
                        <img src="/images/profile/edit.png" alt="Edit Icon">
                    </a>

                    <a href="/admin/riwayat-pemesanan" class="admin-card" id="card-riwayat-pemesanan">
                        <span>Riwayat Pemesanan</span>
                        <img src="/images/profile/edit.png" alt="Edit Icon">
                    </a>
                </div>
            </div>

            <!-- SECTION 2: PENGAJUAN PROPERTI -->
            <div id="section-pengajuan-properti" class="content-section">
                <h1>Pengajuan Properti</h1>

                <div class="item-list">
                    @forelse($pendingProperties as $property)
                        <div class="review-container">
                            <div class="item-card" style="box-shadow: none; border: none; background: transparent;">
                                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: center {{ $property->coverPhoto->object_position ?? '50' }}%;">

                                <div class="item-info">
                                    <h3>{{ $property->nama_properti }}</h3>
                                    <p>Wilayah: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                                    <p>Mitra: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</p>
                                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                                </div>

                                <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                                    <div class="status-badge pending">Status: Menunggu</div>
                                    <a href="{{ route('detail-properti', $property->id_properti) }}" target="_blank" class="item-action">Info Properti</a>
                                </div>
                            </div>

                            <div class="review-box">
                                <form action="{{ route('admin.property.review', $property->id_properti) }}" method="POST">
                                    @csrf
                                    <div class="review-header">
                                        <span>Catatan</span>

                                        <div class="action-buttons">
                                            <button type="submit" name="status_pengajuan" value="approved" class="btn-decision accept">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Terima
                                            </button>
                                            <button type="submit" name="status_pengajuan" value="rejected" class="btn-decision reject">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Tolak
                                            </button>
                                        </div>
                                    </div>

                                    <textarea name="catatan" placeholder="Tulis Catatan Di Sini"></textarea>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                            Tidak ada pengajuan properti baru yang perlu di-review.
                        </div>
                    @endforelse
                </div>

                <button id="kembali-pengajuan" class="back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali
                </button>
            </div>

            <!-- SECTION 3: RIWAYAT PEMESANAN -->
            <div id="section-riwayat-pemesanan" class="content-section">
                <h1>Riwayat Pemesanan</h1>

                <div class="item-list">
                    @forelse($bookings as $booking)
                        <div class="item-card">
                            <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $booking->property->nama_properti ?? 'Properti' }}" style="object-position: center {{ $booking->property->coverPhoto->object_position ?? '50' }}%;">

                            <div class="item-info">
                                <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                                <p>Wilayah: {{ $booking->property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                                <p>Penyewa: {{ $booking->user->name ?? 'Penyewa tidak diketahui' }}</p>
                                <p>Durasi: {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                                <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                            </div>

                            <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                                @if($booking->status_booking === 'pending')
                                    <div class="status-badge pending">Pending</div>
                                @elseif($booking->status_booking === 'confirmed' || $booking->status_booking === 'completed')
                                    <div class="status-badge approved">Disetujui</div>
                                @else
                                    <div class="status-badge rejected">{{ ucfirst($booking->status_booking) }}</div>
                                @endif
                                <span style="font-size: 13px; color: #6b7280;">Info Pemesanan</span>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                            Belum ada riwayat pemesanan di dalam sistem.
                        </div>
                    @endforelse
                </div>

                <button id="kembali-riwayat" class="back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali
                </button>
            </div>

            <!-- SECTION 4: LIST PROPERTI -->
            <div id="section-list-properti" class="content-section">
                <h1>List Properti</h1>

                <div class="item-list">
                    @forelse($allProperties as $property)
                        <div class="item-card">
                            <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: center {{ $property->coverPhoto->object_position ?? '50' }}%;">

                            <div class="item-info">
                                <h3>{{ $property->nama_properti }}</h3>
                                <p>Wilayah: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                                <p>Mitra: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</p>
                                <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                            </div>

                            <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                                @if($property->status_pengajuan === 'approved')
                                    <div class="status-badge approved">Disetujui</div>
                                @elseif($property->status_pengajuan === 'pending')
                                    <div class="status-badge pending">Menunggu</div>
                                @else
                                    <div class="status-badge rejected">Ditolak</div>
                                @endif
                                <a href="{{ route('detail-properti', $property->id_properti) }}" target="_blank" class="item-action">Lihat Info Properti</a>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                            Belum ada properti terdaftar dalam sistem.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash message banner timeout
            const flashContainer = document.getElementById('flash-message-container');
            if (flashContainer) {
                setTimeout(() => {
                    flashContainer.style.opacity = '0';
                    flashContainer.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        flashContainer.style.display = 'none';
                    }, 500);
                }, 4000);
            }

            // SPA Router setup
            const menuLogAktivitas = document.getElementById('menu-log-aktivitas');
            const menuListProperti = document.getElementById('menu-list-properti');
            const cardPengajuanProperti = document.getElementById('card-pengajuan-properti');
            const cardRiwayatPemesanan = document.getElementById('card-riwayat-pemesanan');
            const kembaliPengajuan = document.getElementById('kembali-pengajuan');
            const kembaliRiwayat = document.getElementById('kembali-riwayat');

            const menuItems = [
                { path: '/profile-admin', sectionId: 'section-log-aktivitas', title: 'Dashboard Admin - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/pengajuan-properti', sectionId: 'section-pengajuan-properti', title: 'Pengajuan Properti - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/riwayat-pemesanan', sectionId: 'section-riwayat-pemesanan', title: 'Riwayat Pemesanan - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/list-properti', sectionId: 'section-list-properti', title: 'List Properti - SpotRent', menuEl: menuListProperti }
            ];

            function navigateTo(path, pushState = true) {
                let matched = menuItems.find(item => item.path === path);
                if (!matched) {
                    matched = menuItems[0];
                }

                // Transition sections
                menuItems.forEach(item => {
                    const sec = document.getElementById(item.sectionId);
                    if (item === matched) {
                        sec.style.display = 'block';
                        sec.offsetHeight; // force reflow
                        sec.classList.add('active');
                    } else {
                        sec.classList.remove('active');
                        sec.style.display = 'none';
                    }
                });

                // Update active states on sidebar items
                menuItems.forEach(item => {
                    if (item.menuEl) {
                        if (item.menuEl === matched.menuEl) {
                            item.menuEl.classList.add('active');
                        } else {
                            item.menuEl.classList.remove('active');
                        }
                    }
                });

                document.title = matched.title;

                if (pushState) {
                    history.pushState({ path: matched.path }, '', matched.path);
                }
            }

            // Click Handlers
            if (menuLogAktivitas) {
                menuLogAktivitas.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }
            if (menuListProperti) {
                menuListProperti.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/list-properti');
                });
            }
            if (cardPengajuanProperti) {
                cardPengajuanProperti.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/pengajuan-properti');
                });
            }
            if (cardRiwayatPemesanan) {
                cardRiwayatPemesanan.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/riwayat-pemesanan');
                });
            }
            if (kembaliPengajuan) {
                kembaliPengajuan.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }
            if (kembaliRiwayat) {
                kembaliRiwayat.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }

            // Init page from URL
            const currentPath = window.location.pathname;
            navigateTo(currentPath, false);

            // Popstate browser navigation
            window.addEventListener('popstate', function(e) {
                const path = (e.state && e.state.path) ? e.state.path : window.location.pathname;
                navigateTo(path, false);
            });
        });
    </script>
</body>

</html>
