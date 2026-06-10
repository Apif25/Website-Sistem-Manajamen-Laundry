<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;
use App\Services\PelangganAuthService; 
use Illuminate\Validation\ValidationException;

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
        // 1. Validasi Input Form termasuk Captcha
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required',
        ]);

        // 2. Verifikasi token ke API Google
        if (!$this->verifyCaptcha()) {
            $this->resetCaptcha();
            $this->dispatch('reset-recaptcha');
            session()->flash('error', 'Captcha tidak valid.');
            return;
        }

        try {
            // 3. Eksekusi Login via Service
            $authService->login([
                'email'    => $this->email,
                'password' => $this->password,
            ], $this->remember);

            // Jika sukses, arahkan ke halaman dashboard pelanggan
            return redirect()->route('pelanggan.beranda');

        } catch (ValidationException $e) {
            // Jika login gagal, reset token captcha agar user mencentang ulang
            $this->resetCaptcha();
            $this->dispatch('reset-recaptcha');

            // Ambil pesan error email dari Service untuk ditampilkan di session flash atau properti error
            if (isset($e->errors()['email'])) {
                $this->addError('email', $e->errors()['email'][0]);
                session()->flash('error', $e->errors()['email'][0]);
            } else {
                // Melempar kembali error validasi bawaan (seperti email required / password required) ke view
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