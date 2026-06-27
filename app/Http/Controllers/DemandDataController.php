<?php

namespace App\Http\Controllers;

use App\Models\DemandData;
use App\Models\Medicine;
use Illuminate\Http\Request;

class DemandDataController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandData::with('medicine');

        if ($request->filled('medicine_id')) {
            $query->where('medicine_id', $request->medicine_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('medicine', function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%");
            });
        }

        $demandData = $query->orderBy('periode', 'desc')->paginate(15);
        $medicines = Medicine::orderBy('nama_obat')->get();

        return view('demand-data.index', compact('demandData', 'medicines'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('nama_obat')->get();
        return view('demand-data.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'periode' => 'required|string',
            'jumlah_permintaan' => 'required|integer|min:0',
        ]);

        DemandData::create($request->all());

        return redirect()->route('demand-data.index')
            ->with('success', 'Data permintaan berhasil ditambahkan.');
    }

    public function edit(DemandData $demandDatum)
    {
        $medicines = Medicine::orderBy('nama_obat')->get();
        return view('demand-data.edit', compact('demandDatum', 'medicines'));
    }

    public function update(Request $request, DemandData $demandDatum)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'periode' => 'required|string',
            'jumlah_permintaan' => 'required|integer|min:0',
        ]);

        $demandDatum->update($request->all());

        return redirect()->route('demand-data.index')
            ->with('success', 'Data permintaan berhasil diperbarui.');
    }

    public function destroy(DemandData $demandDatum)
    {
        $demandDatum->delete();

        return redirect()->route('demand-data.index')
            ->with('success', 'Data permintaan berhasil dihapus.');
    }
}
