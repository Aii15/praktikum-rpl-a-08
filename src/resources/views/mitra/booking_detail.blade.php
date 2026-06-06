@extends('mitra.layout')

@section('styles')
    <style>
        .detail-card {
            max-width: 620px;
            background: #f9fafb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .detail-banner {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .detail-info {
            padding: 26px;
        }

        .detail-info h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .info-group {
            margin: 0;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
        }

        .info-group:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-group strong {
            display: block;
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-group p {
            font-size: 16px;
            font-weight: 500;
            color: #1f2937;
            margin: 0;
        }

        .booking-status {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .back-btn:hover {
            color: #111827;
            transform: translateX(-4px);
        }
    </style>
@endsection

@section('content')
    <h1>Detail Penyewaan</h1>

    <div class="detail-card">
        <img src="{{ $booking->property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="detail-banner" alt="{{ $booking->property->nama_properti }}">

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
