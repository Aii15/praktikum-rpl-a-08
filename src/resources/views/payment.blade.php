@extends('layouts.app')

@section('title', 'Pembayaran Booking - SpotRent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')
    @include('partials.navbar')

    @php
        $startCarbon = \Carbon\Carbon::parse($start);
        $endCarbon = \Carbon\Carbon::parse($end);
        \Carbon\Carbon::setLocale('id');
        $formattedStart = $startCarbon->translatedFormat('d F Y');
        $formattedEnd = $endCarbon->translatedFormat('d F Y');
    @endphp

    <div class="payment-wrapper">
        <div class="payment-container">
            
            <!-- Left Panel: Invoice Details -->
            <div class="payment-invoice">
                <div class="invoice-header">
                    <h2>Rincian Pemesanan</h2>
                    <p>Silakan tinjau pesanan Anda sebelum melakukan pembayaran.</p>
                </div>

                <!-- Property Details Card -->
                <div class="property-invoice-card">
                    <img class="property-invoice-img" src="{{ $property->coverPhoto->url_foto ?? '/images/landing/property.png' }}" alt="{{ $property->nama_properti }}">
                    <div class="property-invoice-info">
                        <span class="property-invoice-category">{{ $property->category->nama_kategori ?? 'Kategori' }}</span>
                        <h3 class="property-invoice-title">{{ $property->nama_properti }}</h3>
                        <div class="property-invoice-location">
                            <!-- Simple SVG Map Pin Pin -->
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>{{ $property->location->kota ?? '' }}, {{ $property->location->provinsi ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Date Summary Box -->
                <div class="booking-dates-summary">
                    <div class="date-box">
                        <span>Check-In</span>
                        <strong>{{ $formattedStart }}</strong>
                    </div>
                    <div class="date-box">
                        <span>Check-Out</span>
                        <strong>{{ $formattedEnd }}</strong>
                    </div>
                </div>

                <!-- Detailed Pricing Breakdown -->
                <div class="price-breakdown">
                    <div class="price-item">
                        <span>Harga sewa per hari</span>
                        <span>Rp {{ number_format($property->harga_per_hari, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-item">
                        <span>Durasi sewa</span>
                        <span>{{ $nights }} hari</span>
                    </div>
                    <div class="price-item total">
                        <span>Total Pembayaran</span>
                        <span class="total-amount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Payment Interface / Wizard -->
            <div class="payment-wizard">
                
                <!-- Step Navigation Progress Line -->
                <div class="steps-progress">
                    <div class="progress-line" id="progressLine"></div>
                    
                    <div class="step-node active" id="stepNode1">
                        1
                        <span class="step-label">Metode</span>
                    </div>
                    <div class="step-node" id="stepNode2">
                        2
                        <span class="step-label">Detail Kartu</span>
                    </div>
                    <div class="step-node" id="stepNode3">
                        3
                        <span class="step-label">Selesai</span>
                    </div>
                </div>

                <!-- Step 1 Panel: Payment Method Selection -->
                <div class="wizard-panel active" id="panelStep1">
                    <h3 class="method-title">Pilih Metode Pembayaran</h3>
                    <div class="method-selection-container">
                        
                        <!-- Visa Option Card -->
                        <div class="payment-card-option visa" onclick="selectPaymentMethod('visa')">
                            <div class="card-top">
                                <div class="card-chip"></div>
                                <img class="card-brand-logo" src="{{ asset('icons/visa.svg') }}" alt="Visa">
                            </div>
                            <div class="card-middle">
                                <span>•••• •••• •••• ••••</span>
                            </div>
                            <div class="card-bottom">
                                <div class="card-holder">
                                    <span class="card-holder-label">Pemegang Kartu</span>
                                    <span class="card-holder-name">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="card-expiry">
                                    <span class="card-expiry-label">Valid Thru</span>
                                    <span class="card-expiry-val">••/••</span>
                                </div>
                            </div>
                        </div>

                        <!-- Mastercard Option Card -->
                        <div class="payment-card-option mastercard" onclick="selectPaymentMethod('mastercard')">
                            <div class="card-top">
                                <div class="card-chip"></div>
                                <img class="card-brand-logo" src="{{ asset('icons/mastercard.svg') }}" alt="Mastercard">
                            </div>
                            <div class="card-middle">
                                <span>•••• •••• •••• ••••</span>
                            </div>
                            <div class="card-bottom">
                                <div class="card-holder">
                                    <span class="card-holder-label">Pemegang Kartu</span>
                                    <span class="card-holder-name">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="card-expiry">
                                    <span class="card-expiry-label">Valid Thru</span>
                                    <span class="card-expiry-val">••/••</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Step 2 Panel: Credit Card Form Details -->
                <div class="wizard-panel" id="panelStep2">
                    <!-- Mini Virtual Card Preview -->
                    <div class="mini-virtual-card" id="miniCard">
                        <div class="card-top">
                            <div class="card-chip"></div>
                            <img class="card-brand-logo" id="miniCardLogo" src="" alt="Brand">
                        </div>
                        <div class="card-middle">
                            <span id="miniCardNumber">•••• •••• •••• ••••</span>
                        </div>
                        <div class="card-bottom">
                            <div class="card-holder">
                                <span class="card-holder-label">Pemegang Kartu</span>
                                <span class="card-holder-name">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="card-expiry">
                                <span class="card-expiry-label">Valid Thru</span>
                                <span class="card-expiry-val" id="miniCardExpiry">••/••</span>
                            </div>
                        </div>
                    </div>

                    <!-- Error Alert -->
                    <div class="wizard-error-alert" id="wizardError">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span id="errorMessage">Terjadi kesalahan. Silakan coba lagi.</span>
                    </div>

                    <!-- Input form fields -->
                    <div class="wizard-form-container">
                        <div class="form-group">
                            <label for="cardNumber">Nomor Kartu</label>
                            <div class="input-with-icon">
                                <input type="text" id="cardNumber" readonly>
                                <img class="input-icon-right" id="inputBrandIcon" src="" alt="Brand Icon">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cardName">Nama Pemegang Kartu</label>
                            <input type="text" id="cardName" class="standard-input" value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="cardExpiry">Masa Berlaku (MM/YY)</label>
                                <input type="text" id="cardExpiry" class="standard-input" readonly>
                            </div>
                            <div class="form-group">
                                <label for="cardCVV">CVV</label>
                                <input type="text" id="cardCVV" class="standard-input" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-actions">
                        <button type="button" class="btn-wizard-back" onclick="goToStep1()">Kembali</button>
                        <button type="button" class="btn-wizard-submit" id="btnSubmitPayment" onclick="submitPayment()">
                            <div class="submit-spinner" id="btnSpinner"></div>
                            <span id="btnText">Bayar Sekarang</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Success Screen (Absolute Overlay) -->
                <div class="success-panel-overlay" id="panelSuccess">
                    <div class="checkmark-outer-circle">
                        <img class="checkmark-inner-icon" src="{{ asset('icons/centang.svg') }}" alt="Success Checkmark">
                    </div>
                    <h2 class="success-title">Pembayaran Berhasil!</h2>
                    <p class="success-description">Pemesanan Anda telah disimpan dengan status pending. Anda akan dialihkan ke riwayat booking.</p>
                    
                    <div class="countdown-bar-container">
                        <div class="countdown-bar-fill"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let selectedBrand = '';
        let generatedCardNum = '';
        let generatedExpiry = '';
        let generatedCVV = '';

        const visaLogoPath = "{{ asset('icons/visa.svg') }}";
        const mastercardLogoPath = "{{ asset('icons/mastercard.svg') }}";
        const storeEndpoint = "{{ route('property.payment.store', $property->id_properti) }}";
        const csrfToken = "{{ csrf_token() }}";
        const bookingStart = "{{ $start }}";
        const bookingEnd = "{{ $end }}";
        const redirectUrl = "{{ route('user.booking.history') }}";

        function generateRandomCardNumber(brand) {
            let prefix = brand === 'visa' ? '4' : '5';
            let num = prefix;
            for (let i = 0; i < 15; i++) {
                num += Math.floor(Math.random() * 10);
            }
            return num.replace(/(\d{4})/g, '$1 ').trim();
        }

        function generateRandomExpiry() {
            let month = Math.floor(Math.random() * 12) + 1;
            let formattedMonth = month < 10 ? '0' + month : month;
            let year = Math.floor(Math.random() * 5) + 26; // Year 2026 to 2030
            return formattedMonth + '/' + year;
        }

        function generateRandomCVV() {
            return Math.floor(100 + Math.random() * 900).toString();
        }

        function selectPaymentMethod(brand) {
            selectedBrand = brand;
            
            // Generate mock data
            generatedCardNum = generateRandomCardNumber(brand);
            generatedExpiry = generateRandomExpiry();
            generatedCVV = generateRandomCVV();

            // Setup Mini Virtual Card Preview
            const miniCard = document.getElementById('miniCard');
            miniCard.className = 'mini-virtual-card ' + brand;

            const miniCardLogo = document.getElementById('miniCardLogo');
            const inputBrandIcon = document.getElementById('inputBrandIcon');

            miniCardLogo.src = brand === 'visa' ? visaLogoPath : mastercardLogoPath;
            miniCardLogo.alt = brand === 'visa' ? 'Visa' : 'Mastercard';
            inputBrandIcon.src = brand === 'visa' ? visaLogoPath : mastercardLogoPath;
            inputBrandIcon.alt = brand === 'visa' ? 'Visa' : 'Mastercard';

            if (brand === 'visa') {
                miniCardLogo.style.height = '16px';
                inputBrandIcon.style.height = '16px';
            } else {
                miniCardLogo.style.height = '30px';
                inputBrandIcon.style.height = '30px';
            }

            document.getElementById('miniCardNumber').textContent = generatedCardNum;
            document.getElementById('miniCardExpiry').textContent = generatedExpiry;

            // Populate Form Fields
            document.getElementById('cardNumber').value = generatedCardNum;
            document.getElementById('cardExpiry').value = generatedExpiry;
            document.getElementById('cardCVV').value = generatedCVV;

            // Transition to Step 2
            document.getElementById('panelStep1').classList.remove('active');
            document.getElementById('panelStep2').classList.add('active');

            // Update Steps Progress Nodes
            document.getElementById('stepNode1').classList.remove('active');
            document.getElementById('stepNode1').classList.add('completed');
            document.getElementById('stepNode2').classList.add('active');
            document.getElementById('progressLine').style.width = '50%';
        }

        function goToStep1() {
            // Reset state
            selectedBrand = '';
            
            // Transition back to Step 1
            document.getElementById('panelStep2').classList.remove('active');
            document.getElementById('panelStep1').classList.add('active');

            // Reset Steps Progress Nodes
            document.getElementById('stepNode1').classList.remove('completed');
            document.getElementById('stepNode1').classList.add('active');
            document.getElementById('stepNode2').classList.remove('active');
            document.getElementById('progressLine').style.width = '0%';

            // Hide any error
            document.getElementById('wizardError').style.display = 'none';
        }

        function submitPayment() {
            const btnSubmit = document.getElementById('btnSubmitPayment');
            const spinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');
            const errorAlert = document.getElementById('wizardError');
            const errorMessageSpan = document.getElementById('errorMessage');

            // Disable UI
            btnSubmit.disabled = true;
            spinner.style.display = 'inline-block';
            btnText.textContent = 'Memproses...';
            errorAlert.style.display = 'none';

            // Send AJAX POST
            fetch(storeEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    start: bookingStart,
                    end: bookingEnd
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errData => {
                        throw new Error(errData.error || 'Terjadi kesalahan sistem.');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update steps UI to completed
                    document.getElementById('stepNode2').classList.remove('active');
                    document.getElementById('stepNode2').classList.add('completed');
                    document.getElementById('stepNode3').classList.add('active');
                    document.getElementById('progressLine').style.width = '100%';

                    // Activate success screen overlay
                    document.getElementById('panelSuccess').classList.add('active');

                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 3000);
                } else {
                    throw new Error('Terjadi kesalahan saat memproses booking.');
                }
            })
            .catch(error => {
                // Restore UI
                btnSubmit.disabled = false;
                spinner.style.display = 'none';
                btnText.textContent = 'Bayar Sekarang';

                // Display Error
                errorMessageSpan.textContent = error.message;
                errorAlert.style.display = 'flex';
            });
        }
    </script>
@endsection
