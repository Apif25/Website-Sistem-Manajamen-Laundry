<?php

namespace App\Repositories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Collection;

class PelangganRepository
{
    public function __construct(
        protected Pelanggan $model
    ) {}

    public function findByEmail(string $email): ?Pelanggan
    {
        return $this->model->where('email', $email)->first();
    }

    public function findById(int $id_pelanggan): ?Pelanggan
    {
        return $this->model->find($id_pelanggan);
    }

    public function create(array $data): Pelanggan
    {
        return $this->model->create($data);
    }

    public function update(int $id_pelanggan, array $data): bool
    {
        return $this->model->where('id', $id_pelanggan)->update($data);
    }

    public function delete(int $id_pelanggan): bool
    {
        return $this->model->where('id_pelanggan', $id_pelanggan)->delete();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}