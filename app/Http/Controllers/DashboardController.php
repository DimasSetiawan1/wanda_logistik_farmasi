<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\EoqCalculation;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalObat = Medicine::count();
        $stokKritis = EoqCalculation::where('status', 'perlu_pesan')->count();
        $overstock = EoqCalculation::where('status', 'overstock')->count();
        $pesananAktif = Order::where('status', '!=', 'selesai')->count();

        // Data untuk chart
        $stokData = Medicine::select('nama_obat', 'stok_aktual')
            ->orderBy('stok_aktual', 'asc')
            ->limit(10)
            ->get();

        // Obat yang perlu dipesan
        $perluPesan = EoqCalculation::with('medicine')
            ->where('status', 'perlu_pesan')
            ->get();

        // Pesanan terbaru
        $pesananTerbaru = Order::with('medicine')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalObat',
            'stokKritis',
            'overstock',
            'pesananAktif',
            'stokData',
            'perluPesan',
            'pesananTerbaru'
        ));
    }
}
