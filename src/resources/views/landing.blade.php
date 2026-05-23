<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotRent</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7f7f7;
            color: #222;
        }

        .hero {
            width: 100%;
            height: 520px;
            border-radius: 0 0 40px 40px;
            background:
                linear-gradient(rgba(0, 0, 0, .45), rgba(0, 0, 0, .45)),
                url('/images/landing/hero.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 28px 34px;
            color: white;
            overflow: hidden;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 22px;
            color: white;
        }

        .logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-buttons a {
            background: #f7c948;
            color: #111;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            margin-left: 10px;
        }

        .hero-title {
            text-align: center;
            margin-top: 60px;
            font-size: 53px;
            line-height: 1.2;
            font-weight: 800;
        }

        .search-box {
            width: 58%;
            height: 78px;
            background: white;
            border-radius: 999px;
            position: absolute;
            left: 50%;
            bottom: 90px;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            padding: 0 10px 0 28px;
            color: #333;
        }

        .search-item {
            flex: 1;
            font-size: 17px;
            font-weight: 600;
            border-right: 1px solid #ddd;
            padding-left: 8px;
        }

        .search-item:last-of-type {
            border-right: none;
        }

        .search-item span {
            display: block;
            color: #777;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 400;
        }

        .search-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            background: #f7c948;
            font-size: 34px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .property-section {
            width: 82%;
            margin: 110px auto 70px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 12px 16px 16px;
        }

        .card-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .category {
            font-size: 13px;
            color: #444;
        }

        .price {
            font-size: 13px;
            font-weight: 700;
            color: #111;
        }

        .location {
            font-size: 12px;
            color: #e74c3c;
        }

        .rating {
            font-size: 12px;
            color: #777;
        }

        .card-title {
            font-size: 17px;
            font-weight: 800;
            margin-top: 6px;
            color: #111;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 28px;
            }

            .search-box {
                width: 90%;
                height: auto;
                padding: 15px;
                flex-direction: column;
                gap: 15px;
                border-radius: 20px;
            }

            .search-item {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
            }

            .property-section {
                width: 90%;
                grid-template-columns: 1fr;
            }

            .card-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <section class="hero">
        <div class="navbar">
            <div class="logo">
                <img src="/images/logo.png" alt="Logo">
                <span>SpotRent</span>
            </div>

            <div class="nav-buttons">
                <a href="#">Daftarkan Properti</a>
                <a href="/login">Daftar / Masuk</a>
            </div>
        </div>

        <h1 class="hero-title">
            Temukan Lokasi Syuting Terbaik <br>
            Dalam Sekejap
        </h1>

        <div class="search-box">
            <div class="search-item">
                <span>Lokasi</span>
                All
            </div>

            <div class="search-item">
                <span>Tipe Properti</span>
                All
            </div>

            <div class="search-item">
                <span>Harga</span>
                All
            </div>

            <button class="search-button">›</button>
        </div>
    </section>

    <section class="property-section">
        @for ($i = 0; $i < 9; $i++)
            <div class="card">
                <img src="/images/landing/property.jpg" alt="Property">

                <div class="card-content">
                    <div class="card-row">
                        <span class="category">Komersial</span>
                        <span class="price">IDR 15.000.000</span>
                    </div>

                    <div class="card-row">
                        <span class="location">📍 Jakarta Barat</span>
                        <span class="rating">⭐ 4.9 (70)</span>
                    </div>

                    <div class="card-title">
                        Kota Tua Jakarta
                    </div>
                </div>
            </div>
        @endfor
    </section>

</body>

</html>
