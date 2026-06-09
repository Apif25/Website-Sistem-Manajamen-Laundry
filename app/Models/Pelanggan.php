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
        'alamat',
        'jenis_kelamin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'no_telepon' => 'encrypted', // FIX: Diubah dari 'no_telp' menjadi 'no_telepon' agar sinkron dengan $fillable
        'alamat' => 'encrypted',
    ];
}