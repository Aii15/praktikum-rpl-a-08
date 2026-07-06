<!-- SECTION 4: TAMBAH PROPERTI -->
<div id="section-tambah-properti" class="content-section">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 28px;">
        <button type="button" id="btn-back-crop-top" class="btn-back-arrow" onclick="goToSubStep('upload')" title="Kembali ke Upload" style="display: none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
        </button>
        <h1 id="form-title" style="margin: 0; margin-bottom: 0 !important; letter-spacing: 0.5px;">Tambah Properti</h1>
    </div>

    <form action="{{ route('mitra.property.store') }}" method="POST" enctype="multipart/form-data" id="propertyForm">
        @csrf
        
        <!-- LANGKAH 1: SPESIFIKASI PROPERTI -->
        <div id="step-1" class="form-step">
            <div class="form-list">
                
                <div class="field-card" onclick="this.querySelector('input').focus();">
                    <div class="field-text">
                        <small>Nama Properti</small>
                        <input type="text" name="nama_properti" class="profile-input" value="{{ old('nama_properti') }}" placeholder="Nama Properti" required>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <!-- Dropdown kustom untuk kategori dengan ikon -->
                <div class="field-card" style="position: relative; z-index: 15;" id="kategori-dropdown-container">
                    <div class="field-text" onclick="toggleKategoriDropdown(event)">
                        <small>Kategori Properti</small>
                        <div id="kategori-display" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 2px;">
                            <span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Kategori</span>
                        </div>
                        <input type="hidden" name="id_kategori" id="kategori-value" value="{{ old('id_kategori') }}" required>
                    </div>
                    <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleKategoriDropdown(event)">

                    <div id="kategori-dropdown" class="dropdown-menu-list">
                        @php
                            $categoryIconsList = [
                                'hunian' => 'hunian.svg',
                                'heritage' => 'heritage.svg',
                                'lanskap' => 'lanskap.svg',
                                'fasilitas publik' => 'fasilitas_publik.svg',
                                'komersial' => 'komersial.svg',
                                'studio' => 'studio_icon.svg',
                                'industrial' => 'industrial.svg',
                            ];
                        @endphp
                        @foreach($categories as $category)
                            @php
                                $catKey = strtolower($category->nama_kategori);
                                $catIcon = $categoryIconsList[$catKey] ?? 'property.png';
                            @endphp
                            <div class="dropdown-item-row category-item-row" data-id="{{ $category->id_kategori }}" data-name="{{ $category->nama_kategori }}" data-icon="/images/landing/icons/{{ $catIcon }}" onclick="selectKategori('{{ $category->id_kategori }}', '{{ $category->nama_kategori }}', '/images/landing/icons/{{ $catIcon }}', event)">
                                <img src="/images/landing/icons/{{ $catIcon }}" class="facility-icon" alt="{{ $category->nama_kategori }}">
                                <span>{{ $category->nama_kategori }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="field-card" onclick="this.querySelector('input').focus();">
                    <div class="field-text">
                        <small>Provinsi</small>
                        <input type="text" name="provinsi" class="profile-input" value="{{ old('provinsi') }}" placeholder="Contoh: Jawa Barat" required>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="field-card" onclick="this.querySelector('input').focus();">
                    <div class="field-text">
                        <small>Kota / Kabupaten</small>
                        <input type="text" name="kota" class="profile-input" value="{{ old('kota') }}" placeholder="Contoh: Bandung" required>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="field-card" onclick="this.querySelector('textarea').focus();" style="height: auto; min-height: 85px;">
                    <div class="field-text">
                        <small>Alamat Lengkap / Detail</small>
                        <textarea name="alamat_detail" class="profile-textarea" placeholder="Tulis nama jalan, nomor, RT/RW, kecamatan" style="min-height: 45px;" required>{{ old('alamat_detail') }}</textarea>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="field-card" onclick="this.querySelector('input').focus();">
                    <div class="field-text">
                        <small>Kode Pos</small>
                        <input type="text" name="kode_pos" class="profile-input" value="{{ old('kode_pos') }}" placeholder="Contoh: 40135">
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="field-card" onclick="document.getElementById('harga_display').focus();">
                    <div class="field-text">
                        <small>Harga per Hari (Rp)</small>
                        <input type="text" id="harga_display" class="profile-input" value="{{ old('harga_per_hari') }}" placeholder="Harga per Hari" required>
                        <!-- Input tersembunyi yang menyimpan nilai integer mentah untuk pengiriman -->
                        <input type="hidden" name="harga_per_hari" id="harga_per_hari" value="{{ old('harga_per_hari') }}">
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <!-- Dropdown kustom untuk fasilitas dengan ikon -->
                <div class="field-card" style="position: relative; z-index: 10;" id="fasilitas-dropdown-container">
                    <div class="field-text" onclick="toggleFasilitasDropdown(event)">
                        <small>Fasilitas</small>
                        <div id="fasilitas-display" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 2px;">
                            <span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>
                        </div>
                        <input type="hidden" name="fasilitas" id="fasilitas-value" value="{{ old('fasilitas') }}">
                    </div>
                    <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleFasilitasDropdown(event)">

                    <div id="fasilitas-dropdown" class="dropdown-menu-list">
                        @php
                            $predefinedFacilities = [
                                'Sanitasi' => 'sanitasi.svg',
                                'Listrik dan Penerangan' => 'listrik.svg',
                                'CCTV' => 'cctv.svg',
                                'Parkir Mobil' => 'parkir.svg',
                                'Sprinkler Water' => 'sprinkler.svg',
                                'Permit Included' => 'permit.svg',
                                'APAR' => 'apar.svg',
                                'Outdoor' => 'outdoor.svg'
                            ];
                        @endphp
                        @foreach($predefinedFacilities as $name => $icon)
                            <label class="dropdown-item-row" onclick="event.stopPropagation();">
                                <input type="checkbox" class="facility-checkbox" value="{{ $name }}" data-icon="/images/informasi/icons/{{ $icon }}" onchange="updateFasilitasSelection()" {{ in_array(strtolower($name), array_map('trim', explode(',', strtolower(old('fasilitas'))))) ? 'checked' : '' }}>
                                <img src="/images/informasi/icons/{{ $icon }}" class="facility-icon" alt="{{ $name }}">
                                <span>{{ $name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="field-card" onclick="this.querySelector('textarea').focus();">
                    <div class="field-text">
                        <small>Deskripsi Properti</small>
                        <textarea name="deskripsi" class="profile-textarea" placeholder="Deskripsi Properti" required>{{ old('deskripsi') }}</textarea>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

            </div>

            <div class="btn-container">
                <button type="button" class="btn-next" onclick="goToStep(2)">
                    <span>Lanjut</span>
                    <img src="/images/profile/next.png" alt="Lanjut" style="width: 16px; height: 16px;">
                </button>
            </div>
        </div>

        <!-- LANGKAH 2: TAMBAH FOTO PROPERTI -->
        <div id="step-2" class="form-step" style="display: none;">
            
            <!-- SUB-LANGKAH 2A: UNGGAH FOTO -->
            <div id="sub-step-upload" class="form-list">
                <div class="field-card">
                    <div class="field-text">
                        <small>Unggah File Foto (Minimal 2, Maksimal 5 Foto, Maksimal 10MB per foto)</small>
                        <span id="photo-count-label" style="font-size: 15px; font-weight: 500; color: #222; margin-top: 2px;">Belum ada foto terpilih</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="dropzone-container" id="dropzone" onclick="document.getElementById('property-images').click();">
                    <img src="/images/profile/tambah-foto.png" class="placeholder-icon" alt="Tambah Foto Icon">
                    <span class="main-text">Taruh Foto Di Sini</span>
                    <span class="sub-text">atau klik untuk memilih file dari komputer (maks. 10MB per foto)</span>
                    <input type="file" id="property-images" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFileSelect(event)">
                </div>

                <div id="hidden-positions-container"></div>
                
                <!-- Daftar unggahan menampilkan file dengan tanda panah pengurutan dan aksi hapus -->
                <div class="photo-upload-list" id="uploadPhotoList"></div>
                
                <div class="btn-container">
                    <button type="button" class="btn-back" onclick="goToStep(1)">Kembali</button>
                    <button type="button" class="btn-next" id="btn-to-crop" onclick="goToSubStep('crop')" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <span>Atur Posisi Gambar</span>
                        <img src="/images/profile/next.png" alt="Lanjut" style="width: 16px; height: 16px;">
                    </button>
                </div>
            </div>

            <!-- SUB-LANGKAH 2B: ATUR POSISI GAMBAR -->
            <div id="sub-step-crop" class="form-list" style="display: none;">
                <div class="sticky-preview-wrapper">
                    <div class="preview-gallery-container" id="previewGalleryContainer">
                        <h3 style="margin-bottom: 10px;">Live Layout Preview</h3>
                        <div id="liveLayoutGallery"></div>
                    </div>
                </div>

                <div class="field-card">
                    <div class="field-text">
                        <small>Sesuaikan Thumbnail</small>
                        <span style="font-size: 14px; font-weight: 500; color: #666; margin-top: 2px;">Geser slider untuk memposisikan bagian tengah gambar yang ingin ditampilkan pada mockup layout di atas.</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <!-- Daftar kontrol foto menampilkan slider horizontal/vertical (tata letak tabel) -->
                <div class="crop-table-container">
                    <table class="crop-table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Informasi</th>
                                <th>Posisi Horiz (X)</th>
                                <th>Posisi Vert (Y)</th>
                            </tr>
                        </thead>
                        <tbody id="photoControlList"></tbody>
                    </table>
                </div>

                <div class="btn-container">
                    <button type="button" class="btn-back" onclick="goToSubStep('upload')">Kembali ke Upload</button>
                    <button type="submit" class="btn-submit">Ajukan Properti</button>
                </div>
            </div>

        </div>

    </form>
</div>
