<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Dashboard Admin - SpotRent</title>
    <link rel="icon" href="/images/logo.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-admin-custom.css') }}">
</head>

<body>
    <main class="profile-page">

        <aside class="sidebar">
            <div>
                <div class="logo" onclick="window.location.href='/'">
                    <img src="/images/logo.png" alt="SpotRent Logo">
                    <span>SpotRent</span>
                </div>

                <h2 class="side-title">Profil Saya</h2>

                <nav class="menu">
                    <a href="/profile-admin" id="menu-log-aktivitas" class="menu-item active">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Log Aktivitas">
                        <span>Log Aktivitas</span>
                        @if(count($pendingProperties) > 0)
                            <span class="notification-bubble">{{ count($pendingProperties) }}</span>
                        @endif
                    </a>

                    <a href="/admin/list-properti" id="menu-list-properti" class="menu-item">
                        <img src="/images/profile/property.png" class="menu-icon" alt="List Properti">
                        <span>List Properti</span>
                    </a>

                    <a href="/admin/manage-comments" id="menu-manage-comments" class="menu-item">
                        <img src="/icons/chat_icon.svg" class="menu-icon" alt="Kelola Komentar">
                        <span>Kelola Komentar</span>
                    </a>

                    <a href="/admin/manage-users" id="menu-manage-users" class="menu-item">
                        <img src="/icons/members.svg" class="menu-icon" alt="Manajemen Pengguna">
                        <span>Manajemen Pengguna</span>
                    </a>

                    <a href="/admin/stats" id="menu-stats" class="menu-item">
                        <img src="/icons/stats_icon.svg" class="menu-icon" alt="Statistik">
                        <span>Statistik</span>
                    </a>
                </nav>
            </div>

            <div>
                <a href="/" class="home-link" style="margin-bottom: 12px;">
                    <img src="/images/profile/home.png" alt="Beranda Icon">
                    <span>Ke Beranda</span>
                </a>

                <a href="#" class="home-link" style="color: #ef4444;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/icons/logout.svg" alt="Logout Icon" style="width: 28px; height: 28px; filter: invert(34%) sepia(82%) saturate(3685%) hue-rotate(338deg) brightness(96%) contrast(96%);">
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <section class="content">
            @if(session('success'))
                <div id="flash-message-container">
                    <div class="flash-alert">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- BAGIAN 1: LOG AKTIVITAS (DASHBOARD) -->
            @include('partials.admin.log-aktivitas')

            <!-- BAGIAN 4: LIST PROPERTI -->
            @include('partials.admin.list-properti')

            <!-- BAGIAN 5: KELOLA KOMENTAR -->
            @include('partials.admin.manage-comments')

            <!-- BAGIAN 6: MANAJEMEN PENGGUNA -->
            @include('partials.admin.manage-users')

            <!-- BAGIAN 7: STATISTIK -->
            @include('partials.admin.stats-summary')
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash message banner timeout
            const flashContainer = document.getElementById('flash-message-container');
            if (flashContainer) {
                setTimeout(() => {
                    flashContainer.style.opacity = '0';
                    flashContainer.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        flashContainer.style.display = 'none';
                    }, 500);
                }, 4000);
            }

            // SPA Router setup
            const menuLogAktivitas = document.getElementById('menu-log-aktivitas');
            const menuListProperti = document.getElementById('menu-list-properti');
            const menuManageComments = document.getElementById('menu-manage-comments');
            const menuManageUsers = document.getElementById('menu-manage-users');
            const menuStats = document.getElementById('menu-stats');
            const cardPengajuanProperti = document.getElementById('card-pengajuan-properti');
            const cardRiwayatPemesanan = document.getElementById('card-riwayat-pemesanan');
            const kembaliPengajuan = document.getElementById('kembali-pengajuan');
            const kembaliRiwayat = document.getElementById('kembali-riwayat');

            const menuItems = [
                { path: '/profile-admin', sectionId: 'section-log-aktivitas', title: 'Dashboard Admin - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/pengajuan-properti', sectionId: 'section-pengajuan-properti', title: 'Pengajuan Properti - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/riwayat-pemesanan', sectionId: 'section-riwayat-pemesanan', title: 'Riwayat Pemesanan - SpotRent', menuEl: menuLogAktivitas },
                { path: '/admin/list-properti', sectionId: 'section-list-properti', title: 'List Properti - SpotRent', menuEl: menuListProperti },
                { path: '/admin/manage-comments', sectionId: 'section-manage-comments', title: 'Kelola Komentar - SpotRent', menuEl: menuManageComments },
                { path: '/admin/manage-users', sectionId: 'section-manage-users', title: 'Manajemen Pengguna - SpotRent', menuEl: menuManageUsers },
                { path: '/admin/stats', sectionId: 'section-stats', title: 'Statistik - SpotRent', menuEl: menuStats }
            ];

            function navigateTo(path, pushState = true) {
                let matched = menuItems.find(item => item.path === path);
                if (!matched) {
                    matched = menuItems[0];
                }

                // Transition sections
                menuItems.forEach(item => {
                    const sec = document.getElementById(item.sectionId);
                    if (item === matched) {
                        sec.style.display = 'block';
                        sec.offsetHeight; // force reflow
                        sec.classList.add('active');
                    } else {
                        sec.classList.remove('active');
                        sec.style.display = 'none';
                    }
                });

                // Update active states on sidebar items
                menuItems.forEach(item => {
                    if (item.menuEl) {
                        if (item.menuEl === matched.menuEl) {
                            item.menuEl.classList.add('active');
                        } else {
                            item.menuEl.classList.remove('active');
                        }
                    }
                });

                document.title = matched.title;

                if (pushState) {
                    history.pushState({ path: matched.path }, '', matched.path);
                }
            }

            // Click Handlers
            if (menuLogAktivitas) {
                menuLogAktivitas.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }
            if (menuListProperti) {
                menuListProperti.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/list-properti');
                });
            }
            if (menuManageComments) {
                menuManageComments.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/manage-comments');
                });
            }
            if (menuManageUsers) {
                menuManageUsers.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/manage-users');
                });
            }
            if (menuStats) {
                menuStats.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/stats');
                });
            }
            if (cardPengajuanProperti) {
                cardPengajuanProperti.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/pengajuan-properti');
                });
            }
            if (cardRiwayatPemesanan) {
                cardRiwayatPemesanan.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/admin/riwayat-pemesanan');
                });
            }
            if (kembaliPengajuan) {
                kembaliPengajuan.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }
            if (kembaliRiwayat) {
                kembaliRiwayat.addEventListener('click', function(e) {
                    e.preventDefault();
                    navigateTo('/profile-admin');
                });
            }

            // Custom Alert Modal Function
            function showCustomAlert(message, alertType = 'success') {
                return new Promise((resolve) => {
                    const overlay = document.createElement('div');
                    overlay.className = 'custom-modal-overlay';
                    
                    overlay.innerHTML = `
                        <div class="custom-modal-box">
                            <div class="custom-modal-icon ${alertType}">
                                ${alertType === 'success' ? '✓' : '!'}
                            </div>
                            <h3>${alertType === 'success' ? 'Sukses' : 'Gagal'}</h3>
                            <p>${message}</p>
                            <div class="custom-modal-actions" style="justify-content: center;">
                                <button class="custom-modal-btn ok-btn">OK</button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(overlay);
                    
                    setTimeout(() => {
                        overlay.classList.add('active');
                    }, 10);
                    
                    const okBtn = overlay.querySelector('.ok-btn');
                    
                    function close() {
                        overlay.classList.remove('active');
                        setTimeout(() => {
                            overlay.remove();
                        }, 300);
                    }
                    
                    okBtn.onclick = () => {
                        close();
                        resolve();
                    };
                    
                    overlay.onclick = (e) => {
                        if (e.target === overlay) {
                            close();
                            resolve();
                        }
                    };
                });
            }
            window.showCustomAlert = showCustomAlert;

            // Custom Confirmation Modal Function
            function showCustomConfirm(message, alertType = 'info') {
                return new Promise((resolve) => {
                    const overlay = document.createElement('div');
                    overlay.className = 'custom-modal-overlay';
                    
                    overlay.innerHTML = `
                        <div class="custom-modal-box">
                            <div class="custom-modal-icon ${alertType}">
                                ?
                            </div>
                            <h3>Konfirmasi</h3>
                            <p>${message}</p>
                            <div class="custom-modal-actions" style="display: flex; gap: 12px; justify-content: center;">
                                <button class="custom-modal-btn cancel-btn" style="background: #e11d48; color: #ffffff;">Batal</button>
                                <button class="custom-modal-btn ok-btn" style="background: #f7c948; color: #111111;">OK</button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(overlay);
                    
                    setTimeout(() => {
                        overlay.classList.add('active');
                    }, 10);
                    
                    const cancelBtn = overlay.querySelector('.cancel-btn');
                    const okBtn = overlay.querySelector('.ok-btn');
                    
                    function close() {
                        overlay.classList.remove('active');
                        setTimeout(() => {
                            overlay.remove();
                        }, 300);
                    }
                    
                    cancelBtn.onclick = () => {
                        close();
                        resolve(false);
                    };
                    
                    okBtn.onclick = () => {
                        close();
                        resolve(true);
                    };
                    
                    overlay.onclick = (e) => {
                        if (e.target === overlay) {
                            close();
                            resolve(false);
                        }
                    };
                });
            }
            window.showCustomConfirm = showCustomConfirm;

            // Toggle Comments Dropdown
            function toggleCommentsDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
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

            // Close dropdowns on outside click
            window.addEventListener('click', function() {
                ['rating-dropdown', 'time-dropdown', 'booking-status-dropdown', 'user-role-dropdown'].forEach(dropId => {
                    const drop = document.getElementById(dropId);
                    if (drop) drop.style.display = 'none';
                });
            });

            // Select Comments Rating
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

            // Select Comments Time sorting
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

            // Apply Comments Filters & Sorting
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
                    
                    // 1. Search filter
                    const matchesSearch = searchQuery === '' || 
                                          propName.includes(searchQuery) || 
                                          tenantName.includes(searchQuery) ||
                                          commentText.includes(searchQuery);
                                          
                    // 2. Rating filter
                    const matchesRating = ratingFilter === 'all' || rating === ratingFilter;
                    
                    if (matchesSearch && matchesRating) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // 3. Sort Cards by timestamp
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
                    
                    // Re-append sorted cards in order
                    cards.forEach(card => {
                        listContainer.appendChild(card);
                    });
                }
                
                // Handle Empty State
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

            window.confirmDeleteReview = function(reviewId) {
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
            };

            window.confirmDeleteFeedback = function(reviewId) {
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
                                    // Hide feedback container wrapper
                                    const feedbackWrapper = document.querySelector(`.feedback-container-wrapper-${reviewId}`);
                                    if (feedbackWrapper) {
                                        feedbackWrapper.style.display = 'none';
                                    }
                                    // Hide the "Hapus Tanggapan" button
                                    const btnDeleteFeedback = document.querySelector(`.btn-delete-feedback-${reviewId}`);
                                    if (btnDeleteFeedback) {
                                        btnDeleteFeedback.style.display = 'none';
                                    }
                                    
                                    // Update data attribute on the card
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
            };

            // All bookings data for detail modal
            const allBookings = @json($bookings);

            // helper functions for date formatting
            function formatDateIndo(dateObj) {
                if (!dateObj) return '';
                const date = new Date(dateObj);
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
            }

            function numberFormat(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // show booking detail in custom modal
            window.showBookingDetail = function(bookingId) {
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
            };

            // Toggle Dropdown Pemesanan
            function toggleBookingsDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
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

            // Inisialisasi Flatpickr pada Filter Rentang Tanggal
            const bookingFlatpickr = flatpickr("#filter-booking-date-range", {
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

            window.resetBookingDateFilter = function(e) {
                if (e) e.stopPropagation();
                if (bookingFlatpickr) {
                    bookingFlatpickr.clear();
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
            };

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
                    // Set filterEnd to end of day to cover same-day comparisons accurately
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

            // Toggle Dropdown Pengguna
            function toggleUsersDropdown(id, e) {
                if (e) e.stopPropagation();
                
                // Close other dropdowns
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
                    
                    // 1. Filter pencarian
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
                
                // Tangani Tampilan Kosong
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

            // Konfirmasi dan hapus pengguna via AJAX
            window.confirmDeleteUser = function(userId) {
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
                                    const card = document.getElementById(`user-card-${userId}`);
                                    if (card) {
                                        card.remove();
                                    }
                                    applyUsersFilters();
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
            };

            // Inisialisasi halaman dari URL
            const currentPath = window.location.pathname;
            navigateTo(currentPath, false);

            // Navigasi browser popstate
            window.addEventListener('popstate', function(e) {
                const path = (e.state && e.state.path) ? e.state.path : window.location.pathname;
                navigateTo(path, false);
            });
        });
    </script>
</body>

</html>
