@extends('layouts.app')

@section('title', 'Tambah Permintaan Obat')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('demand-data.index') }}" class="hover:text-[#04aabe]">Data Permintaan</a>
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Tambah</span>
@endsection

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-[#04aabe]"></i>
                <span>Input Data Permintaan Obat</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Catat jumlah pemakaian/permintaan obat untuk periode tertentu</p>
        </div>
        <a href="{{ route('demand-data.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('demand-data.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Obat <span class="text-rose-500">*</span></label>
                <select name="medicine_id" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-medium text-slate-800" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}" {{ old('medicine_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_obat }} — {{ $m->nama_obat }} ({{ $m->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Periode Pemakaian <span class="text-rose-500">*</span></label>
                <input type="text" name="periode" value="{{ old('periode', date('F Y')) }}" placeholder="Contoh: Januari 2025" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jumlah Permintaan <span class="text-rose-500">*</span></label>
                <input type="number" name="jumlah_permintaan" value="{{ old('jumlah_permintaan') }}" min="1" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-bold text-slate-800" required>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('demand-data.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
