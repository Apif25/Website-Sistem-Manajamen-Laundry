<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AccessCodeService
{
    /**
     * Maksimal percobaan.
     */
    protected int $maxAttempts = 3;

    /**
     * Durasi penyimpanan percobaan (detik).
     */
    protected int $decaySeconds = 600; // 10 menit

    /**
     * Generate key rate limiter.
     */
    protected function key($pekerja): string
    {
        return 'access-code:' . $pekerja->id . '|' . request()->ip();
    }

    /**
     * Verifikasi kode akses.
     */
    public function verify($pekerja, string $accessCode): bool
    {
        return Hash::check($accessCode, $pekerja->access_code);
    }

    /**
     * Tambah percobaan gagal.
     */
    public function hitAttempt($pekerja): void
    {
        RateLimiter::hit(
            $this->key($pekerja),
            $this->decaySeconds
        );
    }

    /**
     * Hapus percobaan gagal.
     */
    public function clearAttempts($pekerja): void
    {
        RateLimiter::clear(
            $this->key($pekerja)
        );
    }

    /**
     * Cek apakah melebihi batas percobaan.
     */
    public function tooManyAttempts($pekerja): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->key($pekerja),
            $this->maxAttempts
        );
    }

    /**
     * Jumlah percobaan saat ini.
     */
    public function attempts($pekerja): int
    {
        return RateLimiter::attempts(
            $this->key($pekerja)
        );
    }

    /**
     * Sisa percobaan.
     */
    public function remainingAttempts($pekerja): int
    {
        return max(
            0,
            $this->maxAttempts - $this->attempts($pekerja)
        );
    }

    /**
     * Logout paksa.
     */
    public function logout(): void
    {
        Auth::guard('pekerja')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Simpan status verifikasi berhasil.
     */
    public function markVerified(): void
    {
        session([
            'access_code_verified' => true,
            'access_code_verified_at' => now()->timestamp,
        ]);
    }
}
