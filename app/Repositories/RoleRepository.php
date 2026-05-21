<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    public function __construct(
        protected Role $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id_role): ?Role
    {
        return $this->model->find($id_role);
    }

    public function findByNama(string $nama_role): ?Role
    {
        return $this->model->where('nama_role', $nama_role)->first();
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update(int $id_role, array $data): bool
    {
        return $this->model->where('id_role', $id_role)->update($data);
    }

    public function delete(int $id_role): bool
    {
        return $this->model->where('id_role', $id_role)->delete();
    }
}
