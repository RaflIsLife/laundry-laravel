<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function home()
    {
        // Mengambil semua transaksi
        $transaksi = Transaksi::all();

        // Mengambil data pelanggan dengan role 'customer'
        $user = User::where('role', 'customer')->get();

        // Mengambil total pemasukan per bulan untuk grafik
        $grafikPemasukan = Transaksi::selectRaw('MONTH(created_at) as bulan, SUM(total_harga) as total_harga')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Mengirim data ke view
        return view('owner.home', compact('transaksi', 'user', 'grafikPemasukan'));
    }
}
