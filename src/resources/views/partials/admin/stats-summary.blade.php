<div id="section-stats" class="content-section">
    <h1>Statistik</h1>

    <!-- Kartu Metrik Utama -->
    <div class="stats-grid">
        <div class="stats-item-card blue">
            <h4>Total Pengguna</h4>
            <div class="stats-value">{{ $stats['total_users'] }}</div>
        </div>
        <div class="stats-item-card green">
            <h4>Total Pemesanan</h4>
            <div class="stats-value">{{ $stats['total_bookings'] }}</div>
        </div>
        <div class="stats-item-card orange">
            <h4>Total Properti</h4>
            <div class="stats-value">{{ $stats['total_properties'] }}</div>
        </div>
    </div>

    <!-- Bagian Rincian Detail -->
    <div class="stats-detail-grid">
        <!-- Detail Pengguna -->
        <div class="stats-detail-section">
            <div class="stats-detail-title">Detail Peran Pengguna</div>
            <div class="stats-row">
                <span>Admin</span>
                <strong>{{ $stats['total_admins'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Mitra (Pemilik Properti)</span>
                <strong>{{ $stats['total_owners'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Penyewa</span>
                <strong>{{ $stats['total_tenants'] }}</strong>
            </div>
        </div>

        <!-- Detail Properti -->
        <div class="stats-detail-section">
            <div class="stats-detail-title">Detail Status Properti</div>
            <div class="stats-row">
                <span>Disetujui (Approved)</span>
                <strong>{{ $stats['approved_properties'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Menunggu (Pending)</span>
                <strong>{{ $stats['pending_properties'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Ditolak (Rejected)</span>
                <strong>{{ $stats['rejected_properties'] }}</strong>
            </div>
        </div>

        <!-- Detail Pemesanan -->
        <div class="stats-detail-section">
            <div class="stats-detail-title">Detail Status Pemesanan</div>
            <div class="stats-row">
                <span>Selesai (Completed)</span>
                <strong>{{ $stats['completed_bookings'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Disetujui (Confirmed)</span>
                <strong>{{ $stats['confirmed_bookings'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Menunggu (Pending)</span>
                <strong>{{ $stats['pending_bookings'] }}</strong>
            </div>
            <div class="stats-row">
                <span>Ditolak (Rejected)</span>
                <strong>{{ $stats['rejected_bookings'] }}</strong>
            </div>
        </div>
    </div>
</div>
