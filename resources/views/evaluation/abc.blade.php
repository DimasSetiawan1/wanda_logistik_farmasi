@extends('layouts.app')

@section('title', 'Prioritas Kategori Stok')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Klasifikasi Prioritas Stok</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-[#04aabe]"></i>
                <span>Klasifikasi Prioritas Persediaan</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Pengelompokan persediaan obat berdasarkan tingkat investasi dan nilai pemakaian tahunan</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        @foreach($summary as $kat => $data)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 text-xs font-black rounded-lg uppercase tracking-wider
                        {{ $kat === 'A' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($kat === 'B' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-brand-50 text-[#04aabe] border border-cyan-200') }}">
                        Kategori {{ $kat }}
                    </span>
                    <span class="text-2xl font-black text-slate-800">{{ $data['count'] }} Obat</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="h-full {{ $kat === 'A' ? 'bg-rose-500' : ($kat === 'B' ? 'bg-amber-500' : 'bg-[#04aabe]') }}" style="width: {{ $data['percentage'] }}%"></div>
                </div>
                <p class="text-[11px] text-slate-500 font-medium">
                    <span class="font-bold text-slate-700">{{ $data['percentage'] }}% Total Item</span> — {{ $data['description'] }}
                </p>
            </div>
        @endforeach
    </div>

    <!-- Chart & Table Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Chart Container -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between w-full overflow-hidden">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-800 mb-1">Distribusi Prioritas Stok</h3>
                <p class="text-xs text-slate-400">Proporsi item obat per kelompok investasi</p>
            </div>
            <div class="py-4 w-full flex items-center justify-center">
                <div class="relative w-full max-w-[220px] aspect-square">
                    <canvas id="abcChart"></canvas>
                </div>
            </div>
            <div class="mt-4 text-[11px] text-slate-400 text-center font-medium">
                Kategori A membutuhkan perhatian paling ketat dalam perencanaan stok.
            </div>
        </div>

        <!-- Table Container -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden w-full">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800">Rincian Klasifikasi Item Obat</h3>
                <p class="text-xs text-slate-500 mt-1">Urutan obat berdasarkan investasi nilai pemakaian</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3.5 px-5">No</th>
                            <th class="py-3.5 px-5">Nama Obat</th>
                            <th class="py-3.5 px-5 text-right">Permintaan</th>
                            <th class="py-3.5 px-5 text-right">Harga Unit</th>
                            <th class="py-3.5 px-5 text-right font-bold">Nilai Pemakaian</th>
                            <th class="py-3.5 px-5 text-right">% Kontribusi</th>
                            <th class="py-3.5 px-5 text-center">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        @forelse($analysisData as $i => $item)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-3.5 px-5 text-slate-400 font-bold">{{ $i + 1 }}</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">{{ $item['medicine']->nama_obat }}</td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-700">{{ number_format($item['total_permintaan']) }}</td>
                                <td class="py-3.5 px-5 text-right font-semibold text-slate-700">Rp {{ number_format($item['harga_per_unit'], 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right font-black text-slate-900">Rp {{ number_format($item['nilai_pakai'], 0, ',', '.') }}</td>
                                <td class="py-3.5 px-5 text-right font-bold text-[#04aabe]">{{ $item['persentase'] }}%</td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="px-2.5 py-1 text-[10px] font-black rounded-lg uppercase tracking-wider whitespace-nowrap
                                        {{ $item['kategori_abc'] === 'A' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($item['kategori_abc'] === 'B' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-brand-50 text-[#04aabe] border border-cyan-200') }}">
                                        Kategori {{ $item['kategori_abc'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data untuk analisis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const abcCtx = document.getElementById('abcChart').getContext('2d');
    new Chart(abcCtx, {
        type: 'doughnut',
        data: {
            labels: ['Kategori A', 'Kategori B', 'Kategori C'],
            datasets: [{
                data: [{{ $summary['A']['count'] }}, {{ $summary['B']['count'] }}, {{ $summary['C']['count'] }}],
                backgroundColor: ['#f43f5e', '#f59e0b', '#04aabe'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        font: { size: 11 },
                        padding: 14,
                        boxWidth: 12
                    }
                }
            },
            cutout: '65%',
        }
    });
</script>
@endpush
