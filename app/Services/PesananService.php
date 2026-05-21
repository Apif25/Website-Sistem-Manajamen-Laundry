<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Repositories\PesananRepository;
use Illuminate\Database\Eloquent\Collection;

class PesananService
{
    public function __construct(
        protected PesananRepository $pesananRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->pesananRepository->all();
    }

    public function findById(int $id): ?Pesanan
    {
        return $this->pesananRepository->findById($id);
    }

    public function create(array $data): Pesanan
    {
        return $this->pesananRepository->create([
            'id_pemesanan'    => $data['id_pemesanan'],
            'id_pelanggan'    => $data['id_pelanggan'],
            'jenis_pesanan'   => $data['jenis_pesanan'],
            'layanan_pesanan' => $data['layanan_pesanan'],
            'berat'           => $data['berat'],
            'harga'           => $data['harga'],
            'tanggal_pesanan' => $data['tanggal_pesanan'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        return $this->pesananRepository->update($id, [
            'id_pemesanan'    => $data['id_pemesanan'],
            'id_pelanggan'    => $data['id_pelanggan'],
            'jenis_pesanan'   => $data['jenis_pesanan'],
            'layanan_pesanan' => $data['layanan_pesanan'],
            'berat'           => $data['berat'],
            'harga'           => $data['harga'],
            'tanggal_pesanan' => $data['tanggal_pesanan'],
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->pesananRepository->delete($id);
    }

    public function search(string $keyword): Collection
    {
        return $this->pesananRepository->search($keyword);
    }
}
