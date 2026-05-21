<?php

namespace App\Services;

use App\Repositories\StockBarangRepository;
use Illuminate\Database\Eloquent\Collection;

class StockBarangService
{
    public function __construct(protected StockBarangRepository $repository) {}

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
            'nama_produk'  => $data['nama_produk'],
            'stock_produk' => $data['stock_produk'],
        ]);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, [
            'nama_produk'  => $data['nama_produk'],
            'stock_produk' => $data['stock_produk'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }
}
