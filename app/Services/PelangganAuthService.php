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
        Auth::guard('pelanggan')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    public function updateProfile(int $id, array $data): bool
    {
        $updateData = [
            'nama_pelanggan' => $data['nama_pelanggan'] ?? null,
            'no_telepon' => $data['no_telepon'] ?? null,
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $result = $this->pelangganRepository->update($id, $updateData);

        if (isset($data['alamat'])) {
            $pelanggan = \App\Models\Pelanggan::find($id);
            if ($pelanggan) {
                $pelanggan->alamat()->updateOrCreate(
                    ['id_pelanggan' => $id],
                    [
                        'label_alamat'   => 'Rumah',
                        'province_id'    => 12, // Default/fallback IDs
                        'regency_id'     => 181,
                        'district_id'    => 2563,
                        'alamat_lengkap' => $data['alamat'],
                        'is_utama'       => true,
                    ]
                );
            }
        }

        return $result;
    }
}
