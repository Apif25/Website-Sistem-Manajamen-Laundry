<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'Pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_pesanan',
        'harga_pembayaran',
        'tanggal_pembayaran',
    ];
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

}
