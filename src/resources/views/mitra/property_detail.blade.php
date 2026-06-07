@extends('mitra.layout')

@section('styles')
    <style>
        .detail-card {
            max-width: 700px;
            background: #f9fafb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .detail-banner {
            width: 100%;
            height: 280px;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-group {
            margin: 0;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 12px;
        }

        .info-group.full {
            grid-column: 1 / -1;
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
            font-size: 15px;
            font-weight: 500;
            color: #1f2937;
            margin: 0;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .pending {
            background: #fef3c7;
            color: #b45309;
        }

        .rejected {
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
    <h1>Detail Properti Saya</h1>

    <div class="detail-card">
        <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="detail-banner" alt="{{ $property->nama_properti }}" style="object-position: center {{ $property->coverPhoto->object_position ?? '50' }}%;">

        <div class="detail-info">
            <h2>{{ $property->nama_properti }}</h2>

            <div class="info-grid">
                <div class="info-group">
                    <strong>Kategori</strong>
                    <p>{{ $property->category->nama_kategori ?? 'Kategori tidak tersedia' }}</p>
                </div>

                <div class="info-group">
                    <strong>Lokasi</strong>
                    <p>{{ $property->location->kota ?? 'Lokasi tidak diketahui' }}</p>
                </div>

                <div class="info-group">
                    <strong>Alamat Lengkap</strong>
                    <p>{{ $property->location->alamat_detail ?? '-' }}</p>
                </div>

                <div class="info-group">
                    <strong>Harga Per Hari</strong>
                    <p>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }}</p>
                </div>

                <div class="info-group full">
                    <strong>Fasilitas</strong>
                    <p>{{ $property->fasilitas ?? 'Tidak ada fasilitas terdaftar' }}</p>
                </div>

                <div class="info-group full">
                    <strong>Deskripsi</strong>
                    <p>{{ $property->deskripsi }}</p>
                </div>
            </div>

            @if($property->status_pengajuan === 'approved')
                <div class="status-badge approved">Properti Aktif / Disetujui</div>
            @elseif($property->status_pengajuan === 'pending')
                <div class="status-badge pending">Menunggu Persetujuan</div>
            @else
                <div class="status-badge rejected">{{ ucfirst($property->status_pengajuan) }}</div>
            @endif
        </div>
    </div>

    <a href="{{ route('mitra.properties') }}" class="back-btn">
        ← Kembali ke Properti Saya
    </a>
@endsection
