@extends('mitra.layout')

@section('content')
    <div class="page-title">
        <h1>Riwayat Penyewaan</h1>
    </div>

    @if($bookings->isEmpty())
        <p>Tidak ada riwayat penyewaan untuk properti Anda saat ini.</p>
    @else
        <div style="display:grid;gap:1rem;">
            @foreach($bookings as $booking)
                <div class="booking-card">
                    <div>
                        <strong>{{ $booking->property->nama_properti ?? 'Properti tidak tersedia' }}</strong>
                        <div>{{ $booking->property->location->kota ?? 'Lokasi tidak tersedia' }}</div>
                        <div>{{ $booking->user->name ?? 'Penyewa tidak diketahui' }}</div>
                        <div>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d-m-Y') }}</div>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge {{ $booking->status_booking === 'confirmed' ? 'approved' : ($booking->status_booking === 'cancelled' ? 'rejected' : 'pending') }}">{{ ucfirst($booking->status_booking) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
