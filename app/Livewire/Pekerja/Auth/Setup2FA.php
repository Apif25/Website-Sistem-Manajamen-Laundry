<?php

namespace App\Livewire\Pekerja\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

#[Layout('backend.layouts.auth')]
#[Title('Login Pekerja')]
class Setup2FA extends Component
{
    public string $secret = '';
    public string $qrCodeUrl = '';
    public string $qrCodeSvg = '';
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
            $pekerja->update([
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ]);

            $pekerja->refresh();
        }

        $this->secret = $pekerja->google2fa_secret;

        $this->qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $pekerja->email,
            $this->secret
        );

        $this->generateQrCode();
    }

    protected function generateQrCode(): void
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(250),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);

            $this->qrCodeSvg = $writer->writeString(
                $this->qrCodeUrl
            );
        } catch (\Throwable $e) {
            report($e);

            $this->qrCodeSvg = '';
        }
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

        session([
            '2fa_verified' => true,
        ]);

        session()->flash(
            'success',
            '2FA berhasil diaktifkan!'
        );

        if ($pekerja->must_change_password) {
            return redirect()->route('pekerja.password.first');
        }

        return redirect()->route('pekerja.dashboard');
    }

    public function render()
    {
        return view('livewire.pekerja.auth.Setup2FA');
    }
}
