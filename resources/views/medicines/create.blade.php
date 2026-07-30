@extends('layouts.app')

@section('title', 'Tambah Data Obat')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('medicines.index') }}" class="hover:text-[#04aabe]">Data Obat</a>
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Tambah Obat Baru</span>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-square-plus text-[#04aabe]"></i>
                    <span>Tambah Obat Baru</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Lengkapi formulir di bawah ini untuk menambahkan data obat baru ke
                    sistem</p>
            </div>
            <a href="{{ route('medicines.index') }}"
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm">
            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs space-y-1">
                    <p class="font-bold">Terjadi kesalahan input:</p>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('medicines.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Kode Obat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Obat <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="kode_obat"
                            value="{{ old('kode_obat', 'OBT' . sprintf('%03d', \App\Models\Medicine::count() + 1)) }}"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-bold font-mono text-slate-800"
                            required>
                    </div>

                    <!-- Nama Obat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Obat <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="nama_obat" value="{{ old('nama_obat') }}"
                            placeholder="Contoh: Paracetamol 500mg"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800"
                            required>
                    </div>

                    <!-- Kategori Obat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Obat
                            <span class="text-rose-500">*</span></label>
                        <input type="text" name="kategori_obat" value="{{ old('kategori_obat') }}"
                            placeholder="Contoh: Analgesik, Antibiotik, Sirup, Injeksi"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800"
                            required>
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Satuan Obat
                            <span class="text-rose-500">*</span></label>
                        <select name="satuan"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800"
                            required>
                            <option value="">-- Pilih Satuan --</option>
                            <option value="Tablet" {{ old('satuan') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="Kapsul" {{ old('satuan') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                            <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Ampul" {{ old('satuan') == 'Ampul' ? 'selected' : '' }}>Ampul</option>
                            <option value="Vial" {{ old('satuan') == 'Vial' ? 'selected' : '' }}>Vial</option>
                            <option value="Strip" {{ old('satuan') == 'Strip' ? 'selected' : '' }}>Strip</option>
                            <option value="Tube" {{ old('satuan') == 'Tube' ? 'selected' : '' }}>Tube</option>
                        </select>
                    </div>

                    <!-- Tingkat Pemakaian -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Tingkat Pemakaian Obat <span class="text-rose-500">*</span>
                        </label>
                        <select name="tingkat_pemakaian"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800"
                            required>
                            <option value="Sangat Sering" {{ old('tingkat_pemakaian') == 'Sangat Sering' ? 'selected' : '' }}>
                                🔥 Sangat Sering (Tinggi)</option>
                            <option value="Sering" {{ old('tingkat_pemakaian', 'Sering') == 'Sering' ? 'selected' : '' }}>⚡
                                Sering (Sedang)</option>
                            <option value="Jarang" {{ old('tingkat_pemakaian') == 'Jarang' ? 'selected' : '' }}>📦 Jarang
                                (Rendah)</option>
                        </select>
                    </div>

                    <!-- Harga Per Unit -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Harga Per Unit
                            (Rp)</label>
                        <input type="number" name="harga_per_unit" value="{{ old('harga_per_unit', 0) }}" min="0" step="100"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-semibold text-slate-800">
                    </div>

                    <!-- Stok Aktual -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Stok Saat Ini
                            (Aktual)</label>
                        <input type="number" name="stok_aktual" value="{{ old('stok_aktual', 0) }}" min="0"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-bold text-slate-800">
                    </div>

                    <!-- Tanggal Kadaluarsa (Expired Date) -->
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 flex items-center gap-1">
                            <i class="fa-solid fa-calendar-days text-[#04aabe]"></i>
                            <span>Tanggal Kadaluarsa </span>
                        </label>
                        <input type="date" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}"
                            class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-semibold text-slate-800">
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('medicines.index') }}"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Data Obat</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection