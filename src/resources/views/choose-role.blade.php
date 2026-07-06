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
    <link rel="stylesheet" href="{{ asset('css/choose-role.css') }}">
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