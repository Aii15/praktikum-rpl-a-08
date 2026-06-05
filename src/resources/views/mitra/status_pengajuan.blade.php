@extends('mitra.layout')

@section('content')
    <div class="page-title">
        <h1>Status Pengajuan</h1>
    </div>

    @if($properties->isEmpty())
        <p>Belum ada pengajuan properti. Silakan tambahkan properti baru.</p>
    @else
        <div style="display:grid;gap:1rem;">
            @foreach($properties as $property)
                <div class="status-card">
                    <div>
                        <strong>{{ $property->nama_properti }}</strong>
                        <div>{{ $property->category->nama_kategori ?? 'Kategori tidak tersedia' }} • {{ $property->location->kota ?? '-' }}</div>
                        <div>Harga: Rp {{ number_format($property->harga_per_periode, 0, ',', '.') }}/periode</div>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge {{ $property->status_pengajuan }}">{{ ucfirst($property->status_pengajuan) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
