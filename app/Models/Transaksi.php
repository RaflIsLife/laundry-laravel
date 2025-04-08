<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'total_harga', 'ongkir', 'status', 'pembayaran', 'qty', 'promo', 'kode_promo', 'cara_pemesanan', 'courier_id', 'status_pembayaran', 'subtotal', 'pengantaran', 'payment_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'transaksi_layanans')
            ->withPivot('qty', 'harga', 'type_qty')
            ->withTimestamps();
    }
}
