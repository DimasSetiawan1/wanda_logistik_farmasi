@extends('layouts.app')

@section('title', 'Evaluasi Efisiensi Stok')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Evaluasi Efisiensi Stok</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-[#04aabe]"></i>
                <span>Evaluasi Perbandingan Biaya Persediaan</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Perbandingan efisiensi pengeluaran anggaran antara penerapan pemesanan teroptimasi vs konvensional</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Biaya Teroptimasi</p>
            <h3 class="text-2xl font-black text-[#04aabe] mt-1">Rp {{ number_format($totalBiayaEoq, 0, ',', '.') }}</h3>
            <span class="inline-block mt-1 text-[11px] text-[#04aabe] font-bold bg-brand-50 px-2.5 py-0.5 rounded-md">Optimal & Efisien</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Biaya Konvensional</p>
            <h3 class="text-2xl font-black text-rose-600 mt-1">Rp {{ number_format($totalBiayaTanpaEoq, 0, ',', '.') }}</h3>
            <span class="inline-block mt-1 text-[11px] text-rose-700 font-bold bg-rose-50 px-2.5 py-0.5 rounded-md">Pemesanan Konvensional</span>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm text-center">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimasi Penghematan Biaya</p>
            <h3 class="text-2xl font-black text-sky-600 mt-1">Rp {{ number_format($penghematan, 0, ',', '.') }}</h3>
            <span class="inline-block mt-1 text-[11px] text-sky-700 font-bold bg-sky-50 px-2.5 py-0.5 rounded-md">Hemat {{ $persentaseHemat }}% Anggaran</span>
        </div>
    </div>

    <!-- Chart & Table Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Chart -->
        <div class="lg:col-span-6 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-800">Visualisasi Penghematan Anggaran</h3>
                <p class="text-xs text-slate-400">Grafik komparasi total biaya persediaan obat</p>
            </div>
            <div class="flex-1 h-72">
                <canvas id="costChart"></canvas>
            </div>
        </div>

        <!-- Table -->
        <div class="lg:col-span-6 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800">Rincian Kuantitas Optimal Per Obat</h3>
                <p class="text-xs text-slate-500 mt-1">Nilai kuantitas optimal dan total biaya per item</p>
            </div>
            <div class="flex-1 overflow-y-auto max-h-80 custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 z-10">
                        <tr>
                            <th class="py-3 px-5">Nama Obat</th>
                            <th class="py-3 px-5 text-right">Kuantitas Optimal</th>
                            <th class="py-3 px-5 text-right">Total Biaya (TC)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        @foreach($calculations as $calc)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="py-3.5 px-5 font-bold text-slate-800">{{ $calc->medicine->nama_obat }}</td>
                                <td class="py-3.5 px-5 text-right font-extrabold text-[#04aabe]">{{ number_format($calc->eoq_value, 0) }} {{ $calc->medicine->satuan }}</td>
                                <td class="py-3.5 px-5 text-right font-black text-slate-900">Rp {{ number_format($calc->total_cost, 0, ',', '.') }}</td>
                            </tr>
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
    new Chart(document.getElementById('costChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Pemesanan Teroptimasi', 'Pemesanan Konvensional'],
            datasets: [{
                label: 'Total Biaya (Rp)',
                data: [{{ $totalBiayaEoq }}, {{ $totalBiayaTanpaEoq }}],
                backgroundColor: ['#04aabe', '#f43f5e'],
                borderRadius: 12,
                barThickness: 50,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v),
                        font: { size: 10 }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
