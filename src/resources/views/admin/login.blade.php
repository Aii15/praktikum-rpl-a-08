<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent Admin Login</title>
    <!-- Website Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        /* Customize card for Admin */
        .login-card {
            border: 2px solid #2564ebc3; /* blue accent to differentiate admin */
        }
        .admin-header {
            color: #2564ebc3 !important;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <div class="login-page">

        <div class="background-slider">
            <div class="slider-row move-right">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([1, 5, 3, 8, 2, 11, 6, 4, 10, 7, 12, 9] as $img)
                            <img src="/images/login/{{ $img }}.png" alt="Property">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-left">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([9, 2, 12, 4, 7, 1, 10, 5, 3, 11, 6, 8] as $img)
                            <img src="/images/login/{{ $img }}.png" alt="Property">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-right">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([6, 10, 1, 9, 3, 12, 5, 8, 2, 11, 4, 7] as $img)
                            <img src="/images/login/{{ $img }}.png" alt="Property">
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>

        <div class="login-card">
            <a href="/" style="text-decoration: none; color: inherit; display: block; margin-bottom: 12px;">
                <div class="brand" style="margin-bottom: 0;">
                    <img src="/images/logo.png" alt="Logo">
                    <span>SpotRent</span>
                </div>
            </a>

            <div class="admin-header">Admin Portal</div>
            <h1 style="margin-top: 4px; margin-bottom: 24px;">Login</h1>

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 12px; border-radius:8px; margin-bottom:16px; text-align:left; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; color: #1e3a8a; padding: 12px; border-radius:8px; margin-bottom:16px; text-align:left; font-size: 14px;">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Dedicated Admin Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="email" name="email" placeholder="E-mail Admin" value="{{ old('email') }}" required style="width: 100%;">
                    @error('email')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 2px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="password" name="password" placeholder="Password" required style="width: 100%;">
                    @error('password')
                        <span style="color: #ef4444; font-size: 12px; margin-top: 2px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit" style="background: #2563eb; color: white; margin-top: 8px;">Masuk Sebagai Admin</button>
            </form>

            <!-- Back to Home -->
            <div style="margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <a href="/" style="font-size: 14px; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#64748b'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

</body>

</html>
