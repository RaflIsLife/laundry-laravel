<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CompanyProfile;
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
        $companyProfile = CompanyProfile::first();
        return view('kasir/kasir', compact('layanan', 'companyProfile'));
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $results = [];

        // Ganti 'your_table' dengan nama tabel Anda
        $data = DB::table('users')
            ->where('role', 'customer')
            ->where(function ($query) use ($term) {
                $query->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('phone', 'LIKE', '%' . $term . '%')
                    ->orWhere('coordinate', 'LIKE', '%' . $term . '%');
            })
            ->get();

        foreach ($data as $row) {
            $results[] = [
                'name'  => $row->name,
                'phone'  => $row->phone,
                'coordinate'  => $row->coordinate,
                // 'label' akan tampil pada dropdown (gabungan nama dan nomor hp)
                'label' => $row->name . ' - ' . $row->phone . ' - ' . $row->coordinate,
                // 'value' bisa disesuaikan, misalnya mengisi input nama
                'value' => $row->name,
            ];
        }
        return response()->json($results);
    }

    public function postKasir(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'latitude' => 'sometimes',
            'longitude' => 'sometimes',
            'address' => 'sometimes',
            'ongkir' => 'sometimes',
            'pengantaran' => 'sometimes',
            'pembayaran' => 'required|in:qris,cod',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:layanans,id',
            'services.*.quantity' => 'required|numeric|min:0.1',
            'services.*.unit' => 'required|in:pcs,kg',
        ]);
        // Hitung total
        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
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
            'subtotal' => $totalHarga,
            'ongkir' => 0,
            'total_harga' => $totalHarga,
            'qty' => count($data['services']),
            'status' => 'menunggu pembayaran',
            'pembayaran' => $data['pembayaran'],
            'status_pembayaran' => 'Pending',
            'cara_pemesanan' => 'offline',
            'pengantaran' => 'tidak',
        ]);

        if ($request->has('pengantaran')) {
            $user->update([
                'coordinate' => $data['latitude'] . ',' . $data['longitude'],
                'address' => $data['address'],
            ]);
            $transaksi->update([
                'ongkir' => $data['ongkir'],
                'total_harga' => ($totalHarga + $data['ongkir']),
                'pengantaran' => 'ya',
            ]);
        }

        // Simpan layanan
        foreach ($data['services'] as $service) {
            $layanan = Layanan::find($service['service_id']);

            $transaksi->layanan()->attach($layanan->id, [
                'qty'   => $service['quantity'],
                'type_qty' => $service['unit'],
                'harga' => ($service['unit'] === 'pcs'
                    ? Layanan::find($service['service_id'])->harga_pcs
                    : Layanan::find($service['service_id'])->harga_kg) * $service['quantity'],
            ]);
        }

        $userController = new UserController();
        if ($data['pembayaran'] == 'cod') {
            $transaksi->update([
                'status' => 'antrian laundry',
                'status_pembayaran' => 'Success',
            ]);
            return redirect()->route('kasir')->with('status', 'Pesanan berhasil dibuat!');
        } elseif ($data['pembayaran'] == 'qris') {
            $snapToken = $userController->midtransPayment($transaksi);
            return response()->json(['snapToken' => $snapToken]);
        }
    }

    public function transaksi()
    {
        $transaksi = Transaksi::whereNotIn('status', ['selesai', 'dibatalkan'])
            ->where(function ($query) {
                $query->whereIn('status_pembayaran', ['Success', 'Settlement'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('cara_pemesanan', 'online')
                            ->where('pembayaran', 'cod')
                            ->where('status_pembayaran', 'Pending');
                    });
            })
            ->with('user')
            ->oldest('created_at')
            ->get();
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

        $updateData = ['status' => $request->status];

        if ($request->status == 'menunggu pengantaran' || $request->status == 'menunggu pengambilan') {
            $updateData['courier_id'] = null;
        } else if ($request->status == 'selesai') {
            $updateData['courier_id'] = null;
            $updateData['status_pembayaran'] = 'Success';
        } else if ($request->status == 'antrian laundry') {
            $updateData['status_pembayaran'] = 'Success';
        }

        $transaksi->update($updateData);

        if ($request->status == 'antrian laundry') {
            $this->antrianLaundrySwitch();
        } else if ($request->status == 'menunggu pengantaran' || $request->status == 'menunggu pengambilan') {
            $userController = new UserController();
            $userController->assignPendingOrders();
        }
        return back()->with('status', 'Status transaksi diperbarui');
    }

    public function antrianLaundrySwitch()
    {
        $transaksi = Transaksi::where('status', 'antrian laundry')
            ->where(function ($query) {
                $query->whereIn('status_pembayaran', ['Success', 'Settlement'])
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('cara_pemesanan', 'online')
                            ->where('pembayaran', 'cod')
                            ->where('status_pembayaran', 'Pending');
                    });
            })
            ->oldest('updated_at')
            ->get();
        $transaksiProsesLaundryCount = Transaksi::where('status', 'proses laundry')->count();

        foreach ($transaksi as $transaksis) {
            if ($transaksiProsesLaundryCount >= 5) {
                break;
            }
            $transaksis->status = 'proses laundry';
            $transaksis->save();

            $transaksiProsesLaundryCount++;
        }
    }
}
