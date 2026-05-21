<?php

namespace App\Repositories;

use App\Models\Pekerja;
use Illuminate\Database\Eloquent\Collection;

class PekerjaRepository
{
    public function __construct(
        protected Pekerja $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Pekerja
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?Pekerja
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): Pekerja
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {

        $pekerja = $this->model->find($id);

        if (! $pekerja) {
            return false;
        }

        return $pekerja->fill($data)->save();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->where('id_pekerja', $id)->delete();
    }
}
