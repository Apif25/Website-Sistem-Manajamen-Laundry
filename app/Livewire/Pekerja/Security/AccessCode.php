<?php

namespace App\Livewire\Pekerja\Security;


use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;


#[Layout('backend.layouts.app')]
class AccessCode extends Component
{
    public string $access_code = '';
    public string $access_code_confirmation = '';

    public string $redirectTo = '';

    public function mount()
    {
        $this->redirectTo = request('redirect') ?? route('pekerja.dashboard');
    }

    public function save()
    {
        $this->validate([
            'access_code' => [
                'required',
                'digits:6',
            ],
            'access_code_confirmation' => [
                'required',
                'same:access_code',
            ],
        ]);

        $user = Auth::user();

        $user->update([
            'access_code' => Hash::make($this->access_code),
        ]);

        session([
            'access_code_verified' => true,
            'access_code_verified_at' => now()->timestamp,
        ]);

        return redirect($this->redirectTo ?: '/dashboard');
    }

    public function render()
    {
        return view('livewire.pekerja.security.access-code');
    }
}
