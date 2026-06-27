@extends('layouts.app')

@section('title', 'Edit Obat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('medicines.index') }}">Master Obat</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header">
    <h4>Edit Data Obat</h4>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('medicines.update', $medicine) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat', $medicine->kode_obat) }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat', $medicine->nama_obat) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        @foreach(['Tablet','Kapsul','Botol','Vial','Ampul','Tube','Sachet'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $medicine->satuan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori ABC</label>
                    <select name="kategori" class="form-select" required>
                        <option value="A" {{ old('kategori', $medicine->kategori) == 'A' ? 'selected' : '' }}>A — High Value</option>
                        <option value="B" {{ old('kategori', $medicine->kategori) == 'B' ? 'selected' : '' }}>B — Medium Value</option>
                        <option value="C" {{ old('kategori', $medicine->kategori) == 'C' ? 'selected' : '' }}>C — Low Value</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga/Unit (Rp)</label>
                    <input type="number" name="harga_per_unit" class="form-control" value="{{ old('harga_per_unit', $medicine->harga_per_unit) }}" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok Aktual</label>
                    <input type="number" name="stok_aktual" class="form-control" value="{{ old('stok_aktual', $medicine->stok_aktual) }}" min="0" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
