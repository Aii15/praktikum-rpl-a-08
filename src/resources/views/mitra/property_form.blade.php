@extends('mitra.layout')

@section('styles')
    <style>
        .form-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .field-card {
            min-height: 64px;
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
            width: 100%;
        }

        .field-text small {
            display: block;
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }

        .profile-input, .profile-select, .profile-textarea {
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

        .profile-textarea {
            resize: vertical;
            min-height: 80px;
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

        /* Standard buttons */
        .btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-next, .btn-submit, .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .btn-next {
            background: #f7c948;
            color: #111;
            box-shadow: 0 4px 14px rgba(247, 201, 72, 0.3);
        }

        .btn-next:hover {
            background: #e2b434;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(247, 201, 72, 0.4);
        }

        .btn-submit {
            background: #25943a;
            color: #fff;
            box-shadow: 0 4px 14px rgba(37, 148, 58, 0.3);
        }

        .btn-submit:hover {
            background: #1e7e30;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 22px rgba(37, 148, 58, 0.4);
        }

        .btn-back {
            background: #f3f4f6;
            color: #4b5563;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-right: auto;
        }

        .btn-back:hover {
            background: #e5e7eb;
            color: #1f2937;
            transform: translateY(-2px);
        }

        .btn-next:active, .btn-submit:active, .btn-back:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* Drag & Drop Zone */
        .dropzone-container {
            width: 100%;
            border: 2px dashed #cfd5db;
            border-radius: 12px;
            min-height: 250px;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.25s ease;
            padding: 20px;
        }

        .dropzone-container:hover, .dropzone-container.dragover {
            border-color: #f7c948;
            background: #fff;
            box-shadow: 0 8px 20px rgba(247, 201, 72, 0.1);
        }

        .dropzone-container img.placeholder-icon {
            width: 64px;
            height: 64px;
            object-fit: contain;
            margin-bottom: 12px;
            opacity: 0.6;
            transition: opacity 0.2s ease;
        }

        .dropzone-container:hover img.placeholder-icon {
            opacity: 0.9;
        }

        .dropzone-container span.main-text {
            font-size: 16px;
            font-weight: 600;
            color: #4b5563;
        }

        .dropzone-container span.sub-text {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 12px;
            margin-top: 20px;
            width: 100%;
        }

        .preview-item {
            position: relative;
            aspect-ratio: 4/3;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Custom dropdown styles */
        .dropdown-menu-list {
            display: none;
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 100;
            max-height: 250px;
            overflow-y: auto;
            padding: 10px;
        }

        .dropdown-item-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s ease;
        }

        .dropdown-item-row:hover {
            background: #f3f4f6;
        }

        .dropdown-item-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #f7c948;
        }

        .dropdown-item-row img.facility-icon {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .dropdown-item-row span {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .selected-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef9c3;
            color: #a16207;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .selected-badge img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <h1 id="form-title">Tambah Properti</h1>

    <form action="{{ route('mitra.property.store') }}" method="POST" enctype="multipart/form-data" id="propertyForm">
        @csrf
        
        <!-- STEP 1: SPESIFIKASI PROPERTI -->
        <div id="step-1" class="form-step">
            <div class="form-list">
                
                <div class="field-card" onclick="this.querySelector('input').focus();">
                    <div class="field-text">
                        <small>Nama Properti</small>
                        <input type="text" name="nama_properti" class="profile-input" value="{{ old('nama_properti') }}" placeholder="Nama Properti" required>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="field-card" onclick="this.querySelector('select').focus();">
                    <div class="field-text">
                        <small>Kategori Properti</small>
                        <select name="id_kategori" class="profile-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_kategori }}" {{ old('id_kategori') == $category->id_kategori ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field-card" onclick="this.querySelector('select').focus();">
                    <div class="field-text">
                        <small>Lokasi Properti</small>
                        <select name="id_lokasi" class="profile-select" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id_lokasi }}" {{ old('id_lokasi') == $location->id_lokasi ? 'selected' : '' }}>{{ $location->kota }} - {{ $location->alamat_detail }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="field-card" onclick="document.getElementById('harga_display').focus();">
                    <div class="field-text">
                        <small>Harga per Hari (Rp)</small>
                        <input type="text" id="harga_display" class="profile-input" value="{{ old('harga_per_hari') }}" placeholder="Harga per Hari" required>
                        <!-- Hidden field holding the unformatted integer for submission -->
                        <input type="hidden" name="harga_per_hari" id="harga_per_hari" value="{{ old('harga_per_hari') }}">
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <!-- Custom dropdown for facilities with icons -->
                <div class="field-card" style="position: relative;" id="fasilitas-dropdown-container">
                    <div class="field-text" onclick="toggleFasilitasDropdown(event)">
                        <small>Fasilitas</small>
                        <div id="fasilitas-display" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 2px;">
                            <span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>
                        </div>
                        <input type="hidden" name="fasilitas" id="fasilitas-value" value="{{ old('fasilitas') }}">
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon" onclick="toggleFasilitasDropdown(event)">

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
                    <span>Next</span>
                    <img src="/images/profile/next.png" alt="Next" style="width: 16px; height: 16px; filter: invert(1);">
                </button>
            </div>
        </div>

        <!-- STEP 2: UPLOAD FOTO -->
        <div id="step-2" class="form-step" style="display: none;">
            <div class="form-list">
                
                <div class="field-card">
                    <div class="field-text">
                        <small>Tambah Foto (Maksimal 5 Foto)</small>
                        <span id="photo-count-label" style="font-size: 15px; font-weight: 500; color: #222; margin-top: 2px;">Belum ada foto terpilih</span>
                    </div>
                    <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
                </div>

                <div class="dropzone-container" id="dropzone" onclick="document.getElementById('property-images').click();">
                    <img src="/images/profile/tambah-foto.png" class="placeholder-icon" alt="Tambah Foto Icon">
                    <span class="main-text">Taruh Foto Di Sini</span>
                    <span class="sub-text">atau klik untuk memilih file dari komputer</span>
                    <input type="file" id="property-images" name="images[]" accept="image/*" multiple style="display: none;" onchange="handleFileSelect(event)">
                </div>

                <div class="preview-grid" id="previewGrid"></div>

            </div>

            <div class="btn-container">
                <button type="button" class="btn-back" onclick="goToStep(1)">Kembali</button>
                <button type="submit" class="btn-submit">Ajukan Properti</button>
            </div>
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        // Toggle facilities list
        function toggleFasilitasDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('fasilitas-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Update facilities text display and hidden input
        function updateFasilitasSelection() {
            const checkboxes = document.querySelectorAll('.facility-checkbox');
            const selectedNames = [];
            const displayContainer = document.getElementById('fasilitas-display');
            displayContainer.innerHTML = '';
            
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedNames.push(cb.value);
                    
                    const badge = document.createElement('div');
                    badge.className = 'selected-badge';
                    
                    const icon = document.createElement('img');
                    icon.src = cb.dataset.icon;
                    
                    const label = document.createElement('span');
                    label.textContent = cb.value;
                    
                    badge.appendChild(icon);
                    badge.appendChild(label);
                    displayContainer.appendChild(badge);
                }
            });
            
            document.getElementById('fasilitas-value').value = selectedNames.join(', ');
            if (selectedNames.length === 0) {
                displayContainer.innerHTML = '<span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('fasilitas-dropdown-container');
            const dropdown = document.getElementById('fasilitas-dropdown');
            if (container && !container.contains(e.target)) {
                if (dropdown) dropdown.style.display = 'none';
            }
        });

        // Price formatting logic (Indonesian Rupiah formatting)
        const displayInput = document.getElementById('harga_display');
        const hiddenInput = document.getElementById('harga_per_hari');

        function formatRupiah(value) {
            let number = value.replace(/[^0-9]/g, '');
            if (number === '') return '';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        displayInput.addEventListener('input', function(e) {
            let rawVal = this.value.replace(/[^0-9]/g, '');
            this.value = formatRupiah(this.value);
            hiddenInput.value = rawVal;
        });

        // If validation fails and returns old input
        if (hiddenInput.value) {
            displayInput.value = formatRupiah(hiddenInput.value);
        }

        // Trigger check on load if old value is present
        document.addEventListener('DOMContentLoaded', () => {
            updateFasilitasSelection();
        });

        // STEP NAVIGATION
        function goToStep(step) {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            if (step === 2) {
                // Validate required inputs in step 1
                const requiredInputs = step1.querySelectorAll('[required]');
                let valid = true;
                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.closest('.field-card').style.borderColor = '#ef4444';
                    } else {
                        input.closest('.field-card').style.borderColor = 'transparent';
                    }
                });

                if (!valid) {
                    alert('Mohon lengkapi semua data spesifikasi properti terlebih dahulu.');
                    return;
                }

                step1.style.display = 'none';
                step2.style.display = 'block';
                document.getElementById('form-title').textContent = 'Tambah Foto Properti';
            } else {
                step1.style.display = 'block';
                step2.style.display = 'none';
                document.getElementById('form-title').textContent = 'Tambah Properti';
            }
        }

        // PHOTO UPLOAD DRAG & DROP
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('property-images');
        const previewGrid = document.getElementById('previewGrid');
        const countLabel = document.getElementById('photo-count-label');
        let selectedFiles = [];

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                handleFiles(e.dataTransfer.files);
            }
        });

        function handleFileSelect(e) {
            handleFiles(e.target.files);
        }

        function handleFiles(files) {
            selectedFiles = Array.from(files).slice(0, 5); // Max 5 photos
            
            // Re-assign selected files to input files
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;

            previewGrid.innerHTML = '';
            
            if (selectedFiles.length > 0) {
                countLabel.textContent = `${selectedFiles.length} foto terpilih`;
                
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const item = document.createElement('div');
                        item.className = 'preview-item';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-btn';
                        removeBtn.innerHTML = '×';
                        removeBtn.type = 'button';
                        removeBtn.onclick = (event) => {
                            event.stopPropagation();
                            removeFile(index);
                        };
                        
                        item.appendChild(img);
                        item.appendChild(removeBtn);
                        previewGrid.appendChild(item);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                countLabel.textContent = 'Belum ada foto terpilih';
            }
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            fileInput.files = dt.files;
            
            handleFiles(fileInput.files);
        }
    </script>
@endsection
