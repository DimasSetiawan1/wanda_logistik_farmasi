@extends('layouts.app')

@section('title', 'Master Obat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Master Obat</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <h4>Master Data Obat</h4>
    <a href="{{ route('medicines.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Obat
    </a>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama/kode obat..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    <option value="A" {{ request('kategori') == 'A' ? 'selected' : '' }}>Kategori A</option>
                    <option value="B" {{ request('kategori') == 'B' ? 'selected' : '' }}>Kategori B</option>
                    <option value="C" {{ request('kategori') == 'C' ? 'selected' : '' }}>Kategori C</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('medicines.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
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
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga/Unit</th>
                        <th class="text-end">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicines as $i => $medicine)
                        <tr>
                            <td>{{ $medicines->firstItem() + $i }}</td>
                            <td><code>{{ $medicine->kode_obat }}</code></td>
                            <td class="fw-semibold">{{ $medicine->nama_obat }}</td>
                            <td>{{ $medicine->satuan }}</td>
                            <td>
                                <span class="badge badge-kategori-{{ strtolower($medicine->kategori) }}">{{ $medicine->kategori }}</span>
                            </td>
                            <td class="text-end">Rp {{ number_format($medicine->harga_per_unit, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($medicine->stok_aktual) }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('medicines.edit', $medicine) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" onsubmit="return confirm('Yakin hapus obat ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data obat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($medicines->hasPages())
        <div class="card-footer bg-transparent">
            {{ $medicines->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
