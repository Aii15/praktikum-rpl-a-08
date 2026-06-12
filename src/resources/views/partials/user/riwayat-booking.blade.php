<div id="section-riwayat-booking" class="content-section">
    <h1>Riwayat Booking</h1>

    <div class="filter-controls-container">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari booking..." onkeyup="searchBookings()">
        </div>

        <div class="filter-card" id="booking-status-filter-card" onclick="toggleDropdown('booking-status-dropdown', event)">
            <div class="filter-text">
                <small>Status Booking</small>
                <div id="booking-status-display" class="filter-display">Semua Status</div>
                <input type="hidden" id="filter-booking-status-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" style="width: 16px; height: 16px;">
            
            <div id="booking-status-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row" onclick="selectBookingFilter('all', 'Semua Status', event)">
                    <span>Semua Status</span>
                </div>
                <div class="dropdown-item-row" onclick="selectBookingFilter('pending', 'Pending', event)">
                    <span class="status-badge-inline process">Pending</span>
                </div>
                <div class="dropdown-item-row" onclick="selectBookingFilter('confirmed', 'Disetujui', event)">
                    <span class="status-badge-inline success">Disetujui</span>
                </div>
                <div class="dropdown-item-row" onclick="selectBookingFilter('completed', 'Selesai', event)">
                    <span class="status-badge-inline completed">Selesai</span>
                </div>
                <div class="dropdown-item-row" onclick="selectBookingFilter('cancelled', 'Dibatalkan', event)">
                    <span class="status-badge-inline danger">Dibatalkan</span>
                </div>
                <div class="dropdown-item-row" onclick="selectBookingFilter('rejected', 'Ditolak', event)">
                    <span class="status-badge-inline danger">Ditolak</span>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-list">
        @forelse($bookings as $booking)
            <a href="{{ route('user.booking.detail', $booking->id_booking) }}" onclick="showBookingDetail(event, {{ $booking->id_booking }})" class="booking-card" data-status="{{ $booking->status_booking }}">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $booking->property->nama_properti ?? 'Property' }}" style="object-position: {{ $booking->property->coverPhoto->position_style ?? 'center 50%' }};">

                <div class="booking-info">
                    <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                    <p>{{ $booking->property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                    <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                </div>

                @if($booking->status_booking === 'pending')
                    <div class="status process">Pending</div>
                @elseif($booking->status_booking === 'confirmed')
                    <div class="status success">Disetujui</div>
                @elseif($booking->status_booking === 'completed')
                    <div class="status completed">Selesai</div>
                @elseif($booking->status_booking === 'cancelled')
                    <div class="status" style="background:#fee2e2;color:#991b1b;">Dibatalkan</div>
                @else
                    <div class="status" style="background:#fee2e2;color:#991b1b;">Ditolak</div>
                @endif
            </a>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Anda belum memiliki riwayat booking.
            </div>
        @endforelse
    </div>
</div>
