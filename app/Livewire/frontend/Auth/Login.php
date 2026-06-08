<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

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

    // Mengatur layout file induk dan section tempat konten dirender
    #[Layout('frontend.layouts.auth')] 
    #[Title('Halaman Masuk Pelanggan')] // Mengatur variabel $title
    public function render()
    {
        return view('livewire.frontend.form.login');
    }
}