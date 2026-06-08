<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proses extends Model
{
    use HasFactory;

    protected $table = 'proses';
    protected $primaryKey = 'id_proses';
    protected $fillable = [
        'id_pesanan',
        'proses',
    ];

    /**
     * Urutan tahapan proses (untuk step progression).
     */
    const STEPS = [
        'Menunggu',
        'Penjemputan',
        'Pencucian',
        'Penyetrikaan',
        'Pengantaran',
        'Selesai',
    ];

    // ─────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // ─────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────

    /**
     * Index step saat ini (0-based).
     */
    public function currentStepIndex(): int
    {
        return array_search($this->proses, self::STEPS) ?? 0;
    }

    /**
     * Step berikutnya setelah step saat ini, atau null jika sudah Selesai.
     */
    public function nextStep(): ?string
    {
        $index = $this->currentStepIndex();
        return self::STEPS[$index + 1] ?? null;
    }

    /**
     * Apakah proses sudah selesai semua.
     */
    public function isSelesai(): bool
    {
        return $this->proses === 'Selesai';
    }

    /**
     * Semua step yang sudah dilewati (termasuk yang sekarang).
     */
    public function completedSteps(): array
    {
        $index = $this->currentStepIndex();
        return array_slice(self::STEPS, 0, $index + 1);
    }
}
