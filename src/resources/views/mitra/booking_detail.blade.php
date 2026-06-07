@extends('mitra.layout')

@section('styles')
    <style>
        .detail-card {
            width: 100%;
            max-width: 650px;
            background: #f9fafb;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            border: 1px solid #e5e7eb;
        }

        .detail-banner {
            width: 100%;
            height: 180px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .detail-info {
            padding: 22px;
        }

        .detail-info h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #111827;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 30px;
        }

        .info-group {
            margin: 0;
        }

        .info-group strong {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-group p {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0;
            line-height: 1.5;
        }

        .booking-status {
            display: inline-block;
            margin-top: 15px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 10px;
            background: #f3f4f6;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: #e5e7eb;
            color: #111827;
            transform: translateX(-4px);
        }

        .back-btn:active {
            transform: translateX(0);
        }
    </style>
@endsection

@section('content')
    <h1>Detail Penyewaan</h1>

    <div class="detail-card">
        <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="detail-banner" alt="{{ $booking->property->nama_properti }}" style="object-position: center {{ $booking->property->coverPhoto->object_position ?? '50' }}%;">

        <div class="detail-info">
            <h2>{{ $booking->property->nama_properti }}</h2>

            <div class="info-grid">
                <div class="info-group">
                    <strong>Penyewa</strong>
                    <p>{{ $booking->user->name ?? 'Penyewa Tidak Diketahui' }}</p>
                </div>

                <div class="info-group">
                    <strong>Alamat E-mail Penyewa</strong>
                    <p>{{ $booking->user->email ?? '-' }}</p>
                </div>

                <div class="info-group">
                    <strong>No Telepon Penyewa</strong>
                    <p>{{ $booking->user->no_hp ?? '-' }}</p>
                </div>

                <div class="info-group">
                    <strong>Rentang Sewa</strong>
                    <p>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d F Y') }}</p>
                </div>

                <div class="info-group">
                    <strong>Total Harga</strong>
                    <p>Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            @if($booking->status_booking === 'pending')
                <div class="booking-status process">Menunggu Konfirmasi</div>
            @elseif($booking->status_booking === 'confirmed')
                <div class="booking-status success">Disetujui / Aktif</div>
            @elseif($booking->status_booking === 'completed')
                <div class="booking-status success">Transaksi Selesai</div>
            @else
                <div class="booking-status danger">{{ ucfirst($booking->status_booking) }}</div>
            @endif
        </div>
    </div>

    <a href="{{ route('mitra.bookings') }}" class="back-btn">
        ← Kembali ke Riwayat Penyewaan
    </a>
@endsection
