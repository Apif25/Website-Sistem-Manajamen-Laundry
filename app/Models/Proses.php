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

    const STEPS = [
        'Menunggu',
        'Penjemputan',
        'Pencucian',
        'Penyetrikaan',
        'Pengantaran',
        'Selesai',
    ];

    /**
     * Otomatis update status_pemesanan menjadi 'Selesai'
     * ketika kolom 'proses' diubah menjadi 'Selesai'.
     */
    protected static function booted()
    {
        static::saved(function ($proses) {
            // Cek apakah tahapan saat ini adalah 'Selesai'
            if ($proses->proses === 'Selesai') {
                // Berjalan mundur: Proses -> Pesanan -> Pemesanan
                $pesanan = $proses->pesanan;
                
                if ($pesanan && $pesanan->pemesanan) {
                    $pesanan->pemesanan->update([
                        'status_pemesanan' => 'Selesai'
                    ]);
                }
            }
        });
    }

    // ─────────────────────────────────────────
    // Relationships & Helpers Anda yang lain tetap di sini...
    // ─────────────────────────────────────────

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function currentStepIndex(): int
    {
        return array_search($this->proses, self::STEPS) ?? 0;
    }

    public function nextStep(): ?string
    {
        $index = $this->currentStepIndex();
        return self::STEPS[$index + 1] ?? null;
    }

    public function isSelesai(): bool
    {
        return $this->proses === 'Selesai';
    }
}