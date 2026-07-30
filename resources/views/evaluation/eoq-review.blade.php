@extends('layouts.app')

@section('title', 'Evaluasi Total Biaya Persediaan')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Evaluasi Total Biaya Persediaan</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-[#04aabe]"></i>
                <span>Evaluasi Total Biaya Persediaan (Total Cost - TC)</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Rincian akumulasi biaya persediaan obat (Biaya Pemesanan + Biaya Penyimpanan + Nilai Pembelian) berdasarkan hasil perhitungan EOQ</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Item Dihitung</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($calculations->count()) }} <span class="text-xs font-normal text-slate-400">Obat</span></h3>
            <span class="inline-block mt-1 text-[11px] text-slate-600 font-bold bg-slate-100 px-2.5 py-0.5 rounded-md">Terdaftar di Sistem</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm text-center sm:col-span-2">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Akumulasi Biaya Persediaan (TC)</p>
            <h3 class="text-2xl font-black text-[#04aabe] mt-1">Rp {{ number_format($totalBiayaPersediaan, 0, ',', '.') }}</h3>
            <span class="inline-block mt-1 text-[11px] text-[#04aabe] font-bold bg-brand-50 px-2.5 py-0.5 rounded-md">Pemesanan Kuantitas Optimal (EOQ)</span>
        </div>
    </div>

    <!-- Table Rincian Biaya Persediaan -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Rincian Total Biaya Persediaan (TC) Per Obat</h3>
            <p class="text-xs text-slate-500 mt-1">Struktur komponen biaya persediaan obat berdasarkan hasil kalkulasi kuantitas optimal</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">Kode & Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Permintaan (D)</th>
                        <th class="py-3.5 px-5 text-right">Kuantitas Optimal</th>
                        <th class="py-3.5 px-5 text-right">Biaya Pesan</th>
                        <th class="py-3.5 px-5 text-right">Biaya Simpan</th>
                        <th class="py-3.5 px-5 text-right">Total Biaya (TC)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($calculations as $calc)
                        @php
                            $param = $calc->eoqParameter;
                            $D = $param ? $param->rata_rata_permintaan : 0;
                            $S = $param ? $param->biaya_pesan : 0;
                            $H = $param ? $param->biaya_simpan : 0;
                            $eoq = $calc->eoq_value > 0 ? $calc->eoq_value : 1;
                            $orderingCost = ($eoq > 0) ? ($D / $eoq) * $S : 0;
                            $holdingCost = ($eoq / 2) * $H;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-800 block">{{ $calc->medicine->nama_obat }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $calc->medicine->kode_obat }}</span>
                            </td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">
                                {{ number_format($D) }} <span class="text-[10px] text-slate-400 font-normal">{{ $calc->medicine->satuan }}</span>
                            </td>
                            <td class="py-4 px-5 text-right font-extrabold text-[#04aabe]">
                                {{ number_format($calc->eoq_value, 0) }} <span class="text-[10px] text-slate-400 font-normal">{{ $calc->medicine->satuan }}</span>
                            </td>
                            <td class="py-4 px-5 text-right text-slate-600">
                                Rp {{ number_format($orderingCost, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5 text-right text-slate-600">
                                Rp {{ number_format($holdingCost, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-5 text-right font-black text-slate-900 text-sm">
                                Rp {{ number_format($calc->total_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data perhitungan biaya persediaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
