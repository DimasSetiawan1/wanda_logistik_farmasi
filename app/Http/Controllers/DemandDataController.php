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

        $demandData = $query->orderBy('created_at', 'desc')->paginate(15);
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
            'jumlah_permintaan' => 'required|integer|min:1',
        ]);

        $medicine = Medicine::findOrFail($request->medicine_id);

        DemandData::create($request->all());

        // Otomatis kurangi stok aktual obat saat pengajuan/permintaan dilakukan
        if ($request->jumlah_permintaan > 0) {
            $medicine->decrement('stok_aktual', $request->jumlah_permintaan);
        }

        return redirect()->route('demand-data.index')
            ->with('success', "Data permintaan berhasil ditambahkan. Stok {$medicine->nama_obat} berkurang {$request->jumlah_permintaan} {$medicine->satuan}.");
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

        $oldAmount = $demandDatum->jumlah_permintaan;
        $newAmount = $request->jumlah_permintaan;
        $diff = $newAmount - $oldAmount;

        $medicine = Medicine::findOrFail($request->medicine_id);

        if ($demandDatum->medicine_id != $request->medicine_id) {
            // Jika ganti obat: kembalikan stok obat lama, kurangi stok obat baru
            $oldMedicine = Medicine::find($demandDatum->medicine_id);
            if ($oldMedicine) {
                $oldMedicine->increment('stok_aktual', $oldAmount);
            }
            $medicine->decrement('stok_aktual', $newAmount);
        } else {
            // Obat sama: sesuaikan selisih
            if ($diff > 0) {
                $medicine->decrement('stok_aktual', $diff);
            } elseif ($diff < 0) {
                $medicine->increment('stok_aktual', abs($diff));
            }
        }

        $demandDatum->update($request->all());

        return redirect()->route('demand-data.index')
            ->with('success', 'Data permintaan dan stok obat berhasil diperbarui.');
    }

    public function destroy(DemandData $demandDatum)
    {
        // Restore stok jika data permintaan dihapus
        $medicine = $demandDatum->medicine;
        if ($medicine && $demandDatum->jumlah_permintaan > 0) {
            $medicine->increment('stok_aktual', $demandDatum->jumlah_permintaan);
        }

        $demandDatum->delete();

        return redirect()->route('demand-data.index')
            ->with('success', 'Data permintaan berhasil dihapus dan stok obat dikembalikan.');
    }
}
