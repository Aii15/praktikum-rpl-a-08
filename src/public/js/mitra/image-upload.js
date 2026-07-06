// =============================================
// LOGIKA UNGGAH & PREVIEW FOTO PROPERTI MITRA
// =============================================

window.selectedFiles = [];
window.activeSubStep = 'upload';

// Element DOM
const dropzone = document.getElementById('dropzone');
const fileInput = document.getElementById('property-images');
const countLabel = document.getElementById('photo-count-label');
const uploadPhotoList = document.getElementById('uploadPhotoList');
const photoControlList = document.getElementById('photoControlList');
const previewGalleryContainer = document.getElementById('previewGalleryContainer');
const liveLayoutGallery = document.getElementById('liveLayoutGallery');
const hiddenPositionsContainer = document.getElementById('hidden-positions-container');

if (dropzone) {
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
            handleFiles(e.dataTransfer.files);
        }
    });
}

function handleFileSelect(e) {
    handleFiles(e.target.files);
}
window.handleFileSelect = handleFileSelect;

function handleFiles(files) {
    if (!fileInput) return;
    const newFiles = Array.from(files);
    let hasOversizedFile = false;
    let oversizedFileNames = [];
    
    for (let file of newFiles) {
        if (window.selectedFiles.length >= 5) break;
        if (!file.type.startsWith('image/')) continue;
        
        // Cek ukuran file maksimal 10 MB dan batas server PHP
        const maxLimit = 10 * 1024 * 1024;
        const phpLimit = window.phpUploadLimit || maxLimit;
        
        if (file.size > maxLimit) {
            hasOversizedFile = true;
            oversizedFileNames.push(`${file.name} (> 10MB)`);
            continue;
        } else if (file.size > phpLimit) {
            hasOversizedFile = true;
            const phpLimitMB = (phpLimit / (1024 * 1024)).toFixed(0);
            oversizedFileNames.push(`${file.name} (> batas server PHP ${phpLimitMB}MB)`);
            continue;
        }

        window.selectedFiles.push({
            file: file,
            positionX: 50,
            positionY: 50,
            previewUrl: URL.createObjectURL(file)
        });
    }
    
    updateFormInputsAndPreviews();

    if (hasOversizedFile) {
        const namesText = oversizedFileNames.join(', ');
        if (typeof window.showProfileToast === 'function') {
            window.showProfileToast(`Ukuran foto terlalu besar. File ditolak: ${namesText}. Silakan naikkan batas 'upload_max_filesize' pada php.ini jika ingin mengunggah hingga 10MB.`);
        } else {
            alert(`Ukuran foto terlalu besar. File ditolak: ${namesText}`);
        }
    }
}

