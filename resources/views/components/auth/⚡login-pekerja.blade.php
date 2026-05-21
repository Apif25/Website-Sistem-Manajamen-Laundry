<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

new class extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public ?string $captcha = null;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required',
        ], [
            'captcha.required' => 'Captcha wajib dicentang.'
        ]);

        // VERIFY CAPTCHA
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('recaptcha.secret_key'),
                'response' => $this->captcha,
            ]
        );

        $result = $response->json();

        if (!$result['success']) {
            $this->captcha = null;
            session()->flash('error', 'Captcha tidak valid.');
            return;
        }

        // LOGIN
        if (Auth::guard('pekerja')->attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {
            return redirect()->route('pekerja.dashboard');
        }

        $this->captcha = null;
        session()->flash('error', 'Email atau password salah');
    }
};
?>

<div id="auth">

    <div class="row h-100">

        <div class="col-lg-5 col-12">

            <div id="auth-left">

                <div class="auth-logo">
                    <a href="#">
                        <img
                            src="{{ asset('templates/backend/assets/compiled/svg/logo.svg') }}"
                            alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Log in.</h1>

                <p class="auth-subtitle mb-5">
                    Log in with your data that you entered during registration.
                </p>

                {{-- ERROR GLOBAL --}}
                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form wire:submit.prevent="login">

                    {{-- EMAIL --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="email"
                            wire:model="email"
                            class="form-control form-control-xl @error('email') is-invalid @enderror"
                            placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="password"
                            wire:model="password"
                            class="form-control form-control-xl @error('password') is-invalid @enderror"
                            placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- REMEMBER --}}
                    <div class="form-check form-check-lg d-flex align-items-end mb-4">
                        <input
                            class="form-check-input me-2"
                            type="checkbox"
                            wire:model="remember">
                        <label class="form-check-label text-gray-600">
                            Keep me logged in
                        </label>
                    </div>

                    {{-- CAPTCHA --}}
                    <div class="mb-4">
                        <div style="background: #fff; padding: 12px; border-radius: 12px; width: fit-content;">
                            {{-- wire:ignore supaya Livewire tidak menyentuh elemen ini --}}
                            <div
                                wire:ignore
                                id="recaptcha-container">
                            </div>
                        </div>
                        @error('captcha')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="btn btn-primary btn-block btn-lg shadow-lg mt-3"
                        wire:loading.attr="disabled"
                        wire:target="login">

                        <span wire:loading.remove wire:target="login">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Log in
                        </span>

                        <span wire:loading wire:target="login">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...
                        </span>

                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>

{{--
    Script ini HARUS di luar @script agar jadi window scope (global).
    Google reCAPTCHA memanggil data-callback lewat window object.
    Render widget secara manual via grecaptcha.render() supaya
    selalu fresh setiap kali halaman dimuat ulang (termasuk setelah logout).
--}}
<script>
    // ID widget reCAPTCHA, digunakan untuk reset
    var recaptchaWidgetId = null;

    // Callback dipanggil Google setelah user centang
    function captchaCallback(token) {
        Livewire.first().set('captcha', token);
    }

    // Render widget reCAPTCHA secara manual ke dalam #recaptcha-container
    function renderRecaptcha() {
        var container = document.getElementById('recaptcha-container');
        if (!container) return;

        // Kosongkan container dulu supaya tidak double render
        container.innerHTML = '';

        if (typeof grecaptcha === 'undefined') {
            // Script reCAPTCHA belum siap, coba lagi 100ms kemudian
            setTimeout(renderRecaptcha, 100);
            return;
        }

        recaptchaWidgetId = grecaptcha.render(container, {
            sitekey: '{{ config("recaptcha.site_key") }}',
            theme: 'light',
            callback: captchaCallback,
        });
    }

    // Jalankan render saat DOM siap
    document.addEventListener('DOMContentLoaded', renderRecaptcha);
</script>

@script
<script>
    Livewire.hook('commit', ({
        component,
        succeed
    }) => {
        succeed(() => {
            if (component.snapshot.data.captcha === null) {
                if (typeof grecaptcha !== 'undefined' && recaptchaWidgetId !== null) {
                    grecaptcha.reset(recaptchaWidgetId);
                } else {
                    renderRecaptcha();
                }
            }
        });
    });
</script>
@endscript