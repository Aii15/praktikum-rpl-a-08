<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile User - SpotRent</title>
    <link rel="icon" href="/images/logo.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/modal-helpers.js') }}"></script>
    <script src="{{ asset('js/spa-router.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/dashboard-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-user-custom.css') }}">
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
                    <a href="/profile-user" id="menu-tentang-saya" class="menu-item">
                        <img src="/icons/tentang_saya.svg" class="menu-icon" alt="Profil Icon">
                        <span>Tentang Saya</span>
                    </a>

                    <a href="/riwayat-booking" id="menu-riwayat-booking" class="menu-item">
                        <img src="/images/profile/history.png" class="menu-icon" alt="Riwayat Booking Icon">
                        <span>Riwayat Booking</span>
                    </a>

                    <a href="/saved-properti" id="menu-saved-properti" class="menu-item">
                        <img src="/icons/love.svg" class="menu-icon" alt="Saved Properti Icon">
                        <span>Saved Properti</span>
                    </a>

                    <a href="/riwayat-transaksi" id="menu-riwayat-transaksi" class="menu-item">
                        <img src="/icons/transaction.svg" class="menu-icon" alt="Riwayat Transaksi Icon">
                        <span>Riwayat Transaksi</span>
                    </a>

                    @if(!Auth::user()->isMitra())
                    <a href="/upgrade-mitra" class="menu-item">
                        <img src="/icons/upgrade.svg" class="menu-icon" alt="Upgrade Icon">
                        <span>Upgrade ke Mitra</span>
                    </a>
                    @endif
                </nav>
            </div>

            <a href="/" class="home-link">
                <img src="/images/profile/home.png" alt="Beranda Icon">
                <span>Ke Beranda</span>
            </a>
        </aside>

        <section class="content">
            <div id="flash-message-container">
                @include('partials.flash')
            </div>

            <!-- SECTION 1: TENTANG SAYA -->
            @include('partials.user.tentang-saya')

            <!-- SECTION 2: RIWAYAT BOOKING -->
            @include('partials.user.riwayat-booking')

            <!-- SECTION 3: SAVED PROPERTIES -->
            @include('partials.user.saved-properti')

            <!-- SECTION 5: RIWAYAT TRANSAKSI -->
            @include('partials.user.riwayat-transaksi')

            <!-- SECTION 4: DETAIL BOOKING -->
            @include('partials.user.detail-booking')
        </section>

    </main>

    <script>
        // Global booking ID passed from server for direct loads
        window.activeBookingId = @json($activeBookingId ?? null);



        function showBookingDetail(event, id, shouldPushState = true) {
            if (event) event.preventDefault();
            
            const loader = document.getElementById('detailLoading');
            const body = document.getElementById('detailBody');
            
            if (loader) loader.style.display = 'flex';
            if (body) body.style.display = 'none';

            if (shouldPushState) {
                navigateTo(`/detail-riwayat-booking/${id}`);
                return;
            }
            
            window.currentDetailBookingId = id;
            
            fetch(`/detail-riwayat-booking/${id}`, {
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
                    document.getElementById('detailPropertyName').textContent = booking.nama_properti;
                    
                    let statusLabel = 'Ditolak';
                    if (booking.status_booking === 'pending') statusLabel = 'Pending';
                    else if (booking.status_booking === 'confirmed') statusLabel = 'Disetujui';
                    else if (booking.status_booking === 'completed') statusLabel = 'Selesai';
                    else if (booking.status_booking === 'cancelled') statusLabel = 'Dibatalkan';
                    
                    document.getElementById('detailStatusBooking').textContent = statusLabel;
                    document.getElementById('detailStatusPembayaran').textContent = booking.status_pembayaran;
                    document.getElementById('detailTotalPrice').textContent = booking.total_price_formatted;
                    document.getElementById('detailRentangHari').textContent = booking.rentang_hari;
                    document.getElementById('detailEmailMitra').textContent = booking.email_mitra;
                    document.getElementById('detailPemilik').textContent = booking.pemilik;

                    const statusBadge = document.getElementById('detailStatusBadge');
                    statusBadge.textContent = 'Booking ' + statusLabel;
                    if (booking.status_booking === 'pending') {
                        statusBadge.className = 'booking-status process';
                    } else if (booking.status_booking === 'confirmed') {
                        statusBadge.className = 'booking-status success';
                    } else if (booking.status_booking === 'completed') {
                        statusBadge.className = 'booking-status completed';
                    } else {
                        statusBadge.className = 'booking-status danger';
                    }

                    // Handle Cancel Booking Section
                    const cancelSection = document.getElementById('bookingCancelSection');
                    if (cancelSection) {
                        if (booking.status_booking === 'pending') {
                            cancelSection.style.display = 'block';
                        } else {
                            cancelSection.style.display = 'none';
                        }
                    }
                    
                    // Handle Review Display & Form
                    const reviewSection = document.getElementById('detailReviewSection');
                    const reviewForm = document.getElementById('reviewForm');
                    const existingReview = document.getElementById('existingReview');
                    
                    if (booking.status_booking === 'confirmed' || booking.status_booking === 'completed') {
                        reviewSection.style.display = 'block';
                        
                        if (booking.review) {
                            // Review exists
                            reviewForm.style.display = 'none';
                            existingReview.style.display = 'block';
                            
                            // Render stars
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
                            
                            // Handle Mitra Reply
                            const mitraReply = document.getElementById('displayMitraReply');
                            if (booking.review.balasan_mitra) {
                                mitraReply.style.display = 'block';
                                document.getElementById('mitraReplyAuthor').textContent = booking.pemilik + ' (Pemilik Properti)';
                                document.getElementById('mitraReplyDate').textContent = booking.review.tanggal_balasan;
                                document.getElementById('mitraReplyText').textContent = booking.review.balasan_mitra;
                            } else {
                                mitraReply.style.display = 'none';
                            }
                        } else {
                            // Review doesn't exist yet, show form
                            reviewForm.style.display = 'block';
                            existingReview.style.display = 'none';
                            
                            // Reset form
                            document.getElementById('ratingValue').value = '';
                            document.getElementById('reviewKomentar').value = '';
                            setRating(0);
                        }
                    } else {
                        reviewSection.style.display = 'none';
                    }
                    
                    loader.style.display = 'none';
                    body.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                if (loader) {
                    loader.innerHTML = '<p style="color: #dc3545; font-size: 14px; font-weight: 500;">Gagal memuat detail booking. Silakan coba lagi.</p>';
                }
            });
        }
        window.showBookingDetail = showBookingDetail;

        let currentRating = 0;
        function setRating(rating) {
            currentRating = rating;
            document.getElementById('ratingValue').value = rating;
            const stars = document.querySelectorAll('.star-input');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = '#f7c948'; // Gold
                } else {
                    star.style.color = '#d1d5db'; // Grey
                }
            });
        }
        window.setRating = setRating;



        function submitReview(event) {
            event.preventDefault();
            const rating = document.getElementById('ratingValue').value;
            const komentar = document.getElementById('reviewKomentar').value;

            if (!rating) {
                showCustomAlert('Silakan pilih rating bintang terlebih dahulu.', 'danger');
                return;
            }

            const bookingId = window.currentDetailBookingId;
            
            fetch(`/booking/${bookingId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    rating: rating,
                    komentar: komentar
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        showBookingDetail(null, bookingId, false);
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal mengirim ulasan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting review:', error);
                showCustomAlert('Terjadi kesalahan saat mengirim ulasan.', 'danger');
            });
        }
        window.submitReview = submitReview;

        document.addEventListener('DOMContentLoaded', function() {
            // Flash message logic
            const flashContainer = document.getElementById('flash-message-container');
            if (flashContainer && flashContainer.innerText.trim() !== '') {
                setTimeout(() => {
                    flashContainer.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    flashContainer.style.opacity = '0';
                    flashContainer.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        flashContainer.style.display = 'none';
                    }, 500);
                }, 4000); // fades out after 4 seconds
            }

            const menuTentangSaya = document.getElementById('menu-tentang-saya');
            const menuRiwayatBooking = document.getElementById('menu-riwayat-booking');
            const menuSavedProperti = document.getElementById('menu-saved-properti');
            const menuRiwayatTransaksi = document.getElementById('menu-riwayat-transaksi');

            const routes = [
                { path: '/profile-user', sectionId: 'section-tentang-saya', title: 'Profile User - SpotRent', menuEl: menuTentangSaya },
                { path: '/riwayat-booking', sectionId: 'section-riwayat-booking', title: 'Riwayat Booking - SpotRent', menuEl: menuRiwayatBooking },
                { path: '/saved-properti', sectionId: 'section-saved-properti', title: 'Saved Properti - SpotRent', menuEl: menuSavedProperti },
                { path: '/riwayat-transaksi', sectionId: 'section-riwayat-transaksi', title: 'Riwayat Transaksi - SpotRent', menuEl: menuRiwayatTransaksi },
                { path: '/detail-riwayat-booking', regex: /^\/detail-riwayat-booking\/(\d+)$/, sectionId: 'section-detail-booking', title: 'Detail Booking - SpotRent', menuEl: menuRiwayatBooking }
            ];

            SPARouter.init(routes, routes[0], (path, matched, params) => {
                if (matched.path === '/detail-riwayat-booking' || matched.regex) {
                    const id = params ? params[0] : path.match(/^\/detail-riwayat-booking\/(\d+)$/)[1];
                    showBookingDetail(null, id, false);
                }
            });

            const menuItems = [
                { el: menuTentangSaya, path: '/profile-user' },
                { el: menuRiwayatBooking, path: '/riwayat-booking' },
                { el: menuSavedProperti, path: '/saved-properti' },
                { el: menuRiwayatTransaksi, path: '/riwayat-transaksi' }
            ];

            menuItems.forEach(item => {
                if (item.el) {
                    item.el.addEventListener('click', function(e) {
                        e.preventDefault();
                        navigateTo(item.path);
                    });
                }
            });

            // Initial load check (could be loaded with activeBookingId from server)
            const currentPath = window.location.pathname;
            if (window.activeBookingId) {
                navigateTo(`/detail-riwayat-booking/${window.activeBookingId}`, false);
            } else {
                navigateTo(currentPath, false);
            }
        });



        async function confirmCancelBooking() {
            const bookingId = window.currentDetailBookingId;
            if (!bookingId) return;

            const confirmed = await showCustomConfirm('Apakah Anda yakin ingin membatalkan booking ini?', 'danger');
            if (!confirmed) return;

            fetch(`/booking/${bookingId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        // Refresh booking details
                        showBookingDetail(null, bookingId, false);
                        
                        // Also update status inside the list of bookings on the left side
                        const card = document.querySelector(`.booking-card[href*="/detail-riwayat-booking/${bookingId}"]`);
                        if (card) {
                            const statusDiv = card.querySelector('.status');
                            if (statusDiv) {
                                statusDiv.className = 'status';
                                statusDiv.style.cssText = 'background:#fee2e2;color:#991b1b;';
                                statusDiv.textContent = 'Dibatalkan';
                            }
                        }
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal membatalkan booking.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error cancelling booking:', error);
                showCustomAlert('Terjadi kesalahan saat membatalkan booking.', 'danger');
            });
        }
        window.confirmCancelBooking = confirmCancelBooking;

        function toggleDropdown(dropdownId, event) {
            if (event) event.stopPropagation();
            const dropdown = document.getElementById(dropdownId);
            const isVisible = dropdown.style.display === 'block';
            
            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu-list').forEach(d => {
                d.style.display = 'none';
            });
            
            if (!isVisible) {
                dropdown.style.display = 'block';
            }
        }
        window.toggleDropdown = toggleDropdown;

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu-list').forEach(d => {
                d.style.display = 'none';
            });
        });

        function selectBookingFilter(statusValue, statusText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-booking-status-value').value = statusValue;
            document.getElementById('booking-status-display').textContent = statusText;
            document.getElementById('booking-status-dropdown').style.display = 'none';
            searchBookings();
        }
        window.selectBookingFilter = selectBookingFilter;

        function searchBookings() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filter-booking-status-value').value;
            const cards = document.querySelectorAll('#section-riwayat-booking .booking-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const city = card.querySelector('p').textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                
                const matchesQuery = title.includes(query) || city.includes(query);
                const matchesStatus = (statusFilter === 'all') || (status === statusFilter);
                
                if (matchesQuery && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        window.searchBookings = searchBookings;

        function selectTransactionFilter(statusValue, statusText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-transaction-status-value').value = statusValue;
            document.getElementById('transaction-status-display').textContent = statusText;
            document.getElementById('transaction-status-dropdown').style.display = 'none';
            searchTransactions();
        }
        window.selectTransactionFilter = selectTransactionFilter;

        function selectTransactionSortFilter(sortValue, sortText, event) {
            if (event) event.stopPropagation();
            document.getElementById('filter-transaction-sort-value').value = sortValue;
            document.getElementById('transaction-sort-display').textContent = sortText;
            document.getElementById('transaction-sort-dropdown').style.display = 'none';
            searchTransactions();
        }
        window.selectTransactionSortFilter = selectTransactionSortFilter;

        function searchTransactions() {
            const query = document.getElementById('transactionSearchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filter-transaction-status-value').value;
            const sortFilter = document.getElementById('filter-transaction-sort-value').value;
            const container = document.querySelector('#section-riwayat-transaksi .booking-list');
            const cards = Array.from(document.querySelectorAll('#section-riwayat-transaksi .transaction-card'));
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const text = card.textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                
                const matchesQuery = title.includes(query) || text.includes(query);
                const matchesStatus = (statusFilter === 'all') || (status === statusFilter);
                
                if (matchesQuery && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            // Sort cards
            cards.sort((a, b) => {
                const timeA = parseInt(a.getAttribute('data-timestamp'));
                const timeB = parseInt(b.getAttribute('data-timestamp'));
                if (sortFilter === 'newest') {
                    return timeB - timeA;
                } else {
                    return timeA - timeB;
                }
            });

            // Re-append cards in sorted order
            cards.forEach(card => container.appendChild(card));
        }
        window.searchTransactions = searchTransactions;
    </script>
</body>

</html>
