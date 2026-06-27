@extends('layouts.app')

@section('title', 'Evaluasi EOQ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Evaluasi EOQ</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-cash-stack text-warning me-2"></i>Evaluasi EOQ — Perbandingan Biaya</h4>
    <p class="text-muted mb-0" style="font-size: 0.85rem;">Review biaya total dengan EOQ vs tanpa EOQ</p>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-top border-4 border-primary">
            <div class="card-body text-center">
                <div class="text-muted mb-1" style="font-size: 0.75rem;">Biaya dengan EOQ</div>
                <div class="fw-bold fs-5 text-primary">Rp {{ number_format($totalBiayaEoq, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-top border-4 border-danger">
            <div class="card-body text-center">
                <div class="text-muted mb-1" style="font-size: 0.75rem;">Biaya tanpa EOQ</div>
                <div class="fw-bold fs-5 text-danger">Rp {{ number_format($totalBiayaTanpaEoq, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-top border-4 border-success">
            <div class="card-body text-center">
                <div class="text-muted mb-1" style="font-size: 0.75rem;">Penghematan</div>
                <div class="fw-bold fs-5 text-success">Rp {{ number_format($penghematan, 0, ',', '.') }}</div>
                <small class="text-muted">({{ $persentaseHemat }}%)</small>
            </div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Perbandingan Biaya</div>
            <div class="card-body">
                <canvas id="costChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Detail Biaya per Obat</div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="sticky-top bg-white">
                            <tr>
                                <th>Obat</th>
                                <th class="text-end">EOQ*</th>
                                <th class="text-end">TC (EOQ)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($calculations as $calc)
                                <tr>
                                    <td>{{ $calc->medicine->nama_obat }}</td>
                                    <td class="text-end">{{ number_format($calc->eoq_value, 0) }}</td>
                                    <td class="text-end">Rp {{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
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
    new Chart(document.getElementById('costChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Dengan EOQ', 'Tanpa EOQ'],
            datasets: [{
                label: 'Total Biaya',
                data: [{{ $totalBiayaEoq }}, {{ $totalBiayaTanpaEoq }}],
                backgroundColor: ['rgba(37, 99, 235, 0.8)', 'rgba(220, 38, 38, 0.8)'],
                borderRadius: 8,
                barThickness: 60,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v),
                        font: { size: 10 }
                    }
                }
            }
        }
    });
</script>
@endpush
