<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI : FORM LOGIN -->
        <div class="login-left">
            <h2>LOGIN</h2>

            <form wire:submit.prevent="loginPelanggan">

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

                    <a href="{{ route('forgot-password') }}"
                        class="text-decoration-none">
                        Lupa Password?
                    </a>
                </div>

                <div id="google-recaptcha" class="mb-4" wire:ignore>
                    <div class="g-recaptcha captcha-scale" data-sitekey="{{ config('recaptcha.site_key') }}" data-callback="setCaptchaToken"></div>
                </div>
                @error('captcha') <span class="text-danger text-sm">{{ $message }}</span> @enderror

                <button type="submit" class="btn-submit">
                    MASUK
                </button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <a href="{{ route('google.login') }}"
                    class="btn-google">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.655 32.657 29.243 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.27 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" />
                        <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.27 4 24 4c-7.682 0-14.347 4.337-17.694 10.691z" />
                        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.146 35.091 26.671 36 24 36c-5.222 0-9.621-3.329-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" />
                        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.237-2.231 4.166-4.084 5.571c.001-.001 6.19 5.238 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" />
                    </svg>

                    <span>Masuk dengan Google</span>
                </a>

                <div class="login-footer">
                    Belum punya akun?
                    <a href="{{ route('register') }}" wire:navigate>Buat akun</a>
                </div>

            </form>
        </div>

        <!-- KANAN : GAMBAR -->
        <div class="login-right">
            <img src="{{ asset('img/login/login frontend.jpg') }}"
                alt="Login Illustration">
        </div>

    </div>
</div>

<style>
    .divider {
        display: flex;
        align-items: center;
        margin: 18px 0;
    }

    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #ddd;
    }

    .divider span {
        margin: 0 12px;
        color: #777;
    }

    .btn-google {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
        color: #333;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-google:hover {
        background: #f8f9fa;
        color: #333;
    }
</style>


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