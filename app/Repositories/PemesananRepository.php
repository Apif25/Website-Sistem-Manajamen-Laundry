<?php

namespace App\Repositories;

use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\Collection;

class PemesananRepository
{
    public function __construct(
        protected Pemesanan $model
    ) {}

    public function all(): Collection
    {
        return $this->model->with('pelanggan')->latest()->get();
    }

    public function findById(int $id_pemesanan): ?Pemesanan
    {
        return $this->model->with('pelanggan')->find($id_pemesanan);
    }

    public function create(array $data): Pemesanan
    {
        return $this->model->create($data);
    }

    public function update(int $id_pemesanan, array $data): bool
    {
        return $this->model->where('id_pemesanan', $id_pemesanan)->update($data);
    }

    public function delete(int $id_pemesanan): bool
    {
        return $this->model->where('id_pemesanan', $id_pemesanan)->delete();
    }

    public function search(string $keyword): Collection
    {
        return $this->model->with('pelanggan')
            ->whereHas('pelanggan', function ($query) use ($keyword) {
                $query->where('nama_pelanggan', 'like', '%' . $keyword . '%');
            })
            ->orWhere('jenis_pemesanan', 'like', '%' . $keyword . '%')
            ->orWhere('layanan_pemesanan', 'like', '%' . $keyword . '%')
            ->latest()
            ->get();
    }
}
