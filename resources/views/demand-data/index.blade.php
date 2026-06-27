@extends('layouts.app')

@section('title', 'Data Permintaan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Permintaan</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <h4>Data Permintaan Obat</h4>
    <a href="{{ route('demand-data.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Data
    </a>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama obat..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="medicine_id" class="form-select form-select-sm">
                    <option value="">Semua Obat</option>
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}" {{ request('medicine_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_obat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('demand-data.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
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
                        <th>Periode</th>
                        <th class="text-end">Jumlah Permintaan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandData as $i => $d)
                        <tr>
                            <td>{{ $demandData->firstItem() + $i }}</td>
                            <td><code>{{ $d->medicine->kode_obat }}</code></td>
                            <td>{{ $d->medicine->nama_obat }}</td>
                            <td>{{ $d->periode }}</td>
                            <td class="text-end">{{ number_format($d->jumlah_permintaan) }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('demand-data.edit', $d) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('demand-data.destroy', $d) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data permintaan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($demandData->hasPages())
        <div class="card-footer bg-transparent">
            {{ $demandData->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
