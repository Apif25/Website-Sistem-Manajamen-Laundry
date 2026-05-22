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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
     *
     * @throws ValidationException
     */
    public function login(array $credentials, bool $remember = false): void
    {
        $key = $this->throttleKey($credentials['email']);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => [
                    "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik."
                ],
            ]);
        }

        if (! Auth::guard('pekerja')->attempt([
            'email'    => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {

            RateLimiter::hit($key, 300);

            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Login berhasil → reset rate limit
        RateLimiter::clear($key);

        // Regenerate session (anti session fixation)
        request()->session()->regenerate();
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

    /**
     * Key unik untuk rate limiting.
     */
    protected function throttleKey(string $email): string
    {
        return Str::lower($email) . '|' . request()->ip();
    }

    public function create(
        array $data,
        ?UploadedFile $foto = null,
        ?string $role = null
    ): Pekerja {
        $payload = [
            'nama_pekerja'         => $data['nama_pekerja'],
            'email'                => $data['email'],
            'password'             => Hash::make($data['password']),
            'must_change_password' => true,
            'no_telepon'           => $data['no_telepon'] ?? null,
            'alamat'               => $data['alamat'] ?? null,
            'jenis_kelamin'        => $data['jenis_kelamin'],
        ];

        // Upload foto jika ada
        if ($foto) {
            $payload['foto'] = $foto->store('pekerja/foto', 'public');
        }

        $pekerja = $this->pekerjaRepository->create($payload);

        // Assign role jika dipilih
        if (!empty($role)) {
            $pekerja->assignRole($role);
        }

        return $pekerja;
    }
    /**
     * Update data pekerja.
     */
    public function update(
        int $id,
        array $data,
        ?UploadedFile $foto = null,
        ?string $role = null
    ): bool {
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
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
            $payload['must_change_password'] = false;
        }
        // Upload foto baru
        if ($foto) {
            if ($pekerja->foto) {
                Storage::disk('public')->delete($pekerja->foto);
            }

            $payload['foto'] = $foto->store('pekerja/foto', 'public');
        }

        $result = $this->pekerjaRepository->update($id, $payload);

        // Update role
        if ($result && ! empty($role)) {
            $pekerja->syncRoles([$role]);
        }

        return $result;
    }

    /**
     * Update profile pekerja yang sedang login.
     */
    public function updateProfile(int $id, array $data): bool
    {
        $foto = isset($data['foto']) && $data['foto'] instanceof UploadedFile
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

        if ($pekerja->foto) {
            Storage::disk('public')->delete($pekerja->foto);
        }

        return $this->pekerjaRepository->delete($id);
    }
}
