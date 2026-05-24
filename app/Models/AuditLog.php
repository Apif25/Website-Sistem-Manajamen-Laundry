<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'pekerja_id',
        'nama_pekerja',
        'email',
        'event',
        'event_label',
        'auditable_type',
        'auditable_id',
        'auditable_label',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'description',
        'status',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    // ─── Relasi ──────────────────────────────────────────────

    public function pekerja(): BelongsTo
    {
        return $this->belongsTo(
            Pekerja::class,
            'pekerja_id',
            'id_pekerja'
        );
    }
    public function auditable()
    {
        return $this->morphTo();
    }

    // ─── Scopes ──────────────────────────────────────────────

    public function scopeByEvent(Builder $q, string $event): Builder
    {
        return $q->where('event', $event);
    }

    public function scopeByStatus(Builder $q, string $status): Builder
    {
        return $q->where('status', $status);
    }

    public function scopeByUser(Builder $q, int $userId): Builder
    {
        return $q->where('pekerja_id', $userId);
    }

    public function scopeSearch(Builder $q, string $keyword): Builder
    {
        return $q->where(function ($sub) use ($keyword) {
            $sub->where('nama_pekerja', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('event_label', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orWhere('ip_address', 'like', "%{$keyword}%")
                ->orWhere('auditable_label', 'like', "%{$keyword}%");
        });
    }

    public function scopeInDateRange(Builder $q, ?string $from, ?string $to): Builder
    {
        if ($from) $q->whereDate('created_at', '>=', $from);
        if ($to)   $q->whereDate('created_at', '<=', $to);
        return $q;
    }

    // ─── Helpers ─────────────────────────────────────────────

    /** Badge color untuk status */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'failed'  => '#c0513f',
            'warning' => '#c49a3c',
            default   => '#639922',
        };
    }

    /** Icon per event */
    public function getEventIconAttribute(): string
    {
        return match ($this->event) {
            'login'         => '🔓',
            'logout'        => '🔒',
            'login_failed'  => '🚫',
            'rate_limited'  => '⛔',
            'view'          => '👁️',
            'create'        => '✅',
            'update'        => '✏️',
            'delete'        => '🗑️',
            'access_code'   => '🔑',
            '2fa'           => '📱',
            default         => '📋',
        };
    }

    /** Grup event untuk filter */
    public static function eventGroups(): array
    {
        return [
            'Autentikasi'  => ['login', 'logout', 'login_failed', 'rate_limited', 'access_code', '2fa'],
            'Data Pekerja' => ['view_pekerja', 'create_pekerja', 'update_pekerja', 'delete_pekerja'],
            'Data Pelanggan' => ['view_pelanggan', 'create_pelanggan', 'update_pelanggan', 'delete_pelanggan'],
            'Data Umum'    => ['view', 'create', 'update', 'delete'],
        ];
    }
}
