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
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f4f9; margin: 0; padding: 2rem; }

        /* Ensure form controls and buttons use Poppins */
        input, textarea, select, button {
            font-family: 'Poppins', sans-serif;
        }

        /* Placeholder font rules for cross-browser support */
        ::-webkit-input-placeholder { font-family: 'Poppins', sans-serif; }
        :-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::placeholder { font-family: 'Poppins', sans-serif; }
        .container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        h1 { margin-top: 0; }
        .user-info { margin-bottom: 2rem; padding: 1rem; background-color: #e9ecef; border-radius: 4px; }
        .role-actions { margin: 1rem 0; }
        .logout-form { display: inline; }
        button { padding: 0.5rem 1rem; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        @include('partials.flash')
        @php
            $user = Auth::user();
            $isMitra = $user->hasRole('mitra');
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
            <p><strong>Role aktif:</strong> {{ ucfirst(session('active_role', Auth::user()->primary_role ?? '—')) }}</p>
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
