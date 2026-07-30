@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Kelola Pengguna</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-[#04aabe]"></i>
                <span>Manajemen Pengguna Sistem</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Daftar akun pengguna aplikasi (Admin, Instalasi Farmasi, Kepala Instalasi)</p>
        </div>
        <a href="{{ route('users.create') }}" class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all shrink-0">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Pengguna Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">No</th>
                        <th class="py-3.5 px-5">Nama Lengkap</th>
                        <th class="py-3.5 px-5">Nama Pengguna</th>
                        <th class="py-3.5 px-5">Peran Pengguna</th>
                        <th class="py-3.5 px-5">Tanggal Dibuat</th>
                        <th class="py-3.5 px-5 text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @foreach($users as $i => $user)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-5 text-slate-400 font-bold">{{ $users->firstItem() + $i }}</td>
                            <td class="py-4 px-5 font-bold text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 px-5 font-mono font-bold text-[#04aabe]">@ {{ $user->username }}</td>
                            <td class="py-4 px-5">
                                @if($user->isAdmin())
                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-700 border border-purple-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-shield-halved"></i> Administrator
                                    </span>
                                @elseif($user->isInstalasiFarmasi())
                                    <span class="px-2.5 py-1 bg-brand-50 text-[#04aabe] border border-cyan-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-pills"></i> Instalasi Farmasi
                                    </span>
                                @elseif($user->isKepalaInstalasi())
                                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                        <i class="fa-solid fa-user-tie"></i> Kepala Instalasi
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-[10px] whitespace-nowrap inline-block">
                                        {{ $user->role }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-500">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition-all" title="Ubah Pengguna">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all" title="Hapus Pengguna">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
