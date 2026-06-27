<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\EoqParameter;
use App\Models\EoqCalculation;
use App\Services\AbcAnalysisService;
use App\Services\EoqCalculationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function abcAnalysis(AbcAnalysisService $service)
    {
        $analysisData = $service->analyze();
        $summary = $service->getSummary();

        return view('evaluation.abc', compact('analysisData', 'summary'));
    }

    public function eoqEvaluation()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])->get();

        // Hitung total biaya EOQ vs biaya tanpa EOQ
        $totalBiayaEoq = $calculations->sum('total_cost');

        // Biaya tanpa EOQ (asumsi pesan sekali setahun dalam jumlah besar)
        $totalBiayaTanpaEoq = 0;
        foreach ($calculations as $calc) {
            $param = $calc->eoqParameter;
            if ($param) {
                $D = $param->rata_rata_permintaan;
                $S = $param->biaya_pesan;
                $H = $param->biaya_simpan;
                $P = $calc->medicine->harga_per_unit;
                // Pesan sekali setahun: TC = S + (D/2 * H) + (D * P)
                $biayaTanpaEoq = $S + (($D / 2) * $H) + ($D * $P);
                $totalBiayaTanpaEoq += $biayaTanpaEoq;
            }
        }

        $penghematan = $totalBiayaTanpaEoq - $totalBiayaEoq;
        $persentaseHemat = $totalBiayaTanpaEoq > 0
            ? round(($penghematan / $totalBiayaTanpaEoq) * 100, 2)
            : 0;

        return view('evaluation.eoq-review', compact(
            'calculations',
            'totalBiayaEoq',
            'totalBiayaTanpaEoq',
            'penghematan',
            'persentaseHemat'
        ));
    }

    public function periodicReview()
    {
        $parameters = EoqParameter::with('medicine')->orderBy('updated_at', 'desc')->get();

        return view('evaluation.periodic', compact('parameters'));
    }

    public function updateParameter(Request $request, EoqParameter $parameter, EoqCalculationService $service)
    {
        $request->validate([
            'rata_rata_permintaan' => 'required|numeric|min:0',
            'biaya_pesan' => 'required|numeric|min:0',
            'biaya_simpan' => 'required|numeric|min:0',
            'lead_time' => 'required|integer|min:1',
            'service_level_z' => 'nullable|numeric|min:0',
        ]);

        $parameter->update($request->only([
            'rata_rata_permintaan', 'biaya_pesan', 'biaya_simpan', 'lead_time', 'service_level_z'
        ]));

        // Recalculate
        $service->calculate($parameter->medicine, $parameter);

        return redirect()->route('evaluation.periodic')
            ->with('success', 'Parameter berhasil diperbarui dan dihitung ulang.');
    }
}
