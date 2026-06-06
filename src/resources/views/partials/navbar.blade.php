<nav class="navbar {{ $class ?? '' }}">
    <div class="logo" onclick="window.location.href='/'" style="cursor: pointer;">
        <img src="/images/logo.png" alt="Logo">
        <span>SpotRent</span>
    </div>

    <div class="nav-buttons">
        @auth
            @php
                $activeRole = session('active_role') ?? (Auth::user()->roles()->first()->name ?? Auth::user()->role ?? 'penyewa');
            @endphp
            @if($activeRole === 'penyewa')
                <div class="profile-dropdown-container">
                    <button class="profile-btn" id="profileDropdownBtn" aria-label="Menu Profil">
                        <img src="/icons/login_profile.svg" alt="Profile" class="profile-icon">
                    </button>
                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        <div class="dropdown-header">
                            <span class="user-fullname">{{ Auth::user()->name }}</span>
                            <span class="user-role-label">{{ ucfirst($activeRole) }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('dashboard') }}" class="dropdown-item profile-link">
                            <span>Lihat Profil</span>
                        </a>
                        <a href="#" class="dropdown-item logout-btn-item" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();">
                            <img src="/icons/logout.svg" alt="Logout" class="logout-icon">
                            <span>Logout</span>
                        </a>
                        <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="btn-dashboard">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline-block; margin-left: 10px;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @endif
        @else
            <a href="/login" class="btn-login">Daftar / Masuk</a>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileMenu = document.getElementById('profileDropdownMenu');
        
        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileMenu.classList.toggle('show');
            });
            
            document.addEventListener('click', function(e) {
                if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileMenu.classList.remove('show');
                }
            });
        }
    });
</script>
