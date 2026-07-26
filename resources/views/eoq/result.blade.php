@extends('layouts.app')

@section('title', 'Hasil EOQ')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('eoq.index') }}" class="hover:text-[#04aabe]">Parameter EOQ</a>
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Hasil Perhitungan</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-square-poll-vertical text-[#04aabe]"></i>
                <span>Hasil Perhitungan EOQ</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Kuantitas optimal pemesanan, frekuensi pesan, dan total biaya persediaan per obat</p>
        </div>
        <a href="{{ route('eoq.index') }}" class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all shrink-0">
            <i class="fa-solid fa-calculator"></i>
            <span>Ubah Parameter / Hitung Ulang</span>
        </a>
    </div>

    <!-- Table Result -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Permintaan (D)</th>
                        <th class="py-3.5 px-5 text-right">Biaya Pesan (S)</th>
                        <th class="py-3.5 px-5 text-right">Biaya Simpan (H)</th>
                        <th class="py-3.5 px-5 text-right bg-brand-50 text-[#04aabe] font-extrabold">Kuantitas Optimal (EOQ)</th>
                        <th class="py-3.5 px-5 text-right">Frekuensi Pesan</th>
                        <th class="py-3.5 px-5 text-right">Total Biaya (TC)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($calculations as $i => $calc)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5 text-slate-400 font-bold">{{ $i + 1 }}</td>
                            <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $calc->medicine->kode_obat }}</td>
                            <td class="py-4 px-5 font-bold text-slate-800">{{ $calc->medicine->nama_obat }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">{{ number_format($calc->eoqParameter->rata_rata_permintaan, 0) }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($calc->eoqParameter->biaya_pesan, 0, ',', '.') }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($calc->eoqParameter->biaya_simpan, 0, ',', '.') }}</td>
                            <td class="py-4 px-5 text-right bg-brand-50/60 font-black text-[#04aabe] text-sm">
                                {{ number_format($calc->eoq_value, 0) }} <span class="text-[10px] font-normal text-slate-400">{{ $calc->medicine->satuan }}</span>
                            </td>
                            <td class="py-4 px-5 text-right font-bold text-slate-800">{{ number_format($calc->frekuensi_pesan, 1) }} Kali / Tahun</td>
                            <td class="py-4 px-5 text-right font-black text-slate-900">Rp {{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">
                                Belum ada hasil perhitungan. <a href="{{ route('eoq.index') }}" class="text-[#04aabe] font-bold underline">Hitung EOQ Sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
