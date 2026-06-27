@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4>Dashboard</h4>
        <p class="text-muted mb-0" style="font-size: 0.85rem;">Selamat datang, {{ Auth::user()->name }}. Berikut ringkasan logistik farmasi RSPH.</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-capsule"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">Total Obat</div>
                    <div class="fw-bold fs-4">{{ $totalObat }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">Stok Kritis</div>
                    <div class="fw-bold fs-4">{{ $stokKritis }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">Overstock</div>
                    <div class="fw-bold fs-4">{{ $overstock }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 500;">Pesanan Aktif</div>
                    <div class="fw-bold fs-4">{{ $pesananAktif }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Chart Stok Terendah -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart me-2"></i>10 Obat dengan Stok Terendah</span>
            </div>
            <div class="card-body">
                <canvas id="stokChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Obat Perlu Dipesan -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-exclamation-triangle text-danger me-2"></i>Perlu Dipesan
            </div>
            <div class="card-body p-0">
                @if($perluPesan->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($perluPesan as $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $item->medicine->nama_obat }}</div>
                                    <small class="text-muted">Stok: {{ $item->medicine->stok_aktual }} | Min: {{ number_format($item->stok_minimum, 0) }}</small>
                                </div>
                                <span class="badge bg-danger">Kritis</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                        <p class="mt-2 mb-0" style="font-size: 0.85rem;">Semua stok dalam kondisi aman</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Pesanan Terbaru -->
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2"></i>Pesanan Terbaru</span>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Obat</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananTerbaru as $order)
                                <tr>
                                    <td>{{ $order->tanggal_pesan->format('d/m/Y') }}</td>
                                    <td>{{ $order->medicine->nama_obat }}</td>
                                    <td>{{ number_format($order->jumlah_pesan) }}</td>
                                    <td>
                                        @if($order->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->status === 'diproses')
                                            <span class="badge bg-info">Diproses</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const stokData = @json($stokData);
    const ctx = document.getElementById('stokChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stokData.map(d => d.nama_obat.length > 20 ? d.nama_obat.substr(0, 20) + '...' : d.nama_obat),
            datasets: [{
                label: 'Stok Aktual',
                data: stokData.map(d => d.stok_aktual),
                backgroundColor: stokData.map(d => d.stok_aktual < 100 ? 'rgba(220, 38, 38, 0.8)' : d.stok_aktual < 200 ? 'rgba(217, 119, 6, 0.8)' : 'rgba(37, 99, 235, 0.8)'),
                borderRadius: 6,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 } }
                }
            }
        }
    });
</script>
@endpush
