<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    Protected $fillable = ['user_id', 'total_harga', 'status', 'pembayaran', 'qty', 'cara_pemesanan'];

    Public function user()
    {
        Return $this->belongsTo(User::class);
    }

    Public function layanan()
    {
        Return $this->belongsToMany(Layanan::class, 'transaksi_layanans')
                    ->withPivot('qty', 'harga')
                    ->withTimestamps();
    }

}
