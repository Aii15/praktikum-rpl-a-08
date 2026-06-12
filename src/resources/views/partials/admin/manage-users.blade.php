<div id="section-manage-users" class="content-section">
    <h1>Manajemen Pengguna</h1>

    <!-- Kontrol Filter dan Pengurutan mencocokkan halaman lainnya -->
    <div class="filter-controls-container">
        <!-- Kartu Pencarian -->
        <div class="field-card filter-card search-card" onclick="document.getElementById('filter-users-search-input').focus()">
            <div class="field-text">
                <small>Cari Pengguna</small>
                <input type="text" id="filter-users-search-input" class="profile-input" placeholder="Tulis nama, email, atau nomor HP..." onkeyup="applyUsersFilters()">
            </div>
            <img src="/images/profile/edit.png" class="edit-icon" alt="Edit Icon">
        </div>

        <!-- Kartu Dropdown Peran -->
        <div class="field-card filter-card dropdown-card" id="user-role-dropdown-container" style="position: relative; z-index: 15;">
            <div class="field-text" onclick="toggleUsersDropdown('user-role-dropdown', event)">
                <small>Filter Peran</small>
                <div id="user-role-display" class="selected-display">Semua Peran</div>
                <input type="hidden" id="filter-user-role-value" value="all">
            </div>
            <img src="/icons/chevron-down.svg" class="edit-icon" alt="Dropdown Icon" onclick="toggleUsersDropdown('user-role-dropdown', event)">
            
            <div id="user-role-dropdown" class="dropdown-menu-list">
                <div class="dropdown-item-row user-role-item-row" data-val="all" onclick="selectUserRoleFilter('all', 'Semua Peran', event)">
                    <span>Semua Peran</span>
                </div>
                <div class="dropdown-item-row user-role-item-row" data-val="admin" onclick="selectUserRoleFilter('admin', 'Admin', event)">
                    <span class="status-badge-inline success" style="background: #dcfce7; color: #15803d;">Admin</span>
                </div>
                <div class="dropdown-item-row user-role-item-row" data-val="mitra" onclick="selectUserRoleFilter('mitra', 'Mitra', event)">
                    <span class="status-badge-inline process" style="background: #fef3c7; color: #b45309;">Mitra</span>
                </div>
                <div class="dropdown-item-row user-role-item-row" data-val="penyewa" onclick="selectUserRoleFilter('penyewa', 'Penyewa', event)">
                    <span class="status-badge-inline completed" style="background: #e0f2fe; color: #0369a1;">Penyewa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="item-list">
        @forelse($users as $user)
            @php
                $primaryRole = $user->primary_role;
                $initials = strtoupper(substr($user->name, 0, 1));
                
                $colorIndex = ord($initials) % 5;
                $bgColors = ['#fef3c7', '#dcfce7', '#e0f2fe', '#fee2e2', '#f3e8ff'];
                $textColors = ['#b45309', '#15803d', '#0369a1', '#991b1b', '#6b21a8'];
                $avatarBg = $bgColors[$colorIndex];
                $avatarText = $textColors[$colorIndex];
            @endphp
            <div class="item-card user-card-item" id="user-card-{{ $user->id }}"
                 data-user-name="{{ strtolower($user->name ?? '') }}"
                 data-user-email="{{ strtolower($user->email ?? '') }}"
                 data-user-phone="{{ $user->no_hp ?? '' }}"
                 data-user-role="{{ $primaryRole }}"
                 style="display: flex; align-items: center; gap: 20px; padding: 20px; width: 100%;">
                
                <!-- Avatar Inisial -->
                <div style="width: 54px; height: 54px; border-radius: 50%; background: {{ $avatarBg }}; color: {{ $avatarText }}; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; flex-shrink: 0; box-shadow: 0 4px 8px rgba(0,0,0,0.04);">
                    {{ $initials }}
                </div>

                <!-- Detail Pengguna -->
                <div class="item-info">
                    <h3 style="margin-bottom: 4px;">{{ $user->name }}</h3>
                    <p style="margin-bottom: 2px;"><strong>Email:</strong> {{ $user->email }}</p>
                    <p style="margin-bottom: 2px;"><strong>No. HP:</strong> {{ $user->no_hp ?? '-' }}</p>
                    @if($user->alamat)
                        <p style="margin-bottom: 2px;"><strong>Alamat:</strong> {{ $user->alamat }}</p>
                    @endif
                    @if($user->rekening_bank)
                        <p style="margin-bottom: 2px;"><strong>Rekening Bank:</strong> {{ $user->rekening_bank }}</p>
                    @endif
                </div>

                <!-- Lencana Peran dan Aksi -->
                <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 12px; flex-shrink: 0;">
                    @if($primaryRole === 'admin')
                        <span class="status-badge approved">Admin</span>
                    @elseif($primaryRole === 'mitra')
                        <span class="status-badge pending" style="background: #fef3c7; color: #b45309;">Mitra</span>
                    @else
                        <span class="status-badge" style="background: #e0f2fe; color: #0369a1;">Penyewa</span>
                    @endif

                    @if(Auth::id() != $user->id)
                        <button onclick="confirmDeleteUser({{ $user->id }})" 
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; outline: none; font-family: 'Poppins', sans-serif;" 
                                onmouseover="this.style.background='#fecaca'" 
                                onmouseout="this.style.background='#fee2e2'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            Hapus Pengguna
                        </button>
                    @else
                        <span style="font-size: 12px; color: #9ca3af; font-style: italic;">Akun Anda</span>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px 0; color: #666; font-size: 16px; background: #f9fafb; border-radius: 14px; width: 100%;">
                Belum ada pengguna terdaftar.
            </div>
        @endforelse
    </div>
</div>