function updateFormInputsAndPreviews() {
    if (!fileInput || !countLabel || !hiddenPositionsContainer) return;
    
    // Sinkronisasi daftar file ke bidang input
    const dt = new DataTransfer();
    window.selectedFiles.forEach(item => dt.items.add(item.file));
    fileInput.files = dt.files;

    // Sinkronisasi input tersembunyi untuk posisi
    hiddenPositionsContainer.innerHTML = '';
    window.selectedFiles.forEach(item => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'positions[]';
        hiddenInput.value = `${item.positionX || 50}% ${item.positionY || 50}%`;
        hiddenPositionsContainer.appendChild(hiddenInput);
    });

    // Perbarui teks jumlah foto
    if (window.selectedFiles.length > 0) {
        countLabel.textContent = `${window.selectedFiles.length} foto terpilih (Minimal 2, Maksimal 5)`;
    } else {
        countLabel.textContent = 'Belum ada foto terpilih (Minimal 2, Maksimal 5)';
    }

    // Sinkronisasi status aktif/nonaktif tombol navigasi di Tahap Unggah
    const btnToCrop = document.getElementById('btn-to-crop');
    if (btnToCrop) {
        if (window.selectedFiles.length >= 2) {
            btnToCrop.disabled = false;
            btnToCrop.style.opacity = '1';
            btnToCrop.style.cursor = 'pointer';
        } else {
            btnToCrop.disabled = true;
            btnToCrop.style.opacity = '0.5';
            btnToCrop.style.cursor = 'not-allowed';
        }
    }

    // Jika saat ini berada di langkah crop tetapi jumlah foto kurang dari 2, secara otomatis kembali ke sub-langkah unggah
    if (window.activeSubStep === 'crop' && window.selectedFiles.length < 2) {
        if (typeof window.goToSubStep === 'function') {
            window.goToSubStep('upload');
        }
    }

    // 1. Tampilkan Sub-langkah Daftar Unggahan 2A
    if (uploadPhotoList) {
        uploadPhotoList.innerHTML = '';
        window.selectedFiles.forEach((item, index) => {
            const card = document.createElement('div');
            card.className = 'upload-item-card';

            // Pratinjau gambar mini
            const thumb = document.createElement('div');
            thumb.className = 'upload-item-thumb';
            const img = document.createElement('img');
            img.src = item.previewUrl;
            thumb.appendChild(img);
            card.appendChild(thumb);

            // Informasi
            const info = document.createElement('div');
            info.className = 'upload-item-info';

            const title = document.createElement('div');
            title.className = 'upload-item-title';
            
            const filenameSpan = document.createElement('span');
            filenameSpan.className = 'upload-item-filename';
            filenameSpan.textContent = item.file.name;
            filenameSpan.title = item.file.name;
            title.appendChild(filenameSpan);

            // Label ukuran file
            const sizeSpan = document.createElement('span');
            sizeSpan.className = 'upload-item-size';
            const sizeInMB = item.file.size / (1024 * 1024);
            sizeSpan.textContent = sizeInMB < 0.1 ? (item.file.size / 1024).toFixed(1) + ' KB' : sizeInMB.toFixed(2) + ' MB';
            sizeSpan.style.fontSize = '11px';
            sizeSpan.style.color = '#6b7280';
            sizeSpan.style.fontWeight = '500';
            title.appendChild(sizeSpan);

            const badge = document.createElement('span');
            if (index === 0) {
                badge.className = 'badge-cover';
                badge.textContent = 'Foto Utama (Cover)';
            } else {
                badge.className = 'badge-secondary';
                badge.textContent = `Foto Detail #${index + 1}`;
            }
            title.appendChild(badge);
            info.appendChild(title);
            card.appendChild(info);

            // Aksi pengurutan kembali & penghapusan
            const actions = document.createElement('div');
            actions.className = 'upload-item-actions';

            if (index > 0) {
                const btnUp = document.createElement('button');
                btnUp.type = 'button';
                btnUp.className = 'btn-action';
                btnUp.textContent = '◀';
                btnUp.title = 'Pindahkan Ke Kiri';
                btnUp.onclick = () => swapFiles(index, index - 1);
                actions.appendChild(btnUp);
            }

            if (index < window.selectedFiles.length - 1) {
                const btnDown = document.createElement('button');
                btnDown.type = 'button';
                btnDown.className = 'btn-action';
                btnDown.textContent = '▶';
                btnDown.title = 'Pindahkan Ke Kanan';
                btnDown.onclick = () => swapFiles(index, index + 1);
                actions.appendChild(btnDown);
            }

            const btnDel = document.createElement('button');
            btnDel.type = 'button';
            btnDel.className = 'btn-action btn-delete';
            btnDel.textContent = 'Hapus';
            btnDel.onclick = () => removeFile(index);
            actions.appendChild(btnDel);

            card.appendChild(actions);
            uploadPhotoList.appendChild(card);
        });
    }

    // 2. Tampilkan Sub-langkah Daftar Kontrol Pemotongan 2B (Baris Tabel)
    if (photoControlList) {
        photoControlList.innerHTML = '';
        window.selectedFiles.forEach((item, index) => {
            const row = document.createElement('tr');

            // 1. Sel gambar mini
            const tdThumb = document.createElement('td');
            const thumb = document.createElement('div');
            thumb.className = 'crop-table-thumb';
            const img = document.createElement('img');
            img.src = item.previewUrl;
            img.id = `preview-thumb-img-${index}`;
            thumb.appendChild(img);
            tdThumb.appendChild(thumb);
            row.appendChild(tdThumb);

            // 2. Sel info
            const tdInfo = document.createElement('td');
            const info = document.createElement('div');
            info.className = 'crop-table-info';
            
            const filenameSpan = document.createElement('span');
            filenameSpan.className = 'crop-table-filename';
            filenameSpan.textContent = item.file.name;
            filenameSpan.title = item.file.name;
            info.appendChild(filenameSpan);

            // Label ukuran file
            const sizeSpan = document.createElement('span');
            sizeSpan.className = 'crop-table-size';
            const sizeInMB = item.file.size / (1024 * 1024);
            sizeSpan.textContent = sizeInMB < 0.1 ? (item.file.size / 1024).toFixed(1) + ' KB' : sizeInMB.toFixed(2) + ' MB';
            sizeSpan.style.fontSize = '11px';
            sizeSpan.style.color = '#6b7280';
            sizeSpan.style.fontWeight = '500';
            info.appendChild(sizeSpan);

            const badge = document.createElement('span');
            if (index === 0) {
                badge.className = 'badge-cover';
                badge.textContent = 'Foto Utama (Cover)';
            } else {
                badge.className = 'badge-secondary';
                badge.textContent = `Foto Detail #${index + 1}`;
            }
            info.appendChild(badge);
            tdInfo.appendChild(info);
            row.appendChild(tdInfo);

            // 3. Sel Slider Horizontal
            const tdSliderX = document.createElement('td');
            tdSliderX.className = 'crop-table-slider-cell';
            const adjusterX = document.createElement('div');
            adjusterX.className = 'crop-table-adjuster';
            
            const sliderX = document.createElement('input');
            sliderX.type = 'range';
            sliderX.className = 'crop-slider';
            sliderX.min = '0';
            sliderX.max = '100';
            sliderX.value = item.positionX || 50;
            
            const valDisplayX = document.createElement('span');
            valDisplayX.style.width = '30px';
            valDisplayX.style.textAlign = 'right';
            valDisplayX.style.fontSize = '12px';
            valDisplayX.style.fontWeight = '600';
            valDisplayX.style.color = '#4b5563';
            valDisplayX.textContent = `${sliderX.value}%`;

            adjusterX.appendChild(sliderX);
            adjusterX.appendChild(valDisplayX);
            tdSliderX.appendChild(adjusterX);
            row.appendChild(tdSliderX);

            // 4. Sel Slider Vertikal
            const tdSliderY = document.createElement('td');
            tdSliderY.className = 'crop-table-slider-cell';
            const adjusterY = document.createElement('div');
            adjusterY.className = 'crop-table-adjuster';
            
            const sliderY = document.createElement('input');
            sliderY.type = 'range';
            sliderY.className = 'crop-slider';
            sliderY.min = '0';
            sliderY.max = '100';
            sliderY.value = item.positionY || 50;
            
            const valDisplayY = document.createElement('span');
            valDisplayY.style.width = '30px';
            valDisplayY.style.textAlign = 'right';
            valDisplayY.style.fontSize = '12px';
            valDisplayY.style.fontWeight = '600';
            valDisplayY.style.color = '#4b5563';
            valDisplayY.textContent = `${sliderY.value}%`;

            adjusterY.appendChild(sliderY);
            adjusterY.appendChild(valDisplayY);
            tdSliderY.appendChild(adjusterY);
            row.appendChild(tdSliderY);

            function updateImagePositions() {
                const valX = sliderX.value;
                const valY = sliderY.value;
                item.positionX = valX;
                item.positionY = valY;
                valDisplayX.textContent = `${valX}%`;
                valDisplayY.textContent = `${valY}%`;
                
                const posStr = `${valX}% ${valY}%`;
                
                // Perbarui pratinjau tata letak secara langsung (pergeseran posisi gambar galeri tiruan, gambar mini dikunci melalui CSS)
                const galleryImg = document.getElementById(`gallery-img-${index}`);
                if (galleryImg) {
                    galleryImg.style.objectPosition = posStr;
                }

                // Perbarui nilai input tersembunyi yang sesuai
                if (hiddenPositionsContainer && hiddenPositionsContainer.children && hiddenPositionsContainer.children[index]) {
                    hiddenPositionsContainer.children[index].value = posStr;
                }
            }

            sliderX.oninput = updateImagePositions;
            sliderY.oninput = updateImagePositions;

            photoControlList.appendChild(row);
        });
    }

    // 3. Perbarui/Alihkan visibilitas Pratinjau Tata Letak Langsung
    if (previewGalleryContainer) {
        if (window.selectedFiles.length >= 2) {
            previewGalleryContainer.style.display = 'block';
            if (window.activeSubStep === 'crop') {
                renderLiveLayoutPreview();
            }
        } else {
            previewGalleryContainer.style.display = 'none';
        }
    }
}

