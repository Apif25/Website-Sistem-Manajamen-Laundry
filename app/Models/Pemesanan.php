<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUniqueCodeAndUuid;

class Pemesanan extends Model
{
    use HasUniqueCodeAndUuid;

    protected bool $usesUuid = true;
    protected string $codeFieldName = 'kode_pemesanan';
    protected string $codePrefix = 'PMS';

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    
    protected $fillable = [
        'uuid',
        'kode_pemesanan',
        'id_pelanggan',
        'id_alamat',
        'jenis_pemesanan',
        'layanan_pemesanan',
        'jumlah_brg',
        'tanggal_pemesanan',
        'status_pemesanan',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getCodePrefix(): ?string
    {
        if (strtolower($this->layanan_pemesanan) === 'kilat') {
            return 'KLT';
        }

        return 'REG';
    }

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