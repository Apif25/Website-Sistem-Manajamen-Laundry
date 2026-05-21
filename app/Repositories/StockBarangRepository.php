<?php

namespace App\Repositories;

use App\Models\StockBarang;
use Illuminate\Database\Eloquent\Collection;

class StockBarangRepository
{
    public function __construct(protected StockBarang $model) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->model
            ->oldest()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_produk', 'like', "%{$search}%")
                    ->orWhere('stock_produk', 'like', "%{$search}%");
            })
            ->get();
    }

    public function findById(int $id): StockBarang
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): StockBarang
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): StockBarang
    {
        $stock = $this->findById($id);
        $stock->update($data);
        return $stock;
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }
}
