<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Properti</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f7f7f7;
            color: #222;
        }

        .detail-page {
            width: 100%;
            min-height: 100vh;
            background: white;
            padding: 34px 60px 60px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: 700;
        }

        .logo img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .nav-buttons a {
            background: #f7c948;
            color: #111;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 12px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 28px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .top-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 18px;
        }

        .top-actions button {
            border: none;
            border-radius: 8px;
            padding: 9px 15px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .share-btn {
            background: #111b3d;
            color: white;
        }

        .save-btn {
            background: #e7192f;
            color: white;
        }

        .gallery {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }

        .main-img,
        .side-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .main-img {
            height: 360px;
        }

        .side-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .side-gallery img {
            height: 173px;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 70px;
            align-items: start;
        }

        .property-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .property-subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 28px;
        }

        .info-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border: 1px solid #d8d8d8;
            border-radius: 12px;
            padding: 18px 10px;
            margin-bottom: 36px;
        }

        .info-item {
            min-height: 76px;
            text-align: center;
            border-right: 1px solid #bdbdbd;
            font-size: 13px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4px;
        }

        .info-item:last-child {
            border-right: none;
        }

        .info-img {
            width: 24px;
            height: 24px;
            object-fit: contain;
            margin-bottom: 3px;
        }

        .info-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            line-height: 1.2;
        }

        .info-desc {
            color: #555;
            font-size: 13px;
            line-height: 1.2;
        }

        .star-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3px;
            margin-top: 5px;
        }

        .star-icons img {
            width: 13px;
            height: 13px;
            object-fit: contain;
            display: block;
        }

        .owner {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            background: #33aa4a;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
        }

        .owner b {
            font-size: 15px;
        }

        .owner p {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
        }

        hr {
            border: none;
            border-top: 1px solid #aaa;
            margin: 26px 0;
        }

        .description {
            font-size: 13px;
            line-height: 1.7;
            color: #555;
            text-align: justify;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .spec-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px 70px;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #333;
        }

        .spec-item img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .booking-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.18);
            margin-top: 80px;

            position: sticky;
            top: 100px;
            align-self: start;
        }

        .booking-card h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .booking-card p {
            color: #666;
            font-size: 14px;
            margin-bottom: 26px;
        }

        .date-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid #222;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 26px;
        }

        .date-item {
            padding: 10px 8px;
            border-right: 1px solid #222;
        }

        .date-item:last-child {
            border-right: none;
        }

        .date-item b {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .date-item span {
            font-size: 13px;
            color: #222;
        }

        .booking-card button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #f7c948;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .booking-card button:hover {
            opacity: 0.9;
        }

        .calendar-section {
            margin-top: 36px;
            max-width: 760px;
        }

        .calendar-section h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .calendar-section p {
            font-size: 14px;
            color: #666;
            margin-bottom: 24px;
        }

        .calendar-section #dateRange {
            display: none;
        }

        .rating-section {
            margin-top: 80px;
            width: 100%;
            max-width: none;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            gap: 90px;
            width: 100%;
            margin-bottom: 50px;
        }

        .rating-score {
            width: 140px;
            text-align: center;
            flex-shrink: 0;
        }

        .rating-score h2 {
            font-size: 48px;
            font-weight: 500;
            line-height: 1;
            margin-bottom: 10px;
        }

        .big-stars {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .big-stars img {
            width: 23px;
            height: 23px;
            object-fit: contain;
        }

        .rating-bars {
            flex: 1;
            width: 100%;
            max-width: none;
        }

        .rating-bars p {
            text-align: center;
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 22px;
        }

        .rating-lines {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            width: 100%;
        }

        .bar-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .bar-row span {
            font-size: 11px;
            font-weight: 500;
        }

        .bar-row div {
            flex: 1;
            height: 4px;
            background: #999;
            border-radius: 999px;
        }

        .review-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px 70px;
        }

        .review-card {
            border: 1px solid #cfcfcf;
            border-radius: 12px;
            padding: 14px;
        }

        .review-head {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .review-avatar {
            width: 30px;
            height: 30px;
            background: #2fa84f;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-head b {
            font-size: 13px;
        }

        .review-head p {
            font-size: 10px;
            color: #777;
        }

        .review-stars {
            display: flex;
            gap: 3px;
            margin: 12px 0;
        }

        .review-stars img {
            width: 12px;
            height: 12px;
        }

        .review-text {
            font-size: 11px;
            line-height: 1.5;
            color: #444;
        }

        .action-buttons {
            display: flex;
            gap: 14px;
        }

        .action-buttons button {
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            color: white;
        }

        .action-buttons img {
            width: 15px;
            height: 15px;
            object-fit: contain;
        }

        .share-btn {
            background: #0b1d57;
        }

        .save-btn {
            background: #ef233c;
        }
    </style>
</head>


<body>
    <div class="detail-page">

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

        <a href="/" class="back-link">← Kembali Ke Daftar Properti</a>

        <div class="top-actions">
            <button class="share-btn">
                <img src="/images/informasi/icons/share.png" alt="Share">
                <span>Share</span>
            </button>

            <button class="save-btn">
                <img src="/images/informasi/icons/like.png" alt="Save">
                <span>Save</span>
            </button>
        </div>

        <section class="gallery">
            <img class="main-img" src="/images/informasi/prop1.png" alt="Lawang Sewu">

            <div class="side-gallery">
                <img src="/images/informasi/prop2.png" alt="">
                <img src="/images/informasi/prop3.png" alt="">
                <img src="/images/informasi/prop4.png" alt="">
                <img src="/images/informasi/prop5.png" alt="">
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
                        <img src="/images/informasi/icons/location.png" alt="" class="info-img">
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
                        <img src="/images/informasi/icons/sanitasi.png" alt="">
                        <span>Sanitasi</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/listrik.png" alt="">
                        <span>Listrik dan Penerangan</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/cctv.png" alt="">
                        <span>CCTV</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/parkir.png" alt="">
                        <span>Parkir Mobil</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/sprinkler.png" alt="">
                        <span>Sprinkler Water</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/permit.png" alt="">
                        <span>Permit Included</span>
                    </div>

                    <div class="spec-item">
                        <img src="/images/informasi/icons/apar.png" alt="">
                        <span>APAR</span>
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
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
    </script>

</body>

</html>
