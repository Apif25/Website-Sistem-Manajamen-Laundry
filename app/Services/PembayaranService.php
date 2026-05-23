<?php

namespace App\Services;

use App\Models\Pesanan;
use App\Repositories\PembayaranRepository;
use App\Repositories\KeuanganRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepository $repository,
        protected KeuanganRepository $keuanganRepository
    ) {}

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
        return DB::transaction(function () use ($data) {

            $pembayaran = $this->repository->create([
                'id_pesanan'         => $data['id_pesanan'],
                'harga_pembayaran'   => $data['harga_pembayaran'],
                'tanggal_pembayaran' => $data['tanggal_pembayaran'],
            ]);

            $this->keuanganRepository->create([
                'id_pembayaran' => $pembayaran->id_pembayaran,
                'tanggal'       => $pembayaran->tanggal_pembayaran,
                'jenis'         => 'Pemasukan',
                'kategori'      => 'Cucian Biasa',
                'jumlah'        => $pembayaran->harga_pembayaran,
                'keterangan'    => 'Pembayaran pesanan #' . $pembayaran->id_pesanan,
                'id_pekerja'    => Auth::guard('pekerja')->user()->id_pekerja,
            ]);

            return $pembayaran;
        });
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
        return Pesanan::select('id_pesanan')
            ->oldest('id_pesanan')
            ->get();
    }
}
