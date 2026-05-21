<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'Keuangan';
    protected $primaryKey = 'id_keuangan';
    protected $fillable = [
        'id_pembayaran',
        'tanggal',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'id_pekerja',
    ];

    public function pekerja()
    {
        return $this->belongsTo(Pekerja::class, 'id_pekerja', 'id_pekerja');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }
}
