<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use App\Models\User;
use Faker\Provider\ar_EG\Company;
use Hamcrest\Core\AllOf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Midtrans\Snap;

class UserController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function login()
    {
        return view('auth/login');
    }

    public function postLogin(Request $request)
    {
        $cek = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($cek)) {
            $user = Auth::user();
            if ($user->role == 'customer') {
                return redirect()->route('user')->with('status', 'Selamat datang :' . $user->name);
            } else if ($user->role == 'admin') {
                return redirect()->route('admin.home')->with('status', 'Selamat datang :' . $user->name);
            } else if ($user->role == 'kasir') {
                return redirect()->route('kasir')->with('status', 'Selamat datang :' . $user->name);
            } else if ($user->role == 'kurir') {
                return redirect()->route('kurir')->with('status', 'Selamat datang :' . $user->name);
            } else if ($user->role == 'owner') {
                return redirect()->route('owner')->with('status', 'Selamat datang :' . $user->name);
            }
        }
        return back()->with('status', 'Email/Password salah');
    }


    public function register()
    {
        return view('auth/register');
    }

    //Haversine formula
    public function calculateDistance($address, $lat2, $lon2)
    {
        $radius = 6371000; // Radius bumi(meter)

        $coordinate = explode(',', $address);
        $lat1 = $coordinate[0];
        $lon1 = $coordinate[1];

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c;

        return $distance;
    }

    public function postRegister(Request $request)
    {
        $userOffline = User::where([
            ['name', $request->name],
            ['phone', $request->phone],
            ['email', null],
            ['password', null],
        ])->first();

        if ($userOffline) {
            $cek = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone' => 'required|numeric',
                'latitude' => 'required',
                'longitude' => 'required',
                'address' => 'required',
            ], [
                'email.unique' => 'Email sudah terpakai, mohon ganti.',
                'phone.unique' => 'Nomor HP sudah terpakai, mohon ganti.'
            ]);

            if ($userOffline->coordinate != null) {
                $distance = $this->calculateDistance($userOffline->coordinate, $cek['latitude'], $cek['longitude']);
                if ($distance > 50) {
                    return back()->with('status', 'Nomor HP sudah terpakai, mohon ganti.');
                }
            }

            $userOffline->update([
                'email' => $cek['email'],
                'password' => bcrypt($cek['password']),
                'coordinate' => $cek['latitude'] . ',' . $cek['longitude'],
                'address' => $cek['address'],
            ]);
            return redirect()->route('login')->with('status', 'Berhasil Register menggunakan akun Offline, silahkan login');
        } else {
            $cek = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone' => 'required|numeric|unique:users,phone',
                'latitude' => 'required',
                'longitude' => 'required',
                'address' => 'required',
            ], [
                'email.unique' => 'Email sudah terpakai, mohon ganti.',
                'phone.unique' => 'Nomor HP sudah terpakai, mohon ganti.'
            ]);

            User::create([
                'name' => $cek['name'],
                'email' => $cek['email'],
                'password' => bcrypt($cek['password']),
                'phone' => $cek['phone'],
                'coordinate' => $cek['latitude'] . ',' . $cek['longitude'],
                'address' => $cek['address'],
            ]);

            return redirect()->route('login')->with('status', 'Berhasil Register, silahkan login');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }



    public function user(Request $request)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->whereIn('status_pembayaran', ['Success', 'Pending', 'Settlement'])->whereNotIn('status', ['selesai', 'dibatalkan'])->paginate(10);
        return view('user/home', compact('transaksi'));
    }
    public function detailPesanan(Request $request, Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('user/detailPesanan', compact('transaksi', 'transaksiLayanan'));
    }

    public function pesananBaru(Request $request)
    {
        $layanan = Layanan::all();
        $companyProfile = CompanyProfile::first();
        return view('user/pesanan_baru', compact('layanan', 'companyProfile'));
    }

    public function assignPendingOrders()
    {
        $pendingOrders = Transaksi::whereNull('courier_id')
            ->where('pengantaran', 'ya')
            ->whereIn('status', ['menunggu pengambilan', 'menunggu pengantaran']) // pake whereIn
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($pendingOrders as $order) {
            $availableCourier = User::where('role', 'kurir')
                ->where('status', 'available')
                ->orderBy('daily_completed_orders', 'asc')
                ->first();

            if ($availableCourier) {
                $order->courier_id = $availableCourier->id;
                if ($order->status == 'menunggu pengambilan') {
                    $order->status = 'pengambilan';
                } else if ($order->status == 'menunggu pengantaran') {
                    $order->status = 'pengantaran';
                }
                $order->save();

                $availableCourier->status = 'on_delivery';
                $availableCourier->save();

                break;
            }
        }
    }

    public function midtransPayment($transaksi)
    {
        if ($transaksi->payment_token) {
            return $this->snapToken($transaksi->id);
        }

        $companyProfile = CompanyProfile::first();

        //MIDTRANS IMPLEMENTATION
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $transaction_details = array(
            'order_id' => $transaksi->id,
            'gross_amount' => $transaksi->total_harga,
        );

        $item_details = [];

        foreach ($transaksi->layanan as $layanan) {
            $item_details[] = [
                'id' => $layanan->id,
                'price' => $layanan->pivot->type_qty == 'kg' ? $layanan->harga_kg : $layanan->harga_pcs,
                'quantity' => intval($layanan->pivot->qty),
                'name' => $layanan->nama_layanan . " (" . $layanan->pivot->type_qty . ")",
            ];
        };

        $item_details[] = [
            'id' => 0,
            'price' => $transaksi->ongkir,
            'quantity' => 1,
            'name' => "Ongkir",
        ];

        $user = User::find($transaksi->user_id);

        $billing_address = array(
            'first_name'    => $user->name,
            'address'       => $user->address,
            'city'          => "Sukabumi",
            'phone'         => $user->phone,
            'country_code'  => 'IDN'
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $companyProfile->nama,
            'address'       => $companyProfile->address,
            'city'          => "Sukabumi",
            'phone'         => "0812345678",
            'country_code'  => 'IDN'
        );

        $customer_details = array(
            'first_name'    => $user->name,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        $params = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaksi->payment_token = $snapToken;
        $transaksi->save();

        return $snapToken;
    }

    // public function snapToken($transaksi)
    // {
    //     try {
    //         $transaksi2 = Transaksi::where('id', $transaksi)->first();
    //         return response()->json(['snapToken' => $transaksi2->payment_token]);
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //     }
    // }

    public function snapToken($transaksiId)
    {
        $transaksi = Transaksi::findOrFail($transaksiId);

        if ($transaksi->payment_token) {
            return response()->json(['snapToken' => $transaksi->payment_token]);
        }

        // Generate snapToken baru jika belum ada
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $companyProfile = CompanyProfile::first();
        $user = User::find($transaksi->user_id);

        $transaction_details = [
            'order_id' => $transaksi->id,
            'gross_amount' => $transaksi->total_harga,
        ];

        $item_details = [];
        foreach ($transaksi->layanan as $layanan) {
            $item_details[] = [
                'id' => $layanan->id,
                'price' => $layanan->pivot->type_qty == 'kg' ? $layanan->harga_kg : $layanan->harga_pcs,
                'quantity' => intval($layanan->pivot->qty),
                'name' => $layanan->nama_layanan . " (" . $layanan->pivot->type_qty . ")",
            ];
        }
        $item_details[] = [
            'id' => 0,
            'price' => $transaksi->ongkir,
            'quantity' => 1,
            'name' => "Ongkir",
        ];

        $customer_details = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'billing_address' => [
                'first_name' => $user->name,
                'address' => $user->address,
                'city' => "Sukabumi",
                'phone' => $user->phone,
                'country_code' => 'IDN',
            ],
            'shipping_address' => [
                'first_name' => $companyProfile->nama,
                'address' => $companyProfile->address,
                'city' => "Sukabumi",
                'phone' => "0812345678",
                'country_code' => 'IDN',
            ],
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaksi->payment_token = $snapToken;
        $transaksi->save();

        return response()->json(['snapToken' => $snapToken]);
    }

    public function postPesanan(Request $request)
    {
        $data = $request->validate([
            'payment_method' => 'required|string',
            'services' => 'required|array',
            'services.*.service_id' => 'required|exists:layanans,id',
            'services.*.quantity' => 'required|numeric|min:0.1',
            'services.*.unit' => 'required|string',
            'ongkir' => 'required',
        ]);

        $totalHarga = 0;
        $totalJumlah = 0;

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'id' => rand(1000, 1000000),
            'user_id' => auth()->id(),
            'total_harga' => 0,
            'qty' => 0,
            'subtotal' => 0,
            'ongkir' => 0,
            'status' => 'menunggu pembayaran',
            'pembayaran' => $data['payment_method'],
            'status_pembayaran' => 'Pending',
        ]);
        // Loop setiap pesanan layanan
        foreach ($data['services'] as $pesanan) {
            $layanan = Layanan::find($pesanan['service_id']);

            // Tentukan harga satuan sesuai unit
            if ($pesanan['unit'] === 'pcs') {
                $hargaSatuan = $layanan->harga_pcs;
                $type = 'pcs';
            } else {
                $hargaSatuan = $layanan->harga_kg;
                $type = 'kg';
            }

            $jumlah = $pesanan['quantity'];
            $harga = $hargaSatuan * $jumlah;

            // Tambah ke total
            $totalHarga += $harga;
            $totalJumlah++;

            // Simpan detail ke pivot table (transaksi_layanan)
            $transaksi->layanan()->attach($layanan->id, [
                'qty'   => $jumlah,
                'type_qty' => $type,
                'harga' => $harga,
            ]);
        }
        $subtotal = $totalHarga;
        $totalHarga += $data['ongkir'];
        // Update total di transaksi
        $transaksi->update([
            'subtotal'    => $subtotal,
            'ongkir'      => intval($data['ongkir']),
            'total_harga' => $totalHarga,
            'qty'         => $totalJumlah,
        ]);

        if ($data['payment_method'] == 'cod') {
            $transaksi->update(['status' => 'menunggu pengambilan']);
            $this->assignPendingOrders();
            return response()->json(['redirect' => route('user')]);
        } elseif ($data['payment_method'] == 'qris') {
            $snapToken = $this->midtransPayment($transaksi);
            return response()->json(['snapToken' => $snapToken]);
        }
    }

    public function cancelPesanan(Transaksi $transaksi)
    {
        $transaksi->update(['status' => 'dibatalkan', 'status_pembayaran' => 'Denied']);
        return redirect()->route('user')->with('status', 'Pesanan berhasil dibatalkan');
    }

    public function history(Request $request)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->where('status', 'selesai')->paginate(10);
        return view('user/history', compact('transaksi'));
    }
    public function detailRiwayat(Transaksi $transaksi)
    {
        $transaksiLayanan = TransaksiLayanan::where('transaksi_id', $transaksi->id)->with('layanan')->get();
        return view('user/detailRiwayat', compact('transaksi', 'transaksiLayanan'));
    }
    public function profile()
    {
        return view('user/profile');
    }
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // 'password' => 'required|max:255',
            'phone' => 'required|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => $request->password,
            'phone' => $request->phone,
        ]);

        $transaksi = Transaksi::where('user_id', Auth::id())->whereNotIn('status', ['selesai', 'dibatalkan'])->whereIn('status_pembayaran', ['Success', 'Pending'])->get();
        if ($transaksi) {
            return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui. Namun, alamat gagal diperbarui karena masih ada pesanan yang belum selesai.');
        } else {
            $user->update([
                'coordinate' => $request->latitude . ',' . $request->longitude,
                'address' => $request->address,
            ]);
        }

        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui.');
    }
}
