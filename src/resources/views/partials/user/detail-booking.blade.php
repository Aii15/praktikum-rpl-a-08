<div id="section-detail-booking" class="content-section">
    <h1>Detail Booking</h1>

    <div id="detailLoading" class="modal-loader-container">
        <div class="modal-spinner"></div>
        <p>Memuat detail booking...</p>
    </div>

    <div id="detailBody" style="display: none;">
        <div class="detail-card">
            <img id="detailBanner" src="" class="detail-banner" alt="Property Banner">

            <div class="detail-info">
                <h2 id="detailPropertyName"></h2>

                <div class="info-grid">
                    <div class="info-group">
                        <strong>Status Booking</strong>
                        <p id="detailStatusBooking"></p>
                    </div>

                    <div class="info-group">
                        <strong>Status Pembayaran</strong>
                        <p id="detailStatusPembayaran"></p>
                    </div>

                    <div class="info-group">
                        <strong>Total Harga</strong>
                        <p id="detailTotalPrice"></p>
                    </div>

                    <div class="info-group">
                        <strong>Rentang Hari</strong>
                        <p id="detailRentangHari"></p>
                    </div>

                    <div class="info-group">
                        <strong>Pemilik Properti</strong>
                        <p id="detailPemilik"></p>
                    </div>
                </div>

                <span id="detailStatusBadge" class="booking-status"></span>

                <!-- Cancel Booking Section -->
                <div id="bookingCancelSection" style="margin-top: 20px; display: none;">
                    <button type="button" onclick="confirmCancelBooking()" style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; transition: background 0.2s; outline: none; font-family: 'Poppins', sans-serif;">
                        Batalkan Booking
                    </button>
                </div>

                <!-- section review -->
                <div id="detailReviewSection" style="margin-top: 25px; border-top: 1px solid #e5e7eb; padding-top: 20px; display: none;">
                    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px; color: #111827;">Ulasan Anda</h3>
                    
                    <!-- Form untuk submit review -->
                    <form id="reviewForm" style="display: none;" onsubmit="submitReview(event)">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Rating</label>
                            <div class="star-rating" style="display: flex; gap: 8px;">
                                <span class="star-input" onclick="setRating(1)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input" onclick="setRating(2)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input" onclick="setRating(3)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input" onclick="setRating(4)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                                <span class="star-input" onclick="setRating(5)" style="cursor:pointer; font-size: 28px; color: #d1d5db; transition: color 0.15s;">★</span>
                            </div>
                            <input type="hidden" id="ratingValue" value="" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label for="reviewKomentar" style="display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px;">Komentar</label>
                            <textarea id="reviewKomentar" rows="3" style="width:100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline:none; font-family:'Poppins',sans-serif; resize: vertical;" placeholder="Tulis komentar ulasan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" style="background:#f7c948; color:#111; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer; font-size:14px; transition: background 0.2s; outline:none;">Kirim Ulasan</button>
                    </form>

                    <!-- menampilkan review -->
                    <div id="existingReview" style="display: none;">
                        <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                            <span id="displayReviewStars" style="font-size: 20px; color: #f7c948; letter-spacing: 2px;"></span>
                            <span id="displayReviewDate" style="font-size: 12px; color: #6b7280; margin-left: 8px;"></span>
                        </div>
                        <p id="displayReviewText" style="font-size: 14px; color: #374151; margin-bottom: 0; line-height: 1.5; font-style: italic;"></p>
                        
                        <!-- menampilkan feedback dari mitra -->
                        <div id="displayMitraReply" style="margin-top: 15px; background: #f3f4f6; border-radius: 8px; padding: 12px 16px; border-left: 4px solid #f7c948; display: none;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                                <span style="font-size: 13px; font-weight: 600; color: #111827;" id="mitraReplyAuthor"></span>
                                <span id="mitraReplyDate" style="font-size: 11px; color: #6b7280;"></span>
                            </div>
                            <p id="mitraReplyText" style="font-size: 13px; color: #4b5563; margin-bottom: 0; line-height: 1.4;"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="/riwayat-booking" onclick="event.preventDefault(); navigateTo('/riwayat-booking');" class="back-btn">
            ← Kembali ke Riwayat
        </a>
    </div>
</div>
