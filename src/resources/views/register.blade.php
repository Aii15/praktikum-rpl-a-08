{{-- untuk tampilan halaman registrasi pengguna --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        input, textarea, select, button {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-input-placeholder { font-family: 'Poppins', sans-serif; }
        :-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::placeholder { font-family: 'Poppins', sans-serif; }

        .login-page {
            min-height: 100vh;
            background: #07142d;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        .background-slider {
            position: absolute;
            inset: -40px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
            overflow: hidden;
        }

        .slider-row {
            width: 100%;
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            gap: 50px;
            width: max-content;
        }

        .slider-track img {
            width: 200px;
            height: 200px;
            border-radius: 18px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .move-left .slider-track {
            animation: slideLeft 95s linear infinite;
        }

        .move-right .slider-track {
            animation: slideRight 95s linear infinite;
        }

        @keyframes slideLeft {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes slideRight {
            from {
                transform: translateX(-50%);
            }

            to {
                transform: translateX(0);
            }
        }

        .login-card {
            position: relative;
            z-index: 10;
            width: 400px;
            background: white;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35);
        }

        .brand {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-weight: 700;
            font-size: 18px;
        }

        .brand img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        h1 {
            margin-bottom: 28px;
            font-size: 36px;
            font-weight: 700;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        input {
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #f7c948;
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #f7c948;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        button:hover {
            opacity: 0.9;
        }
        
        .login-link {
            margin-top: 16px;
            font-size: 14px;
        }
        
        .login-link a {
            color: #f7c948;
            text-decoration: none;
            font-weight: bold;
        }

        .auth-switch {
            margin-top: 16px;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            background: #f8fafc;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            font-size: 14px;
            color: #475569;
        }

        .auth-switch a {
            display: inline;
            padding: 0;
            border: none;
            background: transparent;
            color: #9a7500;
            text-decoration: none;
            text-decoration-line: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 3px;
            font-weight: 700;
            box-shadow: none;
            transition: color 0.18s ease, text-decoration-color 0.18s ease;
        }

        .auth-switch a:hover {
            color: #7a5d00;
            text-decoration-color: #7a5d00;
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
                            <img src="/images/login/{{ $img }}.png">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-left">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([9, 2, 12, 4, 7, 1, 10, 5, 3, 11, 6, 8] as $img)
                            <img src="/images/login/{{ $img }}.png">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-right">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([6, 10, 1, 9, 3, 12, 5, 8, 2, 11, 4, 7] as $img)
                            <img src="/images/login/{{ $img }}.png">
                        @endforeach
                    @endfor
                </div>
            </div>

        </div>

        <div class="login-card">
            <div class="brand">
                <img src="/images/logo.png" alt="Logo">
                <span>SpotRent</span>
            </div>

            <h1>Daftar</h1>

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius:8px; margin-bottom:12px; text-align:left;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; color: #1e3a8a; padding: 10px; border-radius:8px; margin-bottom:12px; text-align:left;">
                    {{ session('info') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required style="width: 100%;">
                    @error('name')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required style="width: 100%;">
                    @error('email')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="text" name="no_hp" placeholder="No. HP" value="{{ old('no_hp') }}" required style="width: 100%;">
                    @error('no_hp')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="password" name="password" placeholder="Password" required style="width: 100%;">
                    @error('password')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required style="width: 100%;">
                </div>

                <button type="submit">Daftar</button>
            </form>
            
            <div class="auth-switch">
                Sudah punya akun? <a href="{{ route('login') }}" class="nav-link-outline">Masuk</a>
            </div>
        </div>

    </div>

</body>

</html>
