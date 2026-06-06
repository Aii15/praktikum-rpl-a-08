@extends('mitra.layout')

@section('styles')
    <style>
        .property-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .property-card {
            background: #f9fafb;
            border-radius: 14px;
            padding: 18px;
            display: grid;
            grid-template-columns: 130px 1fr 150px 100px;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }

        .property-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            border-color: #f7c948;
            background: #ffffff;
        }

        .property-card img.property-thumb {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
        }

        .property-info h3 {
            font-size: 18px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .property-info p {
            color: #666;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .property-info strong {
            font-size: 15px;
            font-weight: 600;
            color: #d97706;
        }

        .info-link {
            font-size: 14px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            text-align: right;
            transition: color 0.2s ease;
        }

        .info-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .delete-btn {
            border: none;
            background: transparent;
            color: #e11d48;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .delete-btn:hover {
            transform: scale(1.05);
            color: #be123c;
        }

        .delete-btn img {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }
    </style>
@endsection

@section('content')
    <h1>Properti Saya</h1>

    <div class="property-list">
        @forelse($properties as $property)
            <div class="property-card">
                <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" class="property-thumb" alt="{{ $property->nama_properti }}">

                <div class="property-info">
                    <h3>{{ $property->nama_properti }}</h3>
                    <p>{{ $property->location->kota ?? 'Lokasi Tidak Diketahui' }}</p>
                    <strong>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }} / hari</strong>
                </div>

                <a href="{{ route('mitra.property.detail', $property->id_properti) }}" class="info-link">
                    Lihat Info Properti
                </a>

                <form action="{{ route('mitra.property.delete', $property->id_properti) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus properti ini?');">
                    @csrf
                    <button type="submit" class="delete-btn">
                        <img src="/images/profile/trash.png" alt="Hapus">
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px;">
                Belum ada properti terdaftar. Silakan tambah properti baru.
            </div>
        @endforelse
    </div>
@endsection