function swapFiles(idx1, idx2) {
    const temp = window.selectedFiles[idx1];
    window.selectedFiles[idx1] = window.selectedFiles[idx2];
    window.selectedFiles[idx2] = temp;
    updateFormInputsAndPreviews();
}
window.swapFiles = swapFiles;

function removeFile(index) {
    if (window.selectedFiles[index]) {
        URL.revokeObjectURL(window.selectedFiles[index].previewUrl);
        window.selectedFiles.splice(index, 1);
    }
    updateFormInputsAndPreviews();
}
window.removeFile = removeFile;

function renderLiveLayoutPreview() {
    if (!liveLayoutGallery) return;
    liveLayoutGallery.innerHTML = '';

    const n = window.selectedFiles.length; // Rentang [2, 5]
    const galleryDiv = document.createElement('div');
    galleryDiv.className = `mock-gallery mock-gallery-${n}`;

    // Slot Utama / Sampul (Slot 1)
    const mainItem = document.createElement('div');
    mainItem.className = 'mock-gallery-item mock-main-item';
    
    const mainImg = document.createElement('img');
    mainImg.src = window.selectedFiles[0].previewUrl;
    mainImg.style.objectPosition = `${window.selectedFiles[0].positionX || 50}% ${window.selectedFiles[0].positionY || 50}%`;
    mainImg.id = 'gallery-img-0';
    mainItem.appendChild(mainImg);

    const mainLabel = document.createElement('div');
    mainLabel.className = 'slot-label';
    mainLabel.textContent = 'Foto 1: Cover (Utama)';
    mainItem.appendChild(mainLabel);

    galleryDiv.appendChild(mainItem);

    // Slot Samping
    if (n > 1) {
        const sideGallery = document.createElement('div');
        sideGallery.className = 'mock-side-gallery';

        for (let i = 1; i < n; i++) {
            const sideItem = document.createElement('div');
            sideItem.className = 'mock-gallery-item';
            
            const sideImg = document.createElement('img');
            sideImg.src = window.selectedFiles[i].previewUrl;
            sideImg.style.objectPosition = `${window.selectedFiles[i].positionX || 50}% ${window.selectedFiles[i].positionY || 50}%`;
            sideImg.id = `gallery-img-${i}`;
            sideItem.appendChild(sideImg);

            const sideLabel = document.createElement('div');
            sideLabel.className = 'slot-label';
            sideLabel.textContent = `Foto ${i + 1}`;
            sideItem.appendChild(sideLabel);

            sideGallery.appendChild(sideItem);
        }
        galleryDiv.appendChild(sideGallery);
    }

    liveLayoutGallery.appendChild(galleryDiv);
}
window.renderLiveLayoutPreview = renderLiveLayoutPreview;

