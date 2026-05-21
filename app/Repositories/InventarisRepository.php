<?php

namespace App\Repositories;

use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Collection;

class InventarisRepository
{
    public function __construct(protected Inventaris $model) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->model
            ->oldest()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->get();
    }

    public function findById(int $id): Inventaris
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Inventaris
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Inventaris
    {
        $inventaris = $this->findById($id);
        $inventaris->update($data);
        return $inventaris;
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }
}
