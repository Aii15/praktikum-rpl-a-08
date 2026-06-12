<div id="section-list-properti" class="content-section">
    <h1>List Properti</h1>

    <div class="item-list">
        @forelse($allProperties as $property)
            <div class="item-card">
                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="item-thumb" alt="{{ $property->nama_properti }}" style="object-position: {{ $property->coverPhoto->position_style ?? 'center 50%' }};">

                <div class="item-info">
                    <h3>{{ $property->nama_properti }}</h3>
                    <p>Wilayah: {{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                    <p>Mitra: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</p>
                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                </div>

                <div style="text-align: right; display: flex; flex-direction: column; gap: 8px;">
                    @if($property->status_pengajuan === 'approved')
                        <div class="status-badge approved">Disetujui</div>
                    @elseif($property->status_pengajuan === 'pending')
                        <div class="status-badge pending">Menunggu</div>
                    @else
                        <div class="status-badge rejected">Ditolak</div>
                    @endif
                    <a href="{{ route('detail-properti', $property->id_properti) }}" target="_blank" class="item-action">Lihat Info Properti</a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Belum ada properti terdaftar dalam sistem.
            </div>
        @endforelse
    </div>
</div>
