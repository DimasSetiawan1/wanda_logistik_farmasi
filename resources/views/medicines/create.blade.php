@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('medicines.index') }}">Master Obat</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="page-header">
    <h4>Tambah Data Obat</h4>
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

        <form method="POST" action="{{ route('medicines.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" value="{{ old('kode_obat') }}" placeholder="OBT001" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" placeholder="Paracetamol 500mg" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-select" required>
                        <option value="">Pilih...</option>
                        <option value="Tablet" {{ old('satuan') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="Kapsul" {{ old('satuan') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                        <option value="Vial" {{ old('satuan') == 'Vial' ? 'selected' : '' }}>Vial</option>
                        <option value="Ampul" {{ old('satuan') == 'Ampul' ? 'selected' : '' }}>Ampul</option>
                        <option value="Tube" {{ old('satuan') == 'Tube' ? 'selected' : '' }}>Tube</option>
                        <option value="Sachet" {{ old('satuan') == 'Sachet' ? 'selected' : '' }}>Sachet</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori ABC</label>
                    <select name="kategori" class="form-select" required>
                        <option value="C" {{ old('kategori') == 'C' ? 'selected' : '' }}>C — Low Value</option>
                        <option value="B" {{ old('kategori') == 'B' ? 'selected' : '' }}>B — Medium Value</option>
                        <option value="A" {{ old('kategori') == 'A' ? 'selected' : '' }}>A — High Value</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Harga/Unit (Rp)</label>
                    <input type="number" name="harga_per_unit" class="form-control" value="{{ old('harga_per_unit') }}" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stok Aktual</label>
                    <input type="number" name="stok_aktual" class="form-control" value="{{ old('stok_aktual', 0) }}" min="0" required>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
