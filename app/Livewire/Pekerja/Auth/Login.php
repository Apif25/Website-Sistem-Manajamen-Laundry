<?php

namespace App\Livewire\Pekerja\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

#[Layout('backend.layouts.auth')]
#[Title('Login Pekerja')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public ?string $captcha = null;

    protected array $messages = [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
        'captcha.required'  => 'Captcha wajib dicentang.',
    ];

    public function mount()
    {
        // 🔥 FIX BUG CAPTCHA BLANK SETELAH LOGOUT
        $this->resetCaptcha();
    }

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'captcha'  => 'required',
        ]);

        // VERIFY CAPTCHA
        if (!$this->verifyCaptcha()) {
            $this->resetCaptcha();
            session()->flash('error', 'Captcha tidak valid.');
            $this->dispatch('reset-recaptcha'); // trigger JS reset
            return;
        }

        // LOGIN ATTEMPT
        if (
            !Auth::guard('pekerja')->attempt([
                'email'    => $this->email,
                'password' => $this->password,
            ], $this->remember)
        ) {
            $this->resetCaptcha();
            session()->flash('error', 'Email atau password salah.');
            $this->dispatch('reset-recaptcha');
            return;
        }

        $pekerja = Auth::guard('pekerja')->user();

        // 2FA setup check
        if (!$pekerja->google2fa_enabled) {
            return redirect()->route('pekerja.pekerja.Setup2FA');
        }

        return redirect()->route('pekerja.pekerja.Verify2FA');
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
        return view('livewire.pekerja.auth.login');
    }
}
