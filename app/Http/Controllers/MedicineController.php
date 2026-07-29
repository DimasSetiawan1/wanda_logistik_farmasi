<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $medicines = $query->orderBy('kode_obat')->paginate(15);

        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|string|unique:medicines,kode_obat',
            'nama_obat' => 'required|string|max:255',
            'kategori_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'tingkat_pemakaian' => 'required|in:Sangat Sering,Sering,Jarang',
            'kategori' => 'nullable|in:A,B,C',
            'harga_per_unit' => 'nullable|numeric|min:0',
            'stok_aktual' => 'nullable|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['kategori'] = $data['kategori'] ?? 'C';
        $data['harga_per_unit'] = $data['harga_per_unit'] ?? 0;
        $data['stok_aktual'] = $data['stok_aktual'] ?? 0;

        Medicine::create($data);

        return redirect()->route('medicines.index')
            ->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'kode_obat' => 'required|string|unique:medicines,kode_obat,' . $medicine->id,
            'nama_obat' => 'required|string|max:255',
            'kategori_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'tingkat_pemakaian' => 'required|in:Sangat Sering,Sering,Jarang',
            'kategori' => 'nullable|in:A,B,C',
            'harga_per_unit' => 'nullable|numeric|min:0',
            'stok_aktual' => 'nullable|integer|min:0',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['kategori'] = $data['kategori'] ?? $medicine->kategori;
        $data['harga_per_unit'] = $data['harga_per_unit'] ?? $medicine->harga_per_unit;
        $data['stok_aktual'] = $data['stok_aktual'] ?? $medicine->stok_aktual;

        $medicine->update($data);

        return redirect()->route('medicines.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}
