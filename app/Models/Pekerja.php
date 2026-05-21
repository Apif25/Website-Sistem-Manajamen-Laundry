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
        'no_telepon',
        'alamat',
        'jenis_kelamin',
        'foto',
        'google2fa_secret',
        'google2fa_enabled'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    protected $casts = [
        'password'          => 'hashed',
        'no_telepon'        => 'encrypted',
        'alamat'            => 'encrypted',
        'email_verified_at' => 'datetime',
        'google2fa_enabled' => 'boolean'
    ];
}
