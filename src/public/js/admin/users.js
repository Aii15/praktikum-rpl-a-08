// =============================================
// LOGIKA MANAJEMEN AKUN PENGGUNA (USER) ADMIN
// =============================================

// Beralih tampilan dropdown peran pengguna
function toggleUsersDropdown(id, e) {
    if (e) e.stopPropagation();
    
    // Tutup dropdown lainnya terlebih dahulu
    ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown', 'user-role-dropdown'].forEach(dropId => {
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
window.toggleUsersDropdown = toggleUsersDropdown;

// Pilih Filter Peran Pengguna
function selectUserRoleFilter(val, label, e) {
    if (e) e.stopPropagation();
    const valInput = document.getElementById('filter-user-role-value');
    if (valInput) valInput.value = val;
    
    const display = document.getElementById('user-role-display');
    if (display) {
        if (val === 'all') {
            display.innerHTML = 'Semua Peran';
        } else if (val === 'admin') {
            display.innerHTML = `<span class="status-badge-inline success" style="background: #dcfce7; color: #15803d;">${label}</span>`;
        } else if (val === 'mitra') {
            display.innerHTML = `<span class="status-badge-inline process" style="background: #fef3c7; color: #b45309;">${label}</span>`;
        } else {
            display.innerHTML = `<span class="status-badge-inline completed" style="background: #e0f2fe; color: #0369a1;">${label}</span>`;
        }
    }
    
    const dropdown = document.getElementById('user-role-dropdown');
    if (dropdown) dropdown.style.display = 'none';
    applyUsersFilters();
}
window.selectUserRoleFilter = selectUserRoleFilter;

// Terapkan Filter Pengguna
function applyUsersFilters() {
    const searchInputEl = document.getElementById('filter-users-search-input');
    const searchQuery = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
    
    const roleInputEl = document.getElementById('filter-user-role-value');
    const roleFilter = roleInputEl ? roleInputEl.value : 'all';
    
    const listContainer = document.querySelector('#section-manage-users .item-list');
    if (!listContainer) return;
    
    const cards = Array.from(listContainer.querySelectorAll('.user-card-item'));
    let visibleCount = 0;
    
    cards.forEach(card => {
        const userName = card.getAttribute('data-user-name') || '';
        const userEmail = card.getAttribute('data-user-email') || '';
        const userPhone = card.getAttribute('data-user-phone') || '';
        const userRole = card.getAttribute('data-user-role') || '';
        
        // 1. Filter pencarian (berdasarkan nama, email, atau no handphone)
        const matchesSearch = searchQuery === '' || 
                              userName.includes(searchQuery) || 
                              userEmail.includes(searchQuery) ||
                              userPhone.includes(searchQuery);
                              
        // 2. Filter peran
        const matchesRole = roleFilter === 'all' || userRole === roleFilter;
        
        if (matchesSearch && matchesRole) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Tangani Tampilan Kosong jika tidak ada hasil
    let emptyMessage = document.getElementById('empty-users-filter-message');
    if (visibleCount === 0) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('div');
            emptyMessage.id = 'empty-users-filter-message';
            emptyMessage.style.cssText = "text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;";
            emptyMessage.textContent = "Tidak ada pengguna yang cocok dengan filter.";
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
window.applyUsersFilters = applyUsersFilters;

// Konfirmasi dan hapus akun pengguna via AJAX
function confirmDeleteUser(userId) {
    showCustomConfirm('Apakah Anda yakin ingin menghapus pengguna ini beserta seluruh data terkait (properti, pemesanan, dll) secara permanen?', 'danger').then(confirmed => {
        if (confirmed) {
            fetch(`/admin/user/${userId}`, {
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
                        window.location.reload();
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal menghapus pengguna.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Terjadi kesalahan saat menghubungi server.', 'danger');
            });
        }
    });
}
window.confirmDeleteUser = confirmDeleteUser;
