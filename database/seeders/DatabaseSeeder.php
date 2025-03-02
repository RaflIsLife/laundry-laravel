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
            'name' => 'Rafli Custom',
            'email' => 'r@fli.com',
            'phone' => '082120467500',
            'password' => bcrypt(123),
            'role' => 'customer'
         ]);
        User::create([
            'name' => 'Rafli Custom2',
            'email' => 'r@flyii.com',
            'phone' => '082120467510',
            'password' => bcrypt(123),
            'role' => 'customer'
         ]);
        User::create([
            'name' => 'Rafli Kasir',
            'email' => 'r@flu.com',
            'phone' => '082120467501',
            'password' => bcrypt(123),
            'role' => 'kasir'
         ]);
        User::create([
            'name' => 'Rafli Owner',
            'email' => 'r@fpoli.com',
            'phone' => '082120467502',
            'password' => bcrypt(123),
            'role' => 'owner'
         ]);
        User::create([
            'name' => 'Rafli Admin',
            'email' => 'r@pyli.com',
            'phone' => '082120467503',
            'password' => bcrypt(123),
            'role' => 'admin'
         ]);
        User::create([
            'name' => 'Rafli Kurir',
            'email' => 'r@vli.com',
            'phone' => '082120467504',
            'password' => bcrypt(123),
            'role' => 'kurir'
         ]);
        Layanan::create([
            'nama_layanan' => 'pakaian',
            'harga_pcs' => 1500,
            'harga_kg' => 10000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Sprei',
            'harga_pcs' => 2500,
            'harga_kg' => 20000,
         ]);
        Layanan::create([
            'nama_layanan' => 'Handuk',
            'harga_pcs' => 2000,
            'harga_kg' => 15000,
         ]);
         Transaksi::create([
            'user_id' => 1,
            'total_harga'=> 80000,
            'qty' => 2,
            'status' => 'menunggu pengambilan',
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

    }
}
