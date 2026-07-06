<div id="section-riwayat-transaksi" class="content-section">
    <h1>Riwayat Transaksi</h1>

    <div class="filter-controls-container">
        <div class="search-box">
            <input type="text" id="transactionSearchInput" placeholder="Cari transaksi..." onkeyup="searchTransactions()">
        </div>

        <div class="filter-card" id="transaction-status-filter-card" onclick="toggleDropdown('transaction-status-dropdown', event)">
            <div class="filter-text">
                <small>Status Transaksi</small>
                <div id="transaction-status-display" class="filter-display">Semua Status</div>
                <input type="hidden" id="filter-transaction-status-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" style="width: 16px; height: 16px;">
            
            <div id="transaction-status-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row" onclick="selectTransactionFilter('all', 'Semua Status', event)">
                    <span>Semua Status</span>
                </div>
                <div class="dropdown-item-row" onclick="selectTransactionFilter('terbayar', 'Terbayar', event)">
                    <span class="status-badge-inline success">Terbayar</span>
                </div>
                <div class="dropdown-item-row" onclick="selectTransactionFilter('refund', 'Refund', event)">
                    <span class="status-badge-inline danger">Refund</span>
                </div>
            </div>
        </div>

        <div class="filter-card" id="transaction-sort-filter-card" onclick="toggleDropdown('transaction-sort-dropdown', event)">
            <div class="filter-text">
                <small>Urutkan</small>
                <div id="transaction-sort-display" class="filter-display">Terbaru</div>
                <input type="hidden" id="filter-transaction-sort-value" value="newest">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" style="width: 16px; height: 16px;">
            
            <div id="transaction-sort-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row" onclick="selectTransactionSortFilter('newest', 'Terbaru', event)">
                    <span>Terbaru</span>
                </div>
                <div class="dropdown-item-row" onclick="selectTransactionSortFilter('oldest', 'Terlama', event)">
                    <span>Terlama</span>
                </div>
            </div>
        </div>
    </div>

    <div class="booking-list">
        @forelse($bookings as $booking)
            @php
                $status = $booking->status_booking;
                $isRefund = in_array($status, ['rejected', 'cancelled']);
                $transStatus = $isRefund ? 'refund' : 'terbayar';
            @endphp
            <div class="booking-card transaction-card" data-status="{{ $transStatus }}" data-timestamp="{{ $booking->created_at->timestamp }}" style="cursor: default;">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $booking->property->nama_properti ?? 'Property' }}" style="object-position: {{ $booking->property->coverPhoto->position_style ?? 'center 50%' }};">

                <div class="booking-info">
                    <h3>{{ $booking->property->nama_properti ?? 'Properti Tidak Diketahui' }}</h3>
                    <p style="margin-bottom: 4px;">Tanggal Transaksi: {{ $booking->created_at->format('d M Y') }}</p>
                    <p style="margin-bottom: 4px;">Periode Sewa: {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->translatedFormat('d M Y') }}</p>
                    <strong>IDR {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                </div>

                @if($isRefund)
                    <div class="status" style="background:#fee2e2;color:#991b1b;">Refund</div>
                @else
                    <div class="status success">Terbayar</div>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Anda belum memiliki riwayat transaksi.
            </div>
        @endforelse
    </div>
</div>
