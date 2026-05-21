<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Pekerja extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'Pekerja';
    protected $primaryKey = 'id_pekerja';
    protected $guard_name = 'pekerja';

    protected $fillable = [
        'email',
        'password',
        'nama_pekerja',
        'no_telepon',   // fix: konsisten pakai no_telepon
        'alamat',
        'jenis_kelamin',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password'          => 'hashed',
        'no_telepon'        => 'encrypted',  
        'alamat'            => 'encrypted',
        'email_verified_at' => 'datetime',
    ];
}
