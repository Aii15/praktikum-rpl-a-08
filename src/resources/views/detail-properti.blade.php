<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Properti</title>

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
        <div class="logo">
            <img src="/images/logo.png" alt="Logo">
            <span>SpotRent</span>
        </div>

        <div class="nav-buttons">
            <a href="#">Daftarkan Properti</a>
            <a href="/login">Daftar / Masuk</a>
        </div>
    </nav>

    <div class="detail-page">

        <div class="top-header-actions">
            <a href="/" class="back-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 2px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali Ke Daftar Properti
            </a>

            <div class="top-actions">
                <button class="save-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="save-icon">
                        <path d="M0 0h48v48H0z" fill="none" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M15 8C8.925 8 4 12.925 4 19c0 11 13 21 20 23.326C31 40 44 30 44 19c0-6.075-4.925-11-11-11c-3.72 0-7.01 1.847-9 4.674A10.99 10.99 0 0 0 15 8" />
                    </svg>
                    <span>Save</span>
                </button>
            </div>
        </div>

        <section class="gallery">
            <div class="gallery-item main-gallery-item">
                <img class="main-img" src="/images/informasi/prop1.png" alt="Lawang Sewu">
            </div>

            <div class="side-gallery">
                <div class="gallery-item">
                    <img src="/images/informasi/prop2.png" alt="">
                </div>
                <div class="gallery-item">
                    <img src="/images/informasi/prop3.png" alt="">
                </div>
                <div class="gallery-item">
                    <img src="/images/informasi/prop4.png" alt="">
                </div>
                <div class="gallery-item">
                    <img src="/images/informasi/prop5.png" alt="">
                </div>
            </div>
        </section>

        <section class="content-wrapper">

            <div class="left-content">
                <h1 class="property-title">Lawang Sewu</h1>
                <p class="property-subtitle">
                    Bangunan Bersejarah Terkenal Di Kota Semarang, Jawa Tengah.
                </p>

                <div class="info-box">
                    <div class="info-item">
                        <img src="/images/informasi/icons/location.svg" alt="" class="info-img">
                        <div class="info-title">Semarang</div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">Tipe Properti</div>
                        <div class="info-desc">Heritage</div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">4.9</div>
                        <div class="star-icons">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-title">70</div>
                        <div class="info-desc">Reviews</div>
                    </div>
                </div>

                <div class="owner">
                    <div class="avatar">KAI</div>
                    <div>
                        <b>PT. Kereta Api Wisata</b>
                        <p>Pengelola Operasional</p>
                    </div>
                </div>

                <hr>

                <p class="description">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Integer at erat fringilla, ullamcorper tortor at, fermentum ex.
                    Duis ac elit egestas metus tempor tempor.
                    Quisque turpis sapien, facilisis sit amet est at,
                    interdum eleifend est.
                </p>

                <hr>

                <h3 class="section-title">Spesifikasi Properti</h3>

                <div class="spec-grid">
                    <div class="spec-item">
                        <img src="/images/informasi/icons/sanitasi.svg" alt="">
                        <span>Sanitasi</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/listrik.svg" alt="">
                        <span>Listrik dan Penerangan</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/cctv.svg" alt="">
                        <span>CCTV</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/parkir.svg" alt="">
                        <span>Parkir Mobil</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/sprinkler.svg" alt="">
                        <span>Sprinkler Water</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/permit.svg" alt="">
                        <span>Permit Included</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/apar.svg" alt="">
                        <span>APAR</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/outdoor.svg" alt="">
                        <span>Outdoor</span>
                    </div>
                </div>

                <hr>

                <div class="calendar-section">
                    <h2>IDR 150.000.000</h2>
                    <p>Untuk 3 Hari (DD-MM-YY - DD-MM-YY)</p>

                    <input type="text" id="dateRange">
                </div>

            </div>

            <aside class="booking-card">
                <h2>IDR 150.000.000</h2>
                <p>Untuk 3 Hari</p>

                <div class="date-box">
                    <div class="date-item">
                        <b>Check-in</b>
                        <span id="checkInText">12/05/2026</span>
                    </div>

                    <div class="date-item">
                        <b>Check-out</b>
                        <span id="checkOutText">12/05/2026</span>
                    </div>
                </div>

                <button>Pesan</button>
            </aside>

        </section>

        <section class="rating-section">
            <div class="rating-summary">
                <div class="rating-score">
                    <h2>4.9</h2>
                    <div class="big-stars">
                        <img src="/images/informasi/icons/star.png" alt="">
                        <img src="/images/informasi/icons/star.png" alt="">
                        <img src="/images/informasi/icons/star.png" alt="">
                        <img src="/images/informasi/icons/star.png" alt="">
                        <img src="/images/informasi/icons/star.png" alt="">
                    </div>
                </div>

                <div class="rating-bars">
                    <p>Overall Rating</p>

                    <div class="rating-lines">
                        <div class="bar-row"><span>5</span>
                            <div></div>
                        </div>
                        <div class="bar-row"><span>4</span>
                            <div></div>
                        </div>
                        <div class="bar-row"><span>3</span>
                            <div></div>
                        </div>
                        <div class="bar-row"><span>2</span>
                            <div></div>
                        </div>
                        <div class="bar-row"><span>1</span>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-grid">
                @for ($i = 0; $i < 6; $i++)
                    <div class="review-card">
                        <div class="review-head">
                            <div class="review-avatar">P</div>
                            <div>
                                <b>Name</b>
                                <p>DD-MM-YY</p>
                            </div>
                        </div>

                        <div class="review-stars">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                            <img src="/images/informasi/icons/star.png" alt="">
                        </div>

                        <p class="review-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Integer at erat fringilla, ullamcorper tortor at.
                        </p>
                    </div>
                @endfor
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
        // Initialize Flatpickr
        flatpickr("#dateRange", {
            mode: "range",
            inline: true,
            minDate: "today",
            dateFormat: "d/m/Y",
            showMonths: 2,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length >= 1) {
                    document.getElementById("checkInText").textContent =
                        instance.formatDate(selectedDates[0], "d/m/Y");
                }

                if (selectedDates.length === 2) {
                    document.getElementById("checkOutText").textContent =
                        instance.formatDate(selectedDates[1], "d/m/Y");
                }
            }
        });

        // Save Button Toggle State
        const saveBtn = document.querySelector('.save-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', () => {
                saveBtn.classList.toggle('saved');
                const span = saveBtn.querySelector('span');
                if (span) {
                    span.textContent = saveBtn.classList.contains('saved') ? 'Saved' : 'Save';
                }
            });
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
