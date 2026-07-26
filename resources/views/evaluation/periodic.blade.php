@extends('layouts.app')

@section('title', 'Review Periodik')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Review Periodik Parameter</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ activeModal: null }">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate text-[#04aabe]"></i>
                <span>Review Periodik Parameter Obat</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Pembaruan berkala parameter permintaan, biaya pesan, biaya simpan, dan waktu tunggu</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">Nama Obat</th>
                        <th class="py-3.5 px-5 text-right">Permintaan (D)</th>
                        <th class="py-3.5 px-5 text-right">Biaya Pesan (S)</th>
                        <th class="py-3.5 px-5 text-right">Biaya Simpan (H)</th>
                        <th class="py-3.5 px-5 text-right">Lead Time</th>
                        <th class="py-3.5 px-5 text-right">Service Level</th>
                        <th class="py-3.5 px-5">Terakhir Update</th>
                        @if(Auth::user()->isAdmin())
                        <th class="py-3.5 px-5 text-center">Aksi Pembaruan</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($parameters as $param)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5 font-bold text-slate-800">{{ $param->medicine->nama_obat }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">{{ number_format($param->rata_rata_permintaan, 0) }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($param->biaya_pesan, 0, ',', '.') }}</td>
                            <td class="py-4 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($param->biaya_simpan, 0, ',', '.') }}</td>
                            <td class="py-4 px-5 text-right font-bold text-[#04aabe]">{{ $param->lead_time }} Hari</td>
                            <td class="py-4 px-5 text-right font-bold text-slate-800">{{ $param->service_level_z }}</td>
                            <td class="py-4 px-5 text-slate-400 text-[11px]">{{ $param->updated_at->format('d/m/Y H:i') }}</td>
                            @if(Auth::user()->isAdmin())
                            <td class="py-4 px-5 text-center">
                                <button @click="activeModal = {{ $param->id }}" class="px-3 py-1.5 bg-brand-50 text-[#04aabe] hover:bg-[#04aabe] hover:text-white font-bold rounded-xl text-[11px] transition-all flex items-center justify-center gap-1 mx-auto">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Update</span>
                                </button>

                                <!-- Modal Dialog -->
                                <div x-show="activeModal === {{ $param->id }}" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 text-left" style="display: none;">
                                    
                                    <div @click.away="activeModal = null" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 border border-slate-100 space-y-4">
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                            <h3 class="text-sm font-bold text-slate-800">Update Parameter — {{ $param->medicine->nama_obat }}</h3>
                                            <button @click="activeModal = null" class="text-slate-400 hover:text-slate-600">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>

                                        <form method="POST" action="{{ route('evaluation.updateParameter', $param) }}" class="space-y-4">
                                            @csrf @method('PUT')
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1">Rata-rata Permintaan Tahunan (D)</label>
                                                <input type="number" name="rata_rata_permintaan" value="{{ $param->rata_rata_permintaan }}" step="0.01" min="0" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800" required>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Pemesanan (S)</label>
                                                    <input type="number" name="biaya_pesan" value="{{ $param->biaya_pesan }}" step="0.01" min="0" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Penyimpanan (H)</label>
                                                    <input type="number" name="biaya_simpan" value="{{ $param->biaya_simpan }}" step="0.01" min="0" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800" required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Time (Hari)</label>
                                                    <input type="number" name="lead_time" value="{{ $param->lead_time }}" min="1" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800" required>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-700 mb-1">Service Level (Z)</label>
                                                    <input type="number" name="service_level_z" value="{{ $param->service_level_z }}" step="0.01" min="0" class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800">
                                                </div>
                                            </div>

                                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                                                <button type="button" @click="activeModal = null" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs">Batal</button>
                                                <button type="submit" class="px-5 py-2 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl text-xs shadow-md">Update & Hitung Ulang</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">Belum ada data parameter obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
