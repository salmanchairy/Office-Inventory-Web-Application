<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - Pelindo Inventory
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        :root {
            --pelindo-blue: #0788D8;
            --pelindo-blue-dark: #07569B;
            --pelindo-blue-light: #E8F4FF;
            --pelindo-bg: #F4F8FD;
            --pelindo-text: #244363;
            --pelindo-muted: #7A8FA8;
            --pelindo-border: #E1EAF4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--pelindo-bg);
            color: var(--pelindo-text);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 270px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050;
            padding: 12px 12px 14px;
            overflow: hidden;
            background: #FFFFFF;
            color: var(--pelindo-text);
            border-right: 1px solid var(--pelindo-border);
            box-shadow: 8px 0 28px rgba(28, 78, 125, .08);
        }

        .sidebar::before { content: ""; position: absolute; inset: 0; pointer-events: none; }

        .sidebar-brand {
            position: relative;
            margin: -12px -12px 10px;
            padding: 13px 16px 10px;
            text-align: center;
            background: #FFFFFF;
            border-bottom: 1px solid var(--pelindo-border);
        }

        
        .pelindo-logo-wrap {
            width: 100%;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0;
        }

        .pelindo-logo {
            display: block;
            width: 178px;
            max-width: 100%;
            max-height: 56px;
            height: auto;
            object-fit: contain;
        }

        /* Penyesuaian untuk layar HP */
        @media (max-width: 768px) {
            .pelindo-logo-wrap {
                min-height: 82px;
                margin-bottom: 8px;
            }

            .pelindo-logo {
                width: 180px;
                max-height: 76px;
            }
        }

        .pelindo-brand-title {
            color: var(--pelindo-blue-dark);
            font-size: 17px;
            font-weight: 700;
            letter-spacing: .2px;
            line-height: 1.4;
        }

        .pelindo-brand-subtitle {
            display: block;
            margin-top: 5px;
            color: var(--pelindo-muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .menu-title {
            position: relative;
            margin: 10px 11px 4px;
            color: var(--pelindo-muted);
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            position: relative;
            min-height: 39px;
            padding: 8px 12px;
            margin-bottom: 2px;
            border: 1px solid transparent;
            border-radius: 10px;
            text-decoration: none;
            color: #526B87;
            font-size: 13px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease, transform .2s ease, border-color .2s ease;
        }

        .sidebar a i {
            width: 21px;
            margin-right: 10px;
            color: var(--pelindo-blue);
            font-size: 17px;
            text-align: center;
        }

        .sidebar a:hover {
            color: var(--pelindo-blue-dark);
            background: var(--pelindo-blue-light);
            border-color: transparent;
            transform: translateX(2px);
        }

        .sidebar a:hover i {
            color: var(--pelindo-blue-dark);
        }

        
        /* Menu sidebar yang sedang aktif */
        .sidebar a.active {
            color: var(--pelindo-blue-dark);
            background: var(--pelindo-blue-light);
            border-color: transparent;
            font-weight: 700;
            box-shadow: none;
        }

        .sidebar a.active i {
            color: var(--pelindo-blue-dark);
        }


        /* MAIN CONTENT */
        .main-content {
            min-height: 100vh;
            margin-left: 270px;
            background: transparent;
        }

        /* TOPBAR */
        .topbar {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 34px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--pelindo-border);
            backdrop-filter: blur(16px);
        }

        .page-title {
            color: var(--pelindo-blue-dark);
            font-size: 21px;
            font-weight: 700;
            letter-spacing: -.3px;
        }

        /* CONTENT */
        .content {
            padding: 32px 34px 42px;
        }

        /* USER INFO */
        .user-info {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 6px 8px 6px 13px;
            border: 1px solid #e4edf5;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 5px 15px rgba(24, 71, 117, .05);
        }

        .user-name {
            color: var(--pelindo-blue-dark);
            font-size: 14px;
            font-weight: 600;
        }

        .user-role {
            color: var(--pelindo-muted);
            font-size: 11px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--pelindo-blue-light);
            color: var(--pelindo-blue-dark);
            font-weight: 700;
        }

        /* LOGOUT */
        .logout-btn {
            padding: 5px 7px;
            border: none;
            background: transparent;
            color: #7186a0;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: #dc3545;
            background: #fff2f2;
            border-radius: 7px;
        }

        /* MOBILE MENU */
        .mobile-menu-btn {
            display: none;
            border: none;
            background: transparent;
            color: #126ab0;
            font-size: 24px;
        }

        /* DASHBOARD CARDS */
        .card {
            overflow: hidden;
            border: 1px solid rgba(218, 229, 241, .9);
            border-radius: 16px;
            background: #FFFFFF;
            box-shadow: 0 10px 28px rgba(31, 82, 130, .055);
        }

        /* FORM AND TABLE */
        .form-control,
        .form-select {
            border-color: #d7e3f0;
            border-radius: 9px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--pelindo-blue);
            box-shadow: 0 0 0 3px rgba(7, 136, 216, 0.12);
        }

        .table {
            --bs-table-bg: transparent;
        }

        .table thead th { color: #56718e; font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase; background: #f7faff; border-bottom-color: #e8eff6; }
        .table > :not(caption) > * > * { padding: .9rem 1rem; border-bottom-color: #edf2f7; }
        .btn { border-radius: 9px; font-weight: 600; }
        .alert { border: 0; border-radius: 12px; box-shadow: 0 8px 18px rgba(26, 70, 110, .05); }
        .sidebar-backdrop { display: none; }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 270px;
                transform: translateX(-100%);
                transition: transform .28s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-backdrop.show { display: block; position: fixed; inset: 0; z-index: 1040; background: rgba(3, 20, 44, .45); backdrop-filter: blur(2px); }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                min-height: 64px;
                padding: 0 15px;
            }

            .content {
                padding: 22px 15px 30px;
            }

            .mobile-menu-btn {
                display: inline-block !important;
            }

            .user-name,
            .user-role {
                display: none;
            }

            .pelindo-logo {
                width: 165px;
                max-height: 56px;
            }
        }

    </style>

    @stack('styles')

