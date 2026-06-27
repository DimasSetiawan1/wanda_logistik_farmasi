@extends('layouts.app')

@section('title', 'Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Laporan Output</h4>
        <p class="text-muted mb-0" style="font-size: 0.85rem;">Rekomendasi EOQ* & Batas Min-Max untuk setiap item obat RSPH</p>
    </div>
    <a href="{{ route('reports.pdf') }}" class="btn btn-danger">
        <i class="bi bi-file-pdf me-1"></i> Export PDF
    </a>
</div>

<!-- Tabel Rekomendasi EOQ & Min-Max -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Rekomendasi EOQ & Batas Min-Max
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th class="text-center">Kat.</th>
                        <th class="text-end">Stok Aktual</th>
                        <th class="text-end bg-primary bg-opacity-10">EOQ*</th>
                        <th class="text-end">Frekuensi</th>
                        <th class="text-end bg-danger bg-opacity-10">Stok Min</th>
                        <th class="text-end bg-success bg-opacity-10">Stok Max</th>
                        <th class="text-end">Safety Stock</th>
                        <th class="text-end">ROP</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calculations as $i => $calc)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><code>{{ $calc->medicine->kode_obat }}</code></td>
                            <td class="fw-semibold">{{ $calc->medicine->nama_obat }}</td>
                            <td class="text-center">
                                <span class="badge badge-kategori-{{ strtolower($calc->medicine->kategori) }}">{{ $calc->medicine->kategori }}</span>
                            </td>
                            <td class="text-end">{{ number_format($calc->medicine->stok_aktual) }}</td>
                            <td class="text-end bg-primary bg-opacity-10 fw-bold">{{ number_format($calc->eoq_value, 0) }}</td>
                            <td class="text-end">{{ number_format($calc->frekuensi_pesan, 1) }}×</td>
                            <td class="text-end bg-danger bg-opacity-10">{{ number_format($calc->stok_minimum, 0) }}</td>
                            <td class="text-end bg-success bg-opacity-10">{{ number_format($calc->stok_maksimum, 0) }}</td>
                            <td class="text-end">{{ number_format($calc->safety_stock, 0) }}</td>
                            <td class="text-end">{{ number_format($calc->reorder_point, 0) }}</td>
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
                            <td colspan="12" class="text-center text-muted py-4">Belum ada data perhitungan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
