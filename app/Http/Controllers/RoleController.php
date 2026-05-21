<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {}

    public function index(): View
    {
        $roles = $this->roleService->getAll();

        return view('pekerja.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('pekerja.roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->roleService->create(
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );

        return redirect()->route('pekerja.roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role): View
    {
        return view('pekerja.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $this->roleService->update(
            $role->id,
            $request->validate([
                'name' => 'required|string|max:255',
            ])
        );

        return redirect()->route('pekerja.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->roleService->delete($role->id);

        return redirect()->route('pekerja.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
