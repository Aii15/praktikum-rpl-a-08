<div id="section-tentang-saya" class="content-section">
    <h1>Tentang Saya</h1>

    <form id="profile-mitra-form" action="{{ route('mitra.profile.update') }}" method="POST" novalidate>
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

        <button type="submit" id="profile-save-btn" class="save-btn">Simpan Perubahan</button>
    </form>
</div>
