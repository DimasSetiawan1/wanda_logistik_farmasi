<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-hospital me-2"></i>RSPH Farmasi</h5>
        <small>Sistem Manajemen Logistik</small>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <!-- Input Data -->
        <div class="sidebar-heading">Input Data</div>
        <a href="{{ route('medicines.index') }}" class="sidebar-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
            <i class="bi bi-capsule"></i> Master Obat
        </a>
        <a href="{{ route('demand-data.index') }}" class="sidebar-link {{ request()->routeIs('demand-data.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Data Permintaan
        </a>

        <!-- Fase 1: EOQ -->
        <div class="sidebar-heading">Fase 1 — EOQ</div>
        <a href="{{ route('eoq.index') }}" class="sidebar-link {{ request()->routeIs('eoq.index') ? 'active' : '' }}">
            <i class="bi bi-calculator"></i> Parameter EOQ
        </a>
        <a href="{{ route('eoq.result') }}" class="sidebar-link {{ request()->routeIs('eoq.result') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i> Hasil EOQ
        </a>

        <!-- Fase 2: Min-Max -->
        <div class="sidebar-heading">Fase 2 — Min-Max Stock</div>
        <a href="{{ route('minmax.result') }}" class="sidebar-link {{ request()->routeIs('minmax.result') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Hasil Min-Max
        </a>
        <a href="{{ route('minmax.monitoring') }}" class="sidebar-link {{ request()->routeIs('minmax.monitoring') ? 'active' : '' }}">
            <i class="bi bi-activity"></i> Monitoring Stok
        </a>

        <!-- Pemesanan -->
        <div class="sidebar-heading">Pemesanan</div>
        <a href="{{ route('orders.index') }}" class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i> Daftar Pesanan
        </a>

        <!-- Fase 3: Evaluasi -->
        <div class="sidebar-heading">Fase 3 — Evaluasi</div>
        <a href="{{ route('evaluation.abc') }}" class="sidebar-link {{ request()->routeIs('evaluation.abc') ? 'active' : '' }}">
            <i class="bi bi-pie-chart"></i> Analisis ABC
        </a>
        <a href="{{ route('evaluation.eoq') }}" class="sidebar-link {{ request()->routeIs('evaluation.eoq') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Evaluasi EOQ
        </a>
        <a href="{{ route('evaluation.periodic') }}" class="sidebar-link {{ request()->routeIs('evaluation.periodic') ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat"></i> Review Periodik
        </a>

        <!-- Laporan -->
        <div class="sidebar-heading">Output</div>
        <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-pdf"></i> Laporan
        </a>

        <!-- Admin Only -->
        @if(Auth::user()->isAdmin())
        <div class="sidebar-heading">Admin</div>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Kelola User
        </a>
        @endif
    </nav>
</aside>
