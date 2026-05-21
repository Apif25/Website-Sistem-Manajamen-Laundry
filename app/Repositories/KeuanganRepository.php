<?php

namespace App\Repositories;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Collection;

class KeuanganRepository
{
    public function __construct(protected Keuangan $model) {}
    
    public function query()
    {
        return Keuangan::query();
    }

    public function getAll(string $search = ''): Collection
    {
        return $this->model
            ->with(['pembayaran', 'pekerja'])
            ->oldest()
            ->when($search, function ($query) use ($search) {
                $query->where('jenis', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('jumlah', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            })
            ->get();
    }

    public function findById(int $id): Keuangan
    {
        return $this->model->with(['pembayaran', 'pekerja'])->findOrFail($id);
    }

    public function create(array $data): Keuangan
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Keuangan
    {
        $keuangan = $this->findById($id);
        $keuangan->update($data);
        return $keuangan;
    }

    public function delete(int $id): void
    {
        $this->findById($id)->delete();
    }
}
