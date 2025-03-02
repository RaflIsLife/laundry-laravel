<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\TransaksiLayanan;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Custom',
            'email' => 'user@gmail.com',
            'phone' => '082120467500',
            'address' => 'Jl. Jalan',
            'password' => bcrypt(123),
            'role' => 'customer'
         ]);
        User::create([
            'name' => 'Custom2',
            'email' => 'user2@gmail.com',
            'phone' => '082120467510',
            'address' => 'Jl. Jalan',
            'password' => bcrypt(123),
            'role' => 'customer'
         ]);
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'phone' => '082120467501',
            'password' => bcrypt(123),
            'role' => 'kasir'
         ]);
        User::create([
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'phone' => '082120467502',
            'password' => bcrypt(123),
            'role' => 'owner'
         ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '082120467503',
            'password' => bcrypt(123),
            'role' => 'admin'
         ]);
        User::create([
            'name' => 'Kurir',
            'email' => 'kurir@gmail.com',
            'phone' => '082120467504',
            'password' => bcrypt(123),
            'role' => 'kurir'
         ]);
        User::create([
            'name' => 'Kurir2',
            'email' => 'kurir2@gmail.com',
            'phone' => '082120467505',
            'password' => bcrypt(123),
            'role' => 'kurir'
         ]);
        Layanan::create([
            'nama_layanan' => 'Pakaian',
            'harga_pcs' => 1500,
            'harga_kg' => 10000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Sprei',
            'harga_pcs' => 9200,
            'harga_kg' => 20000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Handuk',
            'harga_pcs' => 2000,
            'harga_kg' => 15000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Selimut',
            'harga_pcs' => 13200,
            'harga_kg' => 30000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Bantal',
            'harga_pcs' => 10500,
            'harga_kg' => 27000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Boneka',
            'harga_pcs' => 7000,
            'harga_kg' => 21000,
         ]);
         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 80000,
            'qty' => 2,
            'status' => 'menunggu pengantaran',
            'pembayaran'=>'cod',
            'status_pembayaran'=>'lunas'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 1,
            'layanan_id' => 1,
            'harga'=> 20000,
            'qty' => 2,
            'type_qty' => 'kg'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 1,
            'layanan_id' => 2,
            'harga'=> 60000,
            'qty' =>3,
            'type_qty' => 'pcs'
         ]);




         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 80000,
            'qty' => 2,
            'status' => 'selesai',
            'pembayaran'=>'cod',
            'status_pembayaran'=>'lunas'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 2,
            'layanan_id' => 1,
            'harga'=> 20000,
            'qty' => 2,
            'type_qty' => 'kg'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 2,
            'layanan_id' => 2,
            'harga'=> 60000,
            'qty' =>3,
            'type_qty' => 'pcs'
         ]);



         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 85000,
            'qty' => 2,
            'status' => 'menunggu pengambilan',
            'pembayaran'=>'cod',
            'status_pembayaran'=>'proses'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 3,
            'layanan_id' => 1,
            'harga'=> 25000,
            'qty' => 2,
            'type_qty' => 'kg'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 3,
            'layanan_id' => 2,
            'harga'=> 60000,
            'qty' =>3,
            'type_qty' => 'pcs'
         ]);



         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 80000,
            'qty' => 2,
            'status' => 'proses laundry',
            'pembayaran'=>'qris',
            'status_pembayaran'=>'lunas'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 4,
            'layanan_id' => 1,
            'harga'=> 20000,
            'qty' => 2,
            'type_qty' => 'kg'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 4,
            'layanan_id' => 2,
            'harga'=> 60000,
            'qty' =>3,
            'type_qty' => 'pcs'
         ]);



         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 80000,
            'qty' => 2,
            'status' => 'selesai',
            'pembayaran'=>'qris',
            'status_pembayaran'=>'lunas'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 5,
            'layanan_id' => 1,
            'harga'=> 20000,
            'qty' => 2,
            'type_qty' => 'kg'
         ]);
         TransaksiLayanan::create([
            'transaksi_id' => 5,
            'layanan_id' => 2,
            'harga'=> 60000,
            'qty' =>3,
            'type_qty' => 'pcs'
         ]);




    }
}
