{{-- untuk tampilan pemilihan role aktif bagi pengguna multi-role --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - SpotRent</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; }

        input, textarea, select, button {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-input-placeholder { font-family: 'Poppins', sans-serif; }
        :-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::-ms-input-placeholder { font-family: 'Poppins', sans-serif; }
        ::placeholder { font-family: 'Poppins', sans-serif; }
        .page {
            min-height: 100vh;
            background: linear-gradient(135deg, #07142d 0%, #0f2349 55%, #132d5f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            font-weight: 700;
            font-size: 25px;
        }
        .brand img { width: 44px; height: 44px; object-fit: contain; }
        h1 { font-size: 32px; margin-bottom: 8px; }
        p { color: #475569; line-height: 1.6; margin-bottom: 24px; }
        .role-list { display: grid; gap: 12px; margin-bottom: 24px; }
        .role-option {
            display: block;
            border: 1px solid #dbe4f0;
            border-radius: 16px;
            padding: 14px 16px;
            background: #f8fbff;
            cursor: pointer;
            text-align: left;
            font-size: 16px;
            transition: all 0.2s ease;
        }
        .role-option:hover {
            border-color: #f7c948;
            transform: translateY(-1px);
        }
        .role-option.is-selected {
            background: #f7c948;
            border-color: #d4a90f;
            box-shadow: 0 10px 20px rgba(247, 201, 72, 0.28);
        }
        .role-name { font-weight: 700; color: #0f172a; }
        .role-desc { margin-top: 4px; font-size: 14px; color: #64748b; }
        .role-option.is-selected .role-name,
        .role-option.is-selected .role-desc {
            color: #1f2937;
        }
        .role-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .actions { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .back-link { color: #0f2349; text-decoration: none; font-weight: 700; }
        .alert { margin-bottom: 16px; padding: 12px 14px; border-radius: 12px; font-size: 14px; }
        .alert-error { background: #fef2f2; color: #991b1b; }
        .alert-success { background: #ecfdf5; color: #065f46; }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="brand">
                <img src="/images/logo.png" alt="Logo">
                <span>SpotRent</span>
            </div>

            <h1>Pilih Role Aktif</h1>
            <p>Akun Anda punya lebih dari satu role. Pilih role yang ingin dipakai untuk sesi login ini.</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('role.set') }}" method="POST">
                @csrf
                <div class="role-list">
                    @foreach($roles as $role)
                        <label class="role-option" data-role-option>
                            <input class="role-input" type="radio" name="role" value="{{ $role }}">
                            <span class="role-name">{{ ucfirst($role) }}</span>
                            <div class="role-desc">
                                @if($role === 'penyewa')
                                    Akses untuk mencari dan memesan properti.
                                @elseif($role === 'mitra')
                                    Akses untuk mengelola properti dan booking.
                                @elseif($role === 'admin')
                                    Akses untuk mengelola pengguna dan sistem.
                                @else
                                    Role ini akan dipakai selama sesi aktif.
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('role')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror

                <div class="actions">
                    <a class="back-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                    <button type="submit" style="padding: 12px 18px; border: none; border-radius: 10px; background: #f7c948; font-weight: 700; cursor: pointer;">Lanjutkan</button>
                </div>
            </form>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </div>

    <script>
        const roleOptions = document.querySelectorAll('[data-role-option]');

        function syncRoleSelection(selectedInput) {
            roleOptions.forEach((option) => {
                const input = option.querySelector('input[type="radio"]');
                option.classList.toggle('is-selected', input === selectedInput && input.checked);
            });
        }

        roleOptions.forEach((option) => {
            const input = option.querySelector('input[type="radio"]');

            option.addEventListener('click', () => {
                input.checked = true;
                syncRoleSelection(input);
            });

            input.addEventListener('change', () => syncRoleSelection(input));

            if (input.checked) {
                option.classList.add('is-selected');
            }
        });
    </script>
</body>
</html>