<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/logo/favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('img/logo/apple-touch-icon.png') }}">
    <meta name="theme-color" content="#15803D">
    <title>@yield('title', 'DocuDemi - Pelayanan Dokumen Akademik')</title>
    
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            /* Palette Figma DocuDemi */
            --sidebar-bg: #15803D;        /* Hijau Utama Sidebar */
            --sidebar-hover: #166534;     /* Hijau Gelap Hover */
            --sidebar-active: #22C55E;    /* Hijau Terang Active Indicator */
            --sidebar-text: #E2E8E4;      /* Teks Sidebar */
            
            --primary: #15803D;
            --primary-hover: #166534;
            --secondary: #22C55E;
            --light-accent: #DCFCE7;
            --bg-main: #F6F8F7;
            --surface: #FFFFFF;
            --text-dark: #172B1C;
            --text-muted: #64748B;
            --border-color: #E2E8E4;
            
            --status-warning: #F59E0B;
            --status-info: #3B82F6;
            --status-success: #22C55E;
            --status-danger: #EF4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sembunyikan Layout Sidebar & Navbar Jika di Halaman Auth (Login/Register) */
        body.auth-page .sidebar,
        body.auth-page .navbar {
            display: none !important;
        }

        body.auth-page .main-wrapper {
            margin-left: 0 !important;
            width: 100%;
        }

        /* Sidebar Styling (Hijau Figma) */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .brand-logo img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.5px;
        }

        /* Navigation Links */
        .sidebar-menu {
            padding: 20px 14px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
            overflow-y: auto;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .menu-item i {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        .menu-item:hover {
            background-color: var(--sidebar-hover);
            color: #FFFFFF;
        }

        .menu-item.active {
            background-color: #FFFFFF;
            color: var(--sidebar-bg);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #EF4444;
            border-color: #EF4444;
            color: white;
        }

        /* Main Wrapper */
        .main-wrapper {
            margin-left: 260px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .navbar {
            height: 70px;
            background-color: var(--surface);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .navbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-accent);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        /* Content Body */
        .content-body {
            padding: 32px;
            flex-grow: 1;
        }

        /* UI Base Elements */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-hover); }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
        }
        .btn-outline:hover { background-color: var(--bg-main); }

        .card {
            background-color: var(--surface);
            border-radius: 12px;
            border: 1px solid var(--border-color);logo
            padding: 24px;
            margin-bottom: 24px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-warning { background-color: #FEF3C7; color: #D97706; }
        .badge-info { background-color: #DBEAFE; color: #1D4ED8; }
        .badge-success { background-color: #DCFCE7; color: #15803D; }
        .badge-danger { background-color: #FEE2E2; color: #B91C1C; }

        .alert-success {
            background-color: var(--light-accent);
            color: var(--primary);
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }
    </style>
    @stack('styles')

    <!-- DocuDemi UI layer -->
    <link rel="stylesheet" href="{{ asset('css/docudemi-ui.css') }}">
</head>
<body class="{{ request()->routeIs('login', 'register') ? 'auth-page' : '' }}">

    <!-- Backdrop drawer (mobile) -->
    <div class="sidebar-backdrop" data-nav-backdrop></div>

    <!-- Sidebar Left -->
    <aside class="sidebar" id="sidebar">
       <div class="sidebar-brand">
            <img class="brand-logo" src="{{ asset('img/logo/logo-mark-light.svg') }}" alt="DocuDemi" width="40" height="40">
            <div class="brand-title">DocuDemi<small>SMKN 5 Surakarta</small></div>
        </div>


        <nav class="sidebar-menu">
            @if(Auth::check() && Auth::user()->role === 'alumni')
                <!-- Menu Alumni -->
                <a href="{{ route('alumni.dashboard') }}" class="menu-item {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('alumni.pengajuan.create') }}" class="menu-item {{ request()->routeIs('alumni.pengajuan.create') ? 'active' : '' }}">
                    <i data-lucide="file-plus"></i> Ajukan Layanan
                </a>
                <a href="{{ route('alumni.pengajuan.index') }}" class="menu-item {{ request()->routeIs('alumni.pengajuan.index') ? 'active' : '' }}">
                    <i data-lucide="file-text"></i> Pengajuan Saya
                </a>
                <a href="{{ route('alumni.riwayat') }}" class="menu-item {{ request()->routeIs('alumni.riwayat') ? 'active' : '' }}">
                    <i data-lucide="history"></i> Riwayat
                </a>
                <a href="{{ route('alumni.notifikasi') }}" class="menu-item {{ request()->routeIs('alumni.notifikasi') ? 'active' : '' }}">
                    <i data-lucide="bell"></i> Notifikasi
                </a>
                <a href="{{ route('alumni.profil') }}" class="menu-item {{ request()->routeIs('alumni.profil') ? 'active' : '' }}">
                    <i data-lucide="user"></i> Profil Saya
                </a>

            @elseif(Auth::check() && Auth::user()->role === 'petugas')
                <!-- Menu Petugas Kurikulum -->
                <a href="{{ route('petugas.dashboard') }}" class="menu-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('petugas.pengajuan.index') }}" class="menu-item {{ request()->routeIs('petugas.pengajuan.index') ? 'active' : '' }}">
                    <i data-lucide="inbox"></i> Pengajuan Masuk
                </a>
                <a href="{{ route('petugas.arsip') }}" class="menu-item {{ request()->routeIs('petugas.arsip') ? 'active' : '' }}">
                    <i data-lucide="folder-archive"></i> Arsip Dokumen
                </a>
                <a href="{{ route('petugas.jadwal') }}" class="menu-item {{ request()->routeIs('petugas.jadwal') ? 'active' : '' }}">
                    <i data-lucide="calendar"></i> Jadwal Pengambilan
                </a>
                <a href="{{ route('petugas.alumni') }}" class="menu-item {{ request()->routeIs('petugas.alumni') ? 'active' : '' }}">
                    <i data-lucide="users"></i> Data Alumni
                </a>
                <a href="{{ route('petugas.laporan') }}" class="menu-item {{ request()->routeIs('petugas.laporan') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-2"></i> Laporan
                </a>
                <a href="{{ route('petugas.notifikasi') }}" class="menu-item {{ request()->routeIs('petugas.notifikasi') ? 'active' : '' }}">
                    <i data-lucide="bell"></i> Notifikasi <span style="background:#EF4444; color:white; border-radius:10px; padding:2px 6px; font-size:10px; margin-left:auto;">2</span>
                </a>
                <a href="{{ route('petugas.profil') }}" class="menu-item {{ request()->routeIs('petugas.profil') ? 'active' : '' }}">
                    <i data-lucide="user"></i> Profil
                </a>
            @endif
        </nav>

        @auth
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i data-lucide="log-out"></i> Keluar
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="navbar">
            <button type="button" class="nav-toggle" data-nav-toggle aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
                <i data-lucide="menu"></i>
            </button>
            <div class="navbar-title">@yield('page-title', 'Dashboard')</div>

            @auth
            <a href="{{ Auth::user()->role === 'alumni' ? route('alumni.profil') : route('petugas.profil') }}" class="user-profile">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role === 'petugas' ? 'Petugas Kurikulum' : 'Alumni' }}</span>
                </div>
            </a>
            @endauth
        </header>

        <!-- Content Area -->
        <main class="content-body">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    <script src="{{ asset('js/docudemi-ui.js') }}"></script>
    @stack('scripts')
</body>
</html>