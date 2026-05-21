<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelangganRequest;
use App\Models\Pelanggan;
use App\Services\PelangganAuthService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function __construct(
        protected PelangganAuthService $pelangganAuthService,
        protected RoleService $roleService
    ) {}

    public function index(): View
    {
        $pelanggan = Pelanggan::all();

        return view('auth.pelanggan.login', compact('pelanggan'));
    }

    public function show(Pelanggan $pelanggan): View
    {
        return view('auth.pelanggan.show', compact('pelanggan'));
    }

    public function create(): View
    {
        $roles = $this->roleService->getAll();

        return view('pekerja.pelanggan.create', compact('roles'));
    }

    public function store(PelangganRequest $request): RedirectResponse
    {
        $this->pelangganAuthService->register($request->validated());

        return redirect()->route('pekerja.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan): View
    {
        $roles = $this->roleService->getAll();

        return view('pekerja.pelanggan.edit', compact('pelanggan', 'roles'));
    }

    public function update(PelangganRequest $request, Pelanggan $pelanggan): RedirectResponse
    {
        $this->pelangganAuthService->updateProfile($pelanggan->id, $request->validated());

        return redirect()->route('pekerja.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan): RedirectResponse
    {
        $pelanggan->delete();

        return redirect()->route('pekerja.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
