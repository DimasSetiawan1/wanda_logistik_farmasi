<?php

namespace App\Http\Controllers;

use App\Models\EoqCalculation;
use App\Models\Medicine;
use App\Services\AbcAnalysisService;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])
            ->orderBy('created_at', 'desc')
            ->get();

        $medicines = Medicine::orderBy('kategori')->orderBy('nama_obat')->get();

        return view('reports.index', compact('calculations', 'medicines'));
    }

    public function exportPdf()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])
            ->orderBy('created_at', 'desc')
            ->get();

        $medicines = Medicine::orderBy('kategori')->orderBy('nama_obat')->get();

        $abcService = new AbcAnalysisService();
        $abcData = $abcService->analyze();
        $abcSummary = $abcService->getSummary();

        $data = [
            'calculations' => $calculations,
            'medicines' => $medicines,
            'abcData' => $abcData,
            'abcSummary' => $abcSummary,
            'tanggalCetak' => now()->format('d F Y'),
        ];

        $pdf = Pdf::loadView('reports.pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_EOQ_MinMax_RSPH_' . now()->format('Y-m-d') . '.pdf');
    }
}
