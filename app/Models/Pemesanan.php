<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    
    protected $fillable = [
        'id_pelanggan',
        'jenis_pemesanan',
        'layanan_pemesanan',
        'jumlah_brg',
        'tanggal_pemesanan',
        'status_pemesanan', // <-- Tambahkan ini
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}