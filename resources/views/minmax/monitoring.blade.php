@extends('layouts.app')

@section('title', 'Monitoring Stok')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Monitoring Stok</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-activity text-info me-2"></i>Monitoring Stok Aktual</h4>
        <p class="text-muted mb-0" style="font-size: 0.85rem;">Perbandingan stok aktual vs batas Min-Max</p>
    </div>
    <form method="POST" action="{{ route('orders.auto') }}">
        @csrf
        <button type="submit" class="btn btn-danger" onclick="return confirm('Buat pesanan otomatis untuk semua obat yang stoknya di bawah minimum?')">
            <i class="bi bi-cart-plus me-1"></i> Pesan Otomatis ({{ $summary['perlu_pesan'] }} obat)
        </button>
    </form>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-success">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem;">Normal</div>
                    <div class="fw-bold fs-4 text-success">{{ $summary['normal'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-danger">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem;">Perlu Pesan</div>
                    <div class="fw-bold fs-4 text-danger">{{ $summary['perlu_pesan'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="text-muted" style="font-size: 0.75rem;">Overstock</div>
                    <div class="fw-bold fs-4 text-warning">{{ $summary['overstock'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monitoring Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th class="text-end">Stok Aktual</th>
                        <th class="text-end">Stok Min</th>
                        <th class="text-end">Stok Max</th>
                        <th>Level Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calculations as $i => $calc)
                        @php
                            $stok = $calc->medicine->stok_aktual;
                            $min = $calc->stok_minimum;
                            $max = $calc->stok_maksimum;
                            $pct = $max > 0 ? min(($stok / $max) * 100, 100) : 0;
                            $barColor = $calc->status === 'perlu_pesan' ? 'bg-danger' : ($calc->status === 'overstock' ? 'bg-warning' : 'bg-success');
                        @endphp
                        <tr class="{{ $calc->status === 'perlu_pesan' ? 'table-danger' : ($calc->status === 'overstock' ? 'table-warning' : '') }}">
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $calc->medicine->nama_obat }}</td>
                            <td class="text-end fw-bold">{{ number_format($stok) }}</td>
                            <td class="text-end text-danger">{{ number_format($min, 0) }}</td>
                            <td class="text-end text-success">{{ number_format($max, 0) }}</td>
                            <td style="min-width: 150px;">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar {{ $barColor }}" style="width: {{ $pct }}%"></div>
                                </div>
                                <small class="text-muted">{{ number_format($pct, 0) }}%</small>
                            </td>
                            <td class="text-center">
                                @if($calc->status === 'perlu_pesan')
                                    <span class="badge bg-danger"><i class="bi bi-exclamation-triangle me-1"></i>Perlu Pesan</span>
                                @elseif($calc->status === 'overstock')
                                    <span class="badge bg-warning"><i class="bi bi-arrow-up me-1"></i>Overstock</span>
                                @else
                                    <span class="badge bg-success"><i class="bi bi-check me-1"></i>Normal</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($calc->status === 'perlu_pesan')
                                    <form method="POST" action="{{ route('orders.store') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="medicine_id" value="{{ $calc->medicine_id }}">
                                        <input type="hidden" name="jumlah_pesan" value="{{ ceil($calc->eoq_value) }}">
                                        <input type="hidden" name="keterangan" value="Pemesanan dari monitoring stok">
                                        <button class="btn btn-sm btn-danger" title="Pesan ({{ ceil($calc->eoq_value) }})">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data monitoring</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
