@extends('layouts.app')

@section('title', 'Min-Max')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Min-Max Stock</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-bar-chart-line text-success me-2"></i>Parameter Min-Max Stock</h4>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted">Hasil perhitungan Min-Max tersedia di halaman <a href="{{ route('minmax.result') }}">Hasil Min-Max</a>.</p>
        <p>Untuk menghitung ulang, kunjungi halaman <a href="{{ route('eoq.index') }}">Parameter EOQ</a>.</p>
    </div>
</div>
@endsection
