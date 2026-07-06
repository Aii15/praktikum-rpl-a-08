<div id="section-manage-comments" class="content-section">
    <h1>Kelola Komentar</h1>

    <!-- Kontrol Filter dan Pengurutan mencocokkan gaya Mitra -->
    <div class="filter-controls-container">
        <!-- Kartu Pencarian -->
        <div class="field-card filter-card search-card" onclick="document.getElementById('filter-comments-search-input').focus()">
            <div class="field-text">
                <small>Cari Properti / Penyewa / Komentar</small>
                <input type="text" id="filter-comments-search-input" class="profile-input" placeholder="Tulis nama properti, penyewa, atau ulasan..." onkeyup="applyCommentsFilters()">
            </div>
            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
        </div>

        <!-- Kartu Dropdown Rating -->
        <div class="field-card filter-card dropdown-card" id="rating-dropdown-container" style="position: relative; z-index: 15;">
            <div class="field-text" onclick="toggleCommentsDropdown('rating-dropdown', event)">
                <small>Filter Rating</small>
                <div id="rating-display" class="selected-display">Semua Rating</div>
                <input type="hidden" id="filter-rating-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleCommentsDropdown('rating-dropdown', event)">
            
            <div id="rating-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row rating-item-row" data-val="all" onclick="selectCommentsRating('all', 'Semua Rating', event)">
                    <span>Semua Rating</span>
                </div>
                @for($stars = 5; $stars >= 1; $stars--)
                <div class="dropdown-item-row rating-item-row" data-val="{{ $stars }}" onclick="selectCommentsRating('{{ $stars }}', 'Bintang {{ $stars }}', event)">
                    <span class="status-badge-inline process" style="background: #fef9c3; color: #a16207; display: flex; align-items: center; gap: 4px;">
                        {{ $stars }} ★
                    </span>
                </div>
                @endfor
            </div>
        </div>

        <!-- Kartu Dropdown Waktu Komentar -->
        <div class="field-card filter-card dropdown-card" id="time-dropdown-container" style="position: relative; z-index: 10;">
            <div class="field-text" onclick="toggleCommentsDropdown('time-dropdown', event)">
                <small>Waktu Komentar</small>
                <div id="time-display" class="selected-display">Terbaru</div>
                <input type="hidden" id="filter-time-value" value="newest">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleCommentsDropdown('time-dropdown', event)">
            
            <div id="time-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row time-item-row" data-val="newest" onclick="selectCommentsTime('newest', 'Terbaru', event)">
                    <span>Terbaru</span>
                </div>
                <div class="dropdown-item-row time-item-row" data-val="oldest" onclick="selectCommentsTime('oldest', 'Terlama', event)">
                    <span>Terlama</span>
                </div>
            </div>
        </div>
    </div>

    <div class="item-list">
        @forelse($reviews as $review)
            @php
                $property = $review->booking->property ?? null;
                $penyewa = $review->booking->user ?? null;
                $coverPhoto = $property ? $property->coverPhoto : null;
            @endphp
            <div class="item-card review-card-item" id="review-card-{{ $review->id_review }}" 
                 data-property-name="{{ strtolower($property->nama_properti ?? '') }}" 
                 data-tenant-name="{{ strtolower($penyewa->name ?? '') }}" 
                 data-comment-text="{{ strtolower($review->komentar ?? '') }}" 
                 data-rating="{{ $review->rating }}" 
                 data-has-feedback="{{ $review->balasan_mitra ? 'true' : 'false' }}"
                 data-timestamp="{{ \Carbon\Carbon::parse($review->tanggal_review)->timestamp }}"
                 style="flex-direction: column; align-items: stretch; gap: 16px;">
                <!-- Informasi Properti di bagian atas -->
                @if($property)
                <div style="display: flex; align-items: center; gap: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 12px;">
                    <img src="{{ $coverPhoto->url_foto ?? '/images/landing/property.png' }}" style="width: 70px; height: 50px; border-radius: 8px; object-fit: cover; object-position: {{ $coverPhoto->position_style ?? 'center 50%' }};" alt="{{ $property->nama_properti }}">
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 2px;">{{ $property->nama_properti }}</h4>
                        <span style="font-size: 12px; color: #6b7280;">Pemilik: {{ $property->mitra->nama_mitra ?? $property->mitra->name ?? 'Mitra tidak diketahui' }}</span>
                    </div>
                </div>
                @endif

                <!-- Konten Ulasan -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <div>
                            <span style="font-size: 14px; font-weight: 600; color: #374151;">{{ $penyewa->name ?? 'Penyewa' }}</span>
                            <span style="font-size: 12px; color: #9ca3af; margin-left: 8px;">{{ \Carbon\Carbon::parse($review->tanggal_review)->format('d M Y H:i') }}</span>
                        </div>
                        <div style="display: flex; gap: 2px;">
                            @for ($j = 1; $j <= 5; $j++)
                                @if ($j <= $review->rating)
                                    <img src="/images/informasi/icons/star.png" style="width: 14px; height: 14px; object-fit: contain;" alt="">
                                @else
                                    <img src="/images/informasi/icons/star.png" style="width: 14px; height: 14px; object-fit: contain; opacity: 0.3;" alt="">
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p style="font-size: 14px; color: #4b5563; line-height: 1.5; font-style: italic;">"{{ $review->komentar }}"</p>
                </div>

                <!-- Tanggapan Mitra jika ada -->
                <div class="feedback-container-wrapper-{{ $review->id_review }}" style="display: {{ $review->balasan_mitra ? 'block' : 'none' }}; margin-left: 20px; padding-left: 14px; border-left: 3px solid #f7c948;">
                    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; display: flex; flex-direction: column; gap: 6px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 600; color: #b45309; display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                Tanggapan Mitra (Pemilik Properti)
                            </span>
                            <span style="font-size: 11px; color: #9ca3af;" class="feedback-date-{{ $review->id_review }}">{{ $review->tanggal_balasan ? \Carbon\Carbon::parse($review->tanggal_balasan)->format('d M Y H:i') : '' }}</span>
                        </div>
                        <p style="font-size: 13px; color: #4b5563;" class="feedback-text-{{ $review->id_review }}">{{ $review->balasan_mitra }}</p>
                    </div>
                </div>

                <!-- Tombol aksi -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 4px; border-top: 1px solid #f3f4f6; padding-top: 12px;">
                    <button onclick="confirmDeleteFeedback({{ $review->id_review }})" class="btn-delete-feedback-{{ $review->id_review }}" style="display: {{ $review->balasan_mitra ? 'inline-flex' : 'none' }}; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Hapus Tanggapan
                    </button>
                    <button onclick="confirmDeleteReview({{ $review->id_review }})" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Hapus Ulasan
                    </button>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                Belum ada komentar ulasan di dalam platform.
            </div>
        @endforelse
    </div>
</div>
