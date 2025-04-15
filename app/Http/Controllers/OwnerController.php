<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function home()
    {
        $transaksi = Transaksi::whereIn('status_pembayaran', ['Success', 'Settlement'])->get();

        $user = User::where('role', 'customer')->get();

        $grafikPemasukan = Transaksi::whereIn('status_pembayaran', ['Success', 'Settlement'])
            ->select([
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_harga) as total_harga')
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'), 'asc')
            ->get();

        $grafikCaraPemesanan = Transaksi::whereIn('status_pembayaran', ['Success', 'Settlement'])
            ->select('cara_pemesanan', DB::raw('count(*) as total'))
            ->groupBy('cara_pemesanan')
            ->get();

        $grafikPemesanan = Transaksi::whereIn('status_pembayaran', ['Success', 'Settlement'])
            ->select('cara_pemesanan', DB::raw('count(*) as total'))
            ->groupBy('cara_pemesanan')
            ->get();

        $labelsCaraPemesanan = $grafikCaraPemesanan->pluck('cara_pemesanan');
        $valuesCaraPemesanan = $grafikCaraPemesanan->pluck('total');

        return view('owner.home', compact('transaksi', 'user', 'grafikPemasukan', 'labelsCaraPemesanan', 'valuesCaraPemesanan'));
    }
}
