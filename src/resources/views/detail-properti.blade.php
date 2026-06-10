@extends('layouts.app')

@section('title', $property->nama_properti . ' - Detail Properti')

@section('styles')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/detail-properti.css') }}">
    <style>
        /* Custom Confirmation Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .custom-modal-overlay.active {
            opacity: 1;
        }

        .custom-modal-box {
            background: #ffffff;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .custom-modal-overlay.active .custom-modal-box {
            transform: scale(1);
        }

        .custom-modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            margin: 0 auto 18px;
        }

        .custom-modal-icon.success {
            background: #dcfce7;
            color: #15803d;
        }

        .custom-modal-icon.danger {
            background: #fee2e2;
            color: #ef4444;
        }

        .custom-modal-box h3 {
            font-size: 19px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .custom-modal-box p {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .custom-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .custom-modal-btn {
            flex: 1;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }

        .custom-modal-btn.ok-btn {
            background: #f7c948;
            color: #111111;
            box-shadow: 0 4px 12px rgba(247, 201, 72, 0.2);
        }

        .custom-modal-btn.ok-btn:hover {
            background: #f5b91b;
            box-shadow: 0 6px 16px rgba(247, 201, 72, 0.3);
        }
    </style>
@endsection

@section('content')
    @include('partials.navbar')

    <div class="detail-page">

        @if(request()->query('preview') === 'admin')
            <div class="preview-notice-banner" style="background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 14px; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(217, 119, 6, 0.05); animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span><strong>Mode Preview Admin:</strong> Anda sedang melihat live preview detail properti yang sedang diajukan.</span>
            </div>
        @endif

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; font-family: 'Poppins', sans-serif;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; font-family: 'Poppins', sans-serif;">
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div style="background: #eff6ff; color: #1e3a8a; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 500; font-family: 'Poppins', sans-serif;">
                {{ session('info') }}
            </div>
        @endif

        <div class="top-header-actions">
            @if(request()->query('preview') === 'admin')
                <a href="{{ route('admin.pengajuan') }}" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 2px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali Ke Daftar Pengajuan Properti
                </a>
            @else
                <a href="/" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 2px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali Ke Daftar Properti
                </a>
            @endif

            <div class="top-actions">
                <button class="save-btn {{ $isSaved ? 'saved' : '' }}" onclick="toggleSave({{ $property->id_properti }})">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="save-icon">
                        <path d="M0 0h48v48H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M15 8C8.925 8 4 12.925 4 19c0 11 13 21 20 23.326C31 40 44 30 44 19c0-6.075-4.925-11-11-11c-3.72 0-7.01 1.847-9 4.674A10.99 10.99 0 0 0 15 8" />
                    </svg>
                    <span>{{ $isSaved ? 'Saved' : 'Save' }}</span>
                </button>
            </div>
        </div>

        @php
            $photos = $property->photos->sortBy('urutan');
            $photoCount = count($photos);
            $photoCountClamped = max(2, min(5, $photoCount));
            $cover = $photos->firstWhere('is_cover', true) ?? $photos->first();
            $otherPhotos = $photos->filter(function($p) use ($cover) {
                return $p->id_foto !== ($cover->id_foto ?? null);
            })->take($photoCountClamped - 1);
        @endphp

        <section class="gallery gallery-{{ $photoCountClamped }}">
            <div class="gallery-item main-gallery-item">
                <img class="main-img" src="{{ $cover->url_foto ?? '/images/landing/property.png' }}" alt="{{ $property->nama_properti }}" style="object-position: center {{ $cover->object_position ?? '50' }}%;">
            </div>

            @if($photoCountClamped > 1)
                <div class="side-gallery">
                    @foreach ($otherPhotos as $photo)
                        <div class="gallery-item">
                            <img src="{{ $photo->url_foto }}" alt="" style="object-position: center {{ $photo->object_position ?? '50' }}%;">
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        @php
            $activeRole = session('active_role');
            $canBook = !Auth::check() || $activeRole === 'penyewa';
        @endphp
        <form action="{{ route('detail-properti.book', $property->id_properti) }}" method="POST" style="display: contents;">
            @csrf
            <input type="hidden" name="date_range" id="hiddenDateRange">

            <section class="content-wrapper">

                <div class="left-content">
                    <h1 class="property-title">{{ $property->nama_properti }}</h1>
                    <p class="property-subtitle">
                        {{ $property->location->alamat_detail }}, {{ $property->location->kota }}, {{ $property->location->provinsi }}.
                    </p>

                    <div class="info-box">
                        <div class="info-item">
                            <img src="/images/informasi/icons/location.svg" alt="" class="info-img">
                            <div class="info-title">{{ $property->location->kota }}</div>
                        </div>

                        <div class="info-item">
                            @php
                                $categoryIcons = [
                                    'hunian' => 'hunian.svg',
                                    'heritage' => 'heritage.svg',
                                    'lanskap' => 'lanskap.svg',
                                    'fasilitas publik' => 'fasilitas_publik.svg',
                                    'komersial' => 'komersial.svg',
                                    'studio' => 'studio_icon.svg',
                                    'industrial' => 'industrial.svg',
                                ];
                                $categoryKey = strtolower($property->category->nama_kategori ?? '');
                                $categoryIcon = $categoryIcons[$categoryKey] ?? null;
                            @endphp
                            @if($categoryIcon)
                                <img src="/images/landing/icons/{{ $categoryIcon }}" alt="" class="info-img">
                            @endif
                            <div class="info-title">{{ $property->category->nama_kategori }}</div>
                            <div class="info-desc">Tipe Properti</div>
                        </div>

                        <div class="info-item">
                            <div class="info-title">{{ number_format($avgRating, 1) }}</div>
                            <div class="star-icons">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($avgRating))
                                        <img src="/images/informasi/icons/star.png" alt="Star">
                                    @else
                                        <img src="/images/informasi/icons/star.png" alt="Star" style="opacity: 0.3;">
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-title">{{ $property->reviews->count() }}</div>
                            <div class="info-desc">Reviews</div>
                        </div>
                    </div>

                    <div class="owner">
                        <div class="avatar">{{ strtoupper(substr($property->mitra->name ?? 'M', 0, 1)) }}</div>
                        <div>
                            <b>{{ $property->mitra->name ?? 'Mitra SpotRent' }}</b>
                            <p>Pengelola Operasional</p>
                        </div>
                    </div>

                    <hr>

                    <p class="description">
                        {{ $property->deskripsi }}
                    </p>

                    <hr>

                    <h3 class="section-title">Spesifikasi Properti</h3>

                    <div class="spec-grid">
                        @php
                            $facs = array_map('strtolower', array_map('trim', explode(',', $property->fasilitas)));
                            $fixedSpecs = [
                                'Sanitasi' => ['icon' => 'sanitasi.svg', 'keys' => ['sanitasi']],
                                'Listrik dan Penerangan' => ['icon' => 'listrik.svg', 'keys' => ['listrik dan penerangan', 'listrik', 'penerangan']],
                                'CCTV' => ['icon' => 'cctv.svg', 'keys' => ['cctv']],
                                'Parkir Mobil' => ['icon' => 'parkir.svg', 'keys' => ['parkir mobil', 'parkir']],
                                'Sprinkler Water' => ['icon' => 'sprinkler.svg', 'keys' => ['sprinkler water', 'sprinkler']],
                                'Permit Included' => ['icon' => 'permit.svg', 'keys' => ['permit included', 'permit', 'perizinan']],
                                'APAR' => ['icon' => 'apar.svg', 'keys' => ['apar']],
                                'Outdoor' => ['icon' => 'outdoor.svg', 'keys' => ['outdoor']],
                            ];
                        @endphp
                        @foreach ($fixedSpecs as $name => $spec)
                            @php
                                $hasSpec = false;
                                foreach ($spec['keys'] as $key) {
                                    if (in_array($key, $facs)) {
                                        $hasSpec = true;
                                        break;
                                    }
                                }
                            @endphp
                            @if ($hasSpec)
                                <div class="spec-item">
                                    <img src="/images/informasi/icons/{{ $spec['icon'] }}" alt="">
                                    <span>{{ $name }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <hr>

                    @if ($canBook)
                        <div class="calendar-section">
                            <h2>IDR {{ number_format($property->harga_per_hari, 0, ',', '.') }}<span style="font-size: 16px; font-weight: normal; color: #777;"> / Hari</span></h2>
                            <p id="calendarDaysText">Pilih rentang tanggal di kalender</p>

                            <input type="text" id="dateRange">
                        </div>
                    @else
                        <div class="calendar-section" style="text-align: center; padding: 30px; border: 1px dashed #fca5a5; border-radius: 12px; background-color: #fff5f5; margin-bottom: 20px;">
                            <h3 style="color: #991b1b; font-family: 'Poppins', sans-serif; font-weight: 600; margin-bottom: 8px;">Pemesanan Dinonaktifkan</h3>
                            <p style="color: #b91c1c; font-family: 'Poppins', sans-serif; font-size: 14px; margin: 0;">
                                Sebagai {{ ucfirst($activeRole) }}, Anda tidak dapat melakukan pemesanan properti. Silakan masuk dengan akun Penyewa untuk memesan properti.
                            </p>
                        </div>
                    @endif

                </div>

                <aside class="booking-card">
                    <h2 id="totalPriceText">IDR {{ number_format($property->harga_per_hari, 0, ',', '.') }}<span style="font-size: 16px; font-weight: normal; color: #777;"> / Hari</span></h2>
                    <p id="bookingDaysText">Pilih tanggal</p>

                    @if ($canBook)
                        <div class="date-box" onclick="toggleBookingCardCalendar(event)" style="cursor: pointer; display: grid; grid-template-columns: 1fr 1fr; border: 1px solid #222; border-radius: 6px; overflow: hidden; margin-bottom: 15px;">
                            <div class="date-item">
                                <b>Check-in</b>
                                <span id="checkInText">--/--/----</span>
                            </div>

                            <div class="date-item">
                                <b>Check-out</b>
                                <span id="checkOutText">--/--/----</span>
                            </div>
                        </div>

                        <!-- Inline calendar container inside the booking card -->
                        <div id="bookingCardCalendarWrapper" style="display: none; margin-top: 15px; margin-bottom: 15px; width: 100%; border: 1px solid #eaeaea; border-radius: 12px; padding: 10px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                            <div id="bookingCardCalendarInline"></div>
                        </div>

                        <button type="submit">Pesan</button>
                    @else
                        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; font-size: 14px; font-weight: 500; font-family: 'Poppins', sans-serif; text-align: center; border: 1px solid #fca5a5; mt-15px; margin-bottom: 15px;">
                            Akun Anda terdaftar sebagai {{ ucfirst($activeRole) }}. Hanya akun Penyewa yang dapat melakukan pemesanan.
                        </div>
                        <button type="button" style="background: #ccc; cursor: not-allowed; color: #666; width: 100%; padding: 15px; border-radius: 12px; font-weight: 600; font-family: 'Poppins', sans-serif; border: none;" disabled>Pesan</button>
                    @endif
                </aside>

            </section>
        </form>

        <section class="rating-section">
            <div class="rating-summary">
                <div class="rating-score">
                    <h2>{{ number_format($avgRating, 1) }}</h2>
                    <div class="big-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($avgRating))
                                <img src="/images/informasi/icons/star.png" alt="Star">
                            @else
                                <img src="/images/informasi/icons/star.png" alt="Star" style="opacity: 0.3;">
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="rating-bars">
                    <p>Overall Rating</p>

                    <div class="rating-lines">
                        @php
                            $totalReviews = $property->reviews->count();
                            $starCounts = [
                                5 => $property->reviews->where('rating', 5)->count(),
                                4 => $property->reviews->where('rating', 4)->count(),
                                3 => $property->reviews->where('rating', 3)->count(),
                                2 => $property->reviews->where('rating', 2)->count(),
                                1 => $property->reviews->where('rating', 1)->count(),
                            ];
                        @endphp
                        @foreach([5, 4, 3, 2, 1] as $star)
                            @php
                                $percent = $totalReviews > 0 ? ($starCounts[$star] / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="bar-row">
                                <span>{{ $star }}</span>
                                <div style="position: relative; background: #e0e0e0; border-radius: 4px; height: 8px; width: 100%; overflow: hidden;">
                                    <div style="background: #f7c948; width: {{ $percent }}%; height: 100%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($userBookingToReview)
                <div class="review-form-card" style="background: #ffffff; border-radius: 12px; padding: 24px; border: 1px solid #eaeaea; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 30px; font-family: 'Poppins', sans-serif;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: #111827;">Tulis Ulasan Anda</h3>
                    <p style="font-size: 13px; color: #6b7280; margin-bottom: 18px;">
                        Anda memiliki sewaan yang telah disetujui untuk properti ini (Periode: {{ \Carbon\Carbon::parse($userBookingToReview->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($userBookingToReview->tanggal_selesai)->format('d/m/Y') }}). Silakan bagikan pengalaman Anda.
                    </p>
                    <form id="propertyReviewForm" onsubmit="submitPropertyReview(event, {{ $userBookingToReview->id_booking }})">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Rating</label>
                            <div class="star-rating" style="display: flex; gap: 8px;">
                                <span class="star-input-prop" onclick="setPropertyRating(1)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input-prop" onclick="setPropertyRating(2)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input-prop" onclick="setPropertyRating(3)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input-prop" onclick="setPropertyRating(4)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input-prop" onclick="setPropertyRating(5)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                            </div>
                            <input type="hidden" id="propertyRatingValue" value="" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="propertyReviewKomentar" style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Komentar</label>
                            <textarea id="propertyReviewKomentar" rows="3" style="width:100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline:none; font-family:'Poppins',sans-serif; resize: vertical;" placeholder="Tulis komentar ulasan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" style="background:#f7c948; color:#111; border:none; padding:12px 24px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; transition: background 0.2s; outline:none; font-family: 'Poppins', sans-serif;">Kirim Ulasan</button>
                    </form>
                </div>
            @endif
            
            <div class="review-grid">
                @forelse ($property->reviews as $review)
                    <div class="review-card">
                        <div class="review-head">
                            <div class="review-avatar">
                                {{ strtoupper(substr($review->booking->user->name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <b>{{ $review->booking->user->name ?? 'Penyewa' }}</b>
                                <p>{{ \Carbon\Carbon::parse($review->tanggal_review)->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="review-stars">
                            @for ($j = 1; $j <= 5; $j++)
                                @if ($j <= $review->rating)
                                    <img src="/images/informasi/icons/star.png" alt="">
                                @else
                                    <img src="/images/informasi/icons/star.png" alt="" style="opacity: 0.3;">
                                @endif
                            @endfor
                        </div>

                        <p class="review-text" style="margin-bottom: 0;">
                            {{ $review->komentar }}
                        </p>

                        @if($review->balasan_mitra)
                            <div class="mitra-reply-box" style="margin-top: 15px; background: #f9fafb; border-radius: 8px; padding: 12px 16px; border-left: 4px solid #f7c948; border-top: 1px solid #f0f0f0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; flex-wrap: wrap; gap: 8px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span style="font-size: 13px; font-weight: 600; color: #111827;">{{ $property->mitra->name ?? 'Pemilik Properti' }}</span>
                                        <span style="font-size: 11px; font-weight: 600; color: #a16207; background: #fef9c3; padding: 2px 6px; border-radius: 4px;">Pemilik Properti</span>
                                    </div>
                                    <span style="font-size: 11px; color: #6b7280;">{{ \Carbon\Carbon::parse($review->tanggal_balasan)->format('d/m/Y') }}</span>
                                </div>
                                <p class="reply-text" style="font-size: 13px; color: #4b5563; margin-bottom: 0; line-height: 1.4;">
                                    {{ $review->balasan_mitra }}
                                </p>
                            </div>
                        @elseif(Auth::check() && session('active_role') === 'mitra' && $property->id_mitra === Auth::id())
                            <div class="mitra-reply-form" style="margin-top: 15px; border-top: 1px solid #eaeaea; padding-top: 15px;">
                                <form onsubmit="submitPropertyFeedback(event, {{ $review->id_review }})">
                                    <div style="margin-bottom: 12px;">
                                        <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Tulis Tanggapan Pemilik</label>
                                        <textarea id="propertyFeedbackText-{{ $review->id_review }}" rows="2" style="width:100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; outline:none; font-family:'Poppins',sans-serif; resize: vertical;" placeholder="Tulis tanggapan/feedback Anda terhadap ulasan ini..." required></textarea>
                                    </div>
                                    <button type="submit" style="background:#f7c948; color:#111; border:none; padding:8px 16px; border-radius:6px; font-weight:600; cursor:pointer; font-size:12px; transition: background 0.2s; outline:none;">Kirim Tanggapan</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="grid-column: span 2; text-align: center; color: #777; padding: 40px 0; font-size: 16px;">
                        Belum ada ulasan untuk properti ini.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <!-- Lightbox Modal -->
    <div id="lightboxModal" class="lightbox">
        <span class="lightbox-close">&times;</span>
        <button class="lightbox-prev">&#10094;</button>
        <button class="lightbox-next">&#10095;</button>
        <div class="lightbox-content">
            <img id="lightboxImg" src="" alt="View Property Image">
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')
@endsection

@section('scripts')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        const canBook = {{ $canBook ? 'true' : 'false' }};
        // Initialize Flatpickr with seeded disabled dates
        const disabledDates = @json($disabledDates);
        const parsedDisable = disabledDates.map(range => {
            const partsFrom = range.from.split('-');
            const partsTo = range.to.split('-');
            return {
                from: new Date(partsFrom[0], partsFrom[1] - 1, partsFrom[2]),
                to: new Date(partsTo[0], partsTo[1] - 1, partsTo[2])
            };
        });

        // Helper to format Date to YYYY-MM-DD
        function formatDateYmd(date) {
            const d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            const year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        // Create custom tooltip element for booked dates
        const tooltip = document.createElement("div");
        tooltip.className = "booking-tooltip";
        tooltip.innerHTML = `
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; flex-shrink: 0; color: #ef4444;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span>Tanggal ini sudah dipesan</span>
        `;
        document.body.appendChild(tooltip);

        document.addEventListener("mouseover", function(e) {
            const dayElem = e.target.closest(".booked-day");
            if (dayElem) {
                const tooltipText = dayElem.getAttribute("data-booked-tooltip") || "Tanggal ini sudah dipesan";
                tooltip.querySelector("span").textContent = tooltipText;
                tooltip.classList.add("show");
                
                const rect = dayElem.getBoundingClientRect();
                const tooltipRect = tooltip.getBoundingClientRect();
                
                // Position the tooltip centered above the day element
                const top = rect.top + window.scrollY - tooltipRect.height - 8;
                const left = rect.left + window.scrollX + (rect.width / 2) - (tooltipRect.width / 2);
                
                tooltip.style.top = `${top}px`;
                tooltip.style.left = `${left}px`;
            }
        });

        document.addEventListener("mouseout", function(e) {
            const dayElem = e.target.closest(".booked-day");
            if (dayElem) {
                tooltip.classList.remove("show");
            }
        });

        function handleDateSelection(selectedDates, dateStr, instance) {
            if (selectedDates.length >= 1) {
                document.getElementById("checkInText").textContent =
                    instance.formatDate(selectedDates[0], "d/m/Y");
            }

            if (selectedDates.length === 2) {
                document.getElementById("checkOutText").textContent =
                    instance.formatDate(selectedDates[1], "d/m/Y");

                const timeDiff = Math.abs(selectedDates[1].getTime() - selectedDates[0].getTime());
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                const basePrice = {{ $property->harga_per_hari ?? 0 }};
                const totalPrice = diffDays * basePrice;
                const formattedPrice = 'IDR ' + new Intl.NumberFormat('id-ID').format(totalPrice);

                document.getElementById("totalPriceText").innerHTML = formattedPrice;
                const startStr = formatDateYmd(selectedDates[0]);
                const endStr = formatDateYmd(selectedDates[1]);
                document.getElementById("hiddenDateRange").value = startStr + ' to ' + endStr;
                document.getElementById("bookingDaysText").textContent = `Untuk ${diffDays} Hari`;
                document.getElementById("calendarDaysText").textContent = `Untuk ${diffDays} Hari (${instance.formatDate(selectedDates[0], "d/m/Y")} - ${instance.formatDate(selectedDates[1], "d/m/Y")})`;
            } else {
                document.getElementById("hiddenDateRange").value = "";
                document.getElementById("totalPriceText").innerHTML = `IDR {{ number_format($property->harga_per_hari, 0, ',', '.') }}<span style="font-size: 16px; font-weight: normal; color: #777;"> / Hari</span>`;
                document.getElementById("bookingDaysText").textContent = "Pilih tanggal";
                document.getElementById("calendarDaysText").textContent = "Pilih rentang tanggal di kalender";
                document.getElementById("checkOutText").textContent = "--/--/----";
                if (selectedDates.length === 0) {
                    document.getElementById("checkInText").textContent = "--/--/----";
                }
            }
        }

        let inlineFp = null;
        if (canBook) {
            inlineFp = flatpickr("#dateRange", {
                locale: "id",
                mode: "range",
                inline: true,
                minDate: "today",
                dateFormat: "Y-m-d",
                showMonths: 2,
                disable: parsedDisable,
                onChange: function(selectedDates, dateStr, instance) {
                    handleDateSelection(selectedDates, dateStr, instance);
                    if (window.popupFp) {
                        window.popupFp.setDate(selectedDates, false);
                    }
                },
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    if (!dayElem.dateObj) return;
                    const dateStrYmd = formatDateYmd(dayElem.dateObj);
                    const isBooked = disabledDates.some(range => {
                        return dateStrYmd >= range.from && dateStrYmd <= range.to;
                    });
                    if (isBooked) {
                        dayElem.classList.add("booked-day");
                        dayElem.setAttribute("data-booked-tooltip", "Tanggal ini sudah dipesan");
                    }
                }
            });

            window.popupFp = flatpickr("#bookingCardCalendarInline", {
                locale: "id",
                mode: "range",
                inline: true,
                minDate: "today",
                dateFormat: "Y-m-d",
                showMonths: 1,
                disable: parsedDisable,
                onChange: function(selectedDates, dateStr, instance) {
                    handleDateSelection(selectedDates, dateStr, instance);
                    if (inlineFp) {
                        inlineFp.setDate(selectedDates, false);
                    }
                },
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    if (!dayElem.dateObj) return;
                    const dateStrYmd = formatDateYmd(dayElem.dateObj);
                    const isBooked = disabledDates.some(range => {
                        return dateStrYmd >= range.from && dateStrYmd <= range.to;
                    });
                    if (isBooked) {
                        dayElem.classList.add("booked-day");
                        dayElem.setAttribute("data-booked-tooltip", "Tanggal ini sudah dipesan");
                    }
                }
            });
        }

        function toggleBookingCardCalendar(event) {
            event.stopPropagation();
            const wrapper = document.getElementById("bookingCardCalendarWrapper");
            if (wrapper.style.display === "none") {
                wrapper.style.display = "block";
            } else {
                wrapper.style.display = "none";
            }
        }

        // Save Wishlist AJAX Handler
        function toggleSave(id) {
            fetch(`/detail-properti/${id}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    const saveBtn = document.querySelector('.save-btn');
                    if (data.saved) {
                        saveBtn.classList.add('saved');
                        saveBtn.querySelector('span').textContent = 'Saved';
                    } else {
                        saveBtn.classList.remove('saved');
                        saveBtn.querySelector('span').textContent = 'Save';
                    }
                }
            })
            .catch(err => console.error(err));
        }

        // Custom Lightbox Gallery
        const galleryItems = document.querySelectorAll('.gallery-item img');
        const lightbox = document.getElementById('lightboxModal');
        const lightboxImg = document.getElementById('lightboxImg');
        const closeBtn = document.querySelector('.lightbox-close');
        const prevBtn = document.querySelector('.lightbox-prev');
        const nextBtn = document.querySelector('.lightbox-next');

        let currentIndex = 0;
        const imagesList = Array.from(galleryItems).map(img => img.src);

        function openLightbox(index) {
            currentIndex = index;
            lightboxImg.src = imagesList[currentIndex];
            lightbox.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('show');
            document.body.style.overflow = '';
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % imagesList.length;
            lightboxImg.style.opacity = '0';
            lightboxImg.style.transform = 'scale(0.97)';
            setTimeout(() => {
                lightboxImg.src = imagesList[currentIndex];
                lightboxImg.style.opacity = '1';
                lightboxImg.style.transform = 'scale(1)';
            }, 100);
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + imagesList.length) % imagesList.length;
            lightboxImg.style.opacity = '0';
            lightboxImg.style.transform = 'scale(0.97)';
            setTimeout(() => {
                lightboxImg.src = imagesList[currentIndex];
                lightboxImg.style.opacity = '1';
                lightboxImg.style.transform = 'scale(1)';
            }, 100);
        }

        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            item.addEventListener('click', () => {
                openLightbox(index);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (nextBtn) nextBtn.addEventListener('click', showNext);
        if (prevBtn) prevBtn.addEventListener('click', showPrev);

        // Close when clicking outside the image
        if (lightbox) {
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
        }

        // Keyboard Controls
        document.addEventListener('keydown', (e) => {
            if (!lightbox || !lightbox.classList.contains('show')) return;
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
            if (e.key === 'Escape') closeLightbox();
        });

        // Custom Alert Modal Function
        function showCustomAlert(message, alertType = 'success') {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'custom-modal-overlay';
                
                overlay.innerHTML = `
                    <div class="custom-modal-box">
                        <div class="custom-modal-icon ${alertType}">
                            \${alertType === 'success' ? '✓' : '!'}
                        </div>
                        <h3>\${alertType === 'success' ? 'Sukses' : 'Gagal'}</h3>
                        <p>\${message}</p>
                        <div class="custom-modal-actions" style="justify-content: center;">
                            <button class="custom-modal-btn ok-btn">OK</button>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(overlay);
                
                setTimeout(() => {
                    overlay.classList.add('active');
                }, 10);
                
                const okBtn = overlay.querySelector('.ok-btn');
                
                function close() {
                    overlay.classList.remove('active');
                    setTimeout(() => {
                        overlay.remove();
                    }, 300);
                }
                
                okBtn.onclick = () => {
                    close();
                    resolve();
                };
                
                overlay.onclick = (e) => {
                    if (e.target === overlay) {
                        close();
                        resolve();
                    }
                };
            });
        }
        window.showCustomAlert = showCustomAlert;

        // Rating & Review submit on Property Detail page
        let currentPropRating = 0;
        function setPropertyRating(rating) {
            currentPropRating = rating;
            document.getElementById('propertyRatingValue').value = rating;
            const stars = document.querySelectorAll('.star-input-prop');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = '#f7c948'; // Gold
                } else {
                    star.style.color = '#d1d5db'; // Grey
                }
            });
        }
        window.setPropertyRating = setPropertyRating;

        function submitPropertyReview(event, bookingId) {
            event.preventDefault();
            const rating = document.getElementById('propertyRatingValue').value;
            const komentar = document.getElementById('propertyReviewKomentar').value;

            if (!rating) {
                showCustomAlert('Silakan pilih rating bintang terlebih dahulu.', 'danger');
                return;
            }

            fetch(`/booking/${bookingId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    rating: rating,
                    komentar: komentar
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal mengirim ulasan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting review:', error);
                showCustomAlert('Terjadi kesalahan saat mengirim ulasan.', 'danger');
            });
        }
        window.submitPropertyReview = submitPropertyReview;

        // Feedback reply submit on Property Detail page
        function submitPropertyFeedback(event, reviewId) {
            event.preventDefault();
            const text = document.getElementById(`propertyFeedbackText-\${reviewId}`).value;

            if (!text.trim()) {
                showCustomAlert('Silakan tulis tanggapan terlebih dahulu.', 'danger');
                return;
            }

            fetch(`/mitra/review/\${reviewId}/feedback`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    balasan_mitra: text
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert(data.message, 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    showCustomAlert(data.message || 'Gagal mengirim tanggapan.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting feedback:', error);
                showCustomAlert('Terjadi kesalahan saat mengirim tanggapan.', 'danger');
            });
        }
        window.submitPropertyFeedback = submitPropertyFeedback;
    </script>
@endsection
