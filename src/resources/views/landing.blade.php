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
                font-family: 'Poppins', sans-serif;
            }

            body {
                background: #f7f7f7;
                color: #222;
            }

            .hero {
                width: 100%;
                height: 550px;
                border-radius: 0 0 40px 40px;
                position: relative;
                overflow: visible;
                padding: 28px 34px;
                color: white;

                background:
                    linear-gradient(rgba(0, 0, 0, .45), rgba(0, 0, 0, .45)),
                    url('/images/landing/hero.png');

                background-size: 115%;
                background-repeat: no-repeat;
                background-position: center 65%;
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

            .search-wrapper {
                position: absolute;
                left: 50%;
                bottom: 90px;
                transform: translateX(-50%);
                width: 58%;
                z-index: 999;
            }

            .search-wrapper {
                position: absolute;
                left: 50%;
                bottom: 90px;
                transform: translateX(-50%);
                width: 58%;
                z-index: 999;
            }

            .search-box {
                width: 100%;
                height: 86px;
                background: #eef1f4;
                border-radius: 38px;
                display: flex;
                align-items: center;
                padding: 0 10px 0 20px;
                box-shadow: 0 0 14px rgba(255, 255, 255, .45);
            }

            .search-item {
                flex: 1;
                height: 64px;
                background: transparent;
                border: none;
                text-align: left;
                padding: 10px 22px;
                cursor: pointer;
                position: relative;
                border-radius: 14px;
            }

            .search-item::after {
                content: "";
                position: absolute;
                right: 0;
                top: 16px;
                width: 1px;
                height: 38px;
                background: #8f8f8f;
                z-index: 5;
            }

            .search-item:last-of-type::after {
                display: none;
            }

            .search-item.active {
                background: transparent;
                box-shadow: none;
                padding: 10px 22px;
            }


            .search-item.active::before {
                content: "";
                position: absolute;
                top: 6px;
                bottom: 6px;
                left: 8px;
                right: 8px;

                background: #edf0f3;
                border-radius: 14px;

                box-shadow:
                    inset 2px 2px 6px rgba(0, 0, 0, .20),
                    inset -2px -2px 6px rgba(255, 255, 255, .95);

                z-index: 1;
            }

            .search-item span {
                display: block;
                color: #222;
                margin-bottom: 8px;
                font-size: 15px;
                font-weight: 400;

                position: relative;
                z-index: 10;
            }

            .search-item strong {
                color: #000;
                font-size: 16px;
                font-weight: 500;
                position: relative;
                z-index: 10;
            }

            .search-item:nth-last-of-type(2)::after {
                display: none;
            }

            .search-button {
                width: 60px;
                height: 60px;
                border-radius: 24px;
                border: none;
                background: #f7c948;
                font-size: 50px;
                cursor: pointer;
                flex-shrink: 0;
                padding-bottom: 10px;

                display: flex;
                align-items: center;
                justify-content: center;
                line-height: 1;
            }

            .dropdown {
                display: none;
                position: absolute;
                background: #eef1f4;
                border-radius: 14px;
                box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
                padding: 22px 28px;
                color: #111;
                z-index: 1000;
            }

            .dropdown.show {
                display: grid;
            }

            .dropdown button {
                background: transparent;
                border: none;
                text-align: left;
                font-size: 15px;
                font-weight: 400;
                cursor: pointer;
                padding: 10px 14px;
                border-radius: 12px;
                transition: all 0.15s ease;
                white-space: nowrap;
            }

            .dropdown button:hover {
                background: #edf0f3;
                box-shadow:
                    inset 2px 2px 6px rgba(0, 0, 0, .10),
                    inset -2px -2px 6px rgba(255, 255, 255, .95);
            }

            .location-dropdown {
                width: 700px;
                grid-template-columns: repeat(4, 1fr);
                gap: 24px 42px;
                left: -180px;
                top: 95px;
            }

            .type-dropdown {
                width: 400px;
                grid-template-columns: repeat(2, 1fr);
                gap: 24px 35px;
                left: 170px;
                top: 95px;
            }

            .price-dropdown {
                width: 400px;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                right: 20px;
                top: 95px;
            }

            .type-dropdown img {
                width: 18px;
                height: 18px;
                object-fit: contain;
                margin-right: 10px;
                vertical-align: middle;
            }

            .property-section {
                width: 78%;
                margin: 60px auto;
                display: grid;
                grid-template-columns: repeat(3, 340px);
                justify-content: center;
                gap: 50px 80px;
            }

            .card {
                width: 340px;
                background: #fff;
                border: 1px solid #d6d6d6;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            }

            .card img {
                width: 100%;
                height: 210px;
                object-fit: cover;
                object-position: center 60%;
                display: block;
            }

            .card-content {
                padding: 16px 18px 20px;
            }

            .card-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .category {
                font-size: 16px;
                font-weight: 400;
                color: #333;
            }

            .price-box {
                text-align: right;
            }

            .price {
                font-size: 14px;
                font-weight: 700;
                color: #111;
            }

            .price-box small {
                display: block;
                font-size: 11px;
                color: #777;
                margin-top: 2px;
            }

            .card-divider {
                height: 1px;
                background: #cfcfcf;
                margin: 10px 0;
            }

            .location,
            .rating {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 14px;
                color: #444;
            }

            .location img,
            .rating img {
                width: 16px;
                height: 16px;
                object-fit: contain;
                display: block;
            }

            .card-title {
                margin-top: 14px;
                font-size: 18px;
                font-weight: 700;
                color: #111;
            }

            .footer {
                background: #020f3a;
                color: white;
                margin-top: 80px;
                padding: 70px 90px 30px;
            }

            .footer-container {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 60px;
                flex-wrap: wrap;
            }

            .footer-brand {
                display: flex;
                align-items: center;
                gap: 18px;
                min-width: 250px;
            }

            .footer-brand img {
                width: 70px;
                height: 70px;
                object-fit: contain;
            }

            .footer-brand h2 {
                font-size: 42px;
                font-weight: 700;
                margin: 0;
            }

            .footer-links {
                display: flex;
                flex-direction: column;
                gap: 16px;
                min-width: 180px;
            }

            .footer-links h4 {
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 12px;
            }

            .footer-links a {
                color: white;
                text-decoration: none;
                font-size: 16px;
                font-weight: 400;
                transition: 0.2s;
            }

            .footer-links a:hover {
                opacity: 0.7;
            }

            .footer-bottom {
                text-align: center;
                margin-top: 55px;
                font-size: 16px;
                font-weight: 400;
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
                    <a href="/login">Daftar / Masuk</a>
                </div>
            </div>

            <h1 class="hero-title">
                Temukan Lokasi Syuting Terbaik <br>
                Dalam Sekejap
            </h1>

            <div class="search-wrapper">
                <div class="search-box">
                    <button class="search-item" onclick="toggleDropdown('locationDropdown')">
                        <span>Lokasi</span>
                        <strong id="locationValue">{{ $selectedLocation ?? 'All' }}</strong>
                    </button>

                    <button class="search-item" onclick="toggleDropdown('typeDropdown')">
                        <span>Tipe Properti</span>
                        <strong id="typeValue">{{ $selectedCategory ?? 'All' }}</strong>
                    </button>

                    <button class="search-item" onclick="toggleDropdown('priceDropdown')">
                        <span>Harga</span>
                        <strong id="priceValue">{{ $selectedPrice ?? 'All' }}</strong>
                    </button>

                    <button class="search-button" onclick="searchProperties()">›</button>
                </div>

                <div class="dropdown location-dropdown" id="locationDropdown">
                    <button data-value="All" onclick="selectValue('locationValue', this.dataset.value)">All</button>
                    @foreach ($locations as $location)
                        <button data-value="{{ e($location->kota) }}" onclick="selectValue('locationValue', this.dataset.value)">{{ $location->kota }}</button>
                    @endforeach
                </div>

                <div class="dropdown type-dropdown" id="typeDropdown">
                    <button data-value="All" onclick="selectValue('typeValue', this.dataset.value)">All</button>
                    <button data-value="Hunian" onclick="selectValue('typeValue', this.dataset.value)"><img src="/images/landing/icons/hunian.png">
                        Hunian</button>
                    <button data-value="Heritage" onclick="selectValue('typeValue', this.dataset.value)"><img
                            src="/images/landing/icons/heritage.png">
                        Heritage</button>
                    <button data-value="Lanskap" onclick="selectValue('typeValue', this.dataset.value)"><img src="/images/landing/icons/lanskap.png">
                        Lanskap</button>
                    <button data-value="Fasilitas Publik" onclick="selectValue('typeValue', this.dataset.value)"><img
                            src="/images/landing/icons/fasilitas.png">
                        Fasilitas Publik</button>
                    <button data-value="Komersial" onclick="selectValue('typeValue', this.dataset.value)"><img
                            src="/images/landing/icons/komersial.png">
                        Komersial</button>
                    <button data-value="Studio" onclick="selectValue('typeValue', this.dataset.value)"><img src="/images/landing/icons/studio.png">
                        Studio</button>
                    <button data-value="Industrial" onclick="selectValue('typeValue', this.dataset.value)"><img
                            src="/images/landing/icons/industrial.png">
                        Industrial</button>
                </div>

                <div class="dropdown price-dropdown" id="priceDropdown">
                    <button data-value="All" onclick="selectValue('priceValue', this.dataset.value)">All</button>
                    <button data-value="Harga Terendah" onclick="selectValue('priceValue', this.dataset.value)">Rp. Harga Terendah</button>
                    <button data-value="Harga Tertinggi" onclick="selectValue('priceValue', this.dataset.value)">Rp. Harga Tertinggi</button>
                </div>
            </div>
        </section>

        <section class="property-section">
            @forelse ($properties as $property)
                <div class="card">
                    <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $property->nama_properti }}">

                    <div class="card-content">

                        <div class="card-row top-row">
                            <span class="category">{{ $property->category->nama_kategori ?? 'Kategori Lain' }}</span>

                            <div class="price-box">
                                <span class="price">IDR {{ number_format($property->harga_per_periode, 0, ',', '.') }}</span>
                                <small>Untuk 7 Hari</small>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="card-row middle-row">
                            <div class="location">
                                <img src="/images/landing/icons/location.png" alt="Location">
                                <span>{{ $property->location->kota ?? 'Lokasi Tidak Diketahui' }}</span>
                            </div>

                            <div class="rating">
                                <img src="/images/landing/icons/star.png" alt="Star">
                                <span>{{ number_format($property->reviews->avg('rating') ?? 0, 1) }} ({{ $property->reviews->count() }})</span>
                            </div>
                        </div>

                        <h3 class="card-title">{{ $property->nama_properti }}</h3>

                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 40px 0; color: #555; font-size: 18px;">
                    Tidak ada properti yang sesuai dengan filter.
                </div>
            @endforelse
        </section>

        <footer class="footer">
            <div class="footer-container">

                <div class="footer-brand">
                    <img src="/images/logo.png" alt="SpotRent Logo">
                    <h2>SpotRent</h2>
                </div>

                <div class="footer-links">
                    <h4>Terms of Service</h4>
                    <a href="#">Cookie Policy</a>
                    <a href="#">Privacy Police</a>
                    <a href="#">Terms of Service</a>
                </div>

                <div class="footer-links">
                    <h4>Our Official Social Media</h4>
                    <a href="#">Instagram</a>
                    <a href="#">Facebook</a>
                    <a href="#">X</a>
                </div>

                <div class="footer-links">
                    <h4>Support</h4>
                    <a href="#">Help Center</a>
                    <a href="#">Cancellation options</a>
                </div>

            </div>

            <div class="footer-bottom">
                ©Copyright SpotRent 2026. All Rights Reserved.
            </div>
        </footer>

        <script>
            const selectedFilters = {
                locationValue: "{{ $selectedLocation ?? 'All' }}",
                typeValue: "{{ $selectedCategory ?? 'All' }}",
                priceValue: "{{ $selectedPrice ?? 'All' }}",
            };

            function toggleDropdown(id) {
                const clickedButton = event?.currentTarget || null;

                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    if (dropdown.id !== id) {
                        dropdown.classList.remove('show');
                    }
                });

                document.querySelectorAll('.search-item').forEach(item => {
                    item.classList.remove('active');
                });

                if (clickedButton) {
                    clickedButton.classList.add('active');
                }

                document.getElementById(id).classList.toggle('show');
            }

            function selectValue(targetId, value) {
                document.getElementById(targetId).textContent = value;
                selectedFilters[targetId] = value;

                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });

                document.querySelectorAll('.search-item').forEach(item => {
                    item.classList.remove('active');
                });
            }

            function searchProperties() {
                const params = new URLSearchParams();

                if (selectedFilters.locationValue && selectedFilters.locationValue !== 'All') {
                    params.set('location', selectedFilters.locationValue);
                }

                if (selectedFilters.typeValue && selectedFilters.typeValue !== 'All') {
                    params.set('category', selectedFilters.typeValue);
                }

                if (selectedFilters.priceValue && selectedFilters.priceValue !== 'All') {
                    params.set('price', selectedFilters.priceValue);
                }

                const queryString = params.toString();
                window.location.href = queryString ? `/?${queryString}` : '/';
            }
        </script>
    </body>

    </html>
