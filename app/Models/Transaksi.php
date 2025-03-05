<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_harga', 'ongkir', 'status', 'pembayaran', 'qty', 'cara_pemesanan', 'courier_id', 'status_pembayaran', 'subtotal', 'pengantaran'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'transaksi_layanans')
            ->withPivot('qty', 'harga')
            ->withTimestamps();
    }
}
