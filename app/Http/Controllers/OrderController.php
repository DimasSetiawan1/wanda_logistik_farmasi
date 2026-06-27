<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use App\Models\EoqCalculation;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('medicine');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'jumlah_pesan' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Order::create([
            'medicine_id' => $request->medicine_id,
            'tanggal_pesan' => now(),
            'jumlah_pesan' => $request->jumlah_pesan,
            'status' => 'pending',
            'keterangan' => $request->keterangan ?? 'Pemesanan otomatis berdasarkan EOQ',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pemesanan berhasil dibuat.');
    }

    /**
     * Buat pesanan otomatis untuk obat yang stok-nya di bawah minimum
     */
    public function autoOrder()
    {
        $calculations = EoqCalculation::with('medicine')
            ->where('status', 'perlu_pesan')
            ->get();

        $count = 0;
        foreach ($calculations as $calc) {
            // Cek apakah sudah ada pesanan pending untuk obat ini
            $existingOrder = Order::where('medicine_id', $calc->medicine_id)
                ->where('status', '!=', 'selesai')
                ->exists();

            if (!$existingOrder) {
                Order::create([
                    'medicine_id' => $calc->medicine_id,
                    'tanggal_pesan' => now(),
                    'jumlah_pesan' => ceil($calc->eoq_value),
                    'status' => 'pending',
                    'keterangan' => 'Pemesanan otomatis — Stok di bawah minimum (EOQ* = ' . $calc->eoq_value . ')',
                ]);
                $count++;
            }
        }

        return redirect()->route('orders.index')
            ->with('success', "{$count} pemesanan otomatis berhasil dibuat.");
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $order->update(['status' => $request->status]);

        // Jika selesai, tambahkan stok
        if ($request->status === 'selesai') {
            $medicine = $order->medicine;
            $medicine->increment('stok_aktual', $order->jumlah_pesan);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pemesanan berhasil dihapus.');
    }
}
