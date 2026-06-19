<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Pelanggan';

    // Menentukan primary key custom karena bukan 'id'
    protected $primaryKey = 'id_pelanggan';

    protected $fillable = [
        'nama_pelanggan', // Ini bisa bertindak sebagai username/nama
        'email',
        'password',
        'no_telepon',
        'jenis_kelamin',
        'foto_profil',
        'google_id',
        'google2fa_secret',
        'google2fa_enabled',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'no_telepon' => 'encrypted',
        'google2fa_enabled' => 'boolean',
    ];

    public function alamat()
    {
        return $this->hasMany(AlamatPelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function getAlamatAttribute()
    {
        $alamat = $this->alamat()->first();
        return $alamat ? $alamat->formatted_alamat : null;
    }
}
