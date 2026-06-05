@extends('mitra.layout')

@section('content')
    <div class="page-title">
        <h1>Tentang Saya</h1>
    </div>

    <form action="{{ route('mitra.profile.update') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-field">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-field">
                <label for="nama_mitra">Nama Mitra / Perusahaan</label>
                <input id="nama_mitra" name="nama_mitra" type="text" value="{{ old('nama_mitra', $profile->nama_mitra ?? '') }}" required>
            </div>
            <div class="form-field">
                <label for="email">E-Mail</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-field">
                <label for="no_hp">No Telepon</label>
                <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $user->no_hp) }}" required>
            </div>
            <div class="form-field">
                <label for="rekening_bank">No Rekening</label>
                <input id="rekening_bank" name="rekening_bank" type="text" value="{{ old('rekening_bank', $user->rekening_bank) }}">
            </div>
            <div class="form-field">
                <label for="ktp">No KTP</label>
                <input id="ktp" name="ktp" type="text" value="{{ old('ktp', $user->ktp) }}" required>
            </div>
            <div class="form-field form-row-full">
                <label for="password">Password Baru</label>
                <input id="password" name="password" type="password" placeholder="Kosongkan jika tidak ingin mengganti">
            </div>
            <div class="form-field form-row-full">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Isi jika mengganti password">
            </div>
        </div>

        <button class="button-primary" type="submit">Simpan Perubahan</button>
    </form>
@endsection