</head>


<body>


    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->

    <div class="sidebar" id="sidebar">
        
        <div class="sidebar-brand text-center">

            <div class="pelindo-logo-wrap">
                <img
                    src="{{ asset('images/Pelindo Logo.PNG') }}"
                    alt="Logo Pelindo"
                    class="pelindo-logo"
                >
            </div>

        </div>



        <!-- MENU UTAMA -->

        <div class="menu-title">
            Menu Utama
        </div>

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>


        <!-- INVENTARIS -->

        <div class="menu-title">
            Inventaris
        </div>

        <a href="{{ route('assets.index') }}"
           class="{{ request()->routeIs('assets.*') ? 'active' : '' }}">

            <i class="bi bi-box-seam"></i>

            Data Asset

        </a>

        <a href="{{ route('scan.index') }}"
           class="{{ request()->routeIs('scan.*') ? 'active' : '' }}">
            <i class="bi bi-qr-code-scan"></i>
            Scan QR / Barcode
        </a>

        <!-- PEMERIKSAAN -->

        <div class="menu-title">
            Pemeriksaan
        </div>

        
        {{-- MENU PEMERIKSAAN ASET --}}
        <a href="{{ route('inspections.index') }}"
        class="{{ request()->routeIs('inspections.index', 'inspections.create', 'inspections.store') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i>
            Pemeriksaan Asset
        </a>

        {{-- MENU RIWAYAT PEMERIKSAAN --}}
        <a href="{{ route('inspections.history') }}"
        class="{{ request()->routeIs('inspections.history') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            Riwayat Pemeriksaan
        </a>



        <!-- LAPORAN -->

        <div class="menu-title">
            Laporan
        </div>

        <a href="{{ route('reports.assets') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">

            <i class="bi bi-file-earmark-bar-graph"></i>

            Rekap & Ekspor Aset

        </a>


        <!-- ADMIN -->

        @if(auth()->user()->role && auth()->user()->role->name === 'admin')

            <div class="menu-title">
                Administrator
            </div>

            <a href="{{ route('users.index') }}"
               class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

                <i class="bi bi-people"></i>

                Kelola User

            </a>

            <a href="{{ route('categories.index') }}"
               class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">

                <i class="bi bi-tags"></i>

                Kategori Asset

            </a>

            <a href="{{ route('locations.index') }}"
               class="{{ request()->routeIs('locations.*', 'maps.*') ? 'active' : '' }}">

                <i class="bi bi-geo-alt"></i>

                Lokasi & Peta

            </a>

        @endif

    </div>


    <!-- MAIN CONTENT -->

    <div class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">


            <div class="d-flex align-items-center gap-3">

                <button
                    class="mobile-menu-btn"
                    onclick="toggleSidebar()"
                >

                    <i class="bi bi-list"></i>

                </button>


                <div class="page-title">

                    @yield('page-title', 'Dashboard')

                </div>

            </div>


            <!-- USER -->

            <div class="user-info">


                <div class="text-end">

                    <div class="user-name">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="user-role">

                        {{ ucfirst(auth()->user()->role->name ?? '-') }}

                    </div>

                </div>


                <div class="user-avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>


                <!-- LOGOUT -->

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="ms-2"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn"
                        title="Logout"
                    >

                        <i class="bi bi-box-arrow-right fs-5"></i>

                    </button>

                </form>


            </div>


        </div>


        <!-- PAGE CONTENT -->

        <div class="content">

            @yield('content')

        </div>


    </div>


    <script>

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const isOpen = sidebar.classList.toggle('show');
            backdrop.classList.toggle('show', isOpen);
        }

    </script>



    @stack('scripts')

</body>

</html>
