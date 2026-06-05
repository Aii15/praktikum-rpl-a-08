@extends('mitra.layout')

@section('content')
    <div class="page-title">
        <h1>Properti Saya</h1>
    </div>

    @if($properties->isEmpty())
        <p>Belum ada properti yang terdaftar. Tambahkan properti baru untuk mulai menerima permintaan sewa.</p>
    @else
        <div style="display:grid;gap:1rem;">
            @foreach($properties as $property)
                <div class="property-card">
                    <div class="info">
                        <strong>{{ $property->nama_properti }}</strong>
                        <div>{{ $property->category->nama_kategori ?? 'Kategori tidak tersedia' }} • {{ $property->location->kota ?? '-' }}</div>
                        <div>Harga: Rp {{ number_format($property->harga_per_periode, 0, ',', '.') }}/periode</div>
                        <div>Status: <span class="badge {{ $property->status_pengajuan }}">{{ ucfirst($property->status_pengajuan) }}</span></div>
                    </div>
                    <div class="actions">
                        <form action="{{ route('mitra.property.delete', ['id' => $property->id_properti]) }}" method="POST" onsubmit="return confirm('Hapus properti ini?');">
                            @csrf
                            <button type="submit" class="danger-button">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
