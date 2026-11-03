<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - Pelindo Inventory
    </title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


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
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050;
            padding: 18px 12px;
            overflow-y: auto;
            background: #FFFFFF;
            color: var(--pelindo-text);
            border-right: 1px solid var(--pelindo-border);
            box-shadow: 3px 0 15px rgba(28, 78, 125, 0.04);
        }

        .sidebar-brand {
            margin: -18px -12px 22px;
            padding: 22px 14px 20px;
            text-align: center;
            background: #FFFFFF;
            border-bottom: 1px solid var(--pelindo-border);
        }

        
        .pelindo-logo-wrap {
            width: 100%;
            min-height: 95px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .pelindo-logo {
            display: block;
            width: 220px;
            max-width: 100%;
            max-height: 90px;
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
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
        }

        .pelindo-brand-subtitle {
            display: block;
            margin-top: 5px;
            color: var(--pelindo-muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .menu-title {
            margin: 22px 12px 8px;
            color: var(--pelindo-muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 11px 13px;
            margin-bottom: 5px;
            border-radius: 9px;
            text-decoration: none;
            color: #526B87;
            font-size: 13px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar a i {
            width: 22px;
            margin-right: 10px;
            color: var(--pelindo-blue);
            font-size: 17px;
            text-align: center;
        }

        .sidebar a:hover {
            background: var(--pelindo-blue-light);
            color: var(--pelindo-blue-dark);
        }

        .sidebar a:hover i {
            color: var(--pelindo-blue-dark);
        }

        
        /* Menu sidebar yang sedang aktif */
        .sidebar a.active {
            background: var(--pelindo-blue-light);
            color: var(--pelindo-blue-dark);
            font-weight: 700;
        }

        .sidebar a.active i {
            color: var(--pelindo-blue-dark);
        }


        /* MAIN CONTENT */
        .main-content {
            min-height: 100vh;
            margin-left: 250px;
            background: var(--pelindo-bg);
        }

        /* TOPBAR */
        .topbar {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--pelindo-border);
        }

        .page-title {
            color: var(--pelindo-blue-dark);
            font-size: 20px;
            font-weight: 700;
        }

        /* CONTENT */
        .content {
            padding: 30px;
        }

        /* USER INFO */
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
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
            width: 38px;
            height: 38px;
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
            padding: 5px;
            border: none;
            background: transparent;
            color: #7186A0;
            cursor: pointer;
        }

        .logout-btn:hover {
            color: #DC3545;
        }

        /* MOBILE MENU */
        .mobile-menu-btn {
            display: none;
            border: none;
            background: transparent;
            color: var(--pelindo-blue);
            font-size: 24px;
        }

        /* DASHBOARD CARDS */
        .card {
            overflow: hidden;
            border: 1px solid var(--pelindo-border);
            border-radius: 12px;
            background: #FFFFFF;
            box-shadow: 0 4px 14px rgba(31, 82, 130, 0.05);
        }

        /* FORM AND TABLE */
        .form-control,
        .form-select {
            border-color: #D7E3F0;
            border-radius: 8px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--pelindo-blue);
            box-shadow: 0 0 0 3px rgba(7, 136, 216, 0.12);
        }

        .table {
            --bs-table-bg: transparent;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                height: 64px;
                padding: 0 15px;
            }

            .content {
                padding: 20px 15px;
            }

            .mobile-menu-btn {
                display: inline-block !important;
            }

            .user-name,
            .user-role {
                display: none;
            }

            .pelindo-logo {
                width: 175px;
                max-height: 72px;
            }
        }
    </style>

    @stack('styles')

</head>


<body>


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

            <div class="pelindo-brand-title">Pelindo Inventory</div>

            <small class="pelindo-brand-subtitle">
                IT Server Room — Regional 1
            </small>

        </div>



        <!-- MENU UTAMA -->

        <div class="menu-title">
            Menu Utama
        </div>

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>


        <!-- INVENTARIS -->

        <div class="menu-title">
            Inventaris
        </div>

        <a href="{{ route('assets.index') }}">

            <i class="bi bi-box-seam"></i>

            Data Asset

        </a>

        <a href="{{ route('scan.index') }}">
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

        <a href="#">

            <i class="bi bi-file-earmark-bar-graph"></i>

            Laporan Asset

        </a>


        <!-- ADMIN -->

        @if(auth()->user()->role && auth()->user()->role->name === 'admin')

            <div class="menu-title">
                Administrator
            </div>

            <a href="#">

                <i class="bi bi-people"></i>

                Kelola User

            </a>

            <a href="#">

                <i class="bi bi-tags"></i>

                Kategori Asset

            </a>

            <a href="#">

                <i class="bi bi-geo-alt"></i>

                Lokasi

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

            sidebar.classList.toggle('show');

        }

    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @stack('scripts')

</body>

</html>