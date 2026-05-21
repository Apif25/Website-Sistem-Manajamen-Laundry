<?php

namespace App\Http\Controllers;

use App\Http\Requests\PekerjaRequest;
use App\Models\Pekerja;
use App\Services\PekerjaAuthService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class PekerjaController extends Controller
{
    public function __construct(
        protected PekerjaAuthService $pekerjaAuthService,
        protected RoleService $roleService
    ) {}

    // ==================== AUTH ====================

    public function showLoginForm(): View
    {
        return view('backend.pekerja.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $this->pekerjaAuthService->login(
                $request->only('email', 'password')
            );

            $request->session()->regenerate();

            /** @var Pekerja $user */
            $user = Auth::guard('pekerja')->user();

            if ($user->hasRole('admin')) {
                return redirect()->route('pekerja.dashboard');
            }

            if ($user->hasRole('manajer')) {
                return redirect()->route('manajer.dashboard');
            }

            if ($user->hasRole('kasir')) {
                return redirect()->route('kasir.dashboard');
            }

            return redirect()->route('pekerja.dashboard');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->pekerjaAuthService->logout();

        return redirect('/pekerja/auth/login');
    }

    // ==================== DASHBOARD ====================

    public function dashboard(): View
    {
        /** @var Pekerja $user */
        $user = Auth::guard('pekerja')->user();

        return view('backend.pekerja.dashboard', compact('user'));
    }

    // ==================== MANAJEMEN PEKERJA ====================

    public function index(): View
    {
        $pekerjas = $this->pekerjaAuthService->getAll();


        return view('backend.pekerja.index', compact('pekerjas'));
    }

    public function show($id)
    {

        return view('backend.pekerja.show', compact('id'));
    }

    public function create(): View
    {
        $roles = $this->roleService->getAll();

        return view('backend.pekerja.create', compact('roles'));
    }

    public function store(PekerjaRequest $request): RedirectResponse
    {
        $this->pekerjaAuthService->create($request->validated());

        return redirect()->route('pekerja.index')
            ->with('success', 'Pekerja berhasil ditambahkan.');
    }
    public function edit($id): View
    {
        $pekerja = Pekerja::findOrFail($id);
        $roles   = $this->roleService->getAll();

        return view('backend.pekerja.edit', compact('pekerja', 'roles'));
    }
    public function update(PekerjaRequest $request, $id): RedirectResponse
    {
        $this->pekerjaAuthService->updateProfile($id, $request->validated());

        return redirect()->route('pekerja.index')
            ->with('success', 'Data pekerja berhasil diperbarui.');
    }
    public function destroy($id): RedirectResponse
    {
        $this->pekerjaAuthService->delete((int) $id);

        return redirect()->route('pekerja.index')
            ->with('success', 'Pekerja berhasil dihapus.');
    }
}
