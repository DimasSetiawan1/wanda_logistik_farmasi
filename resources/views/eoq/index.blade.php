@extends('layouts.app')

@section('title', 'Parameter EOQ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Parameter EOQ</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-calculator text-primary me-2"></i>Fase 1 — Perhitungan EOQ</h4>
    <p class="text-muted mb-0" style="font-size: 0.85rem;">Economic Order Quantity — Kuantitas Pemesanan Optimal</p>
</div>

<div class="row g-4">
    <!-- Form Input Parameter -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-sliders me-2"></i>Input Parameter EOQ
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('eoq.calculate') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Obat</label>
                        <select name="medicine_id" class="form-select" id="medicineSelect" required>
                            <option value="">Pilih obat...</option>
                            @foreach($medicines as $m)
                                <option value="{{ $m->id }}"
                                    data-d="{{ $m->latestEoqParameter->rata_rata_permintaan ?? '' }}"
                                    data-s="{{ $m->latestEoqParameter->biaya_pesan ?? '' }}"
                                    data-h="{{ $m->latestEoqParameter->biaya_simpan ?? '' }}"
                                    data-i="{{ $m->latestEoqParameter->faktor_biaya_simpan ?? '0.1' }}"
                                    data-lt="{{ $m->latestEoqParameter->lead_time ?? '' }}"
                                    data-z="{{ $m->latestEoqParameter->service_level_z ?? '1.65' }}"
                                    {{ old('medicine_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->kode_obat }} — {{ $m->nama_obat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-3 bg-light rounded mb-3">
                        <small class="fw-bold text-muted">DATA PERMINTAAN</small>
                        <div class="mt-2">
                            <label class="form-label">Rata-rata Permintaan per Tahun (D)</label>
                            <input type="number" name="rata_rata_permintaan" id="inputD" class="form-control" value="{{ old('rata_rata_permintaan') }}" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded mb-3">
                        <small class="fw-bold text-muted">BIAYA PERSEDIAAN</small>
                        <div class="row g-2 mt-1">
                            <div class="col-6">
                                <label class="form-label">Biaya Pesan (S)</label>
                                <input type="number" name="biaya_pesan" id="inputS" class="form-control" value="{{ old('biaya_pesan') }}" step="0.01" min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Biaya Simpan (H)</label>
                                <input type="number" name="biaya_simpan" id="inputH" class="form-control" value="{{ old('biaya_simpan') }}" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Faktor Biaya Simpan (I)</label>
                            <input type="number" name="faktor_biaya_simpan" id="inputI" class="form-control" value="{{ old('faktor_biaya_simpan', '0.1') }}" step="0.0001" min="0" max="1">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded mb-3">
                        <small class="fw-bold text-muted">PARAMETER MIN-MAX</small>
                        <div class="row g-2 mt-1">
                            <div class="col-6">
                                <label class="form-label">Lead Time (hari)</label>
                                <input type="number" name="lead_time" id="inputLT" class="form-control" value="{{ old('lead_time') }}" min="1" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Service Level (Z)</label>
                                <input type="number" name="service_level_z" id="inputZ" class="form-control" value="{{ old('service_level_z', '1.65') }}" step="0.01" min="0">
                                <small class="text-muted">1.65 = 95%</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-calculator me-1"></i> Hitung EOQ & Min-Max
                    </button>
                </form>

                <hr>
                <form method="POST" action="{{ route('eoq.calculateAll') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-success w-100" onclick="return confirm('Hitung EOQ untuk semua obat yang memiliki parameter?')">
                        <i class="bi bi-arrow-repeat me-1"></i> Hitung Ulang Semua Obat
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Rumus -->
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Rumus EOQ
            </div>
            <div class="card-body">
                <div class="p-3 bg-primary bg-opacity-10 rounded mb-3">
                    <h6 class="fw-bold text-primary">Formula EOQ</h6>
                    <p class="mb-1" style="font-size: 1.1rem; font-family: monospace;">EOQ* = √(2 × D × S / H)</p>
                    <small class="text-muted">D = Permintaan per tahun, S = Biaya pesan, H = Biaya simpan</small>
                </div>
                <div class="p-3 bg-success bg-opacity-10 rounded mb-3">
                    <h6 class="fw-bold text-success">Frekuensi & Biaya Total</h6>
                    <p class="mb-1" style="font-family: monospace;">F = D / EOQ*</p>
                    <p class="mb-1" style="font-family: monospace;">TC = (D/EOQ* × S) + (EOQ*/2 × H) + (D × P)</p>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 rounded">
                    <h6 class="fw-bold text-warning">Min-Max Stock</h6>
                    <p class="mb-1" style="font-family: monospace;">SS = Z × d × √LT</p>
                    <p class="mb-1" style="font-family: monospace;">ROP = (d × LT) + SS</p>
                    <p class="mb-1" style="font-family: monospace;">Min = SS + (d × LT)</p>
                    <p class="mb-0" style="font-family: monospace;">Max = Min + EOQ*</p>
                </div>
            </div>
        </div>

        <!-- Daftar Obat dengan Parameter -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-check me-2"></i>Obat dengan Parameter EOQ
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th class="text-end">D</th>
                                <th class="text-end">S</th>
                                <th class="text-end">H</th>
                                <th class="text-end">LT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicines as $m)
                                @if($m->latestEoqParameter)
                                <tr>
                                    <td>{{ $m->nama_obat }}</td>
                                    <td class="text-end">{{ number_format($m->latestEoqParameter->rata_rata_permintaan, 0) }}</td>
                                    <td class="text-end">{{ number_format($m->latestEoqParameter->biaya_pesan, 0) }}</td>
                                    <td class="text-end">{{ number_format($m->latestEoqParameter->biaya_simpan, 0) }}</td>
                                    <td class="text-end">{{ $m->latestEoqParameter->lead_time }} hari</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('medicineSelect').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt.dataset.d) document.getElementById('inputD').value = opt.dataset.d;
    if (opt.dataset.s) document.getElementById('inputS').value = opt.dataset.s;
    if (opt.dataset.h) document.getElementById('inputH').value = opt.dataset.h;
    if (opt.dataset.i) document.getElementById('inputI').value = opt.dataset.i;
    if (opt.dataset.lt) document.getElementById('inputLT').value = opt.dataset.lt;
    if (opt.dataset.z) document.getElementById('inputZ').value = opt.dataset.z;
});
</script>
@endpush
