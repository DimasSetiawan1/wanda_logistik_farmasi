@extends('layouts.app')

@section('title', 'Batas Min-Max Stock')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Min-Max Stock</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm text-center">
        <div class="w-16 h-16 rounded-full bg-brand-50 text-[#04aabe] flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-chart-column"></i>
        </div>
        <h2 class="text-xl font-bold text-slate-800">Manajemen Batas Persediaan Min-Max</h2>
        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
            Metode Min-Max Stock menentukan batas stok minimum untuk mencegah kehabisan persediaan (stockout) dan batas maksimum untuk menghindari penumpukan modal.
        </p>
        
        <div class="mt-6 flex items-center justify-center gap-3">
            <a href="{{ route('minmax.result') }}" class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl text-xs shadow-lg shadow-[#04aabe]/30">
                Lihat Hasil Min-Max
            </a>
            <a href="{{ route('eoq.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs">
                Kelola Parameter
            </a>
        </div>
    </div>
</div>
@endsection
