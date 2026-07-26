@extends('layouts.app')

@section('title', 'Laporan Logistik')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Laporan Output Sistem</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-file-pdf text-rose-600"></i>
                <span>Laporan Output Logistik Farmasi</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Rekomendasi kuantitas pemesanan (EOQ) dan ambang batas Min-Max Stock RS Puspa Husada</p>
        </div>
        <a href="{{ route('reports.pdf') }}" target="_blank" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl shadow-lg shadow-rose-600/30 text-xs flex items-center gap-2 transition-all shrink-0">
            <i class="fa-solid fa-file-arrow-down"></i>
            <span>Cetak / Download Laporan PDF</span>
        </a>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Rangkuman Rekomendasi EOQ & Batas Stok</h3>
            <p class="text-xs text-slate-500 mt-0.5">Hasil lengkap kalkulasi persediaan obat</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Stok Saat Ini</th>
                        <th class="py-3.5 px-5 text-right bg-brand-50 text-[#04aabe] font-extrabold">EOQ (Unit)</th>
                        <th class="py-3.5 px-5 text-right">Frekuensi Pesan</th>
                        <th class="py-3.5 px-5 text-right text-rose-700 font-bold">Stok Min</th>
                        <th class="py-3.5 px-5 text-right text-[#04aabe] font-bold">Stok Max</th>
                        <th class="py-3.5 px-5 text-right">Safety Stock</th>
                        <th class="py-3.5 px-5 text-right">ROP</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($calculations as $i => $calc)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5 text-slate-400 font-bold">{{ $i + 1 }}</td>
                            <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $calc->medicine->kode_obat }}</td>
                            <td class="py-4 px-5 font-bold text-slate-800">{{ $calc->medicine->nama_obat }}</td>
                            <td class="py-4 px-5 text-right font-black text-slate-900">{{ number_format($calc->medicine->stok_aktual) }}</td>
                            <td class="py-4 px-5 text-right bg-brand-50/60 font-black text-[#04aabe] text-sm">{{ number_format($calc->eoq_value, 0) }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">{{ number_format($calc->frekuensi_pesan, 1) }}×/Thn</td>
                            <td class="py-4 px-5 text-right font-bold text-rose-600 bg-rose-50/30">{{ number_format($calc->stok_minimum, 0) }}</td>
                            <td class="py-4 px-5 text-right font-bold text-[#04aabe] bg-brand-50/30">{{ number_format($calc->stok_maksimum, 0) }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-sky-700">{{ number_format($calc->safety_stock, 0) }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-amber-700">{{ number_format($calc->reorder_point, 0) }}</td>
                            <td class="py-4 px-5 text-center">
                                @if($calc->status === 'perlu_pesan')
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Perlu Pesan
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-8 text-center text-slate-400">Belum ada data kalkulasi laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
