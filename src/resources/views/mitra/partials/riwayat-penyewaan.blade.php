<!-- SECTION 2: RIWAYAT PENYEWAAN -->
<div id="section-riwayat-penyewaan" class="content-section">
    <h1>Riwayat Penyewaan</h1>


    <!-- Kontrol Filter dan Pengurutan -->
    <div class="filter-controls-container">
        <!-- Kartu Pencarian -->
        <div class="field-card filter-card search-card">
            <div class="field-text">
                <small>Cari Properti / Penyewa</small>
                <input type="text" id="filter-search-input" class="profile-input" placeholder="Tulis nama properti atau penyewa..." onkeyup="applyAllFilters()">
            </div>
            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
        </div>

        <!-- Kartu Dropdown Status -->
        <div class="field-card filter-card dropdown-card" id="status-dropdown-container" style="position: relative; z-index: 15;">
            <div class="field-text" onclick="toggleFilterDropdown('status-dropdown', event)">
                <small>Status Penyewaan</small>
                <div id="status-display" class="selected-display">Semua Status</div>
                <input type="hidden" id="filter-status-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleFilterDropdown('status-dropdown', event)">
            
            <div id="status-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row status-item-row" data-val="all" onclick="selectFilterStatus('all', 'Semua Status', event)">
                    <span>Semua Status</span>
                </div>
                <div class="dropdown-item-row status-item-row" data-val="pending" onclick="selectFilterStatus('pending', 'Pending', event)">
                    <span class="status-badge-inline process">Pending</span>
                </div>
                <div class="dropdown-item-row status-item-row" data-val="confirmed" onclick="selectFilterStatus('confirmed', 'Disetujui', event)">
                    <span class="status-badge-inline success">Disetujui</span>
                </div>
                <div class="dropdown-item-row status-item-row" data-val="completed" onclick="selectFilterStatus('completed', 'Selesai', event)">
                    <span class="status-badge-inline completed">Selesai</span>
                </div>
                <div class="dropdown-item-row status-item-row" data-val="rejected" onclick="selectFilterStatus('rejected', 'Ditolak', event)">
                    <span class="status-badge-inline danger">Ditolak</span>
                </div>
            </div>
        </div>

        <!-- Kartu Dropdown Urutkan -->
        <div class="field-card filter-card dropdown-card" id="sort-dropdown-container" style="position: relative; z-index: 10;">
            <div class="field-text" onclick="toggleFilterDropdown('sort-dropdown', event)">
                <small>Urutkan Berdasarkan</small>
                <div id="sort-display" class="selected-display">Tanggal Terbaru</div>
                <input type="hidden" id="filter-sort-value" value="date_desc">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleFilterDropdown('sort-dropdown', event)">
            
            <div id="sort-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row sort-item-row" data-val="date_desc" onclick="selectFilterSort('date_desc', 'Tanggal Terbaru', event)">
                    <span>Tanggal Terbaru</span>
                </div>
                <div class="dropdown-item-row sort-item-row" data-val="date_asc" onclick="selectFilterSort('date_asc', 'Tanggal Terlama', event)">
                    <span>Tanggal Terlama</span>
                </div>
                <div class="dropdown-item-row sort-item-row" data-val="price_desc" onclick="selectFilterSort('price_desc', 'Harga Tertinggi', event)">
                    <span>Harga Tertinggi</span>
                </div>
                <div class="dropdown-item-row sort-item-row" data-val="price_asc" onclick="selectFilterSort('price_asc', 'Harga Terendah', event)">
                    <span>Harga Terendah</span>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-list">
        @forelse($bookings as $booking)
            <a href="{{ route('mitra.booking.detail', $booking->id_booking) }}" 
               onclick="showRentalDetail(event, {{ $booking->id_booking }})" 
               class="booking-card"
               data-status="{{ $booking->status_booking }}"
               data-property-name="{{ strtolower($booking->property->nama_properti ?? '') }}"
               data-tenant-name="{{ strtolower($booking->user->name ?? '') }}"
               data-price="{{ $booking->total_price ?? 0 }}"
               data-timestamp="{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->timestamp }}">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $booking->property->nama_properti ?? 'Property' }}" style="object-position: center {{ $booking->property->coverPhoto->object_position ?? '50' }}%;">

                <div class="booking-info">
                    <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                    <p>Penyewa: {{ $booking->user->name ?? 'Penyewa Tidak Diketahui' }}</p>
                    <p>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                    <strong>IDR {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</strong>
                </div>

                @if($booking->status_booking === 'pending')
                    <div class="status process">Pending</div>
                @elseif($booking->status_booking === 'confirmed')
                    <div class="status success">Disetujui</div>
                @elseif($booking->status_booking === 'completed')
                    <div class="status completed">Selesai</div>
                @elseif($booking->status_booking === 'cancelled')
                    <div class="status danger" style="background:#fee2e2;color:#991b1b;">Dibatalkan</div>
                @else
                    <div class="status danger">Ditolak</div>
                @endif
            </a>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                Belum ada riwayat penyewaan untuk properti Anda.
            </div>
        @endforelse
    </div>
</div>

<!-- BAGIAN 6: DETAIL PENYEWAAN -->
<div id="section-detail-penyewaan" class="content-section">
    <h1>Detail Penyewaan</h1>

    <div id="detailLoading" class="modal-loader-container">
        <div class="modal-spinner"></div>
        <p>Memuat detail penyewaan...</p>
    </div>

    <div id="detailBody" style="display: none;">
        <div class="detail-card">
            <img id="detailBanner" src="" class="detail-banner" alt="Banner Properti">

            <div class="detail-info">
                <h2 id="detailPropertyName"></h2>

                <div class="info-grid">
                    <div class="info-group">
                        <strong>Penyewa</strong>
                        <p id="detailPenyewa"></p>
                    </div>

                    <div class="info-group">
                        <strong>Alamat E-mail Penyewa</strong>
                        <p id="detailEmailPenyewa"></p>
                    </div>

                    <div class="info-group">
                        <strong>No Telepon Penyewa</strong>
                        <p id="detailNoHpPenyewa"></p>
                    </div>

                    <div class="info-group">
                        <strong>Rentang Sewa</strong>
                        <p id="detailRentangSewa"></p>
                    </div>

                    <div class="info-group">
                        <strong>Total Harga</strong>
                        <p id="detailTotalPrice"></p>
                    </div>
                </div>

                <span id="detailStatusBadge" class="booking-status"></span>

                <!-- Tombol Aksi untuk Penyewaan Tertunda -->
                <div id="bookingActionButtons" style="display: none; gap: 12px; margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 18px;">
                    <button onclick="updateBookingStatus('confirmed')" class="action-btn approve-btn">
                        Setujui Penyewaan
                    </button>
                    <button onclick="updateBookingStatus('rejected')" class="action-btn reject-btn">
                        Tolak Penyewaan
                    </button>
                </div>

                <!-- Bagian Ulasan & Tanggapan -->
                <div id="detailReviewSection" style="margin-top: 25px; border-top: 1px solid #e5e7eb; padding-top: 20px; display: none;">
                    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px; color: #111827;">Ulasan Penyewa</h3>
                    
                    <div id="tenantReviewContainer" style="display: none;">
                        <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                            <span id="displayReviewStars" style="font-size: 20px; color: #f7c948; letter-spacing: 2px;"></span>
                            <span id="displayReviewDate" style="font-size: 12px; color: #6b7280; margin-left: 8px;"></span>
                        </div>
                        <p id="displayReviewText" style="font-size: 14px; color: #374151; margin-bottom: 15px; line-height: 1.5; font-style: italic;"></p>
                        
                        <!-- Form untuk Mengirim Tanggapan -->
                        <form id="feedbackForm" style="display: none;" onsubmit="submitFeedback(event)">
                            <div style="margin-bottom: 15px;">
                                <label for="feedbackText" style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Tanggapan Anda</label>
                                <textarea id="feedbackText" rows="3" style="width:100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline:none; font-family:'Poppins',sans-serif; resize: vertical;" placeholder="Tulis tanggapan/feedback Anda di sini..."></textarea>
                            </div>
                            <button type="submit" style="background:#f7c948; color:#111; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; transition: background 0.2s; outline:none;">Kirim Tanggapan</button>
                        </form>

                        <!-- Menampilkan Tanggapan yang Ada -->
                        <div id="existingFeedback" style="display: none; background: #f3f4f6; border-radius: 8px; padding: 12px 16px; border-left: 4px solid #f7c948; margin-top: 15px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                <span style="font-size: 13px; font-weight: 600; color: #111827;" id="displayFeedbackAuthor"></span>
                                <span id="displayFeedbackDate" style="font-size: 11px; color: #6b7280;"></span>
                            </div>
                            <p id="displayFeedbackText" style="font-size: 13px; color: #4b5563; margin-bottom: 0; line-height: 1.4;"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="/riwayat-penyewaan" onclick="event.preventDefault(); navigateTo('/riwayat-penyewaan');" class="back-btn" style="margin-top: 15px;">
            ← Kembali ke Riwayat Penyewaan
        </a>
    </div>
</div>
