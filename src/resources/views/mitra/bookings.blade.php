@extends('mitra.layout')

@section('styles')
    <style>
        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            width: 100%;
            height: 50px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 14px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            background: #fff;
            border-color: #f7c948;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.15);
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            text-decoration: none;
            color: #222;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }

        .booking-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .booking-card:active {
            transform: translateY(-1px) scale(0.99);
        }

        .booking-card img {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .booking-info {
            flex: 1;
        }

        .booking-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .booking-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .booking-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .status {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #15803d;
        }

        .process {
            background: #fef3c7;
            color: #b45309;
        }

        .danger {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
@endsection

@section('content')
    <h1>Riwayat Penyewaan</h1>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Cari penyewaan..." onkeyup="searchBookings()">
    </div>

    <div class="booking-list">
        @forelse($bookings as $booking)
            <a href="{{ route('mitra.booking.detail', $booking->id_booking) }}" class="booking-card">
                <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $booking->property->nama_properti ?? 'Property' }}">

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
                    <div class="status success">Selesai</div>
                @else
                    <div class="status danger">{{ ucfirst($booking->status_booking) }}</div>
                @endif
            </a>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Belum ada riwayat penyewaan untuk properti Anda.
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script>
        function searchBookings() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.booking-card');
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const text = card.querySelector('.booking-info').textContent.toLowerCase();
                if (title.includes(query) || text.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
