<?php

namespace App\Services;

use App\Models\Pekerja;
use App\Repositories\PekerjaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PekerjaAuthService
{
    public function __construct(
        protected PekerjaRepository $pekerjaRepository
    ) {}

    // -------------------------
    // READ
    // -------------------------

    public function getAll(): Collection
    {
        return $this->pekerjaRepository->all();
    }

    public function findById(int $id): ?Pekerja
    {
        return $this->pekerjaRepository->findById($id);
    }

    // -------------------------
    // AUTH
    // -------------------------

    /**
     * Login pekerja menggunakan guard 'pekerja'.
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false): void
    {
        if (! Auth::guard('pekerja')->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }
    }

    /**
     * Logout pekerja.
     */
    public function logout(): void
    {
        Auth::guard('pekerja')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    // -------------------------
    // CRUD
    // -------------------------

    /**
     * Buat akun pekerja baru (hanya bisa dilakukan admin).
     */
    public function create(array $data, ?UploadedFile $foto = null): Pekerja
    {
        $payload = [
            'nama_pekerja'  => $data['nama_pekerja'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'no_telepon'    => $data['no_telepon'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'],
        ];

        if ($foto) {
            $payload['foto'] = $foto->store('pekerja/foto', 'public');
        }

        return $this->pekerjaRepository->create($payload);
    }

    /**
     * Update data pekerja.
     */
    public function update(int $id, array $data, ?UploadedFile $foto = null): bool
    {
        $pekerja = $this->pekerjaRepository->findById($id);

        if (! $pekerja) {
            return false;
        }

        $payload = [
            'nama_pekerja'  => $data['nama_pekerja'],
            'email'         => $data['email'],
            'no_telepon'    => $data['no_telepon'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'],
        ];

        // Update password hanya jika diisi
        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        // Upload foto baru & hapus foto lama
        if ($foto) {
            if ($pekerja->foto) {
                Storage::disk('public')->delete($pekerja->foto);
            }
            $payload['foto'] = $foto->store('pekerja/foto', 'public');
        }

        return $this->pekerjaRepository->update($id, $payload);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $foto = isset($data['foto']) && $data['foto'] instanceof \Illuminate\Http\UploadedFile
            ? $data['foto']
            : null;

        return $this->update($id, $data, $foto);
    }

    /**
     * Hapus pekerja beserta fotonya.
     */
    public function delete(int $id): bool
    {
        $pekerja = $this->pekerjaRepository->findById($id);

        if (! $pekerja) {
            return false;
        }

        // Hapus foto dari storage jika ada
        if ($pekerja->foto) {
            Storage::disk('public')->delete($pekerja->foto);
        }

        return $this->pekerjaRepository->delete($id);
    }
}
