<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Logistik Farmasi RSPH</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #7c3aed;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --bg-light: #f1f5f9;
            --bg-sidebar: #1e293b;
            --text-sidebar: #cbd5e1;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: var(--text-sidebar);
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
        }

        .sidebar-brand small {
            color: #94a3b8;
            font-size: 0.7rem;
        }

        .sidebar-nav {
            padding: 0.75rem 0;
        }

        .sidebar-heading {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1rem 1.5rem 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 400;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-link.active {
            color: #fff;
            background: rgba(37, 99, 235, 0.15);
            border-left-color: var(--primary-color);
            font-weight: 500;
        }

        .sidebar-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1rem;
            text-align: center;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .content-wrapper {
            padding: 1.5rem;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        /* Tables */
        .table th {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }

        .table td {
            font-size: 0.85rem;
            vertical-align: middle;
        }

        /* Badges */
        .badge-kategori-a { background: #dc2626; }
        .badge-kategori-b { background: #d97706; }
        .badge-kategori-c { background: #059669; }

        .badge-status-normal { background: #059669; }
        .badge-status-perlu_pesan { background: #dc2626; }
        .badge-status-overstock { background: #d97706; }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 8px;
            border-color: #cbd5e1;
            font-size: 0.85rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.85rem;
        }

        /* Page header */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h4 {
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .page-header .breadcrumb {
            font-size: 0.8rem;
            margin: 0;
        }

        /* Responsive */
        .sidebar-toggle {
            display: none;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: inline-flex;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1045;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-dark sidebar-toggle me-2 p-0" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name }}
                        <span class="badge bg-primary ms-1" style="font-size: 0.65rem;">{{ ucfirst(Auth::user()->role) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.querySelector('#sidebarOverlay').classList.toggle('show');
        }

        // Format number with thousand separator
        function formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
        }
    </script>

    @stack('scripts')
</body>
</html>
