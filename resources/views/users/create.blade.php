@extends('layouts.app')

@section('title', 'Tambah User')

@section('breadcrumb')
    <span>/</span>
    <a href="{{ route('users.index') }}" class="hover:text-[#04aabe]">Kelola User</a>
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Tambah User</span>
@endsection

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-[#04aabe]"></i>
                <span>Tambah Pengguna Baru</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Buat akun akses baru untuk sistem logistik farmasi</p>
        </div>
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all flex items-center gap-2">
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

        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Apt. Wanda Prasetyo" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Username <span class="text-rose-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: wanda_farmasi" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-mono font-bold text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role Hak Akses <span class="text-rose-500">*</span></label>
                <select name="role" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
                    <option value="instalasi_farmasi" {{ old('role') == 'instalasi_farmasi' ? 'selected' : '' }}>Petugas Instalasi Farmasi</option>
                    <option value="kepala_instalasi" {{ old('role') == 'kepala_instalasi' ? 'selected' : '' }}>Kepala Instalasi Farmasi</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800" required>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan User</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
