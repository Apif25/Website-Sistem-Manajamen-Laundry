<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI -->
        <div class="login-left">

            <h2>VERIFIKASI 2FA</h2>

            <p class="text-muted verification-text">
                Masukkan kode 6 digit dari aplikasi
                <strong>Google Authenticator</strong>
                untuk melanjutkan login.
            </p>

            <form wire:submit.prevent="verify">

                <div class="input-group">
                    <input
                        type="text"
                        maxlength="6"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="Masukkan kode OTP"
                        wire:model.live="otp_code">

                    @error('otp_code')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn-submit">

                    <span wire:loading.remove wire:target="verify">
                        VERIFIKASI
                    </span>

                    <span wire:loading wire:target="verify">
                        MEMVERIFIKASI...
                    </span>

                </button>

            </form>

            <div class="login-footer">
                <a
                    href="#"
                    wire:click.prevent="logout">
                    Keluar dari akun ini
                </a>
            </div>

        </div>

        <!-- KANAN -->
        <div class="login-right">
            <img
                src="{{ asset('img/login/login frontend.jpg') }}"
                alt="Google Authenticator">
        </div>

    </div>
</div>

<style>
    .verification-text {
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .login-footer {
        margin-top: 20px;
        text-align: center;
    }

    .login-footer a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        transition: .2s;
    }

    .login-footer a:hover {
        color: #212529;
    }
</style>