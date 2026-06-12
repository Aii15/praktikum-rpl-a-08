<!-- BAGIAN 5: STATUS PENGAJUAN -->
<div id="section-status-pengajuan" class="content-section">
    <h1>Status Pengajuan Properti</h1>

    <div class="status-list">
        @forelse($properties as $property)
            <a href="{{ route('mitra.status.detail', $property->id_properti) }}" class="status-card">
                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="property-thumb" alt="{{ $property->nama_properti }}" style="object-position: center {{ $property->coverPhoto->object_position ?? '50' }}%;">

                <div class="status-info">
                    <h3>{{ $property->nama_properti }}</h3>
                    <p>Kategori: {{ $property->category->nama_kategori ?? 'Kategori tidak tersedia' }}</p>
                    <p>Lokasi: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                </div>

                @if($property->status_pengajuan === 'approved')
                    <div class="status-badge approved">Disetujui</div>
                @elseif($property->status_pengajuan === 'pending')
                    <div class="status-badge pending">Menunggu</div>
                @else
                    <div class="status-badge rejected">{{ ucfirst($property->status_pengajuan) }}</div>
                @endif
            </a>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Belum ada riwayat pengajuan properti. Silakan tambahkan properti baru.
            </div>
        @endforelse
    </div>
</div>
