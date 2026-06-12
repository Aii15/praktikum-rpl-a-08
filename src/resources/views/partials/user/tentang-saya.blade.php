<div id="section-tentang-saya" class="content-section">
    <h1>Tentang Saya</h1>

    <form action="{{ route('user.profile.update') }}" method="POST">
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
                    <small>Alamat</small>
                    <input type="text" name="alamat" class="profile-input" value="{{ old('alamat', $user->alamat) }}" placeholder="Belum mengatur alamat">
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>

            <div class="field-card" onclick="this.querySelector('input').focus();">
                <div class="field-text">
                    <small>Password</small>
                    <input type="password" name="password" class="profile-input" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
            </div>
        </div>

        <button type="submit" class="save-btn">Simpan Perubahan</button>
    </form>
</div>
