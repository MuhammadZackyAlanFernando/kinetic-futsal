<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Kinetic Futsal</title>
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
            --sidebar-w:    260px;
            --topbar-h:     68px;
        }
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: var(--bg); margin: 0; overflow-x: hidden; }


           /* SIDEBAR */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, #0d2318 0%, var(--dark-green) 60%, #1e4535 100%);
            position: fixed; top: 0; left: 0; z-index: 1050;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column;
            box-shadow: 4px 0 24px rgba(0,0,0,.15);
        }
        #sidebar.collapsed { transform: translateX(calc(-1 * var(--sidebar-w))); }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: .85rem;
        }
        .brand-logo {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, var(--light-green), var(--medium-green));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #fff; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(82,183,136,.4);
        }
        .brand-text .brand-name { font-size: .95rem; font-weight: 700; color: #fff; line-height: 1.2; }
        .brand-text .brand-sub  { font-size: .72rem; color: rgba(255,255,255,.5); }

        /* Nav section label */
        .nav-section-label {
            font-size: .68rem; font-weight: 600;
            color: rgba(255,255,255,.35);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 1rem 1.5rem .4rem;
        }

        #sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: .65rem 1.25rem;
            border-radius: 10px;
            margin: 2px 12px;
            font-size: .875rem; font-weight: 500;
            display: flex; align-items: center; gap: .7rem;
            transition: all .2s;
            position: relative; overflow: hidden;
        }
        #sidebar .nav-link::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; border-radius: 0 3px 3px 0;
            background: var(--light-green);
            transform: scaleY(0); transition: transform .2s;
        }
        #sidebar .nav-link .nav-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; flex-shrink: 0;
            transition: all .25s;
        }
        #sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
        }
        #sidebar .nav-link:hover .nav-icon { background: rgba(82,183,136,.25); color: var(--light-green); }
        #sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, rgba(82,183,136,.2), rgba(45,106,79,.3));
        }
        #sidebar .nav-link.active::before { transform: scaleY(1); }
        #sidebar .nav-link.active .nav-icon { background: var(--light-green); color: #fff; box-shadow: 0 4px 12px rgba(82,183,136,.4); }

        /* Sidebar bottom */
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-footer .nav-link { color: rgba(255,255,255,.55); }
        .sidebar-footer .nav-link:hover { color: #ff6b6b; background: rgba(255,107,107,.08); }
        .sidebar-footer .nav-link .nav-icon { background: rgba(255,107,107,.1); color: #ff6b6b; }

        /* ══════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════ */
        #main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: margin-left .3s cubic-bezier(.4,0,.2,1);
        }
        #main-content.expanded { margin-left: 0; }

        /* Topbar */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            padding: 0 1.75rem;
            box-shadow: 0 1px 0 rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
            position: sticky; top: 0; z-index: 999;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .sidebar-toggle {
            width: 38px; height: 38px; border-radius: 10px;
            background: none; border: 2px solid #e8eae8;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: #6c757d;
            transition: all .2s;
        }
        .sidebar-toggle:hover { background: var(--light-green); border-color: var(--light-green); color: #fff; }

        /* Breadcrumb */
        .breadcrumb { margin: 0; background: none; padding: 0; }
        .breadcrumb-item { font-size: .8rem; color: #9ca3af; }
        .breadcrumb-item.active { color: var(--dark-green); font-weight: 600; }
        .breadcrumb-item + .breadcrumb-item::before { color: #d1d5db; }

        .topbar-right { display: flex; align-items: center; gap: .85rem; }

        /* Notification bell */
        .notif-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: #f8faf8; border: 2px solid #e8eae8;
            display: flex; align-items: center; justify-content: center;
            color: #6c757d; cursor: pointer; position: relative;
            transition: all .2s;
        }
        .notif-btn:hover { background: #e8f5ee; border-color: var(--light-green); color: var(--medium-green); }
        .notif-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #ef4444; border: 2px solid #fff;
            position: absolute; top: 6px; right: 6px;
        }

        /* User info chip */
        .user-chip {
            display: flex; align-items: center; gap: .65rem;
            background: #f8faf8; border: 2px solid #e8eae8;
            border-radius: 12px; padding: .35rem .85rem .35rem .45rem;
            cursor: pointer; transition: all .2s;
        }
        .user-chip:hover { border-color: var(--light-green); background: #e8f5ee; }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--light-green), var(--medium-green));
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 700; color: #fff;
        }
        .user-chip .user-name { font-size: .83rem; font-weight: 600; color: var(--dark-green); }
        .user-chip .user-role { font-size: .7rem; color: #9ca3af; }

        /* Breadcrumb divider row */
        .page-header {
            padding: 1rem 1.75rem .25rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .page-title { font-size: 1.2rem; font-weight: 700; color: var(--dark-green); margin: 0; }

        /* ══════════════════════════════════
           CONTENT AREA
        ══════════════════════════════════ */
        .content-area { padding: .75rem 1.75rem 2rem; }

        /* Alert */
        .alert { border-radius: 12px; border: none; font-size: .875rem; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* Shared card */
        .stat-card {
            border: none; border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.12); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 1.35rem;
        }

        /* Status badges */
        .badge-pending  { background: #fef3c7; color: #92400e; border:1px solid #fde68a; }
        .badge-approved { background: #d1fae5; color: #065f46; border:1px solid #a7f3d0; }
        .badge-rejected { background: #fee2e2; color: #991b1b; border:1px solid #fecaca; }
        .badge-selesai  { background: #dbeafe; color: #1e40af; border:1px solid #bfdbfe; }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 1040;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 991px) {
            #sidebar { transform: translateX(calc(-1 * var(--sidebar-w))); }
            #sidebar.mobile-open { transform: translateX(0); }
            #main-content { margin-left: 0 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- SIDEBAR --}}
    <nav id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo"><i class="fas fa-futbol"></i></div>
            <div class="brand-text">
                <div class="brand-name">Kinetic Futsal</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        <div class="nav-section-label">Menu Utama</div>
        <ul class="nav flex-column px-0">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-gauge-high"></i></div>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.lapangan.index') }}"
                   class="nav-link {{ request()->routeIs('admin.lapangan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-door-open"></i></div>
                    Kelola Lapangan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-users"></i></div>
                    Kelola User
                </a>
            </li>
        </ul>

        <div class="nav-section-label">Transaksi</div>
        <ul class="nav flex-column px-0">
            <li class="nav-item">
                <a href="{{ route('admin.transaksi.index') }}"
                   class="nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-calendar-check"></i></div>
                    Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.laporan.index') }}"
                   class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
                    Laporan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <ul class="nav flex-column px-0">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <div class="nav-icon"><i class="fas fa-right-from-bracket"></i></div>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <div id="main-content">
        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                    <i class="fas fa-bars" style="font-size:.9rem;"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-home me-1"></i>Admin</li>
                        <li class="breadcrumb-item active">@yield('page-title', 'Dashboard')</li>
                    </ol>
                </nav>
            </div>
            <div class="topbar-right">
                <div class="notif-btn" title="Notifikasi">
                    <i class="fas fa-bell" style="font-size:.88rem;"></i>
                    <span class="notif-dot"></span>
                </div>
                <div class="user-chip">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        <div class="px-4 pt-3">
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

        {{-- Page Content --}}
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const sidebar  = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay  = document.getElementById('sidebarOverlay');
        const isDesktop = () => window.innerWidth >= 992;

        function toggleSidebar() {
            if (isDesktop()) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('show');
            }
        }
        function closeSidebar() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
        }
        window.addEventListener('resize', () => {
            if (isDesktop()) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>