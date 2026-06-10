<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    
    protected $fillable = [
        'id_pelanggan',
        'id_alamat',
        'jenis_pemesanan',
        'layanan_pemesanan',
        'jumlah_brg',
        'tanggal_pemesanan',
        'status_pemesanan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPelanggan::class, 'id_alamat', 'id_alamat');
    }

    public function pesanan()
    {
        return $this->hasOne(Pesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}