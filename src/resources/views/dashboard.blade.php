{{-- untuk tampilan dashboard pengguna dan informasi role aktif --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SpotRent</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="container">
        @include('partials.flash')
        @php
            $user = Auth::user();
            $activeRole = session('active_role', $user->primary_role ?? null);
            $isMitra = $activeRole === 'mitra';
            $mitraName = $isMitra
                ? ($user->mitraProfile->nama_mitra ?? $user->nama_mitra ?? '—')
                : null;
        @endphp
        <h1>Dashboard</h1>
        
        <div class="user-info">
            @if($isMitra)
                <p><strong>Nama Mitra / Perusahaan:</strong> {{ $mitraName }}</p>
            @endif
            <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Role aktif:</strong> {{ ucfirst($activeRole ?? '—') }}</p>
            <p><strong>Semua role:</strong> {{ Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->pluck('name')->map(fn ($role) => ucfirst($role))->join(', ') : '—' }}</p>
        </div>

        <p>Selamat datang di SpotRent! Anda berhasil login.</p>

        @if(Auth::user()->roles->count() > 1)
            <div class="role-actions">
                <a href="{{ route('role.choose') }}">Ganti role aktif</a>
            </div>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>

        @if(! Auth::user()->hasRole('mitra'))
            <p style="margin-top:1rem;"><a href="{{ route('upgrade.mitra') }}">Daftar / Upgrade ke Mitra</a></p>
        @endif
    </div>
</body>
</html>
