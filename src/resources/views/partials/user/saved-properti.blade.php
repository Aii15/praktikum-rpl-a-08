<div id="section-saved-properti" class="content-section">
    <h1>Saved Properti</h1>

    <div class="booking-list">
        @forelse($wishlists as $wishlist)
            @if($wishlist->property)
                <a href="{{ route('detail-properti', $wishlist->property->id_properti) }}" class="booking-card">
                    <img src="{{ $wishlist->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $wishlist->property->nama_properti }}" style="object-position: {{ $wishlist->property->coverPhoto->position_style ?? 'center 50%' }};">

                    <div class="booking-info">
                        <h3>{{ $wishlist->property->nama_properti }}</h3>
                        <p>{{ $wishlist->property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                        <strong>Rp {{ number_format($wishlist->property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: flex-end; padding-right: 15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="width: 28px; height: 28px; color: #ef4444; fill: #ef4444;">
                            <path d="M15 8C8.925 8 4 12.925 4 19c0 11 13 21 20 23.326C31 40 44 30 44 19c0-6.075-4.925-11-11-11c-3.72 0-7.01 1.847-9 4.674A10.99 10.99 0 0 0 15 8" />
                        </svg>
                    </div>
                </a>
            @endif
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Anda belum menyimpan properti apa pun.
            </div>
        @endforelse
    </div>
</div>
