<?php

namespace App\Livewire\Pekerja\Security;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

#[Layout('backend.layouts.app')]
class VerifyAccessCode extends Component
{
    public string $access_code = '';
    public string $redirectTo = '';

    public function mount()
    {
        $this->redirectTo = request('redirect') ?? route('pekerja.dashboard');
    }

    public function updatedAccessCode()
    {
        $this->resetErrorBag('access_code');
    }


    public function verify()
    {
        $this->validate([
            'access_code' => 'required',
        ]);

        $pekerja = auth('pekerja')->user();

        if (! $pekerja || ! $pekerja->access_code) {
            return redirect()->route('pekerja.access-code.create');
        }

        if (! Hash::check($this->access_code, $pekerja->access_code)) {
            $this->addError('access_code', 'Kode akses salah.');
            return;
        }

        session([
            'access_code_verified' => true,
            'access_code_verified_at' => now()->timestamp,
        ]);

        return redirect($this->redirectTo ?: route('pekerja.dashboard'));
    }

    public function render()
    {
        return view('livewire.pekerja.security.verify-access-code');
    }
}
