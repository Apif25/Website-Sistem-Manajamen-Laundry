<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

#[Layout('frontend.layouts.app')]
#[Title('Verifikasi 2FA')]
class Verify2FA extends Component
{
    public string $otp_code = '';

    public function mount()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login');
        }

        // Jika belum mengaktifkan 2FA
        if (!$pelanggan->google2fa_enabled) {
            return redirect()->route('pelanggan.setup-2fa');
        }

        // Sudah verifikasi sesi ini
        if (session()->has('pelanggan_2fa_verified')) {
            return redirect()->route('pelanggan.beranda');
        }
    }

    public function verify()
    {
        $this->validate([
            'otp_code' => 'required|digits:6',
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi.',
            'otp_code.digits'   => 'Kode OTP harus 6 digit.',
        ]);

        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan || !$pelanggan->google2fa_secret) {
            $this->addError(
                'otp_code',
                'Akun tidak valid untuk verifikasi 2FA.'
            );

            return;
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $pelanggan->google2fa_secret,
            $this->otp_code
        );

        if (!$valid) {
            $this->otp_code = '';

            $this->addError(
                'otp_code',
                'Kode OTP tidak valid atau sudah kedaluwarsa.'
            );

            return;
        }

        session([
            'pelanggan_2fa_verified' => true,
        ]);

        return redirect()->route('pelanggan.beranda');
    }

    public function logout()
    {
        Auth::guard('pelanggan')->logout();

        session()->forget(
            'pelanggan_2fa_verified'
        );

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.frontend.form.Verify2FA');
    }
}