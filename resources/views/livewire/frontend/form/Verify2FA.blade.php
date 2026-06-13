<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI : FORM VERIFIKASI -->
        <div class="login-left">

            <h2>VERIFIKASI 2FA</h2>

            <p class="mb-4 text-muted">
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
                        placeholder="Masukkan Kode OTP"
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
                    VERIFIKASI
                </button>

                <div class="login-footer mt-3">
                    Bukan akun Anda?
                    <a
                        href="#"
                        wire:click.prevent="logout">
                        Keluar
                    </a>
                </div>

            </form>

        </div>

        <!-- KANAN : GAMBAR -->
        <div class="login-right">
            <img
                src="{{ asset('img/login/login frontend.jpg') }}"
                alt="Google Authenticator">
        </div>

    </div>
</div>