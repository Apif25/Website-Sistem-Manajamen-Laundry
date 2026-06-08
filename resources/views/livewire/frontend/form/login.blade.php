<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI : FORM LOGIN -->
        <div class="login-left">
            <h2>LOGIN</h2>

            <form wire:submit.prevent="login">

                <div class="input-group">
                    <input
                        type="email"
                        placeholder="Masukkan Email"
                        wire:model.live="email">

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="input-group">
                    <input
                        type="password"
                        placeholder="Masukkan Password"
                        wire:model.live="password">

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" wire:model="remember">
                        <span>Ingat saya</span>
                    </label>

                    <a href="#" class="forgot-password">
                        Lupa Password
                    </a>
                </div>

                <div id="google-recaptcha" class="mb-4" wire:ignore>
                    <div class="g-recaptcha captcha-scale" data-sitekey="{{ config('recaptcha.site_key') }}" data-callback="setCaptchaToken"></div>
                </div>
                @error('captcha') <span class="text-danger text-sm">{{ $message }}</span> @enderror

                <button type="submit" class="btn-submit">
                    MASUK
                </button>

                <div class="login-footer">
                    Belum punya akun?
                    <a href="#">Buat akun</a>
                </div>

            </form>
        </div>

        <!-- KANAN : GAMBAR -->
        <div class="login-right">
            <img src="{{ asset('img/login/Saki Rindo.jpg') }}"
                 alt="Login Illustration">
        </div>

    </div>
</div>

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    // Sekarang aman digunakan karena berada langsung di dalam scope komponen login
    function setCaptchaToken(token) {
        @this.set('captcha', token);
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('reset-recaptcha', () => {
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
        });
    });
</script>
@endpush