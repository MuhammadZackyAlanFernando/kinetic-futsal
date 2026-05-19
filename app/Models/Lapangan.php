<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $fillable = [
        'nama_lapangan',
        'deskripsi',
        'harga_per_jam',
        'gambar',
    ];

    // Relasi: Lapangan memiliki banyak transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}