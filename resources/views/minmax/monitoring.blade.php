@extends('layouts.app')

@section('title', 'Monitoring Stok')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Monitoring Stok Real-Time</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header & Auto Order Button -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-heart-pulse text-[#04aabe]"></i>
                <span>Monitoring Stok Aktual Obat</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Pemantauan persediaan langsung terhadap ambang batas Min-Max</p>
        </div>

        @if(!Auth::user()->isInstalasiFarmasi())
        <form method="POST" action="{{ route('orders.auto') }}">
            @csrf
            <button type="submit" onclick="return confirm('Buat pemesanan otomatis untuk seluruh obat di bawah batas minimum?')" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-600/30 text-xs flex items-center gap-2 transition-all shrink-0">
                <i class="fa-solid fa-cart-plus"></i>
                <span>Pesan Otomatis ({{ $summary['perlu_pesan'] }} Obat Kritis)</span>
            </button>
        </form>
        @endif
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-[#04aabe] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Stok Normal</p>
                <h3 class="text-2xl font-black text-[#04aabe] mt-0.5">{{ $summary['normal'] }} Obat</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Dipesan</p>
                <h3 class="text-2xl font-black text-rose-600 mt-0.5">{{ $summary['perlu_pesan'] }} Obat</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelebihan (Overstock)</p>
                <h3 class="text-2xl font-black text-amber-600 mt-0.5">{{ $summary['overstock'] }} Obat</h3>
            </div>
        </div>
    </div>

    <!-- Table Monitoring -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-5">Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Stok Saat Ini</th>
                        <th class="py-3.5 px-5 text-right text-rose-700">Stok Min</th>
                        <th class="py-3.5 px-5 text-right text-[#04aabe]">Stok Max</th>
                        <th class="py-3.5 px-5">Visual Ketersediaan</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($calculations as $i => $calc)
                        @php
                            $stok = $calc->medicine->stok_aktual;
                            $min = $calc->stok_minimum;
                            $max = $calc->stok_maksimum;
                            $pct = $max > 0 ? min(($stok / $max) * 100, 100) : 0;
                            $barBg = $calc->status === 'perlu_pesan' ? 'bg-rose-500' : ($calc->status === 'overstock' ? 'bg-amber-500' : 'bg-[#04aabe]');
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-all {{ $calc->status === 'perlu_pesan' ? 'bg-rose-50/20' : '' }}">
                            <td class="py-4 px-5 text-slate-400 font-bold">{{ $i + 1 }}</td>
                            <td class="py-4 px-5 font-bold text-slate-800">{{ $calc->medicine->nama_obat }}</td>
                            <td class="py-4 px-5 text-right font-black text-slate-900 text-sm">{{ number_format($stok) }} {{ $calc->medicine->satuan }}</td>
                            <td class="py-4 px-5 text-right font-bold text-rose-600">{{ number_format($min, 0) }}</td>
                            <td class="py-4 px-5 text-right font-bold text-[#04aabe]">{{ number_format($max, 0) }}</td>
                            <td class="py-4 px-5 min-w-[160px]">
                                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden mb-1">
                                    <div class="h-full {{ $barBg }} transition-all duration-500 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-[10px] text-slate-400 font-semibold">{{ number_format($pct, 0) }}% Dari Kapasitas Maks</span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if($calc->status === 'perlu_pesan')
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Kritis
                                    </span>
                                @elseif($calc->status === 'overstock')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-boxes-stacked"></i> Overstock
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-brand-50 text-[#04aabe] border border-cyan-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Aman
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if($calc->status === 'perlu_pesan' && !Auth::user()->isInstalasiFarmasi())
                                    <form method="POST" action="{{ route('orders.store') }}" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="medicine_id" value="{{ $calc->medicine_id }}">
                                        <input type="hidden" name="jumlah_pesan" value="{{ ceil($calc->eoq_value) }}">
                                        <input type="hidden" name="keterangan" value="Pemesanan langsung dari monitoring stok">
                                        <button class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-[11px] shadow-sm flex items-center gap-1.5 transition-all">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span>Pesan ({{ ceil($calc->eoq_value) }})</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">Belum ada data monitoring stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
