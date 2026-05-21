<?php

namespace App\Livewire\Pekerja\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

#[Layout('backend.layouts.auth')]
#[Title('Verifikasi 2FA')]
class Verify2FA extends Component
{
    public string $otp_code = '';

    public function mount()
    {
        $pekerja = Auth::guard('pekerja')->user();

        // belum login
        if (!$pekerja) {
            return redirect()->route('pekerja.login');
        }

        // belum aktif 2FA
        if (!$pekerja->google2fa_enabled) {
            return redirect()->route('pekerja.2fa.setup');
        }

        // sudah verified session
        if (session()->has('2fa_verified')) {
            return redirect()->route('pekerja.dashboard');
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

        $pekerja = Auth::guard('pekerja')->user();

        if (!$pekerja || !$pekerja->google2fa_secret) {
            $this->addError('otp_code', 'Akun tidak valid untuk 2FA.');
            return;
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $pekerja->google2fa_secret,
            $this->otp_code
        );

        if (!$valid) {
            $this->otp_code = '';
            $this->addError('otp_code', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
            return;
        }

        session(['2fa_verified' => true]);

        return redirect()->route('pekerja.dashboard');
    }

    public function logout()
    {
        Auth::guard('pekerja')->logout();
        session()->forget('2fa_verified');

        return redirect()->route('pekerja.login');
    }

    public function render()
    {
        return view('livewire.pekerja.auth.verify2-f-a');
    }
}
