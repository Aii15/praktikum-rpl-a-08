<nav class="navbar {{ $class ?? '' }}">
    <div class="logo" onclick="window.location.href='/'" style="cursor: pointer;">
        <img src="/images/logo.png" alt="Logo">
        <span>SpotRent</span>
    </div>

    <div class="nav-buttons">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-dashboard">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline-block; margin-left: 10px;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="/login" class="btn-login">Daftar / Masuk</a>
        @endauth
    </div>
</nav>
