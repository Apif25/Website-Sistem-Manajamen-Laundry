<?php

namespace App\Services;

use App\Repositories\InventarisRepository;
use Illuminate\Database\Eloquent\Collection;

class InventarisService
{
    public function __construct(protected InventarisRepository $repository) {}

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
            'nama_barang'   => $data['nama_barang'],
            'jumlah_barang' => $data['jumlah_barang'],
            'status'        => $data['status'],
            'keterangan'    => $data['keterangan'],
            'tanggal'       => $data['tanggal'],
        ]);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, [
            'nama_barang'   => $data['nama_barang'],
            'jumlah_barang' => $data['jumlah_barang'],
            'status'        => $data['status'],
            'keterangan'    => $data['keterangan'],
            'tanggal'       => $data['tanggal'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }

    public function getStatusOptions(): array
    {
        return ['Aktif', 'Tidak Aktif'];
    }
}
