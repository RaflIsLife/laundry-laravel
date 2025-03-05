<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use App\Models\User;
use Illuminate\Http\Request;

class KasirController extends Controller
{

    public function kasir()
    {
        $layanan = Layanan::all();
        return view('kasir/kasir', compact('layanan'));
    }

    public function postKasir(Request $request, User $user)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'pembayaran' => 'required|in:qris,cod',
            'status_pembayaran' => 'required|in:lunas,proses',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:layanans,id',
            'services.*.quantity' => 'required|numeric|min:0.1',
            'services.*.unit' => 'required|in:pcs,kg',
        ]);

        // Hitung total

        $user = User::where('phone', $data['customer_phone'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'],
                'role' => 'customer',
            ]);
        }
        $totalHarga = 0;
        foreach ($data['services'] as $service) {
            $layanan = Layanan::find($service['service_id']);
            $harga = $service['unit'] === 'pcs'
                ? $layanan->harga_pcs
                : $layanan->harga_kg;
            $totalHarga += $harga * $service['quantity'];
        }

        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'total_harga' => $totalHarga,
            'qty' => count($data['services']),
            'status' => 'antrian laundry',
            'pembayaran' => $data['pembayaran'],
            'status_pembayaran' => $data['status_pembayaran'],
            'cara_pemesanan' => 'offline',
        ]);

        // Simpan layanan
        foreach ($data['services'] as $service) {
            TransaksiLayanan::create([
                'transaksi_id' => $transaksi->id,
                'layanan_id' => $service['service_id'],
                'type_qty' => $service['unit'],
                'qty' => $service['quantity'],
                'harga' => ($service['unit'] === 'pcs'
                    ? Layanan::find($service['service_id'])->harga_pcs
                    : Layanan::find($service['service_id'])->harga_kg) * $service['quantity']
            ]);
        }

        return redirect()->route('kasir')->with('status', 'Transaksi berhasil disimpan!');
    }


    public function transaksi()
    {
        $transaksi = Transaksi::whereNotIn('status', ['selesai'])->with('user')->oldest('created_at')->get();
        return view('kasir/transaksi', compact('transaksi'));
    }
    public function history()
    {
        $transaksi = Transaksi::where('status', ['selesai'])->with('user')->latest('updated_at')->get();
        return view('kasir/history', compact('transaksi'));
    }

    public function detailPesanan(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('kasir/detailPesanan', compact('transaksi', 'transaksiLayanan'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate(['status' => 'required']);

        $transaksi->update(['status' => $request->status]);
        return back()->with('status', 'Status transaksi diperbarui');
    }
}
