<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'lapangan_id',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'status',
        'bukti_pembayaran',
        'nama_rekening',
        'nomor_rekening',
    ];
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relasi ke Lapangan
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
}