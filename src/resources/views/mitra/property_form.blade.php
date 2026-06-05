@extends('mitra.layout')

@section('content')
    <div class="page-title">
        <h1>Tambah Properti</h1>
    </div>

    <form action="{{ route('mitra.property.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-field">
                <label for="nama_properti">Nama Properti</label>
                <input id="nama_properti" name="nama_properti" type="text" value="{{ old('nama_properti') }}" required>
            </div>
            <div class="form-field">
                <label for="id_kategori">Kategori</label>
                <select id="id_kategori" name="id_kategori" required>
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id_kategori }}" {{ old('id_kategori') == $category->id_kategori ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-field">
                <label for="id_lokasi">Lokasi</label>
                <select id="id_lokasi" name="id_lokasi" required>
                    <option value="">Pilih lokasi</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id_lokasi }}" {{ old('id_lokasi') == $location->id_lokasi ? 'selected' : '' }}>{{ $location->kota }} - {{ $location->alamat_detail }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-field">
                <label for="harga_per_periode">Harga per Periode</label>
                <input id="harga_per_periode" name="harga_per_periode" type="number" min="0" value="{{ old('harga_per_periode') }}" required>
            </div>
            <div class="form-field">
                <label for="fasilitas">Fasilitas</label>
                <textarea id="fasilitas" name="fasilitas">{{ old('fasilitas') }}</textarea>
            </div>
            <div class="form-field form-row-full">
                <label for="deskripsi">Deskripsi Properti</label>
                <textarea id="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="form-field form-row-full">
                <label for="images">Foto Properti (maks. 5)</label>
                <input id="images" name="images[]" type="file" accept="image/*" multiple>
            </div>
        </div>

        <button class="button-primary" type="submit">Ajukan Properti</button>
    </form>
@endsection
