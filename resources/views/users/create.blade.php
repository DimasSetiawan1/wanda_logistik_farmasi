@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('users.index') }}" class="hover:text-[#04aabe]">Kelola Pengguna</a>
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Tambah Pengguna Baru</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-brand-50 text-[#04aabe] flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-user-plus text-[#04aabe]"></i>
        </div>
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Tambah Pengguna Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Buat akun pengguna baru untuk mengakses sistem logistik farmasi</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        @if ($errors->any())
            <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl space-y-1">
                <p class="font-bold">Gagal Menyimpan Data:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso, Amd. Farm" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Pengguna (Username) <span class="text-rose-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: budi_farmasi" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-mono font-bold text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran Hak Akses <span class="text-rose-500">*</span></label>
                <select name="role" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
                    <option value="instalasi_farmasi" {{ old('role') == 'instalasi_farmasi' ? 'selected' : '' }}>Petugas Instalasi Farmasi (Pencatatan Pemakaian)</option>
                    <option value="kepala_instalasi" {{ old('role') == 'kepala_instalasi' ? 'selected' : '' }}>Kepala Instalasi Farmasi (Peninjauan & Laporan)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Pengelolaan)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi (Password) <span class="text-rose-500">*</span></label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Pengguna</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
