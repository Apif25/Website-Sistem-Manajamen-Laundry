<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('pelanggan')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {

            session()->regenerate();

            // tutup modal
            $this->dispatch('login-success');

            return redirect()->intended('/pelanggan');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.frontend.form.login');
    }
}