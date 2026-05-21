<?php

namespace App\Services;

use App\Repositories\PengeluaranRepository;
use Illuminate\Database\Eloquent\Collection;

class PengeluaranService
{
    public function __construct(protected PengeluaranRepository $repository) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->repository->getAll($search);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function store(array $data)
    {
        return $this->repository->create([
            'nama_pengeluaran'    => $data['nama_pengeluaran'],
            'nominal_pengeluaran' => $data['nominal_pengeluaran'],
            'tanggal'             => $data['tanggal'],
        ]);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, [
            'nama_pengeluaran'    => $data['nama_pengeluaran'],
            'nominal_pengeluaran' => $data['nominal_pengeluaran'],
            'tanggal'             => $data['tanggal'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }
}
