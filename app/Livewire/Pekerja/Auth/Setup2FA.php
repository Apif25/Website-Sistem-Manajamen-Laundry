<?php

namespace App\Livewire\Pekerja\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Livewire\Attributes\Title;


#[Layout('backend.layouts.auth')]
#[Title('Login Pekerja')]
class Setup2FA extends Component
{
    public string $secret = '';
    public string $qrCodeUrl = '';
    public string $otp_code = '';

    public function mount()
    {
        $pekerja = Auth::guard('pekerja')->user();

        if (!$pekerja) {
            return redirect()->route('pekerja.login');
        }

        if ($pekerja->google2fa_enabled) {
            return redirect()->route('pekerja.dashboard');
        }

        $google2fa = new Google2FA();

        if (!$pekerja->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();

            $pekerja->update([
                'google2fa_secret' => $secret,
            ]);

            $pekerja->refresh();
        }

        $this->secret = $pekerja->google2fa_secret;

        $this->qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $pekerja->email,
            $this->secret
        );
    }

    public function enable()
    {
        $this->validate([
            'otp_code' => 'required|digits:6',
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi.',
            'otp_code.digits'   => 'Kode OTP harus 6 digit.',
        ]);

        $pekerja = Auth::guard('pekerja')->user();

        if (!$pekerja) {
            return redirect()->route('pekerja.login');
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $pekerja->google2fa_secret,
            $this->otp_code
        );

        if (!$valid) {
            $this->addError(
                'otp_code',
                'Kode OTP tidak valid. Coba lagi.'
            );

            return;
        }

        $pekerja->update([
            'google2fa_enabled' => true,
        ]);

        session(['2fa_verified' => true]);

        session()->flash(
            'success',
            '2FA berhasil diaktifkan!'
        );

        return redirect()->route('pekerja.dashboard');
    }

    public function render()
    {
        return view('livewire.pekerja.auth.Setup2FA');
    }
}
