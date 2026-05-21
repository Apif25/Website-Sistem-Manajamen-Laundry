<?php

namespace App\Repositories;

use App\Models\Proses;
use App\Repositories\Contracts\ProsesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProsesRepository implements ProsesRepositoryInterface
{
    // Jangan inject model di constructor, langsung pakai Model static
    public function getAll(): Collection
    {
        return Proses::with('pesanan')->latest()->get();
    }

    public function findById(int $id): Proses
    {
        return Proses::with('pesanan')->findOrFail($id);
    }

    public function findByPesanan(int $idPesanan): ?Proses
    {
        return Proses::with('pesanan')
            ->where('id_pesanan', $idPesanan)
            ->first();
    }

    public function create(array $data): Proses
    {
        return Proses::create($data);
    }

    public function update(int $id, array $data): Proses
    {
        $proses = $this->findById($id);
        $proses->update($data);
        return $proses->fresh('pesanan');
    }

    public function delete(int $id): bool
    {
        $proses = $this->findById($id);
        return $proses->delete();
    }

    public function advanceStep(int $id): Proses
    {
        $proses = $this->findById($id);

        if ($proses->isSelesai()) {
            throw new \LogicException('Proses sudah selesai, tidak bisa dilanjutkan.');
        }

        $next = $proses->nextStep();
        $proses->update(['proses' => $next]);

        return $proses->fresh('pesanan');
    }
}
