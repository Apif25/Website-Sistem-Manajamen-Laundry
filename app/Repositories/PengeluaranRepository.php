<?php

namespace App\Repositories;

use App\Models\Pengeluaran;
use Illuminate\Database\Eloquent\Collection;

class PengeluaranRepository
{
    public function __construct(protected Pengeluaran $model) {}

    public function getAll(string $search = ''): Collection
    {
        return $this->model
            ->oldest()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_pengeluaran', 'like', "%{$search}%")
                    ->orWhere('nominal_pengeluaran', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->get();
    }

    public function findById(int $id): Pengeluaran
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Pengeluaran
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Pengeluaran
    {
        $pengeluaran = $this->findById($id);
        $pengeluaran->update($data);
        return $pengeluaran;
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }
}
