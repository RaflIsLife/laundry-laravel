<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_layanan',
        'harga_kg',
        'harga_pcs'
    ];

    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_layanan')
            ->withPivot('qty', 'harga')
            ->withTimestamps();
    }
}
