<?php

namespace App\Repositories\Contracts;

use App\Models\Proses;
use Illuminate\Database\Eloquent\Collection;

interface ProsesRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?Proses;

    public function findByPesanan(int $idPesanan): ?Proses;

    public function create(array $data): Proses;

    public function update(int $id, array $data): Proses;

    public function delete(int $id): bool;

    public function advanceStep(int $id): Proses;
}
