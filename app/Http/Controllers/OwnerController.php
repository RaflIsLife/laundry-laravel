<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function home()
    {
        $transaksi = Transaksi::all();
        $user = User::where('role', 'customer')->get();
        return view('owner.home', compact('transaksi', 'user'));
    }
}
