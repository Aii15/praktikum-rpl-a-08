@php
    $initialMode = request()->routeIs('register') ? 'register' : 'login';
    
    if ($errors->hasAny(['name', 'email', 'no_hp', 'password_confirmation']) || old('name') || old('email') || old('no_hp')) {
        $initialMode = 'register';
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent {{ $initialMode === 'register' ? 'Register' : 'Login' }}</title>
    <!-- Website Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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
            <a href="/" style="text-decoration: none; color: inherit; display: block; margin-bottom: 20px;">
                <div class="brand" style="margin-bottom: 0;">
                    <img src="/images/logo.png" alt="Logo">
                    <span>SpotRent</span>
                </div>
            </a>

            <h1 id="auth-title">{{ $initialMode === 'register' ? 'Daftar' : 'Login' }}</h1>

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius:8px; margin-bottom:12px; text-align:left; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #eff6ff; color: #1e3a8a; padding: 10px; border-radius:8px; margin-bottom:12px; text-align:left; font-size: 14px;">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Pilihan tab (Masuk / Daftar) -->
            <div class="auth-tabs">
                <div class="tab-indicator" id="tab-indicator"></div>
                <button type="button" class="tab-btn" id="btn-tab-login" onclick="setMode('login')">Masuk</button>
                <button type="button" class="tab-btn" id="btn-tab-register" onclick="setMode('register')">Daftar</button>
            </div>

            <!-- Form Login -->
            <div id="section-login" class="auth-form-section">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                        <input type="text" name="login_id" placeholder="E-mail atau No. HP" value="{{ old('login_id') }}" required style="width: 100%;">
                        @error('login_id')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div style="display: flex; flex-direction: column; text-align: left; gap: 4px;">
                        <input type="password" name="password" placeholder="Password" required style="width: 100%;">
                        @error('password')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit">Masuk</button>
                </form>
            </div>

            <!-- Form Register -->
            <div id="section-register" class="auth-form-section">
                <form action="{{ route('register') }}" method="POST" novalidate>
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
                        <input type="text" name="no_hp" placeholder="No. HP" value="{{ old('no_hp') }}" required pattern="08[0-9]{8,11}" title="Nomor HP harus diawali 08 dan 10-13 digit." minlength="10" maxlength="13" inputmode="numeric" style="width: 100%;">
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

                    <button type="submit" class="btn-submit">Daftar</button>
                </form>
            </div>

            <!-- Tombol balik ke Home -->
            <div style="margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <a href="/" style="font-size: 14px; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

    <script>
        // Pantau mode aktif sekarang (login / register)
        let currentMode = '{{ $initialMode }}';

        // Pasang mode awal pas halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            setMode(currentMode, false);
        });

        // Fungsi buat ganti-ganti mode login & register
        function setMode(mode, updateHistory = true) {
            currentMode = mode;

            const sectionLogin = document.getElementById('section-login');
            const sectionRegister = document.getElementById('section-register');
            const btnTabLogin = document.getElementById('btn-tab-login');
            const btnTabRegister = document.getElementById('btn-tab-register');
            const tabIndicator = document.getElementById('tab-indicator');
            const authTitle = document.getElementById('auth-title');

            if (mode === 'login') {
                // Atur visibilitas form
                sectionLogin.classList.add('active');
                sectionRegister.classList.remove('active');

                // Atur tombol tab aktif
                btnTabLogin.classList.add('active');
                btnTabRegister.classList.remove('active');

                // Geser penanda tab ke kiri
                tabIndicator.style.transform = 'translateX(0)';

                // Ganti title halaman
                authTitle.textContent = 'Login';
                document.title = 'SpotRent Login';

                // Update URL di riwayat browser
                if (updateHistory) {
                    history.pushState({ mode: 'login' }, '', '{{ route("login") }}');
                }
            } else {
                // Atur visibilitas form
                sectionRegister.classList.add('active');
                sectionLogin.classList.remove('active');

                // Atur tombol tab aktif
                btnTabRegister.classList.add('active');
                btnTabLogin.classList.remove('active');

                // Geser penanda tab ke kanan
                tabIndicator.style.transform = 'translateX(100%)';

                // Ganti title halaman
                authTitle.textContent = 'Daftar';
                document.title = 'SpotRent Register';

                // Update URL di riwayat browser
                if (updateHistory) {
                    history.pushState({ mode: 'register' }, '', '{{ route("register") }}');
                }
            }
        }

        // Pantau navigasi back / forward browser
        window.addEventListener('popstate', (event) => {
            if (event.state && event.state.mode) {
                setMode(event.state.mode, false);
            } else {
                // Cadangan: deteksi mode dari path URL
                const path = window.location.pathname;
                const mode = path.includes('register') ? 'register' : 'login';
                setMode(mode, false);
            }
        });
    </script>

</body>

</html>
