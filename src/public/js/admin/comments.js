// =============================================
// LOGIKA MANAJEMEN KOMENTAR & ULASAN ADMIN
// =============================================

// Beralih tampilan dropdown kustom Filter dan Urutkan untuk Komentar
function toggleCommentsDropdown(id, e) {
    if (e) e.stopPropagation();
    
    // Tutup dropdown lainnya terlebih dahulu
    ['rating-dropdown', 'time-dropdown'].forEach(dropId => {
        if (dropId !== id) {
            const drop = document.getElementById(dropId);
            if (drop) drop.style.display = 'none';
        }
    });
    
    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}
window.toggleCommentsDropdown = toggleCommentsDropdown;

// Pilih Filter Rating Komentar
function selectCommentsRating(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-rating-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('rating-display');
    if (display) {
        if (val === 'all') {
            display.innerHTML = 'Semua Rating';
        } else {
            display.innerHTML = `<span class="status-badge-inline process" style="background: #fef9c3; color: #a16207;">${label}</span>`;
        }
    }
    
    const dropdown = document.getElementById('rating-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyCommentsFilters();
}
window.selectCommentsRating = selectCommentsRating;

// Pilih Urutan Waktu Komentar
function selectCommentsTime(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-time-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('time-display');
    if (display) {
        display.innerHTML = label;
    }
    
    const dropdown = document.getElementById('time-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyCommentsFilters();
}
window.selectCommentsTime = selectCommentsTime;

// Terapkan Filter & Pengurutan Komentar
function applyCommentsFilters() {
    const searchInputEl = document.getElementById('filter-comments-search-input');
    const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
    
    const ratingInputEl = document.getElementById('filter-rating-value');
    const ratingFilter = ratingInputEl ? ratingInputEl.value : 'all';
    
    const timeInputEl = document.getElementById('filter-time-value');
    const timeFilter = timeInputEl ? timeInputEl.value : 'newest';
    
    const listContainer = document.querySelector('#section-manage-comments .item-list');
    if (!listContainer) return;
    
    const cards = Array.from(listContainer.querySelectorAll('.review-card-item'));
    let visibleCount = 0;
    
    cards.forEach(card => {
        const propName = card.getAttribute('data-property-name') || '';
        const tenantName = card.getAttribute('data-tenant-name') || '';
        const commentText = card.getAttribute('data-comment-text') || '';
        const rating = card.getAttribute('data-rating') || '';
        
        // 1. Filter pencarian
        const matchesSearch = searchQuery === '' || 
                              propName.includes(searchQuery) || 
                              tenantName.includes(searchQuery) ||
                              commentText.includes(searchQuery);
                              
        // 2. Filter rating
        const matchesRating = ratingFilter === 'all' || rating === ratingFilter;
        
        if (matchesSearch && matchesRating) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // 3. Urutkan kartu ulasan berdasarkan timestamp
    if (visibleCount > 1) {
        cards.sort((a, b) => {
            const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
            const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
            
            if (timeFilter === 'newest') {
                return valB - valA;
            } else {
                return valA - valB;
            }
        });
        
        // Lampirkan kembali kartu yang telah diurutkan sesuai urutan
        cards.forEach(card => {
            listContainer.appendChild(card);
        });
    }
    
    // Tangani Tampilan Kosong jika tidak ada hasil
    let emptyMessage = document.getElementById('empty-comments-message');
    if (visibleCount === 0) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('div');
            emptyMessage.id = 'empty-comments-message';
            emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
            emptyMessage.textContent = "Tidak ada komentar ulasan yang cocok dengan filter.";
            listContainer.appendChild(emptyMessage);
        } else {
            emptyMessage.style.display = 'block';
        }
    } else {
        if (emptyMessage) {
            emptyMessage.style.display = 'none';
        }
    }
}
window.applyCommentsFilters = applyCommentsFilters;

// Konfirmasi dan hapus ulasan via AJAX
function confirmDeleteReview(reviewId) {
    showCustomConfirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?', 'info').then(confirmed => {
        if (confirmed) {
            fetch(`/admin/review/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        const card = document.getElementById(`review-card-${reviewId}`);
                        if (card) {
                            card.remove();
                        }
                        applyCommentsFilters();
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal menghapus ulasan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
            });
        }
    });
}
window.confirmDeleteReview = confirmDeleteReview;

// Konfirmasi dan hapus tanggapan Mitra via AJAX
function confirmDeleteFeedback(reviewId) {
    showCustomConfirm('Apakah Anda yakin ingin menghapus tanggapan Mitra ini?', 'info').then(confirmed => {
        if (confirmed) {
            fetch(`/admin/review/${reviewId}/delete-feedback`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        // Sembunyikan pembungkus kontainer tanggapan
                        const feedbackWrapper = document.querySelector(`.feedback-container-wrapper-${reviewId}`);
                        if (feedbackWrapper) {
                            feedbackWrapper.style.display = 'none';
                        }
                        // Sembunyikan tombol "Hapus Tanggapan"
                        const btnDeleteFeedback = document.querySelector(`.btn-delete-feedback-${reviewId}`);
                        if (btnDeleteFeedback) {
                            btnDeleteFeedback.style.display = 'none';
                        }
                        
                        // Perbarui atribut data pada kartu untuk menandakan tidak ada tanggapan
                        const card = document.getElementById(`review-card-${reviewId}`);
                        if (card) {
                            card.setAttribute('data-has-feedback', 'false');
                        }
                        applyCommentsFilters();
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal menghapus tanggapan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
            });
        }
    });
}
window.confirmDeleteFeedback = confirmDeleteFeedback;
