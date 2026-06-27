@extends('layouts.app')

@section('title', 'Hasil Min-Max')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Min-Max Stock</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-bar-chart-line text-success me-2"></i>Fase 2 — Penetapan Batas Stok Min-Max</h4>
    <p class="text-muted mb-0" style="font-size: 0.85rem;">Safety Stock, Reorder Point, Stok Minimum & Maksimum</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th class="text-end">LT (hari)</th>
                        <th class="text-end">Z</th>
                        <th class="text-end bg-info bg-opacity-10">Safety Stock</th>
                        <th class="text-end bg-warning bg-opacity-10">ROP</th>
                        <th class="text-end bg-danger bg-opacity-10">Stok Min</th>
                        <th class="text-end bg-success bg-opacity-10">Stok Max</th>
                        <th class="text-end">Stok Aktual</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calculations as $i => $calc)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $calc->medicine->nama_obat }}</td>
                            <td class="text-end">{{ $calc->eoqParameter->lead_time }}</td>
                            <td class="text-end">{{ $calc->eoqParameter->service_level_z }}</td>
                            <td class="text-end bg-info bg-opacity-10">{{ number_format($calc->safety_stock, 2) }}</td>
                            <td class="text-end bg-warning bg-opacity-10">{{ number_format($calc->reorder_point, 2) }}</td>
                            <td class="text-end bg-danger bg-opacity-10 fw-bold">{{ number_format($calc->stok_minimum, 2) }}</td>
                            <td class="text-end bg-success bg-opacity-10 fw-bold">{{ number_format($calc->stok_maksimum, 2) }}</td>
                            <td class="text-end">{{ number_format($calc->medicine->stok_aktual) }}</td>
                            <td class="text-center">
                                @if($calc->status === 'perlu_pesan')
                                    <span class="badge bg-danger">Perlu Pesan</span>
                                @elseif($calc->status === 'overstock')
                                    <span class="badge bg-warning">Overstock</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Belum ada perhitungan. <a href="{{ route('eoq.index') }}">Hitung EOQ terlebih dahulu</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
