<?php

namespace App\Services;

use App\Models\Proses;
use App\Repositories\Contracts\ProsesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProsesService
{
    public function __construct(
        protected ProsesRepositoryInterface $prosesRepository
    ) {}

    public function getAllProses(): Collection
    {
        return $this->prosesRepository->getAll();
    }

    public function getProsesByPesanan(int $idPesanan): ?Proses
    {
        return $this->prosesRepository->findByPesanan($idPesanan);
    }

    public function findProses(int $id): Proses
    {
        return $this->prosesRepository->findById($id);
    }

    /**
     * Buat proses baru — dijamin hanya satu proses per pesanan.
     */
    public function createProses(int $idPesanan): Proses
    {
        // Validasi tipe input
        if ($idPesanan <= 0) {
            throw new \InvalidArgumentException('ID pesanan tidak valid.');
        }

        return DB::transaction(function () use ($idPesanan) {
            // Lock row pesanan agar tidak ada race condition
            // (dua request create bersamaan untuk pesanan yang sama)
            $existing = $this->prosesRepository->findByPesanan($idPesanan);

            if ($existing) {
                throw new \InvalidArgumentException('Pesanan ini sudah memiliki proses.');
            }

            return $this->prosesRepository->create([
                'id_pesanan' => $idPesanan,
                'proses'     => 'Menunggu',
            ]);
        });
    }

    /**
     * Update proses secara manual — validasi enum ketat.
     */
    public function updateProses(int $id, string $step): Proses
    {
        // Validasi whitelist enum, bukan blacklist
        if (!in_array($step, Proses::STEPS, strict: true)) {
            throw new \InvalidArgumentException("Tahap '{$step}' tidak dikenali.");
        }

        return DB::transaction(function () use ($id, $step) {
            return $this->prosesRepository->update($id, ['proses' => $step]);
        });
    }

    /**
     * Majukan ke step berikutnya — tidak bisa dimanipulasi skip step.
     */
    public function advanceProses(int $id): Proses
    {
        return DB::transaction(function () use ($id) {
            $proses = $this->prosesRepository->findById($id);

            // Cegah advance kalau sudah Selesai
            if ($proses->isSelesai()) {
                throw new \LogicException('Proses sudah selesai.');
            }

            $nextStep = $proses->nextStep();

            // Pastikan next step ada di whitelist (double check)
            if (!in_array($nextStep, Proses::STEPS, strict: true)) {
                throw new \LogicException('Tahap berikutnya tidak valid.');
            }

            return $this->prosesRepository->update($id, ['proses' => $nextStep]);
        });
    }

    public function deleteProses(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            // Pastikan data ada sebelum hapus
            $this->prosesRepository->findById($id);
            return $this->prosesRepository->delete($id);
        });
    }
}
