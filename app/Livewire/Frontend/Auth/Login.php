<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use App\Services\PelangganAuthService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

#[Layout('frontend.layouts.auth')]
#[Title('Halaman Masuk Pelanggan')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public ?string $captcha = null; // Menampung token captcha

    protected array $messages = [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
        'captcha.required'  => 'Captcha wajib dicentang.',
    ];

    public function mount()
    {
        // Reset status captcha saat halaman pertama kali dimuat
        $this->resetCaptcha();
    }

    public function loginPelanggan(PelangganAuthService $authService)
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required',
        ]);

        if (!$this->verifyCaptcha()) {
            $this->resetCaptcha();
            $this->dispatch('reset-recaptcha');
            session()->flash('error', 'Captcha tidak valid.');
            return;
        }

        try {

            $authService->login([
                'email'    => $this->email,
                'password' => $this->password,
            ], $this->remember);

            $pelanggan = Auth::guard('pelanggan')->user();

            // Jika 2FA sudah aktif, wajib verifikasi OTP
            if ($pelanggan->google2fa_enabled) {

                session()->forget('pelanggan_2fa_verified');

                return redirect()->route('pelanggan.verify-2fa');
            }

            // Jika belum mengaktifkan 2FA, langsung masuk beranda
            return redirect()->route('pelanggan.beranda');
        } catch (ValidationException $e) {

            $this->resetCaptcha();
            $this->dispatch('reset-recaptcha');

            if (isset($e->errors()['email'])) {
                $this->addError('email', $e->errors()['email'][0]);
                session()->flash('error', $e->errors()['email'][0]);
            } else {
                throw $e;
            }
        }
    }

    /**
     * VERIFY CAPTCHA GOOGLE
     */
    private function verifyCaptcha(): bool
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $this->captcha,
            ]
        );

        return (bool) ($response->json('success') ?? false);
    }

    /**
     * RESET CAPTCHA STATE
     */
    private function resetCaptcha(): void
    {
        $this->captcha = null;
    }

    public function render()
    {
        return view('livewire.frontend.form.login');
    }
}
