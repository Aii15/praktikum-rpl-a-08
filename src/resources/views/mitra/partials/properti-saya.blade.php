<!-- BAGIAN 3: PROPERTI SAYA -->
<div id="section-properti-saya" class="content-section">
    <h1>Properti Saya</h1>

    <div class="property-list">
        @forelse($properties as $property)
            <div class="property-card">
                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="property-thumb" alt="{{ $property->nama_properti }}" style="object-position: center {{ $property->coverPhoto->object_position ?? '50' }}%;">

                <div class="property-info">
                    <h3>{{ $property->nama_properti }}</h3>
                    <p>{{ $property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                </div>

                <a href="{{ route('mitra.property.detail', $property->id_properti) }}" class="info-link">
                    Lihat Info Properti
                </a>

                @if(($property->bookings_count ?? 0) > 0)
                    <button type="button" class="delete-btn" style="opacity: 0.55; cursor: not-allowed;" disabled title="Properti tidak bisa dihapus karena sudah pernah dibooking oleh user.">
                        <img src="/images/profile/trash.png" alt="Hapus">
                        <span>Hapus</span>
                    </button>
                @else
                    <form id="delete-form-{{ $property->id_properti }}" action="{{ route('mitra.property.delete', $property->id_properti) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="button" class="delete-btn" onclick="confirmDeleteProperty({{ $property->id_properti }})">
                            <img src="/images/profile/trash.png" alt="Hapus">
                            <span>Hapus</span>
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Belum ada properti terdaftar. Silakan tambah properti baru.
            </div>
        @endforelse
    </div>
</div>
