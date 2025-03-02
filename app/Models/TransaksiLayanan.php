<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiLayanan extends Model
{
    use HasFactory;

    Protected $table = 'transaksi_layanans';
    Protected $fillable = ['transaksi_id', 'layanan_id', 'qty', 'type_qty', 'harga'];

    public function layanan()
{
    return $this->belongsTo(Layanan::class, 'layanan_id');
}


}
