<?php

namespace App\Services;

use App\Models\Pemesanan;
use App\Repositories\PemesananRepository;
use Illuminate\Database\Eloquent\Collection;

class PemesananService
{
    public function __construct(
        protected PemesananRepository $pemesananRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->pemesananRepository->all();
    }

    public function findById(int $id): ?Pemesanan
    {
        return $this->pemesananRepository->findById($id);
    }

    public function create(array $data): Pemesanan
    {
        return $this->pemesananRepository->create([
            'id_pelanggan'      => $data['id_pelanggan'],
            'jenis_pemesanan'   => $data['jenis_pemesanan'],
            'layanan_pemesanan' => $data['layanan_pemesanan'],
            'jumlah_brg'        => $data['jumlah_brg'],
            'tanggal_pemesanan' => $data['tanggal_pemesanan'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        return $this->pemesananRepository->update($id, [
            'id_pelanggan'      => $data['id_pelanggan'],
            'jenis_pemesanan'   => $data['jenis_pemesanan'],
            'layanan_pemesanan' => $data['layanan_pemesanan'],
            'jumlah_brg'        => $data['jumlah_brg'],
            'tanggal_pemesanan' => $data['tanggal_pemesanan'],
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->pemesananRepository->delete($id);
    }

    public function search(string $keyword): Collection
    {
        return $this->pemesananRepository->search($keyword);
    }
}
