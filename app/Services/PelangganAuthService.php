<?php

namespace App\Services;

use App\Repositories\PelangganRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PelangganAuthService
{
    public function __construct(
        protected PelangganRepository $pelangganRepository
    ) {}

    /**
     * Registrasi pelanggan baru.
     */
    public function register(array $data): \App\Models\Pelanggan
    {
        return $this->pelangganRepository->create([
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'nama_pelanggan' => $data['nama_pelanggan'],
            'no_telepon'  => $data['no_telepon'] ?? null,
            'alamat'      => $data['alamat'] ?? null,
        ]);
    }

    /**
     * Login pelanggan menggunakan guard 'pelanggan'.
     *
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false): void
    {
        if (! Auth::guard('pelanggan')->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }
    }

    /**
     * Logout pelanggan.
     */
    public function logout(): void
    {
        Auth::guard('Pelanggan')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Update profil pelanggan.
     */
    public function updateProfile(int $id, array $data): bool
    {
        $updateData = [
            'nama_pelanggan' => $data['nama_pelanggan'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
            'alamat'     => $data['alamat'] ?? null,
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        return $this->pelangganRepository->update($id, $updateData);
    }
}
