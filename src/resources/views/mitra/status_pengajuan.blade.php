@extends('mitra.layout')

@section('styles')
    <style>
        .status-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .status-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: grid;
            grid-template-columns: 130px 1fr 120px;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            text-decoration: none;
            color: #222;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }

        .status-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .status-card:active {
            transform: translateY(-1px) scale(0.99);
        }

        .status-card img.property-thumb {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .status-info {
            flex: 1;
        }

        .status-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .status-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .status-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
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
    </style>
@endsection

@section('content')
    <h1>Status Pengajuan Properti</h1>

    <div class="status-list">
        @forelse($properties as $property)
            <a href="{{ route('mitra.status.detail', $property->id_properti) }}" class="status-card">
                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="property-thumb" alt="{{ $property->nama_properti }}">

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
@endsection
