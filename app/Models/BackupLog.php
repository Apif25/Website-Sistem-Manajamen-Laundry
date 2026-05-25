<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupLog extends Model
{
    protected $fillable = [
        'pekerja_id',
        'nama_pekerja',
        'filename',
        'filepath',
        'filesize',
        'iv',
        'status',
        'notes',
        'restored_at',
        'restored_by',
    ];

    protected $casts = [
        'restored_at' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function pekerja(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Pekerja::class, 'pekerja_id', 'id_pekerja');
    }

    /** Ukuran file dalam format human-readable */
    public function getFilesizeHumanAttribute(): string
    {
        if (! $this->filesize) return '—';
        $units = ['B', 'KB', 'MB', 'GB'];
        $size  = $this->filesize;
        $i     = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    /** Apakah file fisiknya masih ada */
    public function fileExists(): bool
    {
        return \Illuminate\Support\Facades\Storage::exists($this->filepath);
    }
}
