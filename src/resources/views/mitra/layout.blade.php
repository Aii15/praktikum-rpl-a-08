<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent Mitra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background: #f4f4f9; color: #111827; }
        a { color: inherit; text-decoration: none; }
        .page { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .sidebar { background: #ffffff; border-right: 1px solid #e5e7eb; padding: 2rem 1.5rem; }
        .sidebar h2 { margin: 0 0 1.5rem; font-size: 1.3rem; letter-spacing: 0.02em; }
        .sidebar nav a { display: block; margin-bottom: 1rem; padding: 0.9rem 1rem; border-radius: 12px; transition: background 0.15s ease; }
        .sidebar nav a.active, .sidebar nav a:hover { background: #f3f4f6; }
        .sidebar .home-link { margin-top: 2rem; font-weight: 600; color: #047857; }
        .content { padding: 2rem; }
        .panel { background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06); }
        .page-title { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .page-title h1 { margin: 0; font-size: 1.8rem; }
        .button-primary { background: #047857; color: white; border: none; border-radius: 999px; padding: 0.85rem 1.4rem; cursor: pointer; }
        .button-primary:hover { opacity: 0.95; }
        .form-row { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
        .form-row-full { grid-column: 1 / -1; }
        .form-field { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; }
        .form-field label { font-weight: 600; font-size: 0.95rem; }
        .form-field input, .form-field textarea, .form-field select { width: 100%; border: 1px solid #d1d5db; border-radius: 14px; padding: 0.9rem 1rem; font-size: 0.95rem; }
        textarea { min-height: 150px; resize: vertical; }
        .property-card, .booking-card, .status-card { background: #f8fafc; border-radius: 18px; padding: 1.4rem; margin-bottom: 1rem; display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: center; }
        .property-card img { width: 100px; height: 100px; object-fit: cover; border-radius: 16px; background: #e5e7eb; }
        .property-card .info { display: grid; gap: 0.25rem; }
        .badge { display: inline-flex; align-items: center; padding: 0.5rem 0.85rem; border-radius: 999px; font-size: 0.85rem; font-weight: 600; }
        .badge.pending { background: #fef3c7; color: #b45309; }
        .badge.approved { background: #d1fae5; color: #065f46; }
        .badge.rejected { background: #fee2e2; color: #991b1b; }
        .flash-wrapper { margin-bottom: 1rem; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.9rem 0.8rem; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .table th { background: #f8fafc; font-weight: 700; }
        .actions { display: flex; gap: 0.5rem; justify-content: flex-end; }
        .secondary-button { padding: 0.75rem 1rem; border: 1px solid #d1d5db; background: white; border-radius: 999px; cursor: pointer; }
        .secondary-button:hover { background: #f8fafc; }
        .danger-button { background: #e11d48; color: white; border: none; }
        .danger-button:hover { opacity: 0.95; }
    </style>
</head>
<body>
    <div class="page">
        <aside class="sidebar">
            <h2>SpotRent Mitra</h2>
            <nav>
                <a href="{{ route('mitra.profile') }}" class="{{ request()->routeIs('mitra.profile') ? 'active' : '' }}">Tentang Saya</a>
                <a href="{{ route('mitra.bookings') }}" class="{{ request()->routeIs('mitra.bookings') ? 'active' : '' }}">Riwayat Penyewaan</a>
                <a href="{{ route('mitra.properties') }}" class="{{ request()->routeIs('mitra.properties') ? 'active' : '' }}">Properti Saya</a>
                <a href="{{ route('mitra.property.create') }}" class="{{ request()->routeIs('mitra.property.create') ? 'active' : '' }}">Tambah Properti</a>
                <a href="{{ route('mitra.status') }}" class="{{ request()->routeIs('mitra.status') ? 'active' : '' }}">Status Pengajuan</a>
            </nav>
            <a class="home-link" href="{{ route('dashboard') }}">Ke Beranda</a>
        </aside>
        <main class="content">
            <div class="panel">
                @include('partials.flash')
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
