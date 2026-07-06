<!-- BAGIAN 1: LOG AKTIVITAS (DASHBOARD) -->
<div id="section-log-aktivitas" class="content-section">
    <h1>Log Aktivitas</h1>

    <div class="admin-list">
        <a href="/admin/pengajuan-properti" class="admin-card" id="card-pengajuan-properti">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span>Pengajuan Properti</span>
                @if(count($pendingProperties) > 0)
                    <span class="notification-bubble" style="box-shadow: 0 2px 5px rgba(239, 68, 68, 0.2);">{{ count($pendingProperties) }}</span>
                @endif
            </div>
            <img src="/images/profile/edit.png" alt="Edit Icon">
        </a>

        <a href="/admin/riwayat-pemesanan" class="admin-card" id="card-riwayat-pemesanan">
            <span>Riwayat Pemesanan</span>
            <img src="/images/profile/edit.png" alt="Edit Icon">
        </a>
    </div>
</div>

<!-- BAGIAN 2: PENGAJUAN PROPERTI -->
<div id="section-pengajuan-properti" class="content-section">
    <h1>Pengajuan Properti</h1>

    <div class="item-list">
        @forelse($pendingProperties as $property)
            <div class="review-container">
                <div class="item-card" style="box-shadow: none; border: none; background: transparent;">
                    <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: {{ $property->coverPhoto->position_style ?? 'center 50%' }};">

                    <div class="item-info">
                        <h3>{{ $property->nama_properti }}</h3>
                        <p>Wilayah: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                        <p>Mitra: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</p>
                        <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                    </div>

                    <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                        <div class="status-badge pending">Status: Menunggu</div>
                        <a href="{{ route('detail-properti', $property->id_properti) }}?preview=admin" target="_blank" class="item-action btn-preview">Preview Detail Properti</a>
                    </div>
                </div>

                <div class="review-box">
                    <form action="{{ route('admin.property.review', $property->id_properti) }}" method="POST">
                        @csrf
                        <div class="review-header">
                            <span>Catatan</span>

                            <div class="action-buttons">
                                <button type="submit" name="status_pengajuan" value="approved" class="btn-decision accept">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Terima
                                </button>
                                <button type="submit" name="status_pengajuan" value="rejected" class="btn-decision reject">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    Tolak
                                </button>
                            </div>
                        </div>

                        <textarea name="catatan" placeholder="Tulis Catatan Di Sini"></textarea>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Tidak ada pengajuan properti baru yang perlu di-review.
            </div>
        @endforelse
    </div>

    <button id="kembali-pengajuan" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
    </button>
</div>

<!-- BAGIAN 3: RIWAYAT PEMESANAN -->
<div id="section-riwayat-pemesanan" class="content-section">
    <h1>Riwayat Pemesanan</h1>

    <!-- Kontrol Filter dan Pengurutan mencocokkan gaya Mitra -->
    <div class="filter-controls-container">
        <!-- Kartu Pencarian -->
        <div class="field-card filter-card search-card" onclick="document.getElementById('filter-bookings-search-input').focus()">
            <div class="field-text">
                <small>Cari Properti / Penyewa</small>
                <input type="text" id="filter-bookings-search-input" class="profile-input" placeholder="Tulis nama properti atau penyewa..." onkeyup="applyBookingsFilters()">
            </div>
            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
        </div>

        <!-- Kartu Dropdown Tanggal (Kalender) -->
        <div class="field-card filter-card dropdown-card" id="booking-date-filter-container" style="position: relative; z-index: 15;">
            <div class="field-text">
                <small>Filter Tanggal</small>
                <div id="booking-date-display" class="selected-display">Semua Tanggal</div>
                <input type="text" id="filter-booking-date-range" class="profile-input" style="position: absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;" placeholder="Pilih rentang tanggal...">
            </div>
            <div style="display: flex; align-items: center; gap: 8px; position: relative; z-index: 20;">
                <button id="btn-reset-booking-date" style="display: none; background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s; outline: none; font-family: 'Poppins', sans-serif;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'" onclick="resetBookingDateFilter(event)">Reset</button>
                <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon">
            </div>
        </div>

        <!-- Kartu Dropdown Status -->
        <div class="field-card filter-card dropdown-card" id="booking-status-dropdown-container" style="position: relative; z-index: 10;">
            <div class="field-text" onclick="toggleBookingsDropdown('booking-status-dropdown', event)">
                <small>Status Pemesanan</small>
                <div id="booking-status-display" class="selected-display">Semua Status</div>
                <input type="hidden" id="filter-booking-status-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleBookingsDropdown('booking-status-dropdown', event)">
            
            <div id="booking-status-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row booking-status-item-row" data-val="all" onclick="selectBookingStatusFilter('all', 'Semua Status', event)">
                    <span>Semua Status</span>
                </div>
                <div class="dropdown-item-row booking-status-item-row" data-val="pending" onclick="selectBookingStatusFilter('pending', 'Pending', event)">
                    <span class="status-badge-inline process">Pending</span>
                </div>
                <div class="dropdown-item-row booking-status-item-row" data-val="confirmed" onclick="selectBookingStatusFilter('confirmed', 'Disetujui', event)">
                    <span class="status-badge-inline success">Disetujui</span>
                </div>
                <div class="dropdown-item-row booking-status-item-row" data-val="rejected" onclick="selectBookingStatusFilter('rejected', 'Ditolak', event)">
                    <span class="status-badge-inline danger">Ditolak</span>
                </div>
            </div>
        </div>
    </div>

    <div class="item-list">
        @forelse($bookings as $booking)
            <div class="item-card booking-card-item" 
                 data-property-name="{{ strtolower($booking->property->nama_properti ?? '') }}" 
                 data-tenant-name="{{ strtolower($booking->user->name ?? '') }}" 
                 data-start-date="{{ $booking->tanggal_mulai }}" 
                 data-end-date="{{ $booking->tanggal_selesai }}" 
                 data-status="{{ $booking->status_booking }}">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $booking->property->nama_properti ?? 'Properti' }}" style="object-position: {{ $booking->property->coverPhoto->position_style ?? 'center 50%' }};">

                <div class="item-info">
                    <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                    <p>Wilayah: {{ $booking->property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                    <p>Penyewa: {{ $booking->user->name ?? 'Penyewa tidak diketahui' }}</p>
                    <p>Durasi: {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</p>
                    <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                </div>

                <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                    @if($booking->status_booking === 'pending')
                        <div class="status-badge pending">Pending</div>
                    @elseif($booking->status_booking === 'confirmed' || $booking->status_booking === 'completed')
                        <div class="status-badge approved">Disetujui</div>
                    @else
                        <div class="status-badge rejected">{{ ucfirst($booking->status_booking) }}</div>
                    @endif
                    <span style="font-size: 13px; color: #2563eb; cursor: pointer; text-decoration: underline; font-weight: 600;" onclick="showBookingDetail({{ $booking->id_booking }})">Info Pemesanan</span>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                Belum ada riwayat pemesanan di dalam sistem.
            </div>
        @endforelse
    </div>

    <button id="kembali-riwayat" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali
    </button>
</div>
