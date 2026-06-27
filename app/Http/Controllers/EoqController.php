<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\EoqParameter;
use App\Models\EoqCalculation;
use App\Services\EoqCalculationService;
use Illuminate\Http\Request;

class EoqController extends Controller
{
    protected EoqCalculationService $service;

    public function __construct(EoqCalculationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $medicines = Medicine::with('latestEoqParameter')->orderBy('nama_obat')->get();
        return view('eoq.index', compact('medicines'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'rata_rata_permintaan' => 'required|numeric|min:0',
            'biaya_pesan' => 'required|numeric|min:0',
            'biaya_simpan' => 'required|numeric|min:0',
            'faktor_biaya_simpan' => 'nullable|numeric|min:0|max:1',
            'lead_time' => 'required|integer|min:1',
            'service_level_z' => 'nullable|numeric|min:0',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);

        // Simpan atau update parameter
        $parameter = EoqParameter::updateOrCreate(
            ['medicine_id' => $medicine->id],
            [
                'rata_rata_permintaan' => $request->rata_rata_permintaan,
                'biaya_pesan' => $request->biaya_pesan,
                'biaya_simpan' => $request->biaya_simpan,
                'faktor_biaya_simpan' => $request->faktor_biaya_simpan ?? 0.1,
                'lead_time' => $request->lead_time,
                'service_level_z' => $request->service_level_z ?? 1.65,
            ]
        );

        // Hitung EOQ
        $this->service->calculate($medicine, $parameter);

        return redirect()->route('eoq.result')
            ->with('success', 'Perhitungan EOQ untuk ' . $medicine->nama_obat . ' berhasil.');
    }

    public function calculateAll()
    {
        $this->service->calculateAll();

        return redirect()->route('eoq.result')
            ->with('success', 'Perhitungan EOQ untuk semua obat berhasil.');
    }

    public function result()
    {
        $calculations = EoqCalculation::with(['medicine', 'eoqParameter'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('eoq.result', compact('calculations'));
    }
}
