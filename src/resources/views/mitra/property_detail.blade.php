@extends('mitra.layout')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .detail-card {
            max-width: 780px;
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
            color: #111827;
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

        .booking-calendar {
            margin-top: 26px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .booking-calendar-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 10px;
        }

        .booking-calendar-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 6px;
        }

        .booking-calendar-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
            line-height: 1.5;
        }

        .booking-calendar-pill {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .booking-calendar-box {
            margin-top: 18px;
            padding: 16px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        .booking-calendar-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 0;
            height: 0;
        }

        .booking-calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 16px;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #f9fafb;
            color: #374151;
            font-size: 13px;
            font-weight: 500;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            display: inline-block;
        }

        .legend-dot.booked {
            background: #ef4444;
        }

        .legend-dot.available {
            background: #22c55e;
        }

        .booked-range-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .range-chip {
            padding: 10px 14px;
            border-radius: 12px;
            background: #fff1f2;
            color: #9f1239;
            border: 1px solid #fecdd3;
            font-size: 13px;
            font-weight: 500;
        }

        .empty-state {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #f8fafc;
            color: #475569;
            font-size: 14px;
            border: 1px dashed #cbd5e1;
        }

        .flatpickr-day.booked-day,
        .flatpickr-day.booked-day:hover,
        .flatpickr-day.booked-day:focus {
            background: #fee2e2 !important;
            border-color: #fca5a5 !important;
            color: #991b1b !important;
            cursor: not-allowed !important;
        }

        .flatpickr-day.booked-day.selected,
        .flatpickr-day.booked-day.inRange,
        .flatpickr-day.booked-day.startRange,
        .flatpickr-day.booked-day.endRange {
            box-shadow: none !important;
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

        @media (max-width: 768px) {
            .detail-info {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .booking-calendar-header {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <h1>Detail Properti Saya</h1>

    <div class="detail-card">
        <img src="{{ optional($property->coverPhoto)->url_foto ?? '/images/landing/property.png' }}" class="detail-banner" alt="{{ $property->nama_properti }}" style="object-position: {{ optional($property->coverPhoto)->position_style ?? 'center 50%' }};">

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

            <div class="booking-calendar">
                <div class="booking-calendar-header">
                    <div>
                        <p class="booking-calendar-title">Kalender Booking</p>
                        <p class="booking-calendar-subtitle">
                            Kalender ini menunjukkan tanggal yang sudah dibooking. Tanggal yang ditandai merah tidak dapat dipesan oleh penyewa.
                        </p>
                    </div>

                    <div class="booking-calendar-pill">
                        {{ $bookedDateRanges->count() }} rentang terpesan
                    </div>
                </div>

                <div class="booking-calendar-box">
                    <input type="text" id="bookingCalendar" class="booking-calendar-input" readonly>
                </div>

                <div class="booking-calendar-legend">
                    <span class="legend-item"><span class="legend-dot booked"></span>Sudah dibooking</span>
                    <span class="legend-item"><span class="legend-dot available"></span>Tersedia</span>
                </div>

                <div class="booked-range-list">
                    @forelse($bookedDateRanges as $range)
                        <div class="range-chip">
                            {{ \Carbon\Carbon::parse($range['from'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($range['to'])->format('d/m/Y') }}
                        </div>
                    @empty
                        <div class="empty-state">
                            Belum ada booking aktif pada properti ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('mitra.properties') }}" class="back-btn">
        Kembali ke Properti Saya
    </a>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script>
        const bookedDateRanges = @json($bookedDateRanges);
        const parsedDisable = bookedDateRanges.map(range => {
            const partsFrom = range.from.split('-');
            const partsTo = range.to.split('-');

            return {
                from: new Date(partsFrom[0], partsFrom[1] - 1, partsFrom[2]),
                to: new Date(partsTo[0], partsTo[1] - 1, partsTo[2])
            };
        });

        function formatDateYmd(date) {
            const d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            const year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        flatpickr("#bookingCalendar", {
            locale: "id",
            mode: "range",
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",
            showMonths: 2,
            disable: parsedDisable,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                if (!dayElem.dateObj) return;

                const dateStrYmd = formatDateYmd(dayElem.dateObj);
                const isBooked = bookedDateRanges.some(range => {
                    return dateStrYmd >= range.from && dateStrYmd <= range.to;
                });

                if (isBooked) {
                    dayElem.classList.add("booked-day");
                }
            }
        });
    </script>
@endsection
