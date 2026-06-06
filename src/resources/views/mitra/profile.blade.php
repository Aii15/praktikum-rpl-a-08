@extends('mitra.layout')

@section('styles')
    <style>
        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            height: 64px;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .field-card:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .field-card:focus-within {
            background: #ffffff;
            border-color: #f7c948;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.18);
            transform: translateY(-2px);
        }

        .field-text {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .field-text small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }

        .profile-input {
            border: none;
            background: transparent;
            font-size: 15px;
            font-weight: 500;
            color: #222;
            width: 100%;
            outline: none;
            padding: 0;
            margin-top: 2px;
            font-family: 'Poppins', sans-serif;
        }

        .edit-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .field-card:hover .edit-icon {
            opacity: 1;
            transform: scale(1.1);
        }

        .save-btn {
            background: #25943a;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(37, 148, 58, 0.3);
            display: inline-block;
            margin-top: 25px;
            float: right;
            outline: none;
        }

        .save-btn:hover {
            background: #1e7e30;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(37, 148, 58, 0.4);
        }

        .save-btn:active {
            transform: translateY(-1px) scale(0.98);
            box-shadow: 0 4px 12px rgba(37, 148, 58, 0.2);
        }
    </style>
@endsection

@section('content')
    <h1>Tentang Saya</h1>

    <form action="{{ route('mitra.profile.update') }}" method="POST">
        @csrf
        <div class="form-list">
            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>Nama Lengkap</small>
                    <input type="text" name="name" class="profile-input" value="{{ old('name', $user->name) }}" required>
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>Nama Mitra Atau Perusahaan</small>
                    <input type="text" name="nama_mitra" class="profile-input" value="{{ old('nama_mitra', $profile->nama_mitra ?? '') }}" required>
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>E-Mail</small>
                    <input type="email" name="email" class="profile-input" value="{{ old('email', $user->email) }}" required>
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>No Telepon</small>
                    <input type="text" name="no_hp" class="profile-input" value="{{ old('no_hp', $user->no_hp) }}" required>
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>No Rekening</small>
                    <input type="text" name="rekening_bank" class="profile-input" value="{{ old('rekening_bank', $user->rekening_bank ?? $profile->rekening_bank ?? '') }}" placeholder="Belum mengatur nomor rekening">
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>No KTP</small>
                    <input type="text" name="ktp" class="profile-input" value="{{ old('ktp', $user->ktp ?? $profile->ktp ?? '') }}" required>
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>Password Baru</small>
                    <input type="password" name="password" class="profile-input" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>Konfirmasi Password Baru</small>
                    <input type="password" name="password_confirmation" class="profile-input" placeholder="Tulis ulang password baru">
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>
        </div>

        <button type="submit" class="save-btn">Simpan Perubahan</button>
    </form>
@endsection
