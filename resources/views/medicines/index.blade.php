@extends('layouts.app')

@section('title', 'Data Obat')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Data Master Obat</span>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Action Header Bar -->
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-capsules text-[#04aabe]"></i>
                    <span>Daftar Data Obat</span>
                </h2>
                <p class="text-xs text-slate-500 mt-1">Daftar katalog obat yang terdaftar di Sistem Logistik Farmasi RS Puspa Husada
                </p>
            </div>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('medicines.create') }}"
                class="px-5 py-2.5 bg-[#04aabe] hover:bg-[#03899c] text-white font-bold rounded-xl shadow-lg shadow-[#04aabe]/30 text-xs flex items-center gap-2 transition-all shrink-0">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Obat Baru</span>
            </a>
            @endif
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <form method="GET" action="{{ route('medicines.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-9 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-[#04aabe] focus:border-[#04aabe] font-medium text-slate-800 placeholder-slate-400"
                        placeholder="Cari nama atau kode obat...">
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Saring</span>
                </button>
                @if(request()->hasAny(['search', 'kategori']))
                    <a href="{{ route('medicines.index') }}"
                        class="w-full sm:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl text-center transition-all">
                        Atur Ulang
                    </a>
                @endif
            </form>
        </div>

        <!-- Medicines Table -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3.5 px-5">Kode Obat</th>
                            <th class="py-3.5 px-5">Nama Obat</th>
                            <th class="py-3.5 px-5">Kategori Obat</th>
                            <th class="py-3.5 px-5">Satuan</th>
                            <th class="py-3.5 px-5">Tingkat Pemakaian</th>
                            <th class="py-3.5 px-5">Tgl Kadaluarsa</th>
                            <th class="py-3.5 px-5">Harga / Unit</th>
                            <th class="py-3.5 px-5">Stok Saat Ini</th>
                            @if(Auth::user()->isAdmin())
                            <th class="py-3.5 px-5 text-center">Kelola</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        @forelse($medicines as $medicine)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-4 px-5 font-mono font-bold text-slate-500">{{ $medicine->kode_obat }}</td>
                                <td class="py-4 px-5 font-bold text-slate-800">{{ $medicine->nama_obat }}</td>
                                <td class="py-4 px-5">
                                    <span
                                        class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-lg text-[11px] whitespace-nowrap inline-block">
                                        {{ $medicine->kategori_obat ?? 'Obat Umum' }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 font-medium text-slate-600">{{ $medicine->satuan }}</td>
                                <td class="py-4 px-5">
                                    @if($medicine->tingkat_pemakaian === 'Sangat Sering')
                                        <span
                                            class="px-2.5 py-1 bg-brand-50 text-[#04aabe] border border-cyan-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                            <i class="fa-solid fa-fire"></i> Sangat Sering
                                        </span>
                                    @elseif($medicine->tingkat_pemakaian === 'Sering')
                                        <span
                                            class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                            <i class="fa-solid fa-bolt"></i> Sering
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                            <i class="fa-solid fa-minus"></i> Jarang
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5">
                                    @if($medicine->tanggal_kadaluarsa)
                                        @if($medicine->isExpired())
                                            <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                                <i class="fa-solid fa-triangle-exclamation"></i> {{ $medicine->tanggal_kadaluarsa->format('d/m/Y') }} (Kadaluarsa)
                                            </span>
                                        @elseif($medicine->isNearExpired())
                                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-bold rounded-lg text-[10px] whitespace-nowrap inline-flex items-center gap-1">
                                                <i class="fa-solid fa-clock-rotate-left"></i> {{ $medicine->tanggal_kadaluarsa->format('d/m/Y') }} (Mendekati Kadaluarsa)
                                            </span>
                                        @else
                                            <span class="font-medium text-slate-700 whitespace-nowrap">
                                                {{ $medicine->tanggal_kadaluarsa->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-400 font-normal italic">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 font-semibold text-slate-800">Rp
                                    {{ number_format($medicine->harga_per_unit, 0, ',', '.') }}</td>
                                <td class="py-4 px-5 font-bold text-slate-900">
                                    {{ number_format($medicine->stok_aktual) }} <span
                                        class="text-[10px] text-slate-400 font-normal">{{ $medicine->satuan }}</span>
                                </td>
                                @if(Auth::user()->isAdmin())
                                <td class="py-4 px-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('medicines.edit', $medicine->id) }}"
                                            class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition-all"
                                            title="Ubah Obat">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all"
                                                title="Hapus Obat">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isAdmin() ? 9 : 8 }}" class="py-8 text-center text-slate-400">Tidak ada data obat yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($medicines->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $medicines->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection