@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Daftar Pemesanan Obat</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-cart-flatbed text-[#04aabe]"></i>
                <span>Daftar Pemesanan Obat</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Riwayat transaksi pengadaan stok obat ke supplier</p>
        </div>
        <form method="POST" action="{{ route('orders.auto') }}">
            @csrf
            <button type="submit" onclick="return confirm('Buat pemesanan otomatis untuk seluruh obat berkategori kritis?')" class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all shrink-0">
                <i class="fa-solid fa-bolt"></i>
                <span>Pesan Otomatis (Auto Order)</span>
            </button>
        </form>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('orders.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-1/3">
                <select name="status" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-medium text-slate-800">
                    <option value="">-- Semua Status Pemesanan --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses (Dikirim Supplier)</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai (Sudah Diterima)</option>
                </select>
            </div>
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-filter"></i>
                <span>Filter</span>
            </button>
            @if(request()->has('status'))
                <a href="{{ route('orders.index') }}" class="w-full sm:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl text-center transition-all">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-5">Tanggal Pesan</th>
                        <th class="py-3.5 px-5">Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Jumlah Pesan</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5">Keterangan</th>
                        <th class="py-3.5 px-5 text-center">Aksi / Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($orders as $i => $order)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5 text-slate-400 font-bold">{{ $orders->firstItem() + $i }}</td>
                            <td class="py-4 px-5 font-semibold text-slate-800">{{ $order->tanggal_pesan->format('d/m/Y') }}</td>
                            <td class="py-4 px-5 font-bold text-slate-900">{{ $order->medicine->nama_obat }}</td>
                            <td class="py-4 px-5 text-right font-black text-[#04aabe] text-sm">
                                {{ number_format($order->jumlah_pesan) }} <span class="text-[10px] text-slate-400 font-normal">{{ $order->medicine->satuan }}</span>
                            </td>
                            <td class="py-4 px-5">
                                @if($order->status === 'pending')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i> Menunggu
                                    </span>
                                @elseif($order->status === 'diproses')
                                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-truck-fast"></i> Diproses
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-brand-50 text-[#04aabe] border border-cyan-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-500 max-w-xs truncate">{{ $order->keterangan ?? '-' }}</td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="px-2.5 py-1.5 bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white rounded-lg text-[11px] font-bold transition-all flex items-center gap-1" title="Tandai Diproses">
                                                <i class="fa-solid fa-truck-fast"></i>
                                                <span>Proses</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($order->status === 'diproses')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="inline-block">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="px-2.5 py-1.5 bg-brand-50 text-[#04aabe] hover:bg-[#04aabe] hover:text-white rounded-lg text-[11px] font-bold transition-all flex items-center gap-1" title="Tandai Selesai">
                                                <i class="fa-solid fa-check"></i>
                                                <span>Terima Stok</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($order->status !== 'selesai' && Auth::user()->isAdmin())
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus transaksi pemesanan ini?')" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg text-[11px] transition-all" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada catatan pemesanan obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
