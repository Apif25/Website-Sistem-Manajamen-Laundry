<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Log event secara manual.
     *
     * Contoh penggunaan:
     *   AuditLogger::log('login', 'Login Berhasil');
     *   AuditLogger::log('view', 'Melihat Data Pekerja', $pekerja);
     *   AuditLogger::log('update', 'Update Data Pelanggan', $pelanggan, $old, $new);
     */
    public static function log(
        string  $event,
        string  $eventLabel,
        ?Model  $auditable    = null,
        ?array  $oldValues    = null,
        ?array  $newValues    = null,
        string  $status       = 'success',
        ?string $description  = null,
        ?int    $userId       = null,
    ): AuditLog {
        $user = Auth::guard('pekerja')->user();

        $resolvedUserId = $userId ?? optional($user)->id_pekerja;

        $data = [
            'pekerja_id'      => $resolvedUserId,
            'nama_pekerja'    => optional($user)->nama_pekerja,
            'email'           => optional($user)->email,
            'event'           => $event,
            'event_label'     => $eventLabel,
            'auditable_type'  => $auditable ? get_class($auditable) : null,
            'auditable_id'    => $auditable?->getKey(),
            'auditable_label' => $auditable ? self::resolveLabel($auditable) : null,
            'old_values'      => $oldValues,
            'new_values'      => $newValues,
            'ip_address'      => Request::ip(),
            'user_agent'      => Request::userAgent(),
            'url'             => Request::fullUrl(),
            'method'          => Request::method(),
            'description'     => $description,
            'status'          => $status,
            'created_at'      => now(),
        ];
        return AuditLog::create($data);
    }

    // ─── Shortcut methods ────────────────────────────────────

    public static function login(string $email, bool $success = true, ?string $desc = null): AuditLog
    {
        return self::log(
            event: $success ? 'login' : 'login_failed',
            eventLabel: $success ? 'Login Berhasil' : 'Gagal Login',
            status: $success ? 'success' : 'failed',
            description: $desc ?? ($success ? null : "Percobaan login gagal untuk: {$email}"),
        );
    }

    public static function logout(): AuditLog
    {
        return self::log(event: 'logout', eventLabel: 'Logout');
    }

    public static function rateLimited(string $type = 'login'): AuditLog
    {
        $label = match ($type) {
            'access_code' => 'Rate Limit: Kode Akses',
            default       => 'Rate Limit: Login',
        };
        return self::log(event: 'rate_limited', eventLabel: $label, status: 'warning');
    }

    public static function accessCode(bool $success = true): AuditLog
    {
        return self::log(
            event: 'access_code',
            eventLabel: $success ? 'Kode Akses Benar' : 'Kode Akses Salah',
            status: $success ? 'success' : 'failed',
        );
    }

    public static function twoFactor(bool $success = true): AuditLog
    {
        return self::log(
            event: '2fa',
            eventLabel: $success ? '2FA Berhasil' : '2FA Gagal',
            status: $success ? 'success' : 'failed',
        );
    }

    public static function viewed(Model $model): AuditLog
    {
        $type  = class_basename($model);
        return self::log(
            event: 'view',
            eventLabel: "Melihat Data {$type}",
            auditable: $model,
        );
    }

    public static function created(Model $model): AuditLog
    {
        $type  = class_basename($model);
        return self::log(
            event: 'create',
            eventLabel: "Tambah Data {$type}",
            auditable: $model,
            newValues: $model->toArray(),
        );
    }

    public static function updated(Model $model, array $oldValues): AuditLog
    {
        $type = class_basename($model);
        $changed = array_intersect_key($model->toArray(), $oldValues);
        return self::log(
            event: 'update',
            eventLabel: "Update Data {$type}",
            auditable: $model,
            oldValues: $oldValues,
            newValues: $changed,
        );
    }

    public static function deleted(Model $model): AuditLog
    {
        $type = class_basename($model);
        return self::log(
            event: 'delete',
            eventLabel: "Hapus Data {$type}",
            auditable: $model,
            oldValues: $model->toArray(),
            status: 'warning',
        );
    }

    // ─── Internal ─────────────────────────────────────────────

    private static function resolveLabel(Model $model): string
    {
        // Urutan field yang umum dipakai sebagai label
        foreach (
            [
                'nama_pekerja',
                'nama_pelanggan',
                'nama_barang',
                'nama',
                'name',
                'title',
                'email',
                'username',
            ] as $field
        ) {
            if (
                isset($model->{$field}) &&
                !empty($model->{$field})
            ) {
                return (string) $model->{$field};
            }
        }

        return class_basename($model) . ' #' . $model->getKey();
    }
}
