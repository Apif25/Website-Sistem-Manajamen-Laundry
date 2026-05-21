<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id_pekerja
 * @property string $email
 * @property string $password
 * @property string $nama_pekerja
 * @property string $no_telp
 * @property string $alamat
 * @property string $jenis_kelamin
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereIdPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereNamaPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja withoutTeam($teams)
 */
	class Pekerja extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pelanggan
 * @property string $email
 * @property string $password
 * @property string $nama_pelanggan
 * @property string $no_telp
 * @property string $alamat
 * @property string $jenis_kelamin
 * @property string|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereIdPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
 */
	class Pelanggan extends \Eloquent {}
}

