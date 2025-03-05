<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function home()
    {
        $courier = auth()->user();
        $transaksi = Transaksi::where('courier_id', $courier->id)
            ->whereIn('status', ['menunggu pengambilan', 'pengambilan', 'menunggu pengantaran', 'pengantaran'])
            ->first();

        return view('kurir.home', compact('transaksi'));
    }

    public function markPaid(Request $request, Transaksi $transaksi)
    {
        if ($transaksi->pembayaran === 'cod' && $transaksi->status_pembayaran === 'proses') {
            $transaksi->status_pembayaran = 'lunas';
            $transaksi->save();
            return redirect()->back()->with('success', 'Status pembayaran telah diubah menjadi lunas.');
        }
        return redirect()->back()->with('error', 'Gagal mengubah status pembayaran.');
    }

    public function completeOrder(Request $request, Transaksi $transaksi)
    {
        if ($transaksi->courier_id !== auth()->id()) abort(403);

        $nextStatusMap = [
            'menunggu pengambilan' => 'antrian laundry',
            'pengambilan' => 'antrian laundry',
            'menunggu pengantaran' => 'selesai',
            'pengantaran' => 'selesai',
        ];

        if (!isset($nextStatusMap[$transaksi->status])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $transaksi->status = $nextStatusMap[$transaksi->status];
        $transaksi->save();

        $courier = auth()->user();
        $courier->status = 'available';
        $courier->daily_completed_orders += 1;
        $courier->save();

        $userController = new UserController();
        $userController->assignPendingOrders();

        return redirect()->route('kurir')->with('success', 'Pesanan selesai');
    }
    public function detail(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        $companyProfile = CompanyProfile::first();
        return view('kurir.detail', compact('transaksi', 'transaksiLayanan', 'companyProfile'));
    }
}
