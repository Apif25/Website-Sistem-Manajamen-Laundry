<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pekerja;
use App\Repositories\KeuanganRepository;
use Illuminate\Database\Eloquent\Collection;

class KeuanganService
{
    public function __construct(protected KeuanganRepository $repository) {}

    public function query()
    {
        return $this->repository->query();
    }

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
            'id_pembayaran' => $data['id_pembayaran'] ?: null,
            'tanggal'       => $data['tanggal'],
            'jenis'         => $data['jenis'],
            'kategori'      => $data['kategori'],
            'jumlah'        => $data['jumlah'],
            'keterangan'    => $data['keterangan'],
            'id_pekerja'    => $data['id_pekerja'],
        ]);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, [
            'id_pembayaran' => $data['id_pembayaran'] ?: null,
            'tanggal'       => $data['tanggal'],
            'jenis'         => $data['jenis'],
            'kategori'      => $data['kategori'],
            'jumlah'        => $data['jumlah'],
            'keterangan'    => $data['keterangan'],
            'id_pekerja'    => $data['id_pekerja'],
        ]);
    }

    public function destroy(int $id): void
    {
        $this->repository->delete($id);
    }

    public function getAllPembayaran(): Collection
    {
        return Pembayaran::select('id_pembayaran')
            ->oldest('id_pembayaran')
            ->get();
    }

    public function getAllPekerja(): Collection
    {
        return Pekerja::select('id_pekerja', 'nama_pekerja')
            ->oldest('nama_pekerja')
            ->get();
    }

    public function getJenisOptions(): array
    {
        return ['Pemasukan', 'Pengeluaran'];
    }

    public function getKategoriOptions(): array
    {
        return [
            'Cucian Cepat',
            'Cucian Biasa',
            'Perbaikan',
            'Gaji',
            'Listrik',
            'Air',
            'Lingkungan'
        ];
    }
}
