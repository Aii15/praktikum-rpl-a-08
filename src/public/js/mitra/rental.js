// =============================================
// LOGIKA RIWAYAT & DETAIL PENYEWAAN MITRA
// =============================================

function showRentalDetail(event, id, shouldPushState = true) {
    if (event) event.preventDefault();
    
    const loader = document.getElementById('detailLoading');
    const body = document.getElementById('detailBody');
    
    if (loader) loader.style.display = 'flex';
    if (body) body.style.display = 'none';

    if (shouldPushState) {
        navigateTo(`/detail-riwayat-penyewaan/${id}`);
        return;
    }
    
    fetch(`/detail-riwayat-penyewaan/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && body && loader) {
            const booking = data.booking;
            
            document.getElementById('detailBanner').src = booking.cover_photo;
            document.getElementById('detailBanner').style.objectPosition = `center ${booking.cover_photo_position || '50'}%`;
            document.getElementById('detailPropertyName').textContent = booking.nama_properti;
            
            document.getElementById('detailPenyewa').textContent = booking.penyewa;
            document.getElementById('detailEmailPenyewa').textContent = booking.email_penyewa;
            document.getElementById('detailNoHpPenyewa').textContent = booking.no_hp_penyewa;
            document.getElementById('detailRentangSewa').textContent = booking.rentang_sewa;
            document.getElementById('detailTotalPrice').textContent = booking.total_price_formatted;

            const statusBadge = document.getElementById('detailStatusBadge');
            statusBadge.textContent = booking.status_text;
            if (booking.status_booking === 'pending') {
                statusBadge.className = 'booking-status process';
            } else if (booking.status_booking === 'confirmed') {
                statusBadge.className = 'booking-status success';
            } else if (booking.status_booking === 'completed') {
                statusBadge.className = 'booking-status completed';
            } else {
                statusBadge.className = 'booking-status danger';
            }
            
            window.currentViewingBookingId = booking.id_booking;
            const actionButtons = document.getElementById('bookingActionButtons');
            if (actionButtons) {
                if (booking.status_booking === 'pending') {
                    actionButtons.style.display = 'flex';
                } else {
                    actionButtons.style.display = 'none';
                }
            }
            
            // Tangani Bagian Ulasan & Tanggapan
            const reviewSection = document.getElementById('detailReviewSection');
            const tenantReviewContainer = document.getElementById('tenantReviewContainer');
            const feedbackForm = document.getElementById('feedbackForm');
            const existingFeedback = document.getElementById('existingFeedback');
            
            if (booking.review) {
                reviewSection.style.display = 'block';
                tenantReviewContainer.style.display = 'block';
                
                // Tampilkan bintang ulasan
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= booking.review.rating) {
                        starsHtml += '★';
                    } else {
                        starsHtml += '☆';
                    }
                }
                document.getElementById('displayReviewStars').textContent = starsHtml;
                document.getElementById('displayReviewDate').textContent = booking.review.tanggal_review;
                document.getElementById('displayReviewText').textContent = booking.review.komentar || 'Tidak ada komentar tertulis.';
                
                window.currentReviewId = booking.review.id_review;
                
                if (booking.review.balasan_mitra) {
                    feedbackForm.style.display = 'none';
                    existingFeedback.style.display = 'block';
                    
                    document.getElementById('displayFeedbackAuthor').textContent = 'Anda (Pemilik Properti)';
                    document.getElementById('displayFeedbackDate').textContent = booking.review.tanggal_balasan;
                    document.getElementById('displayFeedbackText').textContent = booking.review.balasan_mitra;
                } else {
                    feedbackForm.style.display = 'block';
                    existingFeedback.style.display = 'none';
                    document.getElementById('feedbackText').value = '';
                }
            } else {
                reviewSection.style.display = 'none';
                tenantReviewContainer.style.display = 'none';
                window.currentReviewId = null;
            }
            
            loader.style.display = 'none';
            body.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error fetching rental details:', error);
        if (loader) {
            loader.innerHTML = '<p style="color: #dc3545; font-size: 14px; font-weight: 500;">Gagal memuat detail penyewaan. Silakan coba lagi.</p>';
        }
    });
}
window.showRentalDetail = showRentalDetail;

function submitFeedback(event) {
    event.preventDefault();
    const text = document.getElementById('feedbackText').value;

    if (!text.trim()) {
        showCustomAlert('Silakan tulis tanggapan terlebih dahulu.', 'danger');
        return;
    }

    const reviewId = window.currentReviewId;
    if (!reviewId) {
        showCustomAlert('ID ulasan tidak ditemukan.', 'danger');
        return;
    }

    fetch(`/mitra/review/${reviewId}/feedback`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            balasan_mitra: text
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCustomAlert(data.message, 'success').then(() => {
                showRentalDetail(null, window.currentViewingBookingId, false);
            });
        } else {
            showCustomAlert(data.message || 'Gagal mengirim tanggapan.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error submitting feedback:', error);
        showCustomAlert('Terjadi kesalahan saat mengirim tanggapan.', 'danger');
    });
}
window.submitFeedback = submitFeedback;

async function updateBookingStatus(status) {
    const bookingId = window.currentViewingBookingId;
    if (!bookingId) return;

    const confirmMsg = status === 'confirmed' 
        ? 'Apakah Anda yakin ingin menyetujui penyewaan ini?' 
        : 'Apakah Anda yakin ingin menolak penyewaan ini?';

    const actionType = status === 'confirmed' ? 'success' : 'danger';
    const confirmed = await showCustomConfirm(confirmMsg, actionType);
    if (!confirmed) return;

    const actionButtons = document.getElementById('bookingActionButtons');
    const statusBadge = document.getElementById('detailStatusBadge');
    
    if (actionButtons) actionButtons.style.opacity = '0.5';

    fetch(`/detail-riwayat-penyewaan/${bookingId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(async data => {
        if (actionButtons) actionButtons.style.opacity = '1';
        
        if (data.success) {
            if (actionButtons) actionButtons.style.display = 'none';
            
            if (statusBadge) {
                statusBadge.textContent = data.booking.status_text;
                if (status === 'confirmed') {
                    statusBadge.className = 'booking-status success';
                } else {
                    statusBadge.className = 'booking-status danger';
                }
            }
            
            const card = document.querySelector(`.booking-card[href*="/detail-riwayat-penyewaan/${bookingId}"]`);
            if (card) {
                card.setAttribute('data-status', status);
                const cardStatusDiv = card.querySelector('.status');
                if (cardStatusDiv) {
                    if (status === 'confirmed') {
                        cardStatusDiv.className = 'status success';
                        cardStatusDiv.textContent = 'Disetujui';
                    } else {
                        cardStatusDiv.className = 'status danger';
                        cardStatusDiv.textContent = 'Ditolak';
                    }
                }
            }

            // Perbarui bubble notifikasi sidebar secara dinamis
            const bubble = document.querySelector('#menu-riwayat-penyewaan .notification-bubble');
            if (bubble) {
                let count = parseInt(bubble.textContent.trim()) || 0;
                count = Math.max(0, count - 1);
                if (count > 0) {
                    bubble.textContent = count;
                } else {
                    bubble.remove();
                }
            }
            
            await showCustomAlert(data.message, 'success');
        } else {
            await showCustomAlert(data.message || 'Gagal memperbarui status.', 'info');
        }
    })
    .catch(async error => {
        if (actionButtons) actionButtons.style.opacity = '1';
        console.error('Error updating booking status:', error);
        await showCustomAlert('Terjadi kesalahan saat memproses permintaan.', 'info');
    });
}
window.updateBookingStatus = updateBookingStatus;

// Terapkan semua filter dan pengurutan pada Riwayat Penyewaan Mitra
function applyAllFilters() {
    const searchInputEl = document.getElementById('filter-search-input');
    const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
    
    const statusInputEl = document.getElementById('filter-status-value');
    const statusFilter = statusInputEl ? statusInputEl.value : 'all';
    
    const sortInputEl = document.getElementById('filter-sort-value');
    const sortBy = sortInputEl ? sortInputEl.value : 'date_desc';
    
    const bookingListContainer = document.querySelector('.booking-list');
    if (!bookingListContainer) return;
    
    const cards = Array.from(bookingListContainer.querySelectorAll('.booking-card'));
    let visibleCount = 0;
    
    cards.forEach(card => {
        const propName = card.getAttribute('data-property-name') || '';
        const tenantName = card.getAttribute('data-tenant-name') || '';
        const status = card.getAttribute('data-status') || '';
        
        // 1. Periksa Query Pencarian
        const matchesSearch = searchQuery === '' || 
                              propName.includes(searchQuery) || 
                              tenantName.includes(searchQuery);
                              
        // 2. Periksa Filter Status
        let matchesStatus = false;
        if (statusFilter === 'all') {
            matchesStatus = true;
        } else if (statusFilter === 'pending') {
            matchesStatus = (status === 'pending');
        } else if (statusFilter === 'confirmed') {
            matchesStatus = (status === 'confirmed');
        } else if (statusFilter === 'completed') {
            matchesStatus = (status === 'completed');
        } else if (statusFilter === 'rejected') {
            matchesStatus = (status !== 'pending' && status !== 'confirmed' && status !== 'completed');
        }
        
        if (matchesSearch && matchesStatus) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Tangani Tampilan Riwayat Kosong
    let emptyMessage = document.getElementById('empty-bookings-message');
    if (visibleCount === 0) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('div');
            emptyMessage.id = 'empty-bookings-message';
            emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
            emptyMessage.textContent = "Tidak ada riwayat penyewaan yang cocok dengan filter.";
            bookingListContainer.appendChild(emptyMessage);
        } else {
            emptyMessage.style.display = 'block';
        }
    } else {
        if (emptyMessage) {
            emptyMessage.style.display = 'none';
        }
    }
    
    // 3. Urutkan Kartu
    if (visibleCount > 1) {
        cards.sort((a, b) => {
            const statusA = a.getAttribute('data-status') || '';
            const statusB = b.getAttribute('data-status') || '';

            // Jika filter status adalah "semua", prioritaskan status pending di paling atas
            if (statusFilter === 'all') {
                if (statusA === 'pending' && statusB !== 'pending') return -1;
                if (statusA !== 'pending' && statusB === 'pending') return 1;
            }

            if (sortBy === 'date_desc') {
                const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
                const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
                return valB - valA;
            } else if (sortBy === 'date_asc') {
                const valA = parseInt(a.getAttribute('data-timestamp')) || 0;
                const valB = parseInt(b.getAttribute('data-timestamp')) || 0;
                return valA - valB;
            } else if (sortBy === 'price_desc') {
                const valA = parseFloat(a.getAttribute('data-price')) || 0;
                const valB = parseFloat(b.getAttribute('data-price')) || 0;
                return valB - valA;
            } else if (sortBy === 'price_asc') {
                const valA = parseFloat(a.getAttribute('data-price')) || 0;
                const valB = parseFloat(b.getAttribute('data-price')) || 0;
                return valA - valB;
            }
            return 0;
        });
        
        // Lampirkan kembali kartu yang telah diurutkan sesuai urutan
        cards.forEach(card => {
            bookingListContainer.appendChild(card);
        });
    }
}
window.applyAllFilters = applyAllFilters;

// Beralih tampilan dropdown kustom Filter dan Urutkan
function toggleFilterDropdown(id, e) {
    if (e) e.stopPropagation();
    
    // Tutup dropdown lain terlebih dahulu
    ['status-dropdown', 'sort-dropdown', 'kategori-dropdown', 'fasilitas-dropdown'].forEach(dropId => {
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
window.toggleFilterDropdown = toggleFilterDropdown;

// Pilih Filter Status
function selectFilterStatus(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-status-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('status-display');
    if (display) {
        if (val === 'all') {
            display.innerHTML = 'Semua Status';
        } else {
            let badgeClass = 'process';
            if (val === 'confirmed') badgeClass = 'success';
            if (val === 'completed') badgeClass = 'completed';
            if (val === 'rejected') badgeClass = 'danger';
            
            display.innerHTML = `<span class="status-badge-inline ${badgeClass}">${label}</span>`;
        }
    }
    
    const dropdown = document.getElementById('status-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyAllFilters();
}
window.selectFilterStatus = selectFilterStatus;

// Pilih Filter Pengurutan
function selectFilterSort(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-sort-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('sort-display');
    if (display) display.textContent = label;
    
    const dropdown = document.getElementById('sort-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyAllFilters();
}
window.selectFilterSort = selectFilterSort;
