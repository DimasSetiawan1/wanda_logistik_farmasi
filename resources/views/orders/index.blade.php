@extends('layouts.app')

@section('title', 'Pemesanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pemesanan</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <h4><i class="bi bi-cart-check text-info me-2"></i>Daftar Pemesanan</h4>
    <div>
        <form method="POST" action="{{ route('orders.auto') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success" onclick="return confirm('Buat pesanan otomatis untuk obat yang stoknya kritis?')">
                <i class="bi bi-lightning me-1"></i> Auto Order
            </button>
        </form>
    </div>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-filter me-1"></i>Filter</button>
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
                        <th>Tanggal</th>
                        <th>Obat</th>
                        <th class="text-end">Jumlah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $i => $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $i }}</td>
                            <td>{{ $order->tanggal_pesan->format('d/m/Y') }}</td>
                            <td class="fw-semibold">{{ $order->medicine->nama_obat }}</td>
                            <td class="text-end">{{ number_format($order->jumlah_pesan) }}</td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status === 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ Str::limit($order->keterangan, 50) }}</small></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="diproses">
                                            <button class="btn btn-outline-info btn-sm" title="Proses"><i class="bi bi-play"></i></button>
                                        </form>
                                    @endif
                                    @if($order->status === 'diproses')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button class="btn btn-outline-success btn-sm" title="Selesai"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                    @endif
                                    @if($order->status !== 'selesai')
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada pemesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
        <div class="card-footer bg-transparent">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
