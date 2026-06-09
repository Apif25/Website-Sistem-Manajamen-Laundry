<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;


#[Layout('frontend.layouts.auth')] 
#[Title('Halaman Pendaftaran Pelanggan')]
class Register extends Component
{
    // Properti untuk menampung input
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $otp;
    public $terms = false;

    // Aturan validasi
    protected $rules = [
        'username' => 'required|min:3|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'otp' => 'required|digits:6',
        'terms' => 'accepted',
    ];

    public function sendOtp()
    {
        $this->validateOnly('email');
        // Logika kirim OTP (contoh: simpan ke session/database & kirim email)
        session()->flash('message', 'Kode OTP telah dikirim ke email ' . $this->email);
    }

    public function register()
    {
        $this->validate();

        // Logika simpan user
        Pelanggan::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }

    public function render()
    {
        // Menggunakan layout utama (layouts.app)
        return view('livewire.frontend.form.register');
    }
}