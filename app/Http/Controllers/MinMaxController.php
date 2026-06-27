<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\EoqCalculation;
use App\Services\EoqCalculationService;
use Illuminate\Http\Request;

class MinMaxController extends Controller
{
    protected EoqCalculationService $service;

    public function __construct(EoqCalculationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('minmax.index', compact('calculations'));
    }

    public function result()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('minmax.result', compact('calculations'));
    }

    public function monitoring()
    {
        // Update status monitoring
        $this->service->updateMonitoringStatus();

        $calculations = EoqCalculation::with('medicine')
            ->orderByRaw("FIELD(status, 'perlu_pesan', 'overstock', 'normal')")
            ->get();

        $summary = [
            'normal' => $calculations->where('status', 'normal')->count(),
            'perlu_pesan' => $calculations->where('status', 'perlu_pesan')->count(),
            'overstock' => $calculations->where('status', 'overstock')->count(),
        ];

        return view('minmax.monitoring', compact('calculations', 'summary'));
    }
}
