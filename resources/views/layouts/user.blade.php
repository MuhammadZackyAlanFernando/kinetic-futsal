<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Kinetic Futsal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --dark-green:   #1a3c2e;
            --medium-green: #2d6a4f;
            --light-green:  #52b788;
            --bg:           #f4f6f4;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: var(--bg); margin: 0; }

        /* ══ NAVBAR ══ */
        .main-navbar {
            background: linear-gradient(135deg, #0d2318 0%, var(--dark-green) 60%, #215238 100%);
            padding: 0 1.5rem;
            height: 65px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 999;
            box-shadow: 0 2px 20px rgba(0,0,0,.2);
        }
        .navbar-brand-custom {
            display: flex; align-items: center; gap: .75rem;
            text-decoration: none;
        }
        .nav-brand-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--light-green), var(--medium-green));
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff;
            box-shadow: 0 4px 12px rgba(82,183,136,.4);
        }
        .nav-brand-text { font-size: .95rem; font-weight: 700; color: #fff; line-height: 1; }
        .nav-brand-sub  { font-size: .68rem; color: rgba(255,255,255,.55); }

        /* Nav links */
        .navbar-nav-custom { display: flex; align-items: center; gap: .25rem; }
        .nav-pill {
            padding: .45rem .9rem; border-radius: 8px;
            color: rgba(255,255,255,.7); font-size: .85rem; font-weight: 500;
            text-decoration: none; transition: all .2s;
            display: flex; align-items: center; gap: .45rem;
        }
        .nav-pill:hover  { color: #fff; background: rgba(255,255,255,.1); }
        .nav-pill.active { color: #fff; background: rgba(82,183,136,.25); }
        .nav-pill.active::after {
            /* no pseudo, kept as background highlight only */
        }

        /* User dropdown */
        .user-dropdown-toggle {
            display: flex; align-items: center; gap: .65rem;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
            border-radius: 12px; padding: .4rem .9rem .4rem .5rem;
            cursor: pointer; color: #fff;
            transition: all .2s;
        }
        .user-dropdown-toggle:hover { background: rgba(255,255,255,.18); }
        .user-av-sm {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--light-green), var(--medium-green));
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 700; color: #fff;
        }
        .user-name-sm { font-size: .83rem; font-weight: 600; }

        /* Dropdown menu */
        .user-dropdown-menu {
            position: absolute; right: 1.5rem; top: 70px;
            background: #fff; border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            min-width: 200px; padding: .5rem;
            display: none; z-index: 9999;
            animation: dropIn .15s ease;
        }
        .user-dropdown-menu.show { display: block; }
        @keyframes dropIn {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .dropdown-item-custom {
            padding: .6rem .9rem; border-radius: 9px;
            font-size: .875rem; color: #374151;
            display: flex; align-items: center; gap: .6rem;
            cursor: pointer; transition: background .15s; text-decoration: none;
        }
        .dropdown-item-custom:hover { background: #f3f4f6; color: var(--dark-green); }
        .dropdown-item-custom.danger { color: #dc2626; }
        .dropdown-item-custom.danger:hover { background: #fef2f2; }
        .dropdown-divider-custom { height: 1px; background: #f3f4f6; margin: .35rem 0; }

        /* Mobile toggle */
        .mobile-toggle {
            display: none; background: none; border: none;
            color: #fff; font-size: 1.2rem; padding: .25rem;
        }
        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .navbar-nav-custom { display: none; }
            .navbar-nav-custom.mobile-open {
                display: flex; flex-direction: column;
                position: absolute; top: 65px; left: 0; right: 0;
                background: var(--dark-green); padding: .75rem 1rem;
                gap: .25rem; z-index: 1000;
                box-shadow: 0 4px 20px rgba(0,0,0,.2);
            }
        }

        /* Flash messages */
        .flash-container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        .alert { border-radius: 12px; border: none; font-size: .875rem; margin-top: 1.25rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* Court cards */
        .card-lapangan {
            border: none; border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .25s, box-shadow .25s;
            overflow: hidden;
        }
        .card-lapangan:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.14); }

        /* Status badges */
        .badge-status {
            display: inline-flex; align-items: center; gap: .35rem;
            padding: .35rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 600;
        }
        .badge-status.pending  { background: #fef3c7; color: #92400e; }
        .badge-status.approved { background: #d1fae5; color: #065f46; }
        .badge-status.rejected { background: #fee2e2; color: #991b1b; }
        .badge-status.selesai  { background: #dbeafe; color: #1e40af; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="main-navbar">
        <a class="navbar-brand-custom" href="{{ route('user.dashboard') }}">
            <div class="nav-brand-icon"><i class="fas fa-futbol"></i></div>
            <div>
                <div class="nav-brand-text">Kinetic Futsal</div>
                <div class="nav-brand-sub">Booking Lapangan</div>
            </div>
        </a>

        <div class="navbar-nav-custom" id="navLinks">
            <a href="{{ route('user.dashboard') }}"
               class="nav-pill {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i> Beranda
            </a>
            <a href="{{ route('user.dashboard') }}#lapangan" class="nav-pill">
                <i class="fas fa-door-open"></i> Lapangan
            </a>
            <a href="{{ route('user.dashboard') }}#riwayat" class="nav-pill">
                <i class="fas fa-history"></i> Riwayat
            </a>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- User dropdown -->
            <div class="user-dropdown-toggle" onclick="toggleDropdown()">
                <div class="user-av-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name-sm d-none d-md-block">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down" style="font-size:.7rem;opacity:.7;"></i>
            </div>

            <button class="mobile-toggle" onclick="toggleMobileNav()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- User Dropdown Menu -->
    <div class="user-dropdown-menu" id="userDropdown">
        <div class="dropdown-item-custom" style="pointer-events:none; color:#9ca3af; font-size:.78rem;">
            Masuk sebagai
        </div>
        <div class="dropdown-item-custom fw-semibold" style="pointer-events:none; color:var(--dark-green);">
            {{ auth()->user()->name }}
        </div>
        <div class="dropdown-divider-custom"></div>
        <a href="{{ route('user.dashboard') }}" class="dropdown-item-custom">
            <i class="fas fa-house" style="width:16px;"></i> Beranda
        </a>
        <div class="dropdown-divider-custom"></div>
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="dropdown-item-custom danger w-100 border-0 bg-transparent text-start">
                <i class="fas fa-right-from-bracket" style="width:16px;"></i> Keluar
            </button>
        </form>
    </div>

    <!-- Flash Messages -->
    <div class="flash-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('show');
        }
        document.addEventListener('click', function(e) {
            const menu   = document.getElementById('userDropdown');
            const toggle = document.querySelector('.user-dropdown-toggle');
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
        function toggleMobileNav() {
            document.getElementById('navLinks').classList.toggle('mobile-open');
        }
    </script>
    @stack('scripts')
</body>
</html>