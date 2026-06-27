@extends('layouts.app')

@section('title', 'Analisis ABC')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Analisis ABC</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-pie-chart text-primary me-2"></i>Fase 3 — Analisis ABC</h4>
    <p class="text-muted mb-0" style="font-size: 0.85rem;">Klasifikasi obat berdasarkan nilai pakai (jumlah × harga)</p>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    @foreach($summary as $kat => $data)
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge badge-kategori-{{ strtolower($kat) }} fs-6 px-3">Kategori {{ $kat }}</span>
                        <span class="fw-bold fs-4">{{ $data['count'] }}</span>
                    </div>
                    <div class="progress mb-2" style="height: 6px;">
                        <div class="progress-bar badge-kategori-{{ strtolower($kat) }}" style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                    <small class="text-muted">{{ $data['percentage'] }}% total item — {{ $data['description'] }}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <!-- Chart -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Distribusi ABC</div>
            <div class="card-body">
                <canvas id="abcChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Detail Klasifikasi ABC</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th class="text-end">Total Permintaan</th>
                                <th class="text-end">Harga/Unit</th>
                                <th class="text-end">Nilai Pakai</th>
                                <th class="text-end">%</th>
                                <th class="text-end">Kumulatif</th>
                                <th class="text-center">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($analysisData as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="fw-semibold">{{ $item['medicine']->nama_obat }}</td>
                                    <td class="text-end">{{ number_format($item['total_permintaan']) }}</td>
                                    <td class="text-end">Rp {{ number_format($item['harga_per_unit'], 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item['nilai_pakai'], 0, ',', '.') }}</td>
                                    <td class="text-end">{{ $item['persentase'] }}%</td>
                                    <td class="text-end">{{ $item['kumulatif'] }}%</td>
                                    <td class="text-center">
                                        <span class="badge badge-kategori-{{ strtolower($item['kategori_abc']) }}">{{ $item['kategori_abc'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">Belum ada data untuk analisis</td>
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
    const abcCtx = document.getElementById('abcChart').getContext('2d');
    new Chart(abcCtx, {
        type: 'doughnut',
        data: {
            labels: ['Kategori A', 'Kategori B', 'Kategori C'],
            datasets: [{
                data: [{{ $summary['A']['count'] }}, {{ $summary['B']['count'] }}, {{ $summary['C']['count'] }}],
                backgroundColor: ['#dc2626', '#d97706', '#059669'],
                borderWidth: 0,
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 }, padding: 15 }
                }
            },
            cutout: '60%',
        }
    });
</script>
@endpush
