@extends('layouts.app')

@section('title', 'Edit Data Permintaan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('demand-data.index') }}">Data Permintaan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header">
    <h4>Edit Data Permintaan</h4>
</div>

<div class="card" style="max-width: 600px;">
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

        <form method="POST" action="{{ route('demand-data.update', $demandDatum) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Obat</label>
                <select name="medicine_id" class="form-select" required>
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}" {{ old('medicine_id', $demandDatum->medicine_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_obat }} — {{ $m->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Periode</label>
                <input type="text" name="periode" class="form-control" value="{{ old('periode', $demandDatum->periode) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Permintaan</label>
                <input type="number" name="jumlah_permintaan" class="form-control" value="{{ old('jumlah_permintaan', $demandDatum->jumlah_permintaan) }}" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
            <a href="{{ route('demand-data.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
