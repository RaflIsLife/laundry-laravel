<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    public function home(Request $request){
        $transaksi = Transaksi::where('status', ['menunggu pengambilan', 'menunggu pengantaran' ])->with('user')->get();
        return view('kurir.home' , compact('transaksi'));
    }
    public function detail(){
        $transaksi = Transaksi::where('status', ['menunggu pengambilan', 'menunggu pengantaran' ])->with('user')->get();
        return view('kurir.detail');
    }
}
