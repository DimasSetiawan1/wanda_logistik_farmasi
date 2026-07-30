<?php

namespace App\Http\Controllers;

use App\Models\EoqCalculation;
use App\Services\AbcAnalysisService;
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
        $totalBiayaPersediaan = $calculations->sum('total_cost');

        return view('evaluation.eoq-review', compact('calculations', 'totalBiayaPersediaan'));
    }
}
