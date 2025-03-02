<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function home(Request $request){
        $transaksi = Transaksi::where('status', ['menunggu pengambilan'])->orWhere('status', ['menunggu pengantaran'])->with('user')->get();
        return view('kurir.home' , compact('transaksi'));
    }
    public function detail(Request $request, Transaksi $transaksi){
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('kurir.detail', compact('transaksi', 'transaksiLayanan'));
    }
    public function detailHistory(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('admin/detailHistory', compact('transaksi', 'transaksiLayanan'));
    }
}
