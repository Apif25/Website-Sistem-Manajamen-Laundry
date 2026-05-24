<?php

namespace App\Traits;

use App\Support\AuditLogger;

/**
 * Pasang trait ini pada model yang ingin di-audit otomatis.
 *
 * Contoh penggunaan pada model Pekerja / Pelanggan:
 *
 *   use App\Traits\LogsActivity;
 *
 *   class Pekerja extends Model {
 *       use LogsActivity;
 *
 *       // (opsional) field sensitif yang disembunyikan dari log
 *       protected array $auditHidden = ['password', 'pin'];
 *   }
 */
trait LogsActivity
{
    /**
     * Field yang tidak akan masuk ke old_values / new_values.
     * Bisa di-override di masing-masing model.
     */
    protected array $auditHidden = ['password', 'remember_token', 'pin', 'access_code'];

    /**
     * Simpan snapshot old values di sini — pakai static array
     * agar TIDAK menjadi Eloquent attribute dan tidak ikut di-save ke DB.
     *
     * Key: spl_object_id($model), Value: array original attributes
     */
    private static array $auditSnapshots = [];

    public static function bootLogsActivity(): void
    {
        // CREATE
        static::created(function ($model) {
            AuditLogger::log(
                event: 'create',
                eventLabel: 'Tambah Data ' . class_basename($model),
                auditable: $model,
                newValues: $model->getAuditableAttributes(),
            );
        });

        // UPDATE — simpan snapshot SEBELUM save, di static array (bukan model attribute)
        static::updating(function ($model) {
            self::$auditSnapshots[spl_object_id($model)] = $model->getOriginal();
        });

        static::updated(function ($model) {
            $snapshot = self::$auditSnapshots[spl_object_id($model)] ?? [];

            // Bersihkan snapshot setelah dipakai
            unset(self::$auditSnapshots[spl_object_id($model)]);

            $old = collect($snapshot)
                ->only(array_keys($model->getDirty()))
                ->except($model->auditHidden)
                ->toArray();

            $new = collect($model->getDirty())
                ->except($model->auditHidden)
                ->toArray();

            // Tidak ada perubahan yang perlu di-log, skip
            if (empty($new)) return;

            AuditLogger::log(
                event: 'update',
                eventLabel: 'Update Data ' . class_basename($model),
                auditable: $model,
                oldValues: $old,
                newValues: $new,
            );
        });

        // DELETE
        static::deleted(function ($model) {
            AuditLogger::log(
                event: 'delete',
                eventLabel: 'Hapus Data ' . class_basename($model),
                auditable: $model,
                oldValues: $model->getAuditableAttributes(),
                status: 'warning',
            );
        });
    }

    /**
     * Ambil semua atribut model tanpa field sensitif.
     */
    public function getAuditableAttributes(): array
    {
        return collect($this->toArray())
            ->except($this->auditHidden)
            ->toArray();
    }
}
