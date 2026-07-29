@extends('layouts.app')

@section('title', 'Parameter Optimasi Stok')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Parameter Optimasi Stok</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-sliders text-[#04aabe]"></i>
                <span>Perhitungan & Parameter Optimasi Stok</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Kuantitas Pemesanan Optimal untuk Efisiensi Biaya Persediaan Obat</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Input Form Parameter -->
        <div class="lg:col-span-5 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-[#04aabe]"></i>
                <span>Input Parameter Obat</span>
            </h3>

            @if($errors->any())
                <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-700 p-3 rounded-xl text-xs">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('eoq.calculate') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Obat</label>
                    <select name="medicine_id" id="medicineSelect" class="w-full px-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] font-medium text-slate-800" required>
                        <option value="">-- Pilih Obat --</option>
                        @foreach($medicines as $m)
                            <option value="{{ $m->id }}"
                                data-d="{{ $m->latestEoqParameter->rata_rata_permintaan ?? '' }}"
                                data-s="{{ $m->latestEoqParameter->biaya_pesan ?? '' }}"
                                data-h="{{ $m->latestEoqParameter->biaya_simpan ?? '' }}"
                                data-i="{{ $m->latestEoqParameter->faktor_biaya_simpan ?? '0.1' }}"
                                data-lt="{{ $m->latestEoqParameter->lead_time ?? '' }}"
                                data-z="{{ $m->latestEoqParameter->service_level_z ?? '1.65' }}"
                                {{ old('medicine_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->kode_obat }} — {{ $m->nama_obat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl space-y-3 border border-slate-100">
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Data Permintaan</span>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Permintaan Tahunan (Unit)</label>
                        <input type="number" name="rata_rata_permintaan" id="inputD" value="{{ old('rata_rata_permintaan') }}" step="0.01" min="0" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-bold text-slate-800" required>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl space-y-3 border border-slate-100">
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Biaya Persediaan</span>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Pemesanan (Rp)</label>
                            <input type="number" name="biaya_pesan" id="inputS" value="{{ old('biaya_pesan') }}" step="0.01" min="0" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-bold text-slate-800" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Biaya Penyimpanan (Rp)</label>
                            <input type="number" name="biaya_simpan" id="inputH" value="{{ old('biaya_simpan') }}" step="0.01" min="0" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-bold text-slate-800" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Faktor Biaya Simpan (%)</label>
                        <input type="number" name="faktor_biaya_simpan" id="inputI" value="{{ old('faktor_biaya_simpan', '0.1') }}" step="0.0001" min="0" max="1" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-semibold text-slate-800">
                    </div>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl space-y-3 border border-slate-100">
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider block">Parameter Waktu & Toleransi</span>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Tunggu / Lead Time (Hari)</label>
                            <input type="number" name="lead_time" id="inputLT" value="{{ old('lead_time') }}" min="1" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-bold text-slate-800" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Layanan / Service Level</label>
                            <input type="number" name="service_level_z" id="inputZ" value="{{ old('service_level_z', '1.65') }}" step="0.01" min="0" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg font-bold text-slate-800">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center justify-center gap-2 transition-all">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Hitung Optimasi & Batas Persediaan</span>
                </button>
            </form>

            <div class="mt-4 pt-4 border-t border-slate-100">
                <form method="POST" action="{{ route('eoq.calculateAll') }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Proses hitung ulang seluruh obat?')" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>Hitung Ulang Semua Obat</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Table List Obat dengan Parameter -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-[#04aabe]"></i>
                    <span>Daftar Parameter Terpasang</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">Status variabel persediaan yang telah dikonfigurasi untuk setiap jenis obat</p>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-5">Nama Obat</th>
                            <th class="py-3 px-5 text-right">Permintaan (D)</th>
                            <th class="py-3 px-5 text-right">Biaya Pesan (S)</th>
                            <th class="py-3 px-5 text-right">Biaya Simpan (H)</th>
                            <th class="py-3 px-5 text-right">Lead Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        @foreach($medicines as $m)
                            @if($m->latestEoqParameter)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-3.5 px-5 font-bold text-slate-800">{{ $m->nama_obat }}</td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-700">{{ number_format($m->latestEoqParameter->rata_rata_permintaan, 0) }}</td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($m->latestEoqParameter->biaya_pesan, 0) }}</td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($m->latestEoqParameter->biaya_simpan, 0) }}</td>
                                <td class="py-3.5 px-5 text-right font-bold text-[#04aabe]">{{ $m->latestEoqParameter->lead_time }} Hari</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('medicineSelect').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt.dataset.d) document.getElementById('inputD').value = opt.dataset.d;
    if (opt.dataset.s) document.getElementById('inputS').value = opt.dataset.s;
    if (opt.dataset.h) document.getElementById('inputH').value = opt.dataset.h;
    if (opt.dataset.i) document.getElementById('inputI').value = opt.dataset.i;
    if (opt.dataset.lt) document.getElementById('inputLT').value = opt.dataset.lt;
    if (opt.dataset.z) document.getElementById('inputZ').value = opt.dataset.z;
});
</script>
@endpush
