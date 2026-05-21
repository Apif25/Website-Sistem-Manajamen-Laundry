<?php

namespace App\Livewire\Pekerja\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;

#[Layout('backend.layouts.auth')]
#[Title('Login Pekerja')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public ?string $captcha = null;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required',
        'captcha' => 'required',
    ];

    protected array $messages = [
        'captcha.required' => 'Captcha wajib dicentang.',
    ];

    public function login()
    {
        $this->validate();

        if (!$this->verifyCaptcha()) {
            $this->resetCaptcha();

            session()->flash(
                'error',
                'Captcha tidak valid.'
            );

            return;
        }

        if (!$this->attemptLogin()) {
            $this->resetCaptcha();

            session()->flash(
                'error',
                'Email atau password salah.'
            );

            return;
        }

        return redirect()->route('pekerja.dashboard');
    }

    private function verifyCaptcha(): bool
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $this->captcha,
            ]
        );

        return (bool) ($response->json()['success'] ?? false);
    }

    private function attemptLogin(): bool
    {
        return Auth::guard('pekerja')->attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ], $this->remember);
    }

    private function resetCaptcha(): void
    {
        $this->captcha = null;
    }

    public function render()
    {
        return view('livewire.pekerja.auth.login');
    }
}
