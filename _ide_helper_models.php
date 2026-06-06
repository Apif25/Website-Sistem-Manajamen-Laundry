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
 * @property int $id
 * @property int|null $pekerja_id
 * @property string|null $nama_pekerja
 * @property string|null $email
 * @property string $event
 * @property string $event_label
 * @property string|null $auditable_type
 * @property int|null $auditable_id
 * @property string|null $auditable_label
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $url
 * @property string|null $method
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $auditable
 * @property-read string $event_icon
 * @property-read string $status_color
 * @property-read \App\Models\Pekerja|null $pekerja
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog byEvent(string $event)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog byStatus(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog byUser(int $userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog inDateRange(?string $from, ?string $to)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog search(string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAuditableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAuditableLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereAuditableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereEventLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNamaPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog wherePekerjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditLog whereUserAgent($value)
 */
	class AuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_name
 * @property string $filename
 * @property string $filepath
 * @property int|null $filesize
 * @property string $iv
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $restored_at
 * @property string|null $restored_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $filesize_human
 * @property-read \App\Models\Pekerja|null $pekerja
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereFilepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereFilesize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereIv($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereRestoredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereRestoredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupLog whereUserName($value)
 */
	class BackupLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $encryption_hash
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting whereEncryptionHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BackupSetting whereUpdatedAt($value)
 */
	class BackupSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_barang
 * @property string $nama_barang
 * @property int $jumlah_barang
 * @property string $status
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon $tanggal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereIdBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereJumlahBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventaris whereUpdatedAt($value)
 */
	class Inventaris extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_keuangan
 * @property int|null $id_pembayaran
 * @property string $tanggal
 * @property string $jenis
 * @property string $kategori
 * @property numeric $jumlah
 * @property string $keterangan
 * @property int $id_pekerja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pekerja $pekerja
 * @property-read \App\Models\Pembayaran|null $pembayaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereIdKeuangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereIdPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereIdPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Keuangan whereUpdatedAt($value)
 */
	class Keuangan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pekerja
 * @property string $email
 * @property string $password
 * @property int $must_change_password
 * @property string|null $access_code
 * @property string $nama_pekerja
 * @property string $no_telepon
 * @property string $alamat
 * @property string|null $foto
 * @property string $jenis_kelamin
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $google2fa_secret
 * @property bool $google2fa_enabled
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereGoogle2faEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereIdPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereMustChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereNamaPekerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pekerja whereNoTelepon($value)
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
 * @property string $no_telepon
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pelanggan whereUpdatedAt($value)
 */
	class Pelanggan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pembayaran
 * @property int $id_pesanan
 * @property numeric $harga_pembayaran
 * @property \Illuminate\Support\Carbon $tanggal_pembayaran
 * @property string|null $midtrans_order_id
 * @property string|null $midtrans_transaction_id
 * @property string|null $payment_type
 * @property string $status_pembayaran
 * @property string|null $qr_code_url
 * @property string|null $deeplink_url
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pesanan $pesanan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereDeeplinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereHargaPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereIdPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereIdPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereMidtransOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereMidtransTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereQrCodeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUpdatedAt($value)
 */
	class Pembayaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pemesanan
 * @property int $id_pelanggan
 * @property string $jenis_pemesanan
 * @property string $layanan_pemesanan
 * @property int $jumlah_brg
 * @property string $tanggal_pemesanan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pelanggan $pelanggan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereIdPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereIdPemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereJenisPemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereJumlahBrg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereLayananPemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereTanggalPemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pemesanan whereUpdatedAt($value)
 */
	class Pemesanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_pesanan
 * @property int $id_pemesanan
 * @property int $id_pelanggan
 * @property string $jenis_pesanan
 * @property string $layanan_pesanan
 * @property int $berat
 * @property numeric $harga
 * @property string $tanggal_pesanan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Pemesanan $pemesanan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereBerat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereIdPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereIdPemesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereIdPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereJenisPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereLayananPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereTanggalPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereUpdatedAt($value)
 */
	class Pesanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_proses
 * @property int $id_pesanan
 * @property string $proses
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pesanan $pesanan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses whereIdPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses whereIdProses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses whereProses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Proses whereUpdatedAt($value)
 */
	class Proses extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id_stock
 * @property string $nama_produk
 * @property int $stock_produk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang whereIdStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang whereNamaProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang whereStockProduk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockBarang whereUpdatedAt($value)
 */
	class StockBarang extends \Eloquent {}
}

