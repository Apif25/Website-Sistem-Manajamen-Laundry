<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Repositories\PembayaranRepository;
use Illuminate\Database\Eloquent\Collection;

class PembayaranService
{
    public function __construct(protected PembayaranRepository $repository) {}

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
            'id_pesanan'         => $data['id_pesanan'],
            'harga_pembayaran'   => $data['harga_pembayaran'],
            'tanggal_pembayaran' => $data['tanggal_pembayaran'],
        ]);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, [
            'id_pesanan'         => $data['id_pesanan'],
            'harga_pembayaran'   => $data['harga_pembayaran'],
            'tanggal_pembayaran' => $data['tanggal_pembayaran'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }
    

    public function getAllPesanan(): Collection
    {
        return Pesanan::select('id_pesanan')->oldest('id_pesanan')->get();
    }
}
