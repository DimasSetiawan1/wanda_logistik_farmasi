@extends('layouts.app')

@section('title', 'Hasil EOQ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('eoq.index') }}">Parameter EOQ</a></li>
    <li class="breadcrumb-item active">Hasil Perhitungan</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="bi bi-clipboard-data text-primary me-2"></i>Hasil Perhitungan EOQ</h4>
        <p class="text-muted mb-0" style="font-size: 0.85rem;">EOQ*, Frekuensi Pesan, dan Total Cost per obat</p>
    </div>
    <a href="{{ route('eoq.index') }}" class="btn btn-outline-primary">
        <i class="bi bi-calculator me-1"></i> Hitung Ulang
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th class="text-end">D (Permintaan)</th>
                        <th class="text-end">S (Biaya Pesan)</th>
                        <th class="text-end">H (Biaya Simpan)</th>
                        <th class="text-end bg-primary bg-opacity-10 text-primary fw-bold">EOQ*</th>
                        <th class="text-end">Frekuensi (F)</th>
                        <th class="text-end">Total Cost (TC)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calculations as $i => $calc)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><code>{{ $calc->medicine->kode_obat }}</code></td>
                            <td class="fw-semibold">{{ $calc->medicine->nama_obat }}</td>
                            <td class="text-end">{{ number_format($calc->eoqParameter->rata_rata_permintaan, 0) }}</td>
                            <td class="text-end">Rp {{ number_format($calc->eoqParameter->biaya_pesan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($calc->eoqParameter->biaya_simpan, 0, ',', '.') }}</td>
                            <td class="text-end bg-primary bg-opacity-10 fw-bold">{{ number_format($calc->eoq_value, 2) }}</td>
                            <td class="text-end">{{ number_format($calc->frekuensi_pesan, 2) }}×/tahun</td>
                            <td class="text-end">Rp {{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada hasil perhitungan. <a href="{{ route('eoq.index') }}">Hitung EOQ sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