function scrollToPreview(e) {
    if (e) e.preventDefault();
    const el = document.getElementById('previewGalleryContainer');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
}
window.scrollToPreview = scrollToPreview;

// Tambahkan validasi sisi klien ke pengiriman form
const propertyForm = document.getElementById('propertyForm');
if (propertyForm) {
    propertyForm.addEventListener('submit', function (e) {
        if (window.selectedFiles.length < 2) {
            e.preventDefault();
            showProfileToast('Minimal 2 foto wajib diunggah untuk melanjutkan.');
            return;
        } else if (window.selectedFiles.length > 5) {
            e.preventDefault();
            showProfileToast('Maksimal 5 foto dapat diunggah.');
            return;
        }

        // Cek total ukuran file
        let totalSize = 0;
        window.selectedFiles.forEach(item => {
            totalSize += item.file.size;
        });

        const phpPostLimit = window.phpPostLimit || (50 * 1024 * 1024);
        if (totalSize > phpPostLimit) {
            e.preventDefault();
            const limitMB = (phpPostLimit / (1024 * 1024)).toFixed(0);
            showProfileToast(`Total ukuran file (${(totalSize / (1024 * 1024)).toFixed(1)}MB) melebihi batas server PHP (${limitMB}MB). Silakan kurangi jumlah foto atau perkecil resolusi foto.`);
            return;
        }
    });
}

// Logika Panah Indikator Scroll Ke Bawah (Langkah 2B)
function showScrollArrow() {
    const indicator = document.getElementById('scroll-arrow-indicator');
    if (indicator) {
        indicator.classList.add('active');
    }
}
window.showScrollArrow = showScrollArrow;

function hideScrollArrow() {
    const indicator = document.getElementById('scroll-arrow-indicator');
    if (indicator) {
        indicator.classList.remove('active');
    }
}
window.hideScrollArrow = hideScrollArrow;

function scrollToCropTable() {
    const target = document.querySelector('.crop-table-container');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    }
}
window.scrollToCropTable = scrollToCropTable;

// Hilangkan panah saat user melakukan scroll secara manual atau otomatis
window.addEventListener('scroll', function () {
    if (window.activeSubStep === 'crop') {
        const target = document.querySelector('.crop-table-container');
        if (target) {
            const rect = target.getBoundingClientRect();
            // Jika bagian atas tabel sudah mulai terlihat di layar (dengan toleransi 100px)
            if (rect.top < window.innerHeight - 100) {
                hideScrollArrow();
            } else {
                showScrollArrow();
            }
        }
    }
});
