<div id="auth">

    <style>
        /* PANEL KIRI */
        #auth-left {
            padding: 3rem 4rem;
        }

        /* PANEL KANAN */
        #auth-right {
            position: relative;
            height: 100vh;
            overflow: hidden;
            padding: 0 !important;
            background: none !important;
        }

        .auth-bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Overlay gelap agar teks terlihat */
        .auth-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: #fff;
        }

        .auth-overlay h2 {
            color: #93c5fd;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .auth-overlay p {
            color: #dbeafe;
            font-size: 1.1rem;
            margin-bottom: 0;
            opacity: .9;
        }

        @media (max-width: 991.98px) {
            #auth-left {
                padding: 2rem;
            }
        }
    </style>

    <div class="row h-100">

        {{-- LEFT --}}
        <div class="col-lg-5 col-12">

            <div id="auth-left">

                <div class="auth-logo">
                    <a href="#">
                        <img
                            src="{{ asset('templates/backend/assets/compiled/svg/logo.svg') }}"
                            alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Login</h1>

                <p class="auth-subtitle mb-5">
                    Masuk Ke Sistem Informasi Manajemen Laundry
                </p>

                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form wire:submit="login">

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
                        <small class="text-danger d-block mt-1">
                            {{ $message }}
                        </small>
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
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- REMEMBER --}}
                    <div class="form-check form-check-lg d-flex align-items-end mb-4">
                        <input
                            type="checkbox"
                            class="form-check-input me-2"
                            wire:model="remember">

                        <label class="form-check-label text-gray-600">
                            Ingat Saya
                        </label>
                    </div>

                    {{-- CAPTCHA --}}
                    <div class="mb-4">
                        <div style="background:#fff;padding:12px;border-radius:12px;width:fit-content">
                            <div wire:ignore id="recaptcha-container"></div>
                        </div>

                        @error('captcha')
                        <small class="text-danger d-block mt-2">
                            {{ $message }}
                        </small>
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
                            Login
                        </span>

                        <span wire:loading wire:target="login">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...
                        </span>

                    </button>

                </form>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

                <img
                    src="{{ asset('images/login-bg.jpg') }}"
                    alt="Login Background"
                    class="auth-bg-image">

                <div class="auth-overlay">
                    <h2>Sistem Informasi Manajemen Laundry</h2>
                    <p>Selamat Datang di Portal Pekerja</p>
                </div>

            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    window.captchaWidgetId = null;

    window.captchaCallback = function(token) {
        @this.set('captcha', token);
    };

    window.captchaExpiredCallback = function() {
        @this.set('captcha', null);
    };

    function renderRecaptcha() {
        const container = document.getElementById('recaptcha-container');
        if (!container) return;

        if (container.querySelector('iframe')) return;

        if (typeof grecaptcha === 'undefined' || typeof grecaptcha.render === 'undefined') {
            setTimeout(renderRecaptcha, 150);
            return;
        }

        window.captchaWidgetId = grecaptcha.render(container, {
            sitekey: '{{ config("recaptcha.site_key") }}',
            callback: 'captchaCallback',
            'expired-callback': 'captchaExpiredCallback',
            theme: 'light',
        });
    }

    window.onRecaptchaLoad = function() {
        renderRecaptcha();
    };

    document.addEventListener('livewire:init', () => {
        if (typeof grecaptcha !== 'undefined') {
            renderRecaptcha();
        }

        Livewire.hook('commit', ({
            component,
            succeed
        }) => {
            succeed(() => {
                if (component.snapshot?.data?.captcha === null) {
                    if (typeof grecaptcha !== 'undefined' && window.captchaWidgetId !== null) {
                        grecaptcha.reset(window.captchaWidgetId);
                    }
                }
            });
        });
    });
</script>
@endpush