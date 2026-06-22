<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUniqueCodeAndUuid;

class Pembayaran extends Model
{
    use HasUniqueCodeAndUuid;

    protected bool $usesUuid = true;
    protected string $codeFieldName = 'kode_pembayaran';
    protected string $codePrefix = 'PMB';

    protected $table = 'Pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'uuid',
        'kode_pembayaran',
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

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

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
