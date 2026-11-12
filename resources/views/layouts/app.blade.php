<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'IT Helpdesk') - Portal Layanan IT</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --sidebar-width: 265px;
            --sidebar-bg: #0f172a;
            --body-bg: #f8fafc;
            --primary-blue: #2563eb;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --card-border: #e2e8f0;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.02);
            --card-shadow-hover: 0 12px 24px -4px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--body-bg);
            color: #1e293b;
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
            margin: 0;
        }

        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            min-height: 0;

            background: linear-gradient(
                180deg,
                #0f172a 0%,
                #090d16 100%
            );

            position: fixed;
            left: 0;
            top: 0;

            z-index: 1040;

            border-right: 1px solid rgba(255, 255, 255, 0.07);

            display: flex;
            flex-direction: column;

            overflow: hidden;

            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* =====================================================
           SIDEBAR BRAND
        ===================================================== */

        .sidebar-brand {
            height: 74px;
            min-height: 74px;

            display: flex;
            align-items: center;

            padding: 0 22px;

            color: white;
            text-decoration: none;

            border-bottom: 1px solid rgba(255, 255, 255, 0.06);

            gap: 12px;

            flex-shrink: 0;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #3b82f6 0%,
                #1d4ed8 100%
            );

            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            color: white;

            flex-shrink: 0;
        }

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand-title {
            font-size: 16px;
            font-weight: 700;
            color: #f8fafc;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .sidebar-brand-sub {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }


        /* =====================================================
           SIDEBAR MENU
           BAGIAN INI YANG BISA SCROLL
        ===================================================== */

        .sidebar-menu {
            padding: 16px 14px;

            flex: 1 1 auto;

            min-height: 0;

            overflow-y: auto;
            overflow-x: hidden;

            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.35) transparent;
        }


        /* Scrollbar Chrome / Edge */

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.35);
            border-radius: 10px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.6);
        }


        /* =====================================================
           SIDEBAR SECTION
        ===================================================== */

        .sidebar-section-title {
            font-size: 11px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 0.08em;

            color: #475569;

            padding: 14px 12px 6px;
        }


        /* =====================================================
           SIDEBAR MENU LINK
        ===================================================== */

        .sidebar-menu a {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 10px 14px;

            margin-bottom: 4px;

            color: #94a3b8;

            text-decoration: none;

            border-radius: 10px;

            font-size: 14px;
            font-weight: 500;

            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-menu a .menu-icon {
            width: 32px;
            height: 32px;

            border-radius: 8px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.04);

            font-size: 16px;

            transition: all 0.2s ease;

            flex-shrink: 0;
        }

        .sidebar-menu a:hover {
            color: #ffffff;

            background-color: rgba(255, 255, 255, 0.06);

            transform: translateX(3px);
        }

        .sidebar-menu a:hover .menu-icon {
            background: rgba(255, 255, 255, 0.1);
            color: #60a5fa;
        }

        .sidebar-menu a.active {
            background: linear-gradient(
                135deg,
                #2563eb 0%,
                #1d4ed8 100%
            );

            color: #ffffff;

            font-weight: 600;

            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .sidebar-menu a.active .menu-icon {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }


        /* =====================================================
           SIDEBAR FOOTER
           PROFIL + LOGOUT TETAP DI BAWAH
        ===================================================== */

        .sidebar-footer {
            padding: 16px;

            border-top: 1px solid rgba(255, 255, 255, 0.06);

            background: rgba(0, 0, 0, 0.15);

            flex-shrink: 0;
        }

        .sidebar-user-card {
            background: rgba(255, 255, 255, 0.05);

            border: 1px solid rgba(255, 255, 255, 0.08);

            border-radius: 12px;

            padding: 10px 12px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .main-content {
            margin-left: var(--sidebar-width);

            min-height: 100vh;

            display: flex;
            flex-direction: column;

            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* =====================================================
           TOP NAVBAR
        ===================================================== */

        .top-navbar {
            height: 74px;

            background: rgba(255, 255, 255, 0.88);

            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            border-bottom: 1px solid var(--card-border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 28px;

            position: sticky;

            top: 0;

            z-index: 1020;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content-wrapper {
            padding: 28px;

            flex-grow: 1;
        }


        /* =====================================================
           GLOBAL COMPONENT
        ===================================================== */

        .card {
            border: 1px solid var(--card-border);

            border-radius: 16px;

            box-shadow: var(--card-shadow);

            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-3px);

            box-shadow: var(--card-shadow-hover);

            border-color: #cbd5e1;
        }


        /* =====================================================
           STAT CARD
        ===================================================== */

        .stat-card {
            border: 1px solid var(--card-border);

            border-radius: 16px;

            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);

            box-shadow: var(--card-shadow-hover);
        }

        .stat-icon {
            width: 52px;
            height: 52px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;

            flex-shrink: 0;
        }


        /* =====================================================
           BADGES
        ===================================================== */

        .badge {
            font-weight: 600;

            padding: 0.45em 0.85em;

            border-radius: 9999px;

            letter-spacing: 0.02em;
        }

        .badge-soft-primary {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-soft-success {
            background-color: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-soft-warning {
            background-color: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-soft-danger {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .badge-soft-info {
            background-color: #f0fdfa;
            color: #0f766e;
            border: 1px solid #99f6e4;
        }

        .badge-soft-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-control,
        .form-select {
            border-radius: 10px;

            border: 1px solid #cbd5e1;

            padding: 0.6rem 0.95rem;

            font-size: 0.925rem;

            color: #1e293b;

            transition: all 0.15s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;

            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }


        /* =====================================================
           BUTTON
        ===================================================== */

        .btn {
            border-radius: 10px;

            font-weight: 600;

            padding: 0.55rem 1.15rem;

            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);

            letter-spacing: -0.01em;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(
                135deg,
                #2563eb 0%,
                #1d4ed8 100%
            );

            border: none;

            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(
                135deg,
                #1d4ed8 0%,
                #1e40af 100%
            );

            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table thead th {
            background: #f8fafc;

            color: #64748b;

            font-size: 0.725rem;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.06em;

            border-bottom: 1px solid #e2e8f0;

            padding: 13px 16px;
        }

        .table tbody td {
            padding: 14px 16px;

            border-bottom: 1px solid #f1f5f9;

            color: #1e293b;

            vertical-align: middle;

            font-size: 0.92rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc;
        }


        /* =====================================================
           USER PROFILE CHIP
        ===================================================== */

        .user-profile-chip {
            background: #ffffff;

            border: 1px solid #e2e8f0;

            border-radius: 9999px;

            padding: 6px 14px 6px 8px;

            display: inline-flex;

            align-items: center;

            gap: 10px;

            text-decoration: none;

            color: #1e293b;

            transition: all 0.2s ease;

            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .user-profile-chip:hover {
            background: #f8fafc;

            border-color: #cbd5e1;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);

            transform: translateY(-1px);
        }

        .user-avatar-circle {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #3b82f6 0%,
                #1d4ed8 100%
            );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;

            position: relative;

            flex-shrink: 0;
        }

        .online-dot {
            width: 10px;
            height: 10px;

            background-color: #22c55e;

            border: 2px solid white;

            border-radius: 50%;

            position: absolute;

            bottom: 0;
            right: 0;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        .sidebar-overlay {
            position: fixed;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            background: rgba(15, 23, 42, 0.6);

            backdrop-filter: blur(4px);

            z-index: 1030;

            display: none;

            opacity: 0;

            transition: opacity 0.3s ease;
        }


        @media (max-width: 991.98px) {

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;

                opacity: 1;
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                padding: 18px;
            }

            .top-navbar {
                padding: 0 18px;
            }
        }


        /* =====================================================
           MOBILE SIDEBAR FOOTER
        ===================================================== */

        @media (max-width: 991.98px) {

            .sidebar-footer {
                padding: 12px;
            }

            .sidebar-menu {
                padding: 12px 10px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


    <!-- MOBILE OVERLAY -->

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    <!-- =====================================================
         SIDEBAR
    ===================================================== -->

    <aside class="sidebar" id="sidebar">


        <!-- BRAND LOGO -->

        <a href="
            @if(auth()->user()->role === 'it')
                {{ route('it.dashboard') }}
            @else
                {{ route('pegawai.dashboard') }}
            @endif
        " class="sidebar-brand">

            <div class="sidebar-brand-icon">

                <i class="bi bi-headset"></i>

            </div>


            <div class="sidebar-brand-text">

                <span class="sidebar-brand-title">
                    IT Helpdesk
                </span>

                <span class="sidebar-brand-sub">
                    Service Portal
                </span>

            </div>

        </a>


        <!-- =====================================================
             MENU SIDEBAR
        ===================================================== -->

        <div class="sidebar-menu">


            <!-- MENU UTAMA -->

            <div class="sidebar-section-title">
                Menu Utama
            </div>


            @if(auth()->user()->role === 'it')

                <a href="{{ route('it.dashboard') }}"
                   class="{{ request()->routeIs('it.dashboard') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-grid"></i>
                    </span>

                    <span>
                        Dashboard IT
                    </span>

                </a>

            @else

                <a href="{{ route('pegawai.dashboard') }}"
                   class="{{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-grid"></i>
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>

            @endif



            <!-- =================================================
                 MENU PEGAWAI
            ================================================= -->

            @if(auth()->user()->role === 'pegawai')

                <div class="sidebar-section-title">
                    Layanan Tiket
                </div>


                <a href="{{ route('pegawai.tickets.create') }}"
                   class="{{ request()->routeIs('pegawai.tickets.create') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-plus-circle"></i>
                    </span>

                    <span>
                        Buat Tiket Baru
                    </span>

                </a>


                <a href="{{ route('pegawai.tickets.index') }}"
                   class="{{ request()->routeIs('pegawai.tickets.index', 'pegawai.tickets.show') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-ticket-perforated"></i>
                    </span>

                    <span>
                        Tiket Saya
                    </span>

                </a>

            @endif



            <!-- =================================================
                 MENU IT
            ================================================= -->

            @if(auth()->user()->role === 'it')

                <div class="sidebar-section-title">
                    Manajemen Tiket
                </div>


                <a href="{{ route('it.tickets.index') }}"
                   class="{{ request()->routeIs('it.tickets.index') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-inbox"></i>
                    </span>

                    <span>
                        Tiket Masuk
                    </span>

                </a>


                <a href="{{ route('it.tickets.all') }}"
                   class="{{ request()->routeIs('it.tickets.all') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-ticket-detailed"></i>
                    </span>

                    <span>
                        Semua Tiket
                    </span>

                </a>


                <a href="{{ route('it.tickets.history') }}"
                   class="{{ request()->routeIs('it.tickets.history') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-clock-history"></i>
                    </span>

                    <span>
                        Riwayat
                    </span>

                </a>


                <!-- ANALITIK -->

                <div class="sidebar-section-title">
                    Analitik & Rekap
                </div>


                <a href="{{ route('it.reports.index') }}"
                   class="{{ request()->routeIs('it.reports*') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <i class="bi bi-bar-chart-line"></i>
                    </span>

                    <span>
                        Laporan
                    </span>

                </a>

            @endif



            <!-- =================================================
                 PENGATURAN
            ================================================= -->

            <div class="sidebar-section-title">
                Pengaturan
            </div>


            <a href="{{ route('profile.edit') }}"
               class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">

                <span class="menu-icon">
                    <i class="bi bi-person-gear"></i>
                </span>

                <span>
                    Profil Akun
                </span>

            </a>


        </div>


        <!-- =====================================================
             SIDEBAR FOOTER
        ===================================================== -->

        <div class="sidebar-footer">


            <!-- USER CARD -->

            <div class="sidebar-user-card mb-2">

                <div class="d-flex align-items-center gap-2 overflow-hidden">


                    <div class="user-avatar-circle"
                         style="width: 32px; height: 32px; font-size: 15px;">

                        <i class="bi bi-person"></i>

                    </div>


                    <div class="text-truncate">


                        <div class="text-white small fw-bold text-truncate">

                            {{ auth()->user()->name }}

                        </div>


                        <span
                            class="badge
                            {{ auth()->user()->role === 'it'
                                ? 'badge-soft-primary'
                                : 'badge-soft-secondary' }}
                            px-2 py-0"
                            style="font-size: 10px;">

                            {{ auth()->user()->role === 'it'
                                ? 'IT Support'
                                : 'Pegawai' }}

                        </span>


                    </div>

                </div>

            </div>


            <!-- LOGOUT -->

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center gap-2"
                    style="border-radius: 8px;">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Keluar (Logout)
                    </span>

                </button>

            </form>


        </div>


    </aside>



    <!-- =====================================================
         MAIN CONTENT
    ===================================================== -->

    <main class="main-content">


        <!-- TOP NAVBAR -->

        <nav class="top-navbar">


            <div class="d-flex align-items-center gap-3">


                <!-- HAMBURGER MOBILE -->

                <button
                    class="btn btn-light d-lg-none p-2 border"
                    id="sidebarToggle"
                    type="button"
                    aria-label="Toggle Sidebar">

                    <i class="bi bi-list fs-5"></i>

                </button>


                <div>

                    <h5 class="fw-bold mb-0 text-dark">

                        @yield('page-title', 'Dashboard')

                    </h5>


                    <small class="text-muted d-none d-sm-inline">

                        <i class="bi bi-calendar3 me-1"></i>

                        {{ now()->translatedFormat('l, d F Y') }}

                    </small>

                </div>


            </div>


            <!-- =================================================
                 PROFILE CHIP KANAN
            ================================================= -->

            <a href="{{ route('profile.edit') }}"
               class="user-profile-chip ms-auto">


                <div class="user-avatar-circle">

                    <i class="bi bi-person-fill"></i>

                    <span class="online-dot"></span>

                </div>


                <div class="text-end d-none d-sm-block">


                    <div
                        class="fw-bold text-dark lh-sm"
                        style="font-size: 13px;">

                        {{ auth()->user()->name }}

                    </div>


                    <span
                        class="badge
                        {{ auth()->user()->role === 'it'
                            ? 'badge-soft-primary'
                            : 'badge-soft-success' }}
                        py-0 px-2 mt-1"
                        style="font-size: 10px;">

                        {{ auth()->user()->role === 'it'
                            ? 'IT Support'
                            : 'Pegawai' }}

                    </span>


                </div>


                <i class="bi bi-chevron-right text-muted small ms-1"></i>


            </a>


        </nav>



        <!-- =====================================================
             CONTENT
        ===================================================== -->

        <div class="content-wrapper">

            @yield('content')

        </div>


    </main>



    <!-- =====================================================
         BOOTSTRAP JS
    ===================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <!-- =====================================================
         SIDEBAR MOBILE TOGGLE
    ===================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function() {

            const toggleBtn = document.getElementById('sidebarToggle');

            const sidebar = document.getElementById('sidebar');

            const overlay = document.getElementById('sidebarOverlay');


            if (toggleBtn && sidebar && overlay) {


                toggleBtn.addEventListener('click', function() {

                    sidebar.classList.toggle('show');

                    overlay.classList.toggle('show');

                });


                overlay.addEventListener('click', function() {

                    sidebar.classList.remove('show');

                    overlay.classList.remove('show');

                });

            }

        });

    </script>


    @stack('scripts')


</body>

</html>