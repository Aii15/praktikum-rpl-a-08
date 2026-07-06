// =============================================
// LOGIKA PEMESANAN & RIWAYAT PEMESANAN ADMIN
// =============================================

// Fungsi pembantu untuk memformat tanggal ke format Indonesia
function formatDateIndo(dateObj) {
    if (!dateObj) return '';
    const date = new Date(dateObj);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}
window.formatDateIndo = formatDateIndo;

// Fungsi pembantu untuk memformat angka dengan titik ribuan
function numberFormat(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
window.numberFormat = numberFormat;

// Tampilkan detail pemesanan di dalam modal kustom
function showBookingDetail(bookingId) {
    const allBookings = window.allBookings || [];
    const booking = allBookings.find(b => b.id_booking === bookingId);
    if (!booking) return;
    
    const start = new Date(booking.tanggal_mulai);
    const end = new Date(booking.tanggal_selesai);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    
    const statusLabels = {
        'pending': '<span class="status-badge-inline process">Pending</span>',
        'confirmed': '<span class="status-badge-inline success">Disetujui</span>',
        'completed': '<span class="status-badge-inline completed">Selesai</span>',
        'rejected': '<span class="status-badge-inline danger">Ditolak</span>'
    };
    const statusHtml = statusLabels[booking.status_booking] || `<span class="status-badge-inline danger">${booking.status_booking}</span>`;

    const overlay = document.createElement('div');
    overlay.className = 'custom-modal-overlay';
    
    overlay.innerHTML = `
        <div class="custom-modal-box" style="max-width: 500px; text-align: left; padding: 32px;">
            <h3 style="margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                <span>Detail Pemesanan</span>
                ${statusHtml}
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 16px; font-size: 14px; color: #4b5563;">
                <div>
                    <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Informasi Properti</strong>
                    <p style="margin: 2px 0;"><strong>Nama:</strong> ${booking.property ? booking.property.nama_properti : 'Properti tidak diketahui'}</p>
                    <p style="margin: 2px 0;"><strong>Wilayah:</strong> ${booking.property && booking.property.location ? booking.property.location.kota : '-'}</p>
                    <p style="margin: 2px 0;"><strong>Mitra Pemilik:</strong> ${booking.property && booking.property.mitra ? (booking.property.mitra.nama_mitra || booking.property.mitra.name) : '-'}</p>
                </div>
                
                <hr style="border: 0; border-top: 1px solid #f3f4f6;">
                
                <div>
                    <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Informasi Penyewa</strong>
                    <p style="margin: 2px 0;"><strong>Nama:</strong> ${booking.user ? booking.user.name : '-'}</p>
                    <p style="margin: 2px 0;"><strong>Email:</strong> ${booking.user ? booking.user.email : '-'}</p>
                    <p style="margin: 2px 0;"><strong>No. HP:</strong> ${booking.user ? (booking.user.no_hp || '-') : '-'}</p>
                </div>
                
                <hr style="border: 0; border-top: 1px solid #f3f4f6;">
                
                <div>
                    <strong style="color: #111827; display: block; margin-bottom: 4px; font-size: 15px;">Rincian Sewa & Pembayaran</strong>
                    <p style="margin: 2px 0;"><strong>Periode:</strong> ${formatDateIndo(booking.tanggal_mulai)} - ${formatDateIndo(booking.tanggal_selesai)}</p>
                    <p style="margin: 2px 0;"><strong>Durasi:</strong> ${diffDays} Hari</p>
                    <p style="margin: 2px 0; font-size: 16px; color: #d97706; font-weight: 600;"><strong>Total Pembayaran:</strong> Rp ${numberFormat(booking.total_price || 0)}</p>
                </div>
            </div>
            
            <div class="custom-modal-actions" style="margin-top: 28px; display: flex; justify-content: flex-end;">
                <button class="custom-modal-btn close-btn" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; max-width: 100px;">Tutup</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    setTimeout(() => {
        overlay.classList.add('active');
    }, 10);
    
    const closeBtn = overlay.querySelector('.close-btn');
    
    function close() {
        overlay.classList.remove('active');
        setTimeout(() => {
            overlay.remove();
        }, 300);
    }
    
    closeBtn.onclick = close;
    overlay.onclick = (e) => {
        if (e.target === overlay) close();
    };
}
window.showBookingDetail = showBookingDetail;

// Beralih tampilan dropdown pemesanan
function toggleBookingsDropdown(id, e) {
    if (e) e.stopPropagation();
    
    // Tutup dropdown lainnya terlebih dahulu
    ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown'].forEach(dropId => {
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
window.toggleBookingsDropdown = toggleBookingsDropdown;

// Pilih Filter Status Pemesanan
function selectBookingStatusFilter(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-booking-status-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('booking-status-display');
    if (display) {
        if (val === 'all') {
            display.innerHTML = 'Semua Status';
        } else if (val === 'pending') {
            display.innerHTML = `<span class="status-badge-inline process">${label}</span>`;
        } else if (val === 'confirmed') {
            display.innerHTML = `<span class="status-badge-inline success">${label}</span>`;
        } else {
            display.innerHTML = `<span class="status-badge-inline danger">${label}</span>`;
        }
    }
    
    const dropdown = document.getElementById('booking-status-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyBookingsFilters();
}
window.selectBookingStatusFilter = selectBookingStatusFilter;

// Reset filter rentang tanggal pemesanan
function resetBookingDateFilter(e) {
    if (e) e.stopPropagation();
    if (window.bookingFlatpickr) {
        window.bookingFlatpickr.clear();
    }
    const display = document.getElementById('booking-date-display');
    if (display) {
        display.innerHTML = "Semua Tanggal";
    }
    const resetBtn = document.getElementById('btn-reset-booking-date');
    if (resetBtn) {
        resetBtn.style.display = 'none';
    }
    applyBookingsFilters();
}
window.resetBookingDateFilter = resetBookingDateFilter;

// Terapkan Filter Pemesanan
function applyBookingsFilters() {
    const searchInputEl = document.getElementById('filter-bookings-search-input');
    const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
    
    const statusInputEl = document.getElementById('filter-booking-status-value');
    const statusFilter = statusInputEl ? statusInputEl.value : 'all';
    
    const dateInputEl = document.getElementById('filter-booking-date-range');
    const dateRangeStr = dateInputEl ? dateInputEl.value : '';
    
    let filterStart = null;
    let filterEnd = null;
    if (dateRangeStr.includes(' to ')) {
        const parts = dateRangeStr.split(' to ');
        filterStart = new Date(parts[0]);
        filterEnd = new Date(parts[1]);
        filterEnd.setHours(23, 59, 59, 999);
    } else if (dateRangeStr !== '') {
        filterStart = new Date(dateRangeStr);
        filterEnd = new Date(dateRangeStr);
        filterEnd.setHours(23, 59, 59, 999);
    }
    
    const listContainer = document.querySelector('#section-riwayat-pemesanan .item-list');
    if (!listContainer) return;
    
    const cards = Array.from(listContainer.querySelectorAll('.booking-card-item'));
    let visibleCount = 0;
    
    cards.forEach(card => {
        const propName = card.getAttribute('data-property-name') || '';
        const tenantName = card.getAttribute('data-tenant-name') || '';
        const startDateStr = card.getAttribute('data-start-date') || '';
        const endDateStr = card.getAttribute('data-end-date') || '';
        const status = card.getAttribute('data-status') || '';
        
        // 1. Filter pencarian
        const matchesSearch = searchQuery === '' || 
                              propName.includes(searchQuery) || 
                              tenantName.includes(searchQuery);
                              
        // 2. Filter status
        let matchesStatus = false;
        if (statusFilter === 'all') {
            matchesStatus = true;
        } else if (statusFilter === 'pending') {
            matchesStatus = (status === 'pending');
        } else if (statusFilter === 'confirmed') {
            matchesStatus = (status === 'confirmed' || status === 'completed');
        } else if (statusFilter === 'rejected') {
            matchesStatus = (status !== 'pending' && status !== 'confirmed' && status !== 'completed');
        }
        
        // 3. Filter rentang tanggal
        let matchesDate = true;
        if (filterStart && filterEnd) {
            const cardStart = new Date(startDateStr);
            const cardEnd = new Date(endDateStr);
            matchesDate = (cardStart <= filterEnd && cardEnd >= filterStart);
        }
        
        if (matchesSearch && matchesStatus && matchesDate) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Tangani Tampilan Kosong
    let emptyMessage = document.getElementById('empty-bookings-filter-message');
    if (visibleCount === 0) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('div');
            emptyMessage.id = 'empty-bookings-filter-message';
            emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
            emptyMessage.textContent = "Tidak ada riwayat pemesanan yang cocok dengan filter.";
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
window.applyBookingsFilters = applyBookingsFilters;

// Inisialisasi Flatpickr setelah DOM dimuat
document.addEventListener('DOMContentLoaded', function() {
    const flatpickrInput = document.getElementById('filter-booking-date-range');
    if (flatpickrInput && typeof flatpickr === 'function') {
        window.bookingFlatpickr = flatpickr("#filter-booking-date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: "id",
            onChange: function(selectedDates, dateStr, instance) {
                const display = document.getElementById('booking-date-display');
                const resetBtn = document.getElementById('btn-reset-booking-date');
                if (selectedDates.length === 2) {
                    const startStr = formatDateIndo(selectedDates[0]);
                    const endStr = formatDateIndo(selectedDates[1]);
                    display.innerHTML = `${startStr} - ${endStr}`;
                    if (resetBtn) resetBtn.style.display = 'inline-block';
                } else if (selectedDates.length === 1) {
                    display.innerHTML = formatDateIndo(selectedDates[0]);
                    if (resetBtn) resetBtn.style.display = 'inline-block';
                } else {
                    display.innerHTML = "Semua Tanggal";
                    if (resetBtn) resetBtn.style.display = 'none';
                }
                applyBookingsFilters();
            }
        });
    }
});
