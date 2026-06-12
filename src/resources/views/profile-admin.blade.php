<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        .notification-bubble {
            background: #ef4444;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }

        .menu-item .notification-bubble {
            margin-left: auto;
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
            border: 3px solid #e5e7eb;
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

        .item-action.btn-preview {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
            text-align: center;
            text-decoration: none !important;
            box-shadow: 0 2px 5px rgba(37, 99, 235, 0.2);
            cursor: pointer;
        }

        .item-action.btn-preview:hover {
            background: #1d4ed8;
            color: #ffffff !important;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
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

        .custom-modal-icon.info {
            background: #e0f2fe;
            color: #0284c7;
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

        .custom-modal-btn.cancel-btn {
            background: #e11d48;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
        }

        .custom-modal-btn.cancel-btn:hover {
            background: #be123c;
            box-shadow: 0 6px 16px rgba(225, 29, 72, 0.3);
        }

        /* Filter Controls styles matching Mitra Riwayat Penyewaan */
        .filter-controls-container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 25px;
            position: relative;
            z-index: 20;
        }

        @media (max-width: 768px) {
            .filter-controls-container {
                grid-template-columns: 1fr;
            }
        }

        .filter-card {
            min-height: 64px;
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
            position: relative;
        }

        .filter-card:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .filter-card:focus-within {
            background: #ffffff;
            border-color: #f7c948;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.18);
            transform: translateY(-2px);
        }

        .field-card {
            min-height: 64px;
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
            width: 100%;
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

        .field-card:hover .edit-icon, .filter-card:hover .edit-icon {
            opacity: 1;
            transform: scale(1.1);
        }

        .selected-display {
            font-size: 15px;
            font-weight: 500;
            color: #222;
            margin-top: 2px;
        }

        .status-badge-inline {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge-inline.success {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge-inline.completed {
            background: #e0f2fe;
            color: #0369a1;
        }

        .status-badge-inline.process {
            background: #fef3c7;
            color: #b45309;
        }

        .status-badge-inline.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .dropdown-menu-list {
            display: none;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s ease;
        }

        .dropdown-item-row:hover {
            background: #f3f4f6;
        }

        /* Statistics Panel Styles */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stats-item-card {
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid transparent;
        }
        .stats-item-card.blue {
            background: #eff6ff;
            border-color: #bfdbfe;
        }
        .stats-item-card.green {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }
        .stats-item-card.orange {
            background: #fffbeb;
            border-color: #fef08a;
        }
        .stats-item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        .stats-item-card.blue:hover {
            background: #ffffff;
            border-color: #3b82f6;
        }
        .stats-item-card.green:hover {
            background: #ffffff;
            border-color: #22c55e;
        }
        .stats-item-card.orange:hover {
            background: #ffffff;
            border-color: #eab308;
        }
        .stats-item-card h4 {
            font-size: 14px;
            font-weight: 600;
        }
        .stats-item-card.blue h4 {
            color: #1e40af;
        }
        .stats-item-card.green h4 {
            color: #166534;
        }
        .stats-item-card.orange h4 {
            color: #854d0e;
        }
        .stats-item-card .stats-value {
            font-size: 32px;
            font-weight: 700;
        }
        .stats-item-card.blue .stats-value {
            color: #1d4ed8;
        }
        .stats-item-card.green .stats-value {
            color: #15803d;
        }
        .stats-item-card.orange .stats-value {
            color: #b45309;
        }
        .stats-detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .stats-detail-section {
            background: #f9fafb;
            border: 3px solid #e5e7eb;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stats-detail-section:hover {
            border-color: #cbd5e1;
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }
        .stats-detail-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 8px;
        }
        .stats-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #e5e7eb;
            font-size: 14px;
            color: #4b5563;
        }
        .stats-row:last-child {
            border-bottom: none;
        }
        .stats-row strong {
            color: #111827;
            font-weight: 600;
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
                        @if(count($pendingProperties) > 0)
                            <span class="notification-bubble">{{ count($pendingProperties) }}</span>
                        @endif
                    </a>

                    <a href="/admin/list-properti" id="menu-list-properti" class="menu-item">
                        <img src="/images/profile/property.png" class="menu-icon" alt="List Properti">
                        <span>List Properti</span>
                    </a>

                    <a href="/admin/manage-comments" id="menu-manage-comments" class="menu-item">
                        <img src="/icons/chat_icon.svg" class="menu-icon" alt="Kelola Komentar">
                        <span>Kelola Komentar</span>
                    </a>

                    <a href="/admin/manage-users" id="menu-manage-users" class="menu-item">
                        <img src="/icons/members.svg" class="menu-icon" alt="Manajemen Pengguna">
                        <span>Manajemen Pengguna</span>
                    </a>

                    <a href="/admin/stats" id="menu-stats" class="menu-item">
                        <img src="/icons/stats_icon.svg" class="menu-icon" alt="Statistik">
                        <span>Statistik</span>
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
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span>Pengajuan Properti</span>
                            @if(count($pendingProperties) > 0)
                                <span class="notification-bubble" style="box-shadow: 0 2px 5px rgba(239, 68, 68, 0.2);">{{ count($pendingProperties) }}</span>
                            @endif
                        </div>
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
                                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: {{ $property->coverPhoto->position_style ?? 'center 50%' }};">

                                <div class="item-info">
                                    <h3>{{ $property->nama_properti }}</h3>
                                    <p>Wilayah: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                                    <p>Mitra: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</p>
                                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                                </div>

                                <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                                    <div class="status-badge pending">Status: Menunggu</div>
                                    <a href="{{ route('detail-properti', $property->id_properti) }}?preview=admin" target="_blank" class="item-action btn-preview">Preview Detail Properti</a>
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

                <!-- Filter and Sort Controls matching Mitra style -->
                <div class="filter-controls-container">
                    <!-- Search Card -->
                    <div class="field-card filter-card search-card" onclick="document.getElementById('filter-bookings-search-input').focus()">
                        <div class="field-text">
                            <small>Cari Properti / Penyewa</small>
                            <input type="text" id="filter-bookings-search-input" class="profile-input" placeholder="Tulis nama properti atau penyewa..." onkeyup="applyBookingsFilters()">
                        </div>
                        <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                    </div>

                    <!-- Date Dropdown Card (Calendar) -->
                    <div class="field-card filter-card dropdown-card" id="booking-date-filter-container" style="position: relative; z-index: 15;">
                        <div class="field-text">
                            <small>Filter Tanggal</small>
                            <div id="booking-date-display" class="selected-display">Semua Tanggal</div>
                            <input type="text" id="filter-booking-date-range" class="profile-input" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;" placeholder="Pilih rentang tanggal...">
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; position: relative; z-index: 20;">
                            <button id="btn-reset-booking-date" style="display: none; background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; outline: none; font-family: 'Poppins', sans-serif;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'" onclick="resetBookingDateFilter(event)">Reset</button>
                            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon">
                        </div>
                    </div>

                    <!-- Status Dropdown Card -->
                    <div class="field-card filter-card dropdown-card" id="booking-status-dropdown-container" style="position: relative; z-index: 10;">
                        <div class="field-text" onclick="toggleBookingsDropdown('booking-status-dropdown', event)">
                            <small>Status Pemesanan</small>
                            <div id="booking-status-display" class="selected-display">Semua Status</div>
                            <input type="hidden" id="filter-booking-status-value" value="all">
                        </div>
                        <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleBookingsDropdown('booking-status-dropdown', event)">
                        
                        <div id="booking-status-dropdown" class="dropdown-menu-list">
                            <div class="dropdown-item-row booking-status-item-row" data-val="all" onclick="selectBookingStatusFilter('all', 'Semua Status', event)">
                                <span>Semua Status</span>
                            </div>
                            <div class="dropdown-item-row booking-status-item-row" data-val="pending" onclick="selectBookingStatusFilter('pending', 'Pending', event)">
                                <span class="status-badge-inline process">Pending</span>
                            </div>
                            <div class="dropdown-item-row booking-status-item-row" data-val="confirmed" onclick="selectBookingStatusFilter('confirmed', 'Disetujui', event)">
                                <span class="status-badge-inline success">Disetujui</span>
                            </div>
                            <div class="dropdown-item-row booking-status-item-row" data-val="rejected" onclick="selectBookingStatusFilter('rejected', 'Ditolak', event)">
                                <span class="status-badge-inline danger">Ditolak</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-list">
                    @forelse($bookings as $booking)
                        <div class="item-card booking-card-item" 
                             data-property-name="{{ strtolower($booking->property->nama_properti ?? '') }}" 
                             data-tenant-name="{{ strtolower($booking->user->name ?? '') }}" 
                             data-start-date="{{ $booking->tanggal_mulai }}" 
                             data-end-date="{{ $booking->tanggal_selesai }}" 
                             data-status="{{ $booking->status_booking }}">
                            <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $booking->property->nama_properti ?? 'Properti' }}" style="object-position: {{ $booking->property->coverPhoto->position_style ?? 'center 50%' }};">

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
                                <span style="font-size: 13px; color: #2563eb; cursor: pointer; text-decoration: underline; font-weight: 600;" onclick="showBookingDetail({{ $booking->id_booking }})">Info Pemesanan</span>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
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
                            <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: {{ $property->coverPhoto->position_style ?? 'center 50%' }};">

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

            <!-- SECTION 5: KELOLA KOMENTAR -->
            <div id="section-manage-comments" class="content-section">
                <h1>Kelola Komentar</h1>

                <!-- Filter and Sort Controls matching Mitra style -->
                <div class="filter-controls-container">
                    <!-- Search Card -->
                    <div class="field-card filter-card search-card" onclick="document.getElementById('filter-comments-search-input').focus()">
                        <div class="field-text">
                            <small>Cari Properti / Penyewa / Komentar</small>
                            <input type="text" id="filter-comments-search-input" class="profile-input" placeholder="Tulis nama properti, penyewa, atau ulasan..." onkeyup="applyCommentsFilters()">
                        </div>
                        <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                    </div>

                    <!-- Rating Dropdown Card -->
                    <div class="field-card filter-card dropdown-card" id="rating-dropdown-container" style="position: relative; z-index: 15;">
                        <div class="field-text" onclick="toggleCommentsDropdown('rating-dropdown', event)">
                            <small>Filter Rating</small>
                            <div id="rating-display" class="selected-display">Semua Rating</div>
                            <input type="hidden" id="filter-rating-value" value="all">
                        </div>
                        <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleCommentsDropdown('rating-dropdown', event)">
                        
                        <div id="rating-dropdown" class="dropdown-menu-list">
                            <div class="dropdown-item-row rating-item-row" data-val="all" onclick="selectCommentsRating('all', 'Semua Rating', event)">
                                <span>Semua Rating</span>
                            </div>
                            @for($stars = 5; $stars >= 1; $stars--)
                            <div class="dropdown-item-row rating-item-row" data-val="{{ $stars }}" onclick="selectCommentsRating('{{ $stars }}', 'Bintang {{ $stars }}', event)">
                                <span class="status-badge-inline process" style="background: #fef9c3; color: #a16207; display: flex; align-items: center; gap: 4px;">
                                    {{ $stars }} ★
                                </span>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Waktu Komentar Dropdown Card -->
                    <div class="field-card filter-card dropdown-card" id="time-dropdown-container" style="position: relative; z-index: 10;">
                        <div class="field-text" onclick="toggleCommentsDropdown('time-dropdown', event)">
                            <small>Waktu Komentar</small>
                            <div id="time-display" class="selected-display">Terbaru</div>
                            <input type="hidden" id="filter-time-value" value="newest">
                        </div>
                        <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleCommentsDropdown('time-dropdown', event)">
                        
                        <div id="time-dropdown" class="dropdown-menu-list">
                            <div class="dropdown-item-row time-item-row" data-val="newest" onclick="selectCommentsTime('newest', 'Terbaru', event)">
                                <span>Terbaru</span>
                            </div>
                            <div class="dropdown-item-row time-item-row" data-val="oldest" onclick="selectCommentsTime('oldest', 'Terlama', event)">
                                <span>Terlama</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-list">
                    @forelse($reviews as $review)
                        @php
                            $property = $review->booking->property ?? null;
                            $penyewa = $review->booking->user ?? null;
                            $coverPhoto = $property ? $property->coverPhoto : null;
                        @endphp
                        <div class="item-card review-card-item" id="review-card-{{ $review->id_review }}" 
                             data-property-name="{{ strtolower($property->nama_properti ?? '') }}" 
                             data-tenant-name="{{ strtolower($penyewa->name ?? '') }}" 
                             data-comment-text="{{ strtolower($review->komentar ?? '') }}" 
                             data-rating="{{ $review->rating }}" 
                             data-has-feedback="{{ $review->balasan_mitra ? 'true' : 'false' }}"
                             data-timestamp="{{ \Carbon\Carbon::parse($review->tanggal_review)->timestamp }}"
                             style="flex-direction: column; align-items: stretch; gap: 16px;">
                            <!-- Property info at the top -->
                            @if($property)
                            <div style="display: flex; align-items: center; gap: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                                <img src="{{ $coverPhoto->url_foto ?? '/images/landing/property.png' }}" style="width: 70px; height: 50px; border-radius: 8px; object-fit: cover; object-position: {{ $coverPhoto->position_style ?? 'center 50%' }};" alt="{{ $property->nama_properti }}">
                                <div>
                                    <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 2px;">{{ $property->nama_properti }}</h4>
                                    <span style="font-size: 12px; color: #6b7280;">Pemilik: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</span>
                                </div>
                            </div>
                            @endif

                            <!-- Review content -->
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                    <div>
                                        <span style="font-size: 14px; font-weight: 600; color: #374151;">{{ $penyewa->name ?? 'Penyewa' }}</span>
                                        <span style="font-size: 12px; color: #9ca3af; margin-left: 8px;">{{ \Carbon\Carbon::parse($review->tanggal_review)->format('d M Y H:i') }}</span>
                                    </div>
                                    <div style="display: flex; gap: 2px;">
                                        @for ($j = 1; $j <= 5; $j++)
                                            @if ($j <= $review->rating)
                                                <img src="/images/informasi/icons/star.png" style="width: 14px; height: 14px; object-fit: contain;" alt="">
                                            @else
                                                <img src="/images/informasi/icons/star.png" style="width: 14px; height: 14px; object-fit: contain; opacity: 0.3;" alt="">
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p style="font-size: 14px; color: #4b5563; line-height: 1.5; font-style: italic;">"{{ $review->komentar }}"</p>
                            </div>

                            <!-- Mitra feedback if exists -->
                            <div class="feedback-container-wrapper-{{ $review->id_review }}" style="display: {{ $review->balasan_mitra ? 'block' : 'none' }}; margin-left: 20px; padding-left: 14px; border-left: 3px solid #f7c948;">
                                <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; display: flex; flex-direction: column; gap: 6px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 12px; font-weight: 600; color: #b45309; display: inline-flex; align-items: center; gap: 6px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            Tanggapan Mitra (Pemilik Properti)
                                        </span>
                                        <span style="font-size: 11px; color: #9ca3af;" class="feedback-date-{{ $review->id_review }}">{{ $review->tanggal_balasan ? \Carbon\Carbon::parse($review->tanggal_balasan)->format('d M Y H:i') : '' }}</span>
                                    </div>
                                    <p style="font-size: 13px; color: #4b5563;" class="feedback-text-{{ $review->id_review }}">{{ $review->balasan_mitra }}</p>
                                </div>
                            </div>

                            <!-- Action buttons -->
                            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 4px; border-top: 1px solid #f3f4f6; padding-top: 12px;">
                                <button onclick="confirmDeleteFeedback({{ $review->id_review }})" class="btn-delete-feedback-{{ $review->id_review }}" style="display: {{ $review->balasan_mitra ? 'inline-flex' : 'none' }}; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus Tanggapan
                                </button>
                                <button onclick="confirmDeleteReview({{ $review->id_review }})" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    Hapus Ulasan
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                            Belum ada komentar ulasan di dalam platform.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECTION 6: MANAJEMEN PENGGUNA -->
            <div id="section-manage-users" class="content-section">
                <h1>Manajemen Pengguna</h1>

                <!-- Filter and Sort Controls matching other pages -->
                <div class="filter-controls-container">
                    <!-- Search Card -->
                    <div class="field-card filter-card search-card" onclick="document.getElementById('filter-users-search-input').focus()">
                        <div class="field-text">
                            <small>Cari Pengguna</small>
                            <input type="text" id="filter-users-search-input" class="profile-input" placeholder="Tulis nama, email, atau nomor HP..." onkeyup="applyUsersFilters()">
                        </div>
                        <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                    </div>

                    <!-- Role Dropdown Card -->
                    <div class="field-card filter-card dropdown-card" id="user-role-dropdown-container" style="position: relative; z-index: 15;">
                        <div class="field-text" onclick="toggleUsersDropdown('user-role-dropdown', event)">
                            <small>Filter Peran</small>
                            <div id="user-role-display" class="selected-display">Semua Peran</div>
                            <input type="hidden" id="filter-user-role-value" value="all">
                        </div>
                        <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleUsersDropdown('user-role-dropdown', event)">
                        
                        <div id="user-role-dropdown" class="dropdown-menu-list">
                            <div class="dropdown-item-row user-role-item-row" data-val="all" onclick="selectUserRoleFilter('all', 'Semua Peran', event)">
                                <span>Semua Peran</span>
                            </div>
                            <div class="dropdown-item-row user-role-item-row" data-val="admin" onclick="selectUserRoleFilter('admin', 'Admin', event)">
                                <span class="status-badge-inline success" style="background: #dcfce7; color: #15803d;">Admin</span>
                            </div>
                            <div class="dropdown-item-row user-role-item-row" data-val="mitra" onclick="selectUserRoleFilter('mitra', 'Mitra', event)">
                                <span class="status-badge-inline process" style="background: #fef3c7; color: #b45309;">Mitra</span>
                            </div>
                            <div class="dropdown-item-row user-role-item-row" data-val="penyewa" onclick="selectUserRoleFilter('penyewa', 'Penyewa', event)">
                                <span class="status-badge-inline completed" style="background: #e0f2fe; color: #0369a1;">Penyewa</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item-list">
                    @forelse($users as $user)
                        @php
                            $primaryRole = $user->primary_role;
                            $initials = strtoupper(substr($user->name, 0, 1));
                            
                            $colorIndex = ord($initials) % 5;
                            $bgColors = ['#fef3c7', '#dcfce7', '#e0f2fe', '#fee2e2', '#f3e8ff'];
                            $textColors = ['#b45309', '#15803d', '#0369a1', '#991b1b', '#6b21a8'];
                            $avatarBg = $bgColors[$colorIndex];
                            $avatarText = $textColors[$colorIndex];
                        @endphp
                        <div class="item-card user-card-item" id="user-card-{{ $user->id }}"
                             data-user-name="{{ strtolower($user->name ?? '') }}"
                             data-user-email="{{ strtolower($user->email ?? '') }}"
                             data-user-phone="{{ $user->no_hp ?? '' }}"
                             data-user-role="{{ $primaryRole }}"
                             style="display: flex; align-items: center; gap: 20px; padding: 20px; width: 100%;">
                            
                            <!-- Initials Avatar -->
                            <div style="width: 54px; height: 54px; border-radius: 50%; background: {{ $avatarBg }}; color: {{ $avatarText }}; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.04);">
                                {{ $initials }}
                            </div>

                            <!-- User details -->
                            <div class="item-info">
                                <h3 style="margin-bottom: 4px;">{{ $user->name }}</h3>
                                <p style="margin-bottom: 2px;"><strong>Email:</strong> {{ $user->email }}</p>
                                <p style="margin-bottom: 2px;"><strong>No. HP:</strong> {{ $user->no_hp ?? '-' }}</p>
                                @if($user->alamat)
                                    <p style="margin-bottom: 2px;"><strong>Alamat:</strong> {{ $user->alamat }}</p>
                                @endif
                                @if($user->rekening_bank)
                                    <p style="margin-bottom: 2px;"><strong>Rekening Bank:</strong> {{ $user->rekening_bank }}</p>
                                @endif
                            </div>

                            <!-- Role Badge and Actions -->
                            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 12px; flex-shrink: 0;">
                                @if($primaryRole === 'admin')
                                    <span class="status-badge approved">Admin</span>
                                @elseif($primaryRole === 'mitra')
                                    <span class="status-badge pending" style="background: #fef3c7; color: #b45309;">Mitra</span>
                                @else
                                    <span class="status-badge" style="background: #e0f2fe; color: #0369a1;">Penyewa</span>
                                @endif

                                @if(Auth::id() != $user->id)
                                    <button onclick="confirmDeleteUser({{ $user->id }})" 
                                            style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; outline: none; font-family: 'Poppins', sans-serif;" 
                                            onmouseover="this.style.background='#fecaca'" 
                                            onmouseout="this.style.background='#fee2e2'">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        Hapus Pengguna
                                    </button>
                                @else
                                    <span style="font-size: 12px; color: #9ca3af; font-style: italic;">Akun Anda</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                            Belum ada pengguna terdaftar.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SECTION 7: STATISTIK -->
            <div id="section-stats" class="content-section">
                <h1>Statistik</h1>

                <!-- Main Metric Cards -->
                <div class="stats-grid">
                    <div class="stats-item-card blue">
                        <h4>Total Pengguna</h4>
                        <div class="stats-value">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="stats-item-card green">
                        <h4>Total Pemesanan</h4>
                        <div class="stats-value">{{ $stats['total_bookings'] }}</div>
                    </div>
                    <div class="stats-item-card orange">
                        <h4>Total Properti</h4>
                        <div class="stats-value">{{ $stats['total_properties'] }}</div>
                    </div>
                </div>

                <!-- Detailed Breakdown Sections -->
                <div class="stats-detail-grid">
                    <!-- Detail Pengguna -->
                    <div class="stats-detail-section">
                        <div class="stats-detail-title">Detail Peran Pengguna</div>
                        <div class="stats-row">
                            <span>Admin</span>
                            <strong>{{ $stats['total_admins'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Mitra (Pemilik Properti)</span>
                            <strong>{{ $stats['total_owners'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Penyewa</span>
                            <strong>{{ $stats['total_tenants'] }}</strong>
                        </div>
                    </div>

                    <!-- Detail Properti -->
                    <div class="stats-detail-section">
                        <div class="stats-detail-title">Detail Status Properti</div>
                        <div class="stats-row">
                            <span>Disetujui (Approved)</span>
                            <strong>{{ $stats['approved_properties'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Menunggu (Pending)</span>
                            <strong>{{ $stats['pending_properties'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Ditolak (Rejected)</span>
                            <strong>{{ $stats['rejected_properties'] }}</strong>
                        </div>
                    </div>

                    <!-- Detail Pemesanan -->
                    <div class="stats-detail-section">
                        <div class="stats-detail-title">Detail Status Pemesanan</div>
                        <div class="stats-row">
                            <span>Selesai (Completed)</span>
                            <strong>{{ $stats['completed_bookings'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Disetujui (Confirmed)</span>
                            <strong>{{ $stats['confirmed_bookings'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Menunggu (Pending)</span>
                            <strong>{{ $stats['pending_bookings'] }}</strong>
                        </div>
                        <div class="stats-row">
                            <span>Ditolak (Rejected)</span>
                            <strong>{{ $stats['rejected_bookings'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
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
            const menuManageComments = document.getElementById('menu-manage-comments');
            const menuManageUsers = document.getElementById('menu-manage-users');
            const menuStats = document.getElementById('menu-stats');
            const cardPengajuanProperti = document.getElementById('card-pengajuan-properti');
            const cardRiwayatPemesanan = document.getElementById('card-riwayat-pemesanan');
            const kembaliPengajuan = document.getElementById('kembali-pengajuan');
            const kembaliRiwayat = document.getElementById('kembali-riwayat');

            const menuItems = [
                { path: '/profile-admin', sectionId: 'section-log-aktivitas', title: 'Dashboard Admin - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/pengajuan-properti', sectionId: 'section-pengajuan-properti', title: 'Pengajuan Properti - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/riwayat-pemesanan', sectionId: 'section-riwayat-pemesanan', title: 'Riwayat Pemesanan - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/list-properti', sectionId: 'section-list-properti', title: 'List Properti - SpotRent', menuEl: menuListProperti },
                { path: '/admin/manage-comments', sectionId: 'section-manage-comments', title: 'Kelola Komentar - SpotRent', menuEl: menuManageComments },
                { path: '/admin/manage-users', sectionId: 'section-manage-users', title: 'Manajemen Pengguna - SpotRent', menuEl: menuManageUsers },
                { path: '/admin/stats', sectionId: 'section-stats', title: 'Statistik - SpotRent', menuEl: menuStats }
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
            if (menuManageComments) {
                menuManageComments.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/manage-comments');
                });
            }
            if (menuManageUsers) {
                menuManageUsers.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/manage-users');
                });
            }
            if (menuStats) {
                menuStats.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/stats');
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

            // Custom Confirmation Modal Function
            function showCustomConfirm(message, alertType = 'info') {
                return new Promise((resolve) => {
                    const overlay = document.createElement('div');
                    overlay.className = 'custom-modal-overlay';
                    
                    overlay.innerHTML = `
                        <div class="custom-modal-box">
                            <div class="custom-modal-icon ${alertType}">
                                ?
                            </div>
                            <h3>Konfirmasi</h3>
                            <p>${message}</p>
                            <div class="custom-modal-actions" style="display: flex; gap: 12px; justify-content: center;">
                                <button class="custom-modal-btn cancel-btn" style="background: #e11d48; color: #ffffff;">Batal</button>
                                <button class="custom-modal-btn ok-btn" style="background: #f7c948; color: #111111;">OK</button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(overlay);
                    
                    setTimeout(() => {
                        overlay.classList.add('active');
                    }, 10);
                    
                    const cancelBtn = overlay.querySelector('.cancel-btn');
                    const okBtn = overlay.querySelector('.ok-btn');
                    
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
                    
                    okBtn.onclick = () => {
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
            window.showCustomConfirm = showCustomConfirm;

            // Toggle Comments Dropdown
            function toggleCommentsDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
                ['rating-dropdown', 'time-dropdown'].forEach(dropId => {
                    if (dropId !== id) {
                        const drop = document.getElementById(dropId);
                        if (drop) drop.style.display = 'none';
                    }
                });
                
                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                }
            }
            window.toggleCommentsDropdown = toggleCommentsDropdown;

            // Close dropdowns on outside click
            window.addEventListener('click', function() {
                ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown', 'user-role-dropdown'].forEach(dropId => {
                    const drop = document.getElementById(dropId);
                    if (drop) drop.style.display = 'none';
                });
            });

            // Select Comments Rating
            function selectCommentsRating(val, label, e) {
                if (e) e.stopPropagation();
                const valInput = document.getElementById('filter-rating-value');
                if (valInput) valInput.value = val;
                
                const display = document.getElementById('rating-display');
                if (display) {
                    if (val === 'all') {
                        display.innerHTML = 'Semua Rating';
                    } else {
                        display.innerHTML = `<span class="status-badge-inline process" style="background: #fef9c3; color: #a16207;">${label}</span>`;
                    }
                }
                
                const dropdown = document.getElementById('rating-dropdown');
                if (dropdown) dropdown.style.display = 'none';
                applyCommentsFilters();
            }
            window.selectCommentsRating = selectCommentsRating;

            // Select Comments Time sorting
            function selectCommentsTime(val, label, e) {
                if (e) e.stopPropagation();
                const valInput = document.getElementById('filter-time-value');
                if (valInput) valInput.value = val;
                
                const display = document.getElementById('time-display');
                if (display) {
                    display.innerHTML = label;
                }
                
                const dropdown = document.getElementById('time-dropdown');
                if (dropdown) dropdown.style.display = 'none';
                applyCommentsFilters();
            }
            window.selectCommentsTime = selectCommentsTime;

            // Apply Comments Filters & Sorting
            function applyCommentsFilters() {
                const searchInputEl = document.getElementById('filter-comments-search-input');
                const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
                
                const ratingInputEl = document.getElementById('filter-rating-value');
                const ratingFilter = ratingInputEl ? ratingInputEl.value : 'all';
                
                const timeInputEl = document.getElementById('filter-time-value');
                const timeFilter = timeInputEl ? timeInputEl.value : 'newest';
                
                const listContainer = document.querySelector('#section-manage-comments .item-list');
                if (!listContainer) return;
                
                const cards = Array.from(listContainer.querySelectorAll('.review-card-item'));
                let visibleCount = 0;
                
                cards.forEach(card => {
                    const propName = card.getAttribute('data-property-name') || '';
                    const tenantName = card.getAttribute('data-tenant-name') || '';
                    const commentText = card.getAttribute('data-comment-text') || '';
                    const rating = card.getAttribute('data-rating') || '';
                    
                    // 1. Search filter
                    const matchesSearch = searchQuery === '' || 
                                          propName.includes(searchQuery) || 
                                          tenantName.includes(searchQuery) ||
                                          commentText.includes(searchQuery);
                                          
                    // 2. Rating filter
                    const matchesRating = ratingFilter === 'all' || rating === ratingFilter;
                    
                    if (matchesSearch && matchesRating) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // 3. Sort Cards by timestamp
                if (visibleCount > 1) {
                    cards.sort((a, b) => {
                        const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
                        const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
                        
                        if (timeFilter === 'newest') {
                            return valB - valA;
                        } else {
                            return valA - valB;
                        }
                    });
                    
                    // Re-append sorted cards in order
                    cards.forEach(card => {
                        listContainer.appendChild(card);
                    });
                }
                
                // Handle Empty State
                let emptyMessage = document.getElementById('empty-comments-message');
                if (visibleCount === 0) {
                    if (!emptyMessage) {
                        emptyMessage = document.createElement('div');
                        emptyMessage.id = 'empty-comments-message';
                        emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
                        emptyMessage.textContent = "Tidak ada komentar ulasan yang cocok dengan filter.";
                        listContainer.appendChild(emptyMessage);
                    } else {
                        emptyMessage.style.display = 'block';
                    }
                } else {
                    if (emptyMessage) {
                        emptyMessage.style.display = 'none';
                    }
                }
            }
            window.applyCommentsFilters = applyCommentsFilters;

            window.confirmDeleteReview = function(reviewId) {
                showCustomConfirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?', 'info').then(confirmed => {
                    if (confirmed) {
                        fetch(`/admin/review/${reviewId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showCustomAlert(data.message, 'success').then(() => {
                                    const card = document.getElementById(`review-card-${reviewId}`);
                                    if (card) {
                                        card.remove();
                                    }
                                    applyCommentsFilters();
                                });
                            } else {
                                showCustomAlert(data.message || 'Gagal menghapus ulasan.', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
                        });
                    }
                });
            };

            window.confirmDeleteFeedback = function(reviewId) {
                showCustomConfirm('Apakah Anda yakin ingin menghapus tanggapan Mitra ini?', 'info').then(confirmed => {
                    if (confirmed) {
                        fetch(`/admin/review/${reviewId}/delete-feedback`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showCustomAlert(data.message, 'success').then(() => {
                                    // Hide feedback container wrapper
                                    const feedbackWrapper = document.querySelector(`.feedback-container-wrapper-${reviewId}`);
                                    if (feedbackWrapper) {
                                        feedbackWrapper.style.display = 'none';
                                    }
                                    // Hide the "Hapus Tanggapan" button
                                    const btnDeleteFeedback = document.querySelector(`.btn-delete-feedback-${reviewId}`);
                                    if (btnDeleteFeedback) {
                                        btnDeleteFeedback.style.display = 'none';
                                    }
                                    
                                    // Update data attribute on the card
                                    const card = document.getElementById(`review-card-${reviewId}`);
                                    if (card) {
                                        card.setAttribute('data-has-feedback', 'false');
                                    }
                                    applyCommentsFilters();
                                });
                            } else {
                                showCustomAlert(data.message || 'Gagal menghapus tanggapan.', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
                        });
                    }
                });
            };

            // All bookings data for detail modal
            const allBookings = @json($bookings);

            // helper functions for date formatting
            function formatDateIndo(dateObj) {
                if (!dateObj) return '';
                const date = new Date(dateObj);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
            }

            function numberFormat(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // show booking detail in custom modal
            window.showBookingDetail = function(bookingId) {
                const booking = allBookings.find(b => b.id_booking === bookingId);
                if (!booking) return;
                
                const start = new Date(booking.tanggal_mulai);
                const end = new Date(booking.tanggal_selesai);
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                
                const statusLabels = {
                    'pending': '<span class="status-badge-inline process">Pending</span>',
                    'confirmed': '<span class="status-badge-inline success">Disetujui</span>',
                    'completed': '<span class="status-badge-inline completed">Selesai</span>',
                    'rejected': '<span class="status-badge-inline danger">Ditolak</span>'
                };
                const statusHtml = statusLabels[booking.status_booking] || `<span class="status-badge-inline danger">${booking.status_booking}</span>`;

                const overlay = document.createElement('div');
                overlay.className = 'custom-modal-overlay';
                
                overlay.innerHTML = `
                    <div class="custom-modal-box" style="max-width: 500px; text-align: left; padding: 32px;">
                        <h3 style="margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <span>Detail Pemesanan</span>
                            ${statusHtml}
                        </h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 16px; font-size: 14px; color: #4b5563;">
                            <div>
                                <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Informasi Properti</strong>
                                <p style="margin: 2px 0;"><strong>Nama:</strong> ${booking.property ? booking.property.nama_properti : 'Properti tidak diketahui'}</p>
                                <p style="margin: 2px 0;"><strong>Wilayah:</strong> ${booking.property && booking.property.location ? booking.property.location.kota : '-'}</p>
                                <p style="margin: 2px 0;"><strong>Mitra Pemilik:</strong> ${booking.property && booking.property.mitra ? (booking.property.mitra.nama_mitra || booking.property.mitra.name) : '-'}</p>
                            </div>
                            
                            <hr style="border: 0; border-top: 1px solid #f3f4f6;">
                            
                            <div>
                                <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Informasi Penyewa</strong>
                                <p style="margin: 2px 0;"><strong>Nama:</strong> ${booking.user ? booking.user.name : '-'}</p>
                                <p style="margin: 2px 0;"><strong>Email:</strong> ${booking.user ? booking.user.email : '-'}</p>
                                <p style="margin: 2px 0;"><strong>No. HP:</strong> ${booking.user ? (booking.user.no_hp || '-') : '-'}</p>
                            </div>
                            
                            <hr style="border: 0; border-top: 1px solid #f3f4f6;">
                            
                            <div>
                                <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Rincian Sewa & Pembayaran</strong>
                                <p style="margin: 2px 0;"><strong>Periode:</strong> ${formatDateIndo(booking.tanggal_mulai)} - ${formatDateIndo(booking.tanggal_selesai)}</p>
                                <p style="margin: 2px 0;"><strong>Durasi:</strong> ${diffDays} Hari</p>
                                <p style="margin: 2px 0; font-size: 16px; color: #d97706; font-weight: 600;"><strong>Total Pembayaran:</strong> Rp ${numberFormat(booking.total_price || 0)}</p>
                            </div>
                        </div>
                        
                        <div class="custom-modal-actions" style="margin-top: 28px; display: flex; justify-content: flex-end;">
                            <button class="custom-modal-btn close-btn" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; max-width: 100px;">Tutup</button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 10);
                
                const closeBtn = overlay.querySelector('.close-btn');
                
                function close() {
                    overlay.classList.remove('active');
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }
                
                closeBtn.onclick = close;
                overlay.onclick = (e) => {
                    if (e.target === overlay) close();
                };
            };

            // Toggle Bookings Dropdown
            function toggleBookingsDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
                ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown'].forEach(dropId => {
                    if (dropId !== id) {
                        const drop = document.getElementById(dropId);
                        if (drop) drop.style.display = 'none';
                    }
                });
                
                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                }
            }
            window.toggleBookingsDropdown = toggleBookingsDropdown;

            // Select Booking Status Filter
            function selectBookingStatusFilter(val, label, e) {
                if (e) e.stopPropagation();
                const valInput = document.getElementById('filter-booking-status-value');
                if (valInput) valInput.value = val;
                
                const display = document.getElementById('booking-status-display');
                if (display) {
                    if (val === 'all') {
                        display.innerHTML = 'Semua Status';
                    } else if (val === 'pending') {
                        display.innerHTML = `<span class="status-badge-inline process">${label}</span>`;
                    } else if (val === 'confirmed') {
                        display.innerHTML = `<span class="status-badge-inline success">${label}</span>`;
                    } else {
                        display.innerHTML = `<span class="status-badge-inline danger">${label}</span>`;
                    }
                }
                
                const dropdown = document.getElementById('booking-status-dropdown');
                if (dropdown) dropdown.style.display = 'none';
                applyBookingsFilters();
            }
            window.selectBookingStatusFilter = selectBookingStatusFilter;

            // Initialize Flatpickr on Date Range Filter
            const bookingFlatpickr = flatpickr("#filter-booking-date-range", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: "id",
                onChange: function(selectedDates, dateStr, instance) {
                    const display = document.getElementById('booking-date-display');
                    const resetBtn = document.getElementById('btn-reset-booking-date');
                    if (selectedDates.length === 2) {
                        const startStr = formatDateIndo(selectedDates[0]);
                        const endStr = formatDateIndo(selectedDates[1]);
                        display.innerHTML = `${startStr} - ${endStr}`;
                        if (resetBtn) resetBtn.style.display = 'inline-block';
                    } else if (selectedDates.length === 1) {
                        display.innerHTML = formatDateIndo(selectedDates[0]);
                        if (resetBtn) resetBtn.style.display = 'inline-block';
                    } else {
                        display.innerHTML = "Semua Tanggal";
                        if (resetBtn) resetBtn.style.display = 'none';
                    }
                    applyBookingsFilters();
                }
            });

            window.resetBookingDateFilter = function(e) {
                if (e) e.stopPropagation();
                if (bookingFlatpickr) {
                    bookingFlatpickr.clear();
                }
                const display = document.getElementById('booking-date-display');
                if (display) {
                    display.innerHTML = "Semua Tanggal";
                }
                const resetBtn = document.getElementById('btn-reset-booking-date');
                if (resetBtn) {
                    resetBtn.style.display = 'none';
                }
                applyBookingsFilters();
            };

            // Apply Bookings Filters
            function applyBookingsFilters() {
                const searchInputEl = document.getElementById('filter-bookings-search-input');
                const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
                
                const statusInputEl = document.getElementById('filter-booking-status-value');
                const statusFilter = statusInputEl ? statusInputEl.value : 'all';
                
                const dateInputEl = document.getElementById('filter-booking-date-range');
                const dateRangeStr = dateInputEl ? dateInputEl.value : '';
                
                let filterStart = null;
                let filterEnd = null;
                if (dateRangeStr.includes(' to ')) {
                    const parts = dateRangeStr.split(' to ');
                    filterStart = new Date(parts[0]);
                    filterEnd = new Date(parts[1]);
                    // Set filterEnd to end of day to cover same-day comparisons accurately
                    filterEnd.setHours(23, 59, 59, 999);
                } else if (dateRangeStr !== '') {
                    filterStart = new Date(dateRangeStr);
                    filterEnd = new Date(dateRangeStr);
                    filterEnd.setHours(23, 59, 59, 999);
                }
                
                const listContainer = document.querySelector('#section-riwayat-pemesanan .item-list');
                if (!listContainer) return;
                
                const cards = Array.from(listContainer.querySelectorAll('.booking-card-item'));
                let visibleCount = 0;
                
                cards.forEach(card => {
                    const propName = card.getAttribute('data-property-name') || '';
                    const tenantName = card.getAttribute('data-tenant-name') || '';
                    const startDateStr = card.getAttribute('data-start-date') || '';
                    const endDateStr = card.getAttribute('data-end-date') || '';
                    const status = card.getAttribute('data-status') || '';
                    
                    // 1. Search filter
                    const matchesSearch = searchQuery === '' || 
                                          propName.includes(searchQuery) || 
                                          tenantName.includes(searchQuery);
                                          
                    // 2. Status filter
                    let matchesStatus = false;
                    if (statusFilter === 'all') {
                        matchesStatus = true;
                    } else if (statusFilter === 'pending') {
                        matchesStatus = (status === 'pending');
                    } else if (statusFilter === 'confirmed') {
                        matchesStatus = (status === 'confirmed' || status === 'completed');
                    } else if (statusFilter === 'rejected') {
                        matchesStatus = (status !== 'pending' && status !== 'confirmed' && status !== 'completed');
                    }
                    
                    // 3. Date range filter
                    let matchesDate = true;
                    if (filterStart && filterEnd) {
                        const cardStart = new Date(startDateStr);
                        const cardEnd = new Date(endDateStr);
                        matchesDate = (cardStart <= filterEnd && cardEnd >= filterStart);
                    }
                    
                    if (matchesSearch && matchesStatus && matchesDate) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Handle Empty State
                let emptyMessage = document.getElementById('empty-bookings-filter-message');
                if (visibleCount === 0) {
                    if (!emptyMessage) {
                        emptyMessage = document.createElement('div');
                        emptyMessage.id = 'empty-bookings-filter-message';
                        emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
                        emptyMessage.textContent = "Tidak ada riwayat pemesanan yang cocok dengan filter.";
                        listContainer.appendChild(emptyMessage);
                    } else {
                        emptyMessage.style.display = 'block';
                    }
                } else {
                    if (emptyMessage) {
                        emptyMessage.style.display = 'none';
                    }
                }
            }
            window.applyBookingsFilters = applyBookingsFilters;

            // Toggle Users Dropdown
            function toggleUsersDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
                ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown', 'user-role-dropdown'].forEach(dropId => {
                    if (dropId !== id) {
                        const drop = document.getElementById(dropId);
                        if (drop) drop.style.display = 'none';
                    }
                });
                
                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                }
            }
            window.toggleUsersDropdown = toggleUsersDropdown;

            // Select User Role Filter
            function selectUserRoleFilter(val, label, e) {
                if (e) e.stopPropagation();
                const valInput = document.getElementById('filter-user-role-value');
                if (valInput) valInput.value = val;
                
                const display = document.getElementById('user-role-display');
                if (display) {
                    if (val === 'all') {
                        display.innerHTML = 'Semua Peran';
                    } else if (val === 'admin') {
                        display.innerHTML = `<span class="status-badge-inline success" style="background: #dcfce7; color: #15803d;">${label}</span>`;
                    } else if (val === 'mitra') {
                        display.innerHTML = `<span class="status-badge-inline process" style="background: #fef3c7; color: #b45309;">${label}</span>`;
                    } else {
                        display.innerHTML = `<span class="status-badge-inline completed" style="background: #e0f2fe; color: #0369a1;">${label}</span>`;
                    }
                }
                
                const dropdown = document.getElementById('user-role-dropdown');
                if (dropdown) dropdown.style.display = 'none';
                applyUsersFilters();
            }
            window.selectUserRoleFilter = selectUserRoleFilter;

            // Apply Users Filters
            function applyUsersFilters() {
                const searchInputEl = document.getElementById('filter-users-search-input');
                const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
                
                const roleInputEl = document.getElementById('filter-user-role-value');
                const roleFilter = roleInputEl ? roleInputEl.value : 'all';
                
                const listContainer = document.querySelector('#section-manage-users .item-list');
                if (!listContainer) return;
                
                const cards = Array.from(listContainer.querySelectorAll('.user-card-item'));
                let visibleCount = 0;
                
                cards.forEach(card => {
                    const userName = card.getAttribute('data-user-name') || '';
                    const userEmail = card.getAttribute('data-user-email') || '';
                    const userPhone = card.getAttribute('data-user-phone') || '';
                    const userRole = card.getAttribute('data-user-role') || '';
                    
                    // 1. Search filter
                    const matchesSearch = searchQuery === '' || 
                                          userName.includes(searchQuery) || 
                                          userEmail.includes(searchQuery) ||
                                          userPhone.includes(searchQuery);
                                          
                    // 2. Role filter
                    const matchesRole = roleFilter === 'all' || userRole === roleFilter;
                    
                    if (matchesSearch && matchesRole) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Handle Empty State
                let emptyMessage = document.getElementById('empty-users-filter-message');
                if (visibleCount === 0) {
                    if (!emptyMessage) {
                        emptyMessage = document.createElement('div');
                        emptyMessage.id = 'empty-users-filter-message';
                        emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
                        emptyMessage.textContent = "Tidak ada pengguna yang cocok dengan filter.";
                        listContainer.appendChild(emptyMessage);
                    } else {
                        emptyMessage.style.display = 'block';
                    }
                } else {
                    if (emptyMessage) {
                        emptyMessage.style.display = 'none';
                    }
                }
            }
            window.applyUsersFilters = applyUsersFilters;

            // Confirm and delete user via AJAX
            window.confirmDeleteUser = function(userId) {
                showCustomConfirm('Apakah Anda yakin ingin menghapus pengguna ini beserta seluruh data terkait (properti, pemesanan, dll) secara permanen?', 'danger').then(confirmed => {
                    if (confirmed) {
                        fetch(`/admin/user/${userId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showCustomAlert(data.message, 'success').then(() => {
                                    const card = document.getElementById(`user-card-${userId}`);
                                    if (card) {
                                        card.remove();
                                    }
                                    applyUsersFilters();
                                });
                            } else {
                                showCustomAlert(data.message || 'Gagal menghapus pengguna.', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
                        });
                    }
                });
            };

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
