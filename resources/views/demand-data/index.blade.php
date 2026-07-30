@extends('layouts.app')

@section('title', Auth::user()->isInstalasiFarmasi() ? 'Data Pemakaian' : 'Data Permintaan')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">{{ Auth::user()->isInstalasiFarmasi() ? 'Data Pemakaian Obat' : 'Data Permintaan Obat' }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-[#04aabe]"></i>
                <span>{{ Auth::user()->isInstalasiFarmasi() ? 'Riwayat Pemakaian Obat' : 'Riwayat Permintaan Obat' }}</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                {{ Auth::user()->isInstalasiFarmasi() ? 'Data pemakaian obat oleh Instalasi Farmasi per periode bulanan' : 'Data pemakaian/permintaan obat dari Instalasi Farmasi per periode bulanan' }}
            </p>
        </div>
        @if(Auth::user()->isInstalasiFarmasi())
        <a href="{{ route('demand-data.create') }}" class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all shrink-0">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Data Pemakaian</span>
        </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <form method="GET" action="{{ route('demand-data.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-1/3">
                <select name="medicine_id" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-medium text-slate-800">
                    <option value="">-- Semua Obat --</option>
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}" {{ request('medicine_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_obat }} — {{ $m->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-filter"></i>
                <span>Saring</span>
            </button>
            @if(request()->has('medicine_id'))
                <a href="{{ route('demand-data.index') }}" class="w-full sm:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl text-center transition-all">
                    Atur Ulang
                </a>
            @endif
        </form>
    </div>

    <!-- Demand Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Obat</th>
                        <th class="py-3.5 px-6">Periode</th>
                        <th class="py-3.5 px-6">{{ Auth::user()->isInstalasiFarmasi() ? 'Jumlah Pemakaian' : 'Jumlah Permintaan' }}</th>
                        @if(Auth::user()->isInstalasiFarmasi())
                        <th class="py-3.5 px-6 text-center">Kelola</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($demandData as $item)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-6 font-bold text-slate-800">
                                {{ $item->medicine->nama_obat }}
                                <span class="block text-[10px] text-slate-400 font-mono">{{ $item->medicine->kode_obat }}</span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">{{ $item->periode }}</td>
                            <td class="py-4 px-6 font-bold text-[#04aabe]">
                                {{ number_format($item->jumlah_permintaan) }} <span class="text-[10px] text-slate-400 font-normal">{{ $item->medicine->satuan }}</span>
                            </td>
                            @if(Auth::user()->isInstalasiFarmasi())
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('demand-data.edit', $item->id) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition-all" title="Ubah Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('demand-data.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data pemakaian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all" title="Hapus Data">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->isInstalasiFarmasi() ? 4 : 3 }}" class="py-8 text-center text-slate-400">Belum ada data {{ Auth::user()->isInstalasiFarmasi() ? 'pemakaian' : 'permintaan' }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($demandData->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $demandData->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
