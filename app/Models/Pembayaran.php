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

        'midtrans_order_id',
        'midtrans_transaction_id',

        'payment_type',
        'snap_token',

        'status_pembayaran',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'expired_at'         => 'datetime',
        'harga_pembayaran'   => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }
}
