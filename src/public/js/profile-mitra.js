// ID booking global yang diteruskan dari server untuk pemuatan langsung
        

        function navigateTo(path, pushState = true) {
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatPenyewaan = document.getElementById('menu-riwayat-penyewaan');
            const menuPropertiSaya = document.getElementById('menu-properti-saya');
            const menuTambahProperti = document.getElementById('menu-tambah-properti');
            const menuStatusPengajuan = document.getElementById('menu-status-pengajuan');

            const menuItems = [
                { path: '/profile-mitra', sectionId: 'section-tentang-saya', title: 'Profile Mitra - SpotRent', el: menuTentangSaya },
                { path: '/riwayat-penyewaan', sectionId: 'section-riwayat-penyewaan', title: 'Riwayat Penyewaan - SpotRent', el: menuRiwayatPenyewaan },
                { path: '/properti-saya', sectionId: 'section-properti-saya', title: 'Properti Saya - SpotRent', el: menuPropertiSaya },
                { path: '/tambah-properti', sectionId: 'section-tambah-properti', title: 'Tambah Properti - SpotRent', el: menuTambahProperti },
                { path: '/status-pengajuan', sectionId: 'section-status-pengajuan', title: 'Status Pengajuan - SpotRent', el: menuStatusPengajuan },
                { path: '/detail-riwayat-penyewaan', sectionId: 'section-detail-penyewaan', title: 'Detail Penyewaan - SpotRent', el: menuRiwayatPenyewaan }
            ];

            let isDetail = path.match(/^\/detail-riwayat-penyewaan\/(\d+)$/);
            let matchedPath = isDetail ? '/detail-riwayat-penyewaan' : path;

            // Cari rute yang cocok
            let matched = menuItems.find(item => item.path === matchedPath);
            if (!matched) {
                // fallback to profile
                matched = menuItems[0];
            }

            // Tampilkan section yang cocok, sembunyikan yang lain
            menuItems.forEach(item => {
                const sec = document.getElementById(item.sectionId);
                if (sec) {
                    if (item === matched) {
                        sec.style.display = 'block';
                        sec.offsetHeight; // picu reflow browser
                        sec.classList.add('active');
                        if (item.el) item.el.classList.add('active');
                    } else {
                        sec.classList.remove('active');
                        sec.style.display = 'none';
                        if (item.el && item.el !== matched.el) {
                            item.el.classList.remove('active');
                        }
                    }
                }
            });

            document.title = matched.title;

            if (pushState) {
                history.pushState({ path: path }, '', path);
            }

            if (isDetail) {
                const id = isDetail[1];
                showRentalDetail(null, id, false);
            }

            // Pulihkan sidebar setiap kali halaman berubah di router
            const profilePage = document.querySelector('.profile-page');
            if (profilePage) {
                profilePage.classList.remove('sidebar-collapsed');
            }
            const btnBackCropTop = document.getElementById('btn-back-crop-top');
            if (btnBackCropTop) {
                btnBackCropTop.style.display = 'none';
            }
        }
        window.navigateTo = navigateTo;

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

        async function confirmDeleteProperty(propertyId) {
            const confirmed = await showCustomConfirm('Apakah Anda yakin ingin menghapus properti ini?', 'danger');
            if (confirmed) {
                document.getElementById(`delete-form-${propertyId}`).submit();
            }
        }
        window.confirmDeleteProperty = confirmDeleteProperty;

        document.addEventListener('DOMContentLoaded', function() {
            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatPenyewaan = document.getElementById('menu-riwayat-penyewaan');
            const menuPropertiSaya = document.getElementById('menu-properti-saya');
            const menuTambahProperti = document.getElementById('menu-tambah-properti');
            const menuStatusPengajuan = document.getElementById('menu-status-pengajuan');

            const routes = [
                { path: '/profile-mitra', sectionId: 'section-tentang-saya', title: 'Profile Mitra - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-penyewaan', sectionId: 'section-riwayat-penyewaan', title: 'Riwayat Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan },
                { path: '/properti-saya', sectionId: 'section-properti-saya', title: 'Properti Saya - SpotRent', menuEl: menuPropertiSaya },
                { path: '/tambah-properti', sectionId: 'section-tambah-properti', title: 'Tambah Properti - SpotRent', menuEl: menuTambahProperti },
                { path: '/status-pengajuan', sectionId: 'section-status-pengajuan', title: 'Status Pengajuan - SpotRent', menuEl: menuStatusPengajuan },
                { path: '/detail-riwayat-penyewaan', regex: /^\/detail-riwayat-penyewaan\/(\d+)$/, sectionId: 'section-detail-penyewaan', title: 'Detail Penyewaan - SpotRent', menuEl: menuRiwayatPenyewaan }
            ];

            SPARouter.init(routes, routes[0], (path, matched, params) => {
                if (matched.path === '/detail-riwayat-penyewaan' || matched.regex) {
                    const id = params ? params[0] : path.match(/^\/detail-riwayat-penyewaan\/(\d+)$/)[1];
                    showRentalDetail(null, id, false);
                }
                
                // Restore sidebar whenever page changes in router
                const profilePage = document.querySelector('.profile-page');
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            });

            // Ikat event klik pada menu
            const menuItems = [
                { el: menuTentangSaya, path: '/profile-mitra' },
                { el: menuRiwayatPenyewaan, path: '/riwayat-penyewaan' },
                { el: menuPropertiSaya, path: '/properti-saya' },
                { el: menuTambahProperti, path: '/tambah-properti' },
                { el: menuStatusPengajuan, path: '/status-pengajuan' }
            ];

            menuItems.forEach(item => {
                if (item.el) {
                    item.el.addEventListener('click', function(e) {
                        e.preventDefault();
                        navigateTo(item.path);
                    });
                }
            });

            // Pemeriksaan pemuatan awal halaman
            const currentPath = window.location.pathname;
            if (window.activeBookingId) {
                navigateTo(`/detail-riwayat-penyewaan/${window.activeBookingId}`, false);
            } else {
                navigateTo(currentPath, false);
            }

            // Picu pemeriksaan saat memuat jika nilai lama ada (untuk dropdown fasilitas)
            updateFasilitasSelection();

            // Pra-seleksi kategori lama
            const oldKategoriVal = document.getElementById('kategori-value')?.value;
            if (oldKategoriVal) {
                const matchedRow = document.querySelector(`.category-item-row[data-id="${oldKategoriVal}"]`);
                if (matchedRow) {
                    const name = matchedRow.getAttribute('data-name');
                    const iconUrl = matchedRow.getAttribute('data-icon');
                    selectKategori(oldKategoriVal, name, iconUrl);
                }
            }

            // Terapkan filter riwayat sewa dan pengurutan saat dimuat
            applyAllFilters();
        });

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

        // Beralih tampilan daftar kategori
        function toggleKategoriDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('kategori-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Pilih kategori
        function selectKategori(id, name, iconUrl, e) {
            if (e) e.stopPropagation();
            const valueInput = document.getElementById('kategori-value');
            if (valueInput) {
                valueInput.value = id;
                valueInput.dispatchEvent(new Event('input'));
                
                const card = valueInput.closest('.field-card');
                if (card) {
                    card.style.borderColor = 'transparent';
                    card.style.boxShadow = '';
                }
            }

            const displayContainer = document.getElementById('kategori-display');
            if (displayContainer) {
                displayContainer.innerHTML = '';
                
                const badge = document.createElement('div');
                badge.className = 'selected-badge';
                
                const icon = document.createElement('img');
                icon.src = iconUrl;
                
                const label = document.createElement('span');
                label.textContent = name;
                
                badge.appendChild(icon);
                badge.appendChild(label);
                displayContainer.appendChild(badge);
            }

            const dropdown = document.getElementById('kategori-dropdown');
            if (dropdown) dropdown.style.display = 'none';
        }

        // Beralih tampilan daftar fasilitas
        function toggleFasilitasDropdown(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('fasilitas-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Perbarui tampilan teks fasilitas dan input tersembunyi
        function updateFasilitasSelection() {
            const checkboxes = document.querySelectorAll('.facility-checkbox');
            const selectedNames = [];
            const displayContainer = document.getElementById('fasilitas-display');
            if (!displayContainer) return;
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
            
            const valueInput = document.getElementById('fasilitas-value');
            if (valueInput) valueInput.value = selectedNames.join(', ');
            
            if (selectedNames.length === 0) {
                displayContainer.innerHTML = '<span style="font-size: 15px; font-weight: 500; color: #777;">Pilih Fasilitas</span>';
            }
        }

        // Tutup dropdown jika mengklik di luar area
        document.addEventListener('click', function(e) {
            const container = document.getElementById('fasilitas-dropdown-container');
            const dropdown = document.getElementById('fasilitas-dropdown');
            if (container && !container.contains(e.target)) {
                if (dropdown) dropdown.style.display = 'none';
            }

            const catContainer = document.getElementById('kategori-dropdown-container');
            const catDropdown = document.getElementById('kategori-dropdown');
            if (catContainer && !catContainer.contains(e.target)) {
                if (catDropdown) catDropdown.style.display = 'none';
            }

            const statusContainer = document.getElementById('status-dropdown-container');
            const statusDropdown = document.getElementById('status-dropdown');
            if (statusContainer && !statusContainer.contains(e.target)) {
                if (statusDropdown) statusDropdown.style.display = 'none';
            }

            const sortContainer = document.getElementById('sort-dropdown-container');
            const sortDropdown = document.getElementById('sort-dropdown');
            if (sortContainer && !sortContainer.contains(e.target)) {
                if (sortDropdown) sortDropdown.style.display = 'none';
            }
        });

        // Logika pemformatan harga (pemformatan Rupiah Indonesia)
        const displayInput = document.getElementById('harga_display');
        const hiddenInput = document.getElementById('harga_per_hari');

        function formatRupiah(value) {
            let number = value.replace(/[^0-9]/g, '');
            if (number === '') return '';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        if (displayInput) {
            displayInput.addEventListener('input', function(e) {
                let rawVal = this.value.replace(/[^0-9]/g, '');
                this.value = formatRupiah(this.value);
                if (hiddenInput) hiddenInput.value = rawVal;
            });

            if (hiddenInput && hiddenInput.value) {
                displayInput.value = formatRupiah(hiddenInput.value);
            }
        }

        // NAVIGASI LANGKAH
        let activeSubStep = 'upload';

        function goToSubStep(subStep) {
            const stepUpload = document.getElementById('sub-step-upload');
            const stepCrop = document.getElementById('sub-step-crop');
            const profilePage = document.querySelector('.profile-page');
            if (!stepUpload || !stepCrop) return;

            if (subStep === 'crop') {
                if (selectedFiles.length < 2) {
                    showProfileToast('Minimal 2 foto wajib diunggah untuk mengatur posisi.');
                    return;
                }
                activeSubStep = 'crop';
                stepUpload.style.display = 'none';
                stepCrop.style.display = 'flex';
                renderLiveLayoutPreview();
                
                // Sembunyikan sidebar dengan animasi
                if (profilePage) {
                    profilePage.classList.add('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'inline-flex';
                }
            } else {
                activeSubStep = 'upload';
                stepUpload.style.display = 'flex';
                stepCrop.style.display = 'none';
                
                // Pulihkan sidebar
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            }
            
            // Gulir ke bagian atas form secara halus
            const targetSec = document.getElementById('section-tambah-properti');
            if (targetSec) {
                targetSec.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function goToStep(step) {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            
            if (step === 2) {
                // Validasi input wajib pada langkah 1
                const requiredInputs = step1.querySelectorAll('[required]');
                let valid = true;
                requiredInputs.forEach(input => {
                    const card = input.closest('.field-card');
                    if (!input.value.trim()) {
                        valid = false;
                        if (card) {
                            card.style.borderColor = '#ef4444';
                            card.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
                        }
                    } else {
                        if (card) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }

                    // Clear highlight realtime saat user mulai mengetik
                    input.addEventListener('input', function () {
                        if (card && this.value.trim()) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }, { once: false });
                });

                if (!valid) {
                    showProfileToast('Mohon lengkapi semua data spesifikasi properti terlebih dahulu.');
                    // Scroll ke field pertama yang kosong
                    const firstEmpty = step1.querySelector('[required]:placeholder-shown, input[required][value=""]');
                    if (firstEmpty) {
                        firstEmpty.closest('.field-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }

                step1.style.display = 'none';
                step2.style.display = 'block';
                document.getElementById('form-title').textContent = 'Tambah Foto Properti';
                
                // Secara default masuk ke sub-langkah unggah
                goToSubStep('upload');
            } else {
                step1.style.display = 'block';
                step2.style.display = 'none';
                document.getElementById('form-title').textContent = 'Tambah Properti';
                
                // Pulihkan sidebar saat meninggalkan langkah 2
                const profilePage = document.querySelector('.profile-page');
                if (profilePage) {
                    profilePage.classList.remove('sidebar-collapsed');
                }
                const btnBackCropTop = document.getElementById('btn-back-crop-top');
                if (btnBackCropTop) {
                    btnBackCropTop.style.display = 'none';
                }
            }
        }

        // SERET & TARUH UNTUK UNGGAH FOTO
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('property-images');
        const countLabel = document.getElementById('photo-count-label');
        const uploadPhotoList = document.getElementById('uploadPhotoList');
        const photoControlList = document.getElementById('photoControlList');
        const previewGalleryContainer = document.getElementById('previewGalleryContainer');
        const liveLayoutGallery = document.getElementById('liveLayoutGallery');
        const hiddenPositionsContainer = document.getElementById('hidden-positions-container');
        let selectedFiles = []; // Array of { file: File, positionX: number, positionY: number, previewUrl: string }

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

        function handleFiles(files) {
            if (!fileInput) return;
            const newFiles = Array.from(files);
            
            for (let file of newFiles) {
                if (selectedFiles.length >= 5) break;
                if (!file.type.startsWith('image/')) continue;
                selectedFiles.push({
                    file: file,
                    positionX: 50,
                    positionY: 50,
                    previewUrl: URL.createObjectURL(file)
                });
            }
            
            updateFormInputsAndPreviews();
        }

        function updateFormInputsAndPreviews() {
            if (!fileInput || !countLabel || !hiddenPositionsContainer) return;
            
            // Sinkronisasi daftar file ke bidang input
            const dt = new DataTransfer();
            selectedFiles.forEach(item => dt.items.add(item.file));
            fileInput.files = dt.files;

            // Sinkronisasi input tersembunyi untuk posisi
            hiddenPositionsContainer.innerHTML = '';
            selectedFiles.forEach(item => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'positions[]';
                hiddenInput.value = `${item.positionX || 50}% ${item.positionY || 50}%`;
                hiddenPositionsContainer.appendChild(hiddenInput);
            });

            // Perbarui teks jumlah foto
            if (selectedFiles.length > 0) {
                countLabel.textContent = `${selectedFiles.length} foto terpilih (Minimal 2, Maksimal 5)`;
            } else {
                countLabel.textContent = 'Belum ada foto terpilih (Minimal 2, Maksimal 5)';
            }

            // Sinkronisasi status aktif/nonaktif tombol navigasi di Tahap Unggah
            const btnToCrop = document.getElementById('btn-to-crop');
            if (btnToCrop) {
                if (selectedFiles.length >= 2) {
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
            if (activeSubStep === 'crop' && selectedFiles.length < 2) {
                goToSubStep('upload');
            }

            // 1. Tampilkan Sub-langkah Daftar Unggahan 2A
            if (uploadPhotoList) {
                uploadPhotoList.innerHTML = '';
                selectedFiles.forEach((item, index) => {
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

                    if (index < selectedFiles.length - 1) {
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
                selectedFiles.forEach((item, index) => {
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
                if (selectedFiles.length >= 2) {
                    previewGalleryContainer.style.display = 'block';
                    if (activeSubStep === 'crop') {
                        renderLiveLayoutPreview();
                    }
                } else {
                    previewGalleryContainer.style.display = 'none';
                }
            }
        }

        function swapFiles(idx1, idx2) {
            const temp = selectedFiles[idx1];
            selectedFiles[idx1] = selectedFiles[idx2];
            selectedFiles[idx2] = temp;
            updateFormInputsAndPreviews();
        }

        function removeFile(index) {
            if (selectedFiles[index]) {
                URL.revokeObjectURL(selectedFiles[index].previewUrl);
                selectedFiles.splice(index, 1);
            }
            updateFormInputsAndPreviews();
        }

        function renderLiveLayoutPreview() {
            if (!liveLayoutGallery) return;
            liveLayoutGallery.innerHTML = '';

            const n = selectedFiles.length; // Range [2, 5]
            const galleryDiv = document.createElement('div');
            galleryDiv.className = `mock-gallery mock-gallery-${n}`;

            // Slot Utama / Sampul (Slot 1)
            const mainItem = document.createElement('div');
            mainItem.className = 'mock-gallery-item mock-main-item';
            
            const mainImg = document.createElement('img');
            mainImg.src = selectedFiles[0].previewUrl;
            mainImg.style.objectPosition = `${selectedFiles[0].positionX || 50}% ${selectedFiles[0].positionY || 50}%`;
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
                    sideImg.src = selectedFiles[i].previewUrl;
                    sideImg.style.objectPosition = `${selectedFiles[i].positionX || 50}% ${selectedFiles[i].positionY || 50}%`;
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

        function scrollToPreview(e) {
            if (e) e.preventDefault();
            const el = document.getElementById('previewGalleryContainer');
            if (el) {
                el.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Tambahkan validasi sisi klien ke pengiriman form
        const propertyForm = document.getElementById('propertyForm');
        if (propertyForm) {
            propertyForm.addEventListener('submit', function (e) {
                if (selectedFiles.length < 2) {
                    e.preventDefault();
                    showProfileToast('Minimal 2 foto wajib diunggah untuk melanjutkan.');
                } else if (selectedFiles.length > 5) {
                    e.preventDefault();
                    showProfileToast('Maksimal 5 foto dapat diunggah.');
                }
            });
        }

        // =============================================
        // VALIDASI FORM PROFIL MITRA
        // =============================================
        let profileToastTimer = null;

        function showProfileToast(msg) {
            const overlay = document.getElementById('profile-toast-overlay');
            const box = document.getElementById('profile-toast-box');
            const msgEl = document.getElementById('profile-toast-msg');
            if (!overlay || !box) return;

            msgEl.textContent = msg || 'Mohon lengkapi semua data profil terlebih dahulu.';
            overlay.style.display = 'block';

            // Trigger animation
            requestAnimationFrame(() => {
                box.style.opacity = '1';
                box.style.transform = 'translateX(-50%) translateY(0)';
            });

            // Auto-dismiss setelah 4 detik
            clearTimeout(profileToastTimer);
            profileToastTimer = setTimeout(() => closeProfileToast(), 4000);
        }

        function closeProfileToast() {
            const overlay = document.getElementById('profile-toast-overlay');
            const box = document.getElementById('profile-toast-box');
            if (!overlay || !box) return;

            box.style.opacity = '0';
            box.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => { overlay.style.display = 'none'; }, 300);
        }

        const profileMitraForm = document.getElementById('profile-mitra-form');
        if (profileMitraForm) {
            profileMitraForm.addEventListener('submit', function (e) {
                const requiredInputs = profileMitraForm.querySelectorAll('input[required]');
                let valid = true;

                requiredInputs.forEach(input => {
                    const card = input.closest('.field-card');
                    if (!input.value.trim()) {
                        valid = false;
                        if (card) {
                            card.style.borderColor = '#ef4444';
                            card.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
                        }
                    } else {
                        if (card) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }

                    // Clear highlight realtime saat user mulai mengetik
                    input.addEventListener('input', function () {
                        if (card && this.value.trim()) {
                            card.style.borderColor = 'transparent';
                            card.style.boxShadow = '';
                        }
                    }, { once: false });
                });

                if (!valid) {
                    e.preventDefault();
                    showProfileToast('Mohon lengkapi semua data profil terlebih dahulu.');
                    // Scroll ke field pertama yang kosong
                    const firstEmpty = profileMitraForm.querySelector('input[required]:placeholder-shown, input[required][value=""]');
                    if (firstEmpty) {
                        firstEmpty.closest('.field-card')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
