@extends('layouts.app')

@section('title', 'Review Periodik')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Review Periodik</li>
@endsection

@section('content')
<div class="page-header">
    <h4><i class="bi bi-arrow-repeat text-secondary me-2"></i>Review Periodik Parameter</h4>
    <p class="text-muted mb-0" style="font-size: 0.85rem;">Update parameter D, LT, S, H secara berkala</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Obat</th>
                        <th class="text-end">D (Permintaan)</th>
                        <th class="text-end">S (Biaya Pesan)</th>
                        <th class="text-end">H (Biaya Simpan)</th>
                        <th class="text-end">LT (hari)</th>
                        <th class="text-end">Z</th>
                        <th>Terakhir Update</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parameters as $param)
                        <tr>
                            <td class="fw-semibold">{{ $param->medicine->nama_obat }}</td>
                            <td class="text-end">{{ number_format($param->rata_rata_permintaan, 0) }}</td>
                            <td class="text-end">Rp {{ number_format($param->biaya_pesan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($param->biaya_simpan, 0, ',', '.') }}</td>
                            <td class="text-end">{{ $param->lead_time }}</td>
                            <td class="text-end">{{ $param->service_level_z }}</td>
                            <td><small class="text-muted">{{ $param->updated_at->format('d/m/Y H:i') }}</small></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $param->id }}">
                                    <i class="bi bi-pencil"></i> Update
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $param->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('evaluation.updateParameter', $param) }}">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h6 class="modal-title">Update Parameter — {{ $param->medicine->nama_obat }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Rata-rata Permintaan (D)</label>
                                                <input type="number" name="rata_rata_permintaan" class="form-control" value="{{ $param->rata_rata_permintaan }}" step="0.01" required>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="form-label">Biaya Pesan (S)</label>
                                                    <input type="number" name="biaya_pesan" class="form-control" value="{{ $param->biaya_pesan }}" step="0.01" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Biaya Simpan (H)</label>
                                                    <input type="number" name="biaya_simpan" class="form-control" value="{{ $param->biaya_simpan }}" step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="row g-2 mt-1">
                                                <div class="col-6">
                                                    <label class="form-label">Lead Time (hari)</label>
                                                    <input type="number" name="lead_time" class="form-control" value="{{ $param->lead_time }}" min="1" required>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Service Level (Z)</label>
                                                    <input type="number" name="service_level_z" class="form-control" value="{{ $param->service_level_z }}" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update & Hitung Ulang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada parameter</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
