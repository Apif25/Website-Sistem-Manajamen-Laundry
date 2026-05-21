<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll(): Collection
    {
        return Role::where('guard_name', 'pekerja')->get();
    }

    public function findById(int $id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        $existing = Role::where('name', $data['name'])
            ->where('guard_name', 'pekerja')
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'name' => ['Role sudah ada.'],
            ]);
        }

        return Role::create([
            'name' => $data['name'],
            'guard_name' => 'pekerja',
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $role = Role::findOrFail($id);

        $existing = Role::where('name', $data['name'])
            ->where('guard_name', 'pekerja')
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            throw ValidationException::withMessages([
                'name' => ['Role sudah digunakan.'],
            ]);
        }

        return $role->update([
            'name' => $data['name'],
        ]);
    }

    public function delete(int $id): bool
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }
}
