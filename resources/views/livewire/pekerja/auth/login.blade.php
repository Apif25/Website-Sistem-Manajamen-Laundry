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
                            Keep me logged in
                        </label>
                    </div>

                    {{-- CAPTCHA --}}
                    <div class="mb-4">
                        <div style="background:#fff;padding:12px;border-radius:12px;width:fit-content">
                            <div wire:ignore id="recaptcha-container"></div>
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

        // Jangan render ulang kalau sudah ada iframe di dalam
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

    // Dipanggil otomatis oleh Google reCAPTCHA API setelah script selesai load
    window.onRecaptchaLoad = function() {
        renderRecaptcha();
    };

    document.addEventListener('livewire:init', () => {
        // Fallback kalau grecaptcha sudah ready sebelum livewire:init
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