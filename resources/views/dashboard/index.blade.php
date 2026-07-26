@extends('layouts.app')

@section('title', 'Beranda Utama')

@section('breadcrumb')
    <span>/</span>
    <span class="text-[#04aabe] font-semibold">Beranda</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-[#04aabe] via-cyan-600 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-[#04aabe]/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-cyan-100 text-xs font-semibold mb-3">
                <i class="fa-solid fa-hospital text-cyan-200"></i>
                <span>Sistem Logistik Farmasi RS Puspa Husada</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
            <p class="text-cyan-50 text-sm mt-1 max-w-2xl">
                Anda masuk sebagai <span class="font-bold underline uppercase">@if(Auth::user()->isAdmin()) Administrator @elseif(Auth::user()->isInstalasiFarmasi()) Petugas Instalasi Farmasi @elseif(Auth::user()->isKepalaInstalasi()) Kepala Instalasi Farmasi @endif</span>. Berikut adalah rangkuman aktivitas logistik farmasi saat ini.
            </p>
        </div>
        <div class="shrink-0 bg-white/10 p-3 rounded-2xl backdrop-blur-md hidden md:block">
            <i class="fa-solid fa-boxes-packing text-4xl text-cyan-100"></i>
        </div>
    </div>

    <!-- Summary Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Obat -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Obat</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($totalObat) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-[#04aabe] flex items-center justify-center text-xl shadow-sm">
                    <i class="fa-solid fa-pills"></i>
                </div>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Stok Kritis (Perlu Pesan)</p>
                    <h3 class="text-2xl font-black text-rose-600 mt-1">{{ number_format($stokKritis) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>

        <!-- Overstock -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Batas Maks (Overstock)</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ number_format($overstock) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-sm">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pesanan Aktif</p>
                    <h3 class="text-2xl font-black text-sky-600 mt-1">{{ number_format($pesananAktif) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl shadow-sm">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Alert Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Stok Terendah Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-[#04aabe]"></i>
                        <span>10 Obat dengan Stok Terendah</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pantauan ketersediaan persediaan aktual obat di gudang</p>
                </div>
            </div>
            <div class="h-72">
                <canvas id="stokChart"></canvas>
            </div>
        </div>

        <!-- Warning Card - Need Order -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-bell-concierge text-rose-500"></i>
                    <span>Daftar Perlu Dipesan</span>
                </h3>
                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-bold rounded-lg border border-rose-200">
                    {{ $perluPesan->count() }} Obat
                </span>
            </div>

            <div class="flex-1 overflow-y-auto max-h-72 space-y-3 custom-scrollbar pr-1">
                @forelse($perluPesan as $item)
                    <div class="p-3.5 bg-rose-50/50 border border-rose-100 rounded-xl flex items-center justify-between gap-3">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">{{ $item->medicine->nama_obat }}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Stok: <span class="font-bold text-rose-600">{{ $item->medicine->stok_aktual }} {{ $item->medicine->satuan }}</span> | Min: {{ number_format($item->stok_minimum, 0) }}
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-rose-600 text-white text-[10px] font-bold rounded-lg shadow-sm">
                            Kritis
                        </span>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-12 h-12 rounded-full bg-brand-50 text-[#04aabe] flex items-center justify-center mx-auto mb-2 text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <p class="text-xs font-semibold text-slate-700">Semua Stok Aman</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada obat di bawah batas minimum.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-history text-[#04aabe]"></i>
                    <span>Riwayat Pemesanan Obat Terbaru</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Transaksi pemesanan yang baru dilakukan ke supplier</p>
            </div>
            @if(!Auth::user()->isInstalasiFarmasi())
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">
                Lihat Semua Pesanan
            </a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Tanggal Pesan</th>
                        <th class="py-3.5 px-6">Nama Obat</th>
                        <th class="py-3.5 px-6">Jumlah Pesan</th>
                        <th class="py-3.5 px-6">Status Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($pesananTerbaru as $order)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="py-4 px-6 font-semibold">{{ $order->tanggal_pesan->format('d/m/Y') }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $order->medicine->nama_obat }}</td>
                            <td class="py-4 px-6 font-bold text-[#04aabe]">{{ number_format($order->jumlah_pesan) }} {{ $order->medicine->satuan }}</td>
                            <td class="py-4 px-6">
                                @if($order->status === 'pending')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 font-bold rounded-lg text-[10px]">
                                        Menunggu (Pending)
                                    </span>
                                @elseif($order->status === 'diproses')
                                    <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200 font-bold rounded-lg text-[10px]">
                                        Sedang Diproses
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-brand-50 text-[#04aabe] border border-cyan-200 font-bold rounded-lg text-[10px]">
                                        Selesai Restock
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada transaksi pemesanan obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const stokData = @json($stokData);
    const ctx = document.getElementById('stokChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: stokData.map(d => d.nama_obat.length > 18 ? d.nama_obat.substr(0, 18) + '...' : d.nama_obat),
            datasets: [{
                label: 'Jumlah Stok (Unit)',
                data: stokData.map(d => d.stok_aktual),
                backgroundColor: stokData.map(d => d.stok_aktual < 100 ? '#f43f5e' : d.stok_aktual < 200 ? '#f59e0b' : '#04aabe'),
                borderRadius: 8,
                barThickness: 24,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 10 } }
                }
            }
        }
    });
</script>
@endpush
