<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\EoqCalculation;
use App\Models\DemandData;

class DashboardController extends Controller
{
    public function index()
    {
        $totalObat = Medicine::count();
        $stokKritis = EoqCalculation::where('status', 'perlu_pesan')->count();
        $overstock = EoqCalculation::where('status', 'overstock')->count();
        $totalPemakaian = DemandData::count();

        // Data untuk chart (10 obat stok terendah)
        $stokData = Medicine::select('nama_obat', 'stok_aktual')
            ->orderBy('stok_aktual', 'asc')
            ->limit(10)
            ->get();

        // Obat yang berada di bawah batas stok minimum (kritis)
        $perluPesan = EoqCalculation::with('medicine')
            ->where('status', 'perlu_pesan')
            ->get();

        // Data pemakaian/permintaan terbaru
        $pemakaianTerbaru = DemandData::with('medicine')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalObat',
            'stokKritis',
            'overstock',
            'totalPemakaian',
            'stokData',
            'perluPesan',
            'pemakaianTerbaru'
        ));
    }
}
