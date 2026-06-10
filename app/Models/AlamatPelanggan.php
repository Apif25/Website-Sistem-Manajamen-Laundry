<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPelanggan extends Model
{
    protected $table = 'AlamatPelanggan';
    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'id_pelanggan',
        'label_alamat',
        'province_id',
        'regency_id',
        'district_id',
        'alamat_lengkap',
        'is_utama',
    ];

    protected $casts = [
        'alamat_lengkap' => 'encrypted',
        'is_utama' => 'boolean',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id_alamat', 'id_alamat');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_alamat', 'id_alamat');
    }

    public function getFormattedAlamatAttribute()
    {
        $prov = ucwords(strtolower(\Laravolt\Indonesia\Models\Province::find($this->province_id)?->name ?? ''));
        $city = ucwords(strtolower(\Laravolt\Indonesia\Models\City::find($this->regency_id)?->name ?? ''));
        $dist = ucwords(strtolower(\Laravolt\Indonesia\Models\District::find($this->district_id)?->name ?? ''));

        return sprintf(
            '[%s] %s, Kec. %s, %s, %s',
            $this->label_alamat,
            $this->alamat_lengkap,
            $dist,
            $city,
            $prov
        );
    }
}
