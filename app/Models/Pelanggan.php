<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'Pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $fillable = [
        'email',
        'password',
        'nama_pelanggan',
        'no_telepon',
        'alamat',
        'jenis_kelamin',

    ];

    protected $hidden = [
        'password',
        'remember_token',

    ];

    protected $casts = [
        'password' => 'hashed',
        'no_telp' => 'encrypted',
        'alamat' => 'encrypted',
    ];
}
