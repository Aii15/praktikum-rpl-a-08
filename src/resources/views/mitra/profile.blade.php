@extends('mitra.layout')

@section('content')
    <!-- TOAST PERINGATAN PROFIL MITRA -->
    <div id="profile-toast-overlay" style="
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 99999;
        pointer-events: none;
    ">
        <div id="profile-toast-box" style="
            position: fixed;
            top: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(-20px);
            background: #fff;
            border: 1.5px solid #ef4444;
            border-left: 5px solid #ef4444;
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 8px 30px rgba(239,68,68,0.18);
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #991b1b;
            min-width: 300px;
            max-width: 460px;
            pointer-events: all;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
        ">
            <span style="font-size: 20px; flex-shrink:0;">⚠️</span>
            <span id="profile-toast-msg">Mohon lengkapi semua data profil terlebih dahulu.</span>
            <button onclick="closeProfileToast()" style="margin-left:auto; background:none; border:none; cursor:pointer; font-size:18px; color:#9ca3af; line-height:1;" aria-label="Tutup">×</button>
        </div>
    </div>
    <!-- SECTION 1: TENTANG SAYA -->
    @include('mitra.partials.tentang-mitra')

    <!-- SECTION 2 & 6: RIWAYAT & DETAIL PENYEWAAN -->
    @include('mitra.partials.riwayat-penyewaan')

    <!-- SECTION 3: PROPERTI SAYA -->
    @include('mitra.partials.properti-saya')

    <!-- SECTION 4: TAMBAH PROPERTI -->
    @include('mitra.partials.tambah-properti')

    <!-- SECTION 5: STATUS PENGAJUAN -->
    @include('mitra.partials.status-pengajuan')
@endsection

@section('scripts')
    @php
        function parse_ini_bytes_local($val) {
            $val = trim($val);
            if (empty($val)) return 0;
            $last = strtolower($val[strlen($val)-1]);
            $val = (int)$val;
            switch($last) {
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }
            return $val * 1024; // convert KB to Bytes
        }
        $uploadLimit = parse_ini_bytes_local(ini_get('upload_max_filesize'));
        $postLimit = parse_ini_bytes_local(ini_get('post_max_size'));
    @endphp
    <script>
        // ID booking global yang diteruskan dari server untuk pemuatan langsung
        window.activeBookingId = @json($activeBookingId ?? null);
        window.phpUploadLimit = @json($uploadLimit);
        window.phpPostLimit = @json($postLimit);
    </script>
    <script src="{{ asset('js/mitra/rental.js') }}"></script>
    <script src="{{ asset('js/mitra/property.js') }}"></script>
    <script src="{{ asset('js/mitra/image-upload.js') }}"></script>
    <script src="{{ asset('js/mitra/profile-validation.js') }}"></script>
    <script src="{{ asset('js/profile-mitra.js') }}"></script>
    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.showProfileToast === 'function') {
                window.showProfileToast(@json($errors->first()));
            }
        });
    </script>
    @endif
@endsection
