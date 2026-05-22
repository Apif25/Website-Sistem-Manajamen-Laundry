<?php

namespace App\Livewire\Pekerja\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('backend.layouts.auth')]
#[Title('Ganti Password Pertama')]
class FirstPassword extends Component
{
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        $pekerja = Auth::guard('pekerja')->user();

        if (!$pekerja) {
            return redirect()->route('pekerja.login');
        }

        // Kalau sudah pernah ganti password, jangan masuk sini lagi
        if (!$pekerja->must_change_password) {
            return redirect()->route('pekerja.dashboard');
        }
    }

    public function save()
    {
        $this->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $pekerja = Auth::guard('pekerja')->user();

        $pekerja->update([
            'password' => Hash::make($this->password),
            'must_change_password' => false,
        ]);

        session()->flash(
            'success',
            'Password berhasil diperbarui. Silakan lanjut menggunakan aplikasi.'
        );

        return redirect()->route('pekerja.dashboard');
    }

    public function render()
    {
        return view('livewire.pekerja.auth.first-password');
    }
}
