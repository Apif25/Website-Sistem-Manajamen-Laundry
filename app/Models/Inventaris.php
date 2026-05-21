<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'Inventaris';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'jumlah_barang',
        'status',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
