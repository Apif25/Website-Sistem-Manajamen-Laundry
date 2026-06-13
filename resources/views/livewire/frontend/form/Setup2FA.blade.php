<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI : SETUP 2FA -->
        <div class="login-left">

            <h2>AKTIFKAN VERIFIKASI DUA LANGKAH</h2>

            <p class="text-muted mb-4">
                Scan QR Code berikut menggunakan aplikasi
                <strong>Google Authenticator</strong>,
                lalu masukkan kode OTP yang muncul.
            </p>

            @if ($qrCodeSvg)
            <div class="text-center mb-4">
                {!! $qrCodeSvg !!}
            </div>
            @endif

            <div class="input-group mb-3">
                <input
                    type="text"
                    readonly
                    value="{{ $secret }}"
                    class="form-control">
            </div>

            <form wire:submit.prevent="enable">

                <div class="input-group">
                    <input
                        type="text"
                        maxlength="6"
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
                    AKTIFKAN 2FA
                </button>

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