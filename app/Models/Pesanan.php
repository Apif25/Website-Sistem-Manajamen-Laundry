<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUniqueCodeAndUuid;

class Pesanan extends Model
{
    use HasUniqueCodeAndUuid;

    protected bool $usesUuid = true;
    protected string $codeFieldName = 'kode_pesanan';
    protected string $codePrefix = 'PES';

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'uuid',
        'kode_pesanan',
        'id_pemesanan',
        'id_pelanggan',
        'id_alamat',
        'jenis_pesanan',
        'layanan_pesanan',
        'berat',
        'harga',
        'tanggal_pesanan',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPelanggan::class, 'id_alamat', 'id_alamat');
    }

    public function proses()
    {
        return $this->hasOne(Proses::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }
}
