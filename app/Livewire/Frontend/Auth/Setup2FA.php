<?php

namespace App\Livewire\Frontend\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use PragmaRX\Google2FA\Google2FA;

use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

#[Layout('frontend.layouts.auth')]
#[Title('Setup Google Authenticator')]
class Setup2FA extends Component
{
    public string $secret = '';
    public string $qrCodeUrl = '';
    public string $qrCodeSvg = '';
    public string $otp_code = '';

    public function mount()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.login');
        }

        if ($pelanggan->google2fa_enabled) {
            return redirect()->route('pelanggan.beranda');
        }

        $google2fa = new Google2FA();

        if (!$pelanggan->google2fa_secret) {
            $pelanggan->update([
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ]);

            $pelanggan->refresh();
        }

        $this->secret = $pelanggan->google2fa_secret;

        $this->qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $pelanggan->email,
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

        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.login');
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            $pelanggan->google2fa_secret,
            $this->otp_code
        );

        if (!$valid) {
            $this->addError(
                'otp_code',
                'Kode OTP tidak valid. Coba lagi.'
            );

            return;
        }

        $pelanggan->update([
            'google2fa_enabled' => true,
        ]);

        session([
            'pelanggan_2fa_verified' => true,
        ]);

        session()->flash(
            'success',
            'Google Authenticator berhasil diaktifkan.'
        );

        return redirect()->route('pelanggan.beranda');
    }

    public function render()
    {
        return view('livewire.frontend.form.Setup2FA');
    }
}
