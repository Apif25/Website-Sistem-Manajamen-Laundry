<?php

namespace App\Repositories;

use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Collection;

class PesananRepository
{
    public function __construct(
        protected Pesanan $model
    ) {}

    public function all(): Collection
    {
        return $this->model->with(['pemesanan', 'pelanggan'])->latest()->get();
    }

    public function findById(int $id_pesanan): ?Pesanan
    {
        return $this->model->with(['pemesanan', 'pelanggan'])->find($id_pesanan);
    }

    public function create(array $data): Pesanan
    {
        return $this->model->create($data);
    }

    public function update(int $id_pesanan, array $data): bool
    {
        return $this->model->where('id_pesanan', $id_pesanan)->update($data);
    }

    public function delete(int $id_pesanan): bool
    {
        return $this->model->where('id_pesanan', $id_pesanan)->delete();
    }

    public function search(string $keyword): Collection
    {
        return $this->model->with(['pemesanan', 'pelanggan'])
            ->whereHas('pelanggan', function ($q) use ($keyword) {
                $q->where('nama_pelanggan', 'like', '%' . $keyword . '%');
            })
            ->orWhere('Jenis_Pesanan', 'like', '%' . $keyword . '%')
            ->orWhere('Layanan_Pesanan', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();
    }
}
