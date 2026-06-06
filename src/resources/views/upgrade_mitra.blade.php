{{-- untuk tampilan halaman upgrade akun menjadi mitra --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade to Mitra</title>
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
            font-size: 25px;
        }

        .brand img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        h1 {
            margin-bottom: 12px;
            font-size: 30px;
            font-weight: 700;
        }

        .subtitle {
            margin-bottom: 22px;
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
            text-align: left;
        }

        .account-info {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #f3f4f6;
            text-align: left;
            font-size: 13px;
            color: #374151;
            line-height: 1.6;
        }

        .account-info strong {
            color: #111827;
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

        .helper {
            margin-top: 12px;
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
            text-align: left;
        }

        .link-row {
            margin-top: 16px;
            font-size: 14px;
        }

        .link-row a {
            color: #f7c948;
            text-decoration: none;
            font-weight: bold;
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
                            <img src="/images/login/{{ $img }}.png" alt="SpotRent background">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-left">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([9, 2, 12, 4, 7, 1, 10, 5, 3, 11, 6, 8] as $img)
                            <img src="/images/login/{{ $img }}.png" alt="SpotRent background">
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="slider-row move-right">
                <div class="slider-track">
                    @for ($i = 0; $i < 3; $i++)
                        @foreach ([6, 10, 1, 9, 3, 12, 5, 8, 2, 11, 4, 7] as $img)
                            <img src="/images/login/{{ $img }}.png" alt="SpotRent background">
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

            <h1>Upgrade ke Mitra</h1>

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

            <div class="subtitle">
                Upgrade akun menjadi Mitra untuk bisa listing properti! 
            </div>

            @auth
                <div class="account-info">
                    <strong>Akun aktif:</strong><br>
                    {{ Auth::user()->name }}<br>
                    {{ Auth::user()->email }}
                </div>
            @endauth

            <form action="{{ url('/upgrade-mitra') }}" method="POST" novalidate>
                @csrf
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="text" name="nama_mitra" placeholder="Nama Mitra / Perusahaan" value="{{ old('nama_mitra') }}" required style="width: 100%;">
                    @error('nama_mitra')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="text" name="ktp" placeholder="Nomor KTP" value="{{ old('ktp') }}" required maxlength="16" inputmode="numeric" title="Nomor KTP harus 16 digit angka." style="width: 100%;">
                    @error('ktp')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                    <input type="text" name="rekening_bank" placeholder="Rekening Bank (opsional)" value="{{ old('rekening_bank') }}" maxlength="20" pattern="[0-9]{1,20}" inputmode="numeric" title="Rekening bank hanya boleh angka dan maksimal 20 digit." style="width: 100%;">
                    @error('rekening_bank')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">Upgrade ke Mitra</button>
            </form>

            <div class="helper">
                Setelah upgrade, akun yang sama tetap bisa dipakai sebagai penyewa atau mitra. Saat login, sistem akan meminta pilihan role aktif jika akun Anda punya lebih dari satu role.
            </div>

            <div class="link-row">
                <a href="/dashboard">Kembali ke dashboard</a>
            </div>
        </div>

    </div>

</body>
</html>
