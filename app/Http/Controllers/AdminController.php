<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request)
    {
        $transaksi = Transaksi::whereNotIn('status', ['selesai'])->with('user')->get();
        return view('admin/home', compact('transaksi'));
    }
    public function akun()
    {
        $data = User::all();
        return view('admin/akun', compact('data'));
    }
    public function akunDestroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function create()
    {
        return view('admin/create');
    }

    public function postCreate(Request $request)
    {
        $cek = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.akun')->with('status', 'Berhasil Menambah Akun');
    }
    public function akunUpdate($id)
    {
        $user = User::find($id);
        return view('admin/update', compact('user'));
    }

    public function postAkunUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|numeric|unique:users,phone,' . $id,
            'password' => 'sometimes',
            'role' => 'required|in:owner,admin,kasir,kurir,customer',
        ], [
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'phone.unique' => 'Nomor HP sudah digunakan oleh user lain.',
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.akun')->with('success', 'User berhasil diperbarui!');
    }

    public function layanan()
    {
        $data = Layanan::all();
        return view('admin/layanan', compact('data'));
    }
    public function layananCreate()
    {
        return view('admin/createLayanan');
    }
    public function postLayanan(Request $request)
    {
        $cek = $request->validate([
            'nama_layanan' => 'required',
            'harga' => 'required',
        ]);

        //    logs($request->all());
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.layanan')->with('status', 'Berhasil Menambah Layanan');
    }
    public function layananUpdate($id)
    {
        $layanan = Layanan::find($id);
        return view('admin/updateLayanan', compact('layanan'));
    }

    public function postLayananUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga' => 'required|numeric',
        ]);

        $layanan = Layanan::find($id);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.layanan')->with('success', 'User berhasil diperbarui!');
    }
    public function detailPesanan(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('admin/detailPesanan', compact('transaksi', 'transaksiLayanan'));
    }
    public function historyAdmin(Request $request)
    {
        $transaksi = Transaksi::where('status', 'selesai')->with('user')->get();
        return view('admin/riwayat', compact('transaksi'));
    }
    public function detailHistory(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('admin/detailHistory', compact('transaksi', 'transaksiLayanan'));
    }
}
