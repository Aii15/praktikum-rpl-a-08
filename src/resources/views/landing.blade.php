@extends('layouts.app')

@section('title', 'SpotRent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section('content')
    <section class="hero">
        @include('partials.navbar', ['class' => 'landing-navbar'])

            <h1 class="hero-title">
                Temukan Lokasi Syuting Terbaik <br>
                Dalam Sekejap
            </h1>

            <div class="search-wrapper">
                <div class="search-box">
                    <button class="search-item" onclick="toggleDropdown('locationDropdown', event)">
                        <span>Lokasi</span>
                        <strong id="locationValue">{{ $selectedLocation ?? 'All' }}</strong>
                    </button>

                    <button class="search-item" onclick="toggleDropdown('typeDropdown', event)">
                        <span>Tipe Properti</span>
                        <strong id="typeValue">{{ $selectedCategory ?? 'All' }}</strong>
                    </button>

                    <button class="search-item" onclick="toggleDropdown('priceDropdown', event)" style="display: flex; align-items: center; gap: 10px;">
                        <img src="/images/landing/icons/arrow_sort.svg" alt="Sort" style="width: 26px; height: 26px; object-fit: contain; position: relative; z-index: 10; flex-shrink: 0;">
                        <strong id="priceValue" style="white-space: nowrap; margin-top: 0; line-height: 1;">{{ $selectedPrice ?? 'All' }}</strong>
                    </button>

                    <button class="search-button" onclick="searchProperties()">›</button>
                </div>

                <div class="dropdown location-dropdown" id="locationDropdown">
                    <div style="grid-column: span 4; margin-bottom: 8px;">
                        <input type="text" id="locationSearchInput" placeholder="Cari kota..." onkeyup="filterLocations()" style="width: 100%; padding: 10px 14px; border: 1px solid #cfcfcf; border-radius: 12px; font-size: 14px; outline: none; background: white; font-family: 'Poppins', sans-serif;">
                    </div>
                    <button class="location-btn" data-value="All" onclick="selectValue('locationValue', this.dataset.value)">All</button>
                    @foreach ($locations as $location)
                        <button class="location-btn" data-value="{{ e($location->kota) }}" onclick="selectValue('locationValue', this.dataset.value)">{{ $location->kota }}</button>
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

        <section class="property-section" id="propertySection">
            @forelse ($properties as $property)
                <a href="{{ route('detail-properti', $property->id_properti) }}" class="card" 
                     data-location="{{ $property->location->kota ?? '' }}" 
                     data-category="{{ $property->category->nama_kategori ?? '' }}" 
                     data-price="{{ $property->harga_per_periode }}">
                    <img src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $property->nama_properti }}">

                    <div class="card-content">

                        <div class="card-row top-row">
                            <span class="category">{{ $property->category->nama_kategori ?? 'Kategori Lain' }}</span>

                            <div class="price-box">
                                <span class="price">IDR {{ number_format($property->harga_per_periode, 0, ',', '.') }}</span>
                                <small>Per Hari</small>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="card-row middle-row">
                            <div class="location">
                                <img src="/images/landing/icons/location.svg" alt="Location">
                                <span>{{ $property->location->kota ?? 'Lokasi Tidak Diketahui' }}</span>
                            </div>

                            <div class="rating">
                                <img src="/images/landing/icons/star.png" alt="Star">
                                <span>{{ number_format($property->reviews->avg('rating') ?? 0, 1) }} ({{ $property->reviews->count() }})</span>
                            </div>
                        </div>

                        <h3 class="card-title">{{ $property->nama_properti }}</h3>

                    </div>
                </a>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 40px 0; color: #555; font-size: 18px;">
                    Tidak ada properti yang sesuai dengan filter.
                </div>
            @endforelse
            <div id="noPropertiesMessage" style="grid-column: span 3; text-align: center; padding: 40px 0; color: #555; font-size: 18px; display: none;">
                Tidak ada properti yang sesuai dengan filter.
            </div>
        </section>

        @include('partials.footer')
    @endsection

    @section('scripts')
        <script>
            const selectedFilters = {
                locationValue: "{{ $selectedLocation ?? 'All' }}",
                typeValue: "{{ $selectedCategory ?? 'All' }}",
                priceValue: "{{ $selectedPrice ?? 'All' }}",
            };

            let originalCards = [];
            let propertySection = null;
            let noPropertiesMessage = null;

            document.addEventListener('DOMContentLoaded', () => {
                propertySection = document.getElementById('propertySection');
                noPropertiesMessage = document.getElementById('noPropertiesMessage');
                if (propertySection) {
                    originalCards = Array.from(propertySection.querySelectorAll('.card'));
                }
                
               
                applyFiltersClientSide(false);
            });

            function filterLocations() {
                const query = document.getElementById('locationSearchInput').value.toLowerCase();
                const buttons = document.querySelectorAll('#locationDropdown .location-btn');
                buttons.forEach(button => {
                    const value = button.getAttribute('data-value').toLowerCase();
                    if (value.includes(query) || value === 'all') {
                        button.style.display = 'block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            }

            function toggleDropdown(id, event) {
                if (event) {
                    event.stopPropagation();
                }
                const dropdown = document.getElementById(id);
                const isShowing = dropdown.classList.contains('show');
                const clickedButton = event ? event.currentTarget : null;

                document.querySelectorAll('.dropdown').forEach(d => {
                    d.classList.remove('show');
                });

                document.querySelectorAll('.search-item').forEach(item => {
                    item.classList.remove('active');
                });

                const searchInput = document.getElementById('locationSearchInput');
                if (searchInput) {
                    searchInput.value = '';
                    filterLocations();
                }

                if (!isShowing) {
                    dropdown.classList.add('show');
                    if (clickedButton) {
                        clickedButton.classList.add('active');
                    }
                }
            }

            function selectValue(targetId, value) {
                const targetEl = document.getElementById(targetId);
                targetEl.textContent = value;
                selectedFilters[targetId] = value;

                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });

                document.querySelectorAll('.search-item').forEach(item => {
                    item.classList.remove('active');
                });

                const searchInput = document.getElementById('locationSearchInput');
                if (searchInput) {
                    searchInput.value = '';
                    filterLocations();
                }
            }

            document.addEventListener('click', function(event) {
                const searchWrapper = document.querySelector('.search-wrapper');
                if (searchWrapper && !searchWrapper.contains(event.target)) {
                    document.querySelectorAll('.dropdown').forEach(dropdown => {
                        dropdown.classList.remove('show');
                    });
                    document.querySelectorAll('.search-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    
                    const searchInput = document.getElementById('locationSearchInput');
                    if (searchInput) {
                        searchInput.value = '';
                        filterLocations();
                    }
                }
            });

            function applyFiltersClientSide(pushState = true) {
                if (!propertySection) return;

                const locFilter = selectedFilters.locationValue;
                const typeFilter = selectedFilters.typeValue;
                const priceFilter = selectedFilters.priceValue;

                //  Filter cards
                const filteredCards = originalCards.filter(card => {
                    const cardLoc = card.getAttribute('data-location');
                    const cardCat = card.getAttribute('data-category');

                    const matchesLoc = (locFilter === 'All' || cardLoc === locFilter);
                    const matchesType = (typeFilter === 'All' || cardCat === typeFilter);

                    return matchesLoc && matchesType;
                });

                // Sort card
                if (priceFilter === 'Harga Terendah') {
                    filteredCards.sort((a, b) => {
                        return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
                    });
                } else if (priceFilter === 'Harga Tertinggi') {
                    filteredCards.sort((a, b) => {
                        return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
                    });
                }

                propertySection.querySelectorAll('.card').forEach(card => card.remove());

                if (filteredCards.length > 0) {
                    filteredCards.forEach((card, index) => {
                        card.style.animation = 'none';
                        card.offsetHeight;
                        card.style.animation = 'fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                        card.style.animationDelay = `${index * 0.05}s`;
                        propertySection.appendChild(card);
                    });
                    if (noPropertiesMessage) noPropertiesMessage.style.display = 'none';
                } else {
                    if (noPropertiesMessage) {
                        noPropertiesMessage.style.animation = 'none';
                        noPropertiesMessage.offsetHeight; // trigger reflow
                        noPropertiesMessage.style.animation = 'fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards';
                        noPropertiesMessage.style.display = 'block';
                    }
                }

                if (pushState) {
                    const params = new URLSearchParams();
                    if (locFilter && locFilter !== 'All') params.set('location', locFilter);
                    if (typeFilter && typeFilter !== 'All') params.set('category', typeFilter);
                    if (priceFilter && priceFilter !== 'All') params.set('price', priceFilter);

                    const queryString = params.toString();
                    const nextUrl = queryString ? `/?${queryString}` : '/';
                    history.pushState({ filters: selectedFilters }, '', nextUrl);
                }
            }

            function searchProperties() {
                applyFiltersClientSide(true);
            }

            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.filters) {
                    Object.assign(selectedFilters, event.state.filters);
                    document.getElementById('locationValue').textContent = selectedFilters.locationValue;
                    document.getElementById('typeValue').textContent = selectedFilters.typeValue;
                    document.getElementById('priceValue').textContent = selectedFilters.priceValue;
                    applyFiltersClientSide(false);
                } else {
                    // Reset ke initial URL state
                    const params = new URLSearchParams(window.location.search);
                    selectedFilters.locationValue = params.get('location') || 'All';
                    selectedFilters.typeValue = params.get('category') || 'All';
                    selectedFilters.priceValue = params.get('price') || 'All';
                    document.getElementById('locationValue').textContent = selectedFilters.locationValue;
                    document.getElementById('typeValue').textContent = selectedFilters.typeValue;
                    document.getElementById('priceValue').textContent = selectedFilters.priceValue;
                    applyFiltersClientSide(false);
                }
            });
        </script>
    @endsection
