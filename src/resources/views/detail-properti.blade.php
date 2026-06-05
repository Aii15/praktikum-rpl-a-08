<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $property->nama_properti }} - Detail Properti</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ asset('css/detail-properti.css') }}">
</head>

<body>

    <nav class="navbar">
        <div class="logo" onclick="window.location.href='/'" style="cursor: pointer;">
            <img src="/images/logo.png" alt="Logo">
            <span>SpotRent</span>
        </div>

        <div class="nav-buttons">
            @auth
                <a href="{{ route('dashboard') }}" style="background: #f7c948; color: #111; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 700; margin-left: 10px; display: inline-block;">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline-block; margin-left: 10px;">
                    @csrf
                    <button type="submit" style="background: #dc3545; color: white; border: none; border-radius: 10px; padding: 10px 18px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Poppins', sans-serif;">Logout</button>
                </form>
            @else
                <a href="/login" style="background: #f7c948; color: #111; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 700; margin-left: 10px; display: inline-block;">Daftar / Masuk</a>
            @endauth
        </div>
    </nav>

    <div class="detail-page">

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
            <a href="/" class="back-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 2px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali Ke Daftar Properti
            </a>

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

        <section class="gallery">
            @php
                $cover = $property->coverPhoto ?? $property->photos->first();
                $otherPhotos = $property->photos->where('id_foto', '!=', $cover->id_foto ?? null)->take(4);
            @endphp
            <div class="gallery-item main-gallery-item">
                <img class="main-img" src="{{ $cover->url_foto ?? '/images/landing/property.png' }}" alt="{{ $property->nama_properti }}">
            </div>

            <div class="side-gallery">
                @foreach ($otherPhotos as $photo)
                    <div class="gallery-item">
                        <img src="{{ $photo->url_foto }}" alt="">
                    </div>
                @endforeach
                @for ($i = count($otherPhotos); $i < 4; $i++)
                    <div class="gallery-item">
                        <img src="/images/landing/property.png" alt="">
                    </div>
                @endfor
            </div>
        </section>

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
                            <div class="info-title">Tipe Properti</div>
                            <div class="info-desc">{{ $property->category->nama_kategori }}</div>
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
                            $facs = array_map('trim', explode(',', $property->fasilitas));
                            $iconMap = [
                                'sanitasi' => 'sanitasi.svg',
                                'listrik' => 'listrik.svg',
                                'penerangan' => 'listrik.svg',
                                'cctv' => 'cctv.svg',
                                'parkir' => 'parkir.svg',
                                'sprinkler' => 'sprinkler.svg',
                                'permit' => 'permit.svg',
                                'perizinan' => 'permit.svg',
                                'apar' => 'apar.svg',
                                'outdoor' => 'outdoor.svg',
                            ];
                        @endphp
                        @foreach ($facs as $fac)
                            @if (!empty($fac))
                                @php
                                    $foundIcon = 'permit.svg';
                                    $facLower = strtolower($fac);
                                    foreach ($iconMap as $key => $icon) {
                                        if (str_contains($facLower, $key)) {
                                            $foundIcon = $icon;
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="spec-item">
                                    <img src="/images/informasi/icons/{{ $foundIcon }}" alt="">
                                    <span>{{ $fac }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <hr>

                    <div class="calendar-section">
                        <h2>IDR {{ number_format($property->harga_per_periode, 0, ',', '.') }}</h2>
                        <p id="calendarDaysText">Pilih rentang tanggal di kalender</p>

                        <input type="text" id="dateRange">
                    </div>

                </div>

                <aside class="booking-card">
                    <h2>IDR {{ number_format($property->harga_per_periode, 0, ',', '.') }}</h2>
                    <p id="bookingDaysText">Pilih tanggal</p>

                    <div class="date-box">
                        <div class="date-item">
                            <b>Check-in</b>
                            <span id="checkInText">--/--/----</span>
                        </div>

                        <div class="date-item">
                            <b>Check-out</b>
                            <span id="checkOutText">--/--/----</span>
                        </div>
                    </div>

                    <button type="submit">Pesan</button>
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

                        <p class="review-text">
                            {{ $review->komentar }}
                        </p>
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

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Initialize Flatpickr with seeded disabled dates
        const disabledDates = @json($disabledDates);
        const parsedDisable = disabledDates.map(range => {
            return {
                from: new Date(range.from),
                to: new Date(range.to)
            };
        });

        flatpickr("#dateRange", {
            mode: "range",
            inline: true,
            minDate: "today",
            dateFormat: "Y-m-d",
            showMonths: 2,
            disable: parsedDisable,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length >= 1) {
                    document.getElementById("checkInText").textContent =
                        instance.formatDate(selectedDates[0], "d/m/Y");
                }

                if (selectedDates.length === 2) {
                    document.getElementById("checkOutText").textContent =
                        instance.formatDate(selectedDates[1], "d/m/Y");

                    const timeDiff = Math.abs(selectedDates[1].getTime() - selectedDates[0].getTime());
                    const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                    document.getElementById("hiddenDateRange").value = dateStr;
                    document.getElementById("bookingDaysText").textContent = `Untuk ${diffDays} Hari`;
                    document.getElementById("calendarDaysText").textContent = `Untuk ${diffDays} Hari (${instance.formatDate(selectedDates[0], "d/m/Y")} - ${instance.formatDate(selectedDates[1], "d/m/Y")})`;
                } else {
                    document.getElementById("hiddenDateRange").value = "";
                }
            }
        });

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
    </script>
</body>

</html>
