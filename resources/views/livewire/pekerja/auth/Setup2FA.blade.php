<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">

                <div class="auth-logo">
                    <a href="#">
                        <img src="{{ asset('templates/backend/assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Setup 2FA.</h1>
                <p class="auth-subtitle mb-4">
                    Scan QR code di bawah menggunakan aplikasi <strong>Google Authenticator</strong>,
                    lalu masukkan kode 6 digit yang muncul.
                </p>

                @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- QR CODE --}}
                <div class="text-center mb-4">
                    <div style="background:#fff; padding:16px; border-radius:12px; display:inline-block;">
                        <img
                            src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ rawurlencode($qrCodeUrl) }}"
                            alt="QR Code 2FA">
                    </div>
                </div>

                {{-- MANUAL SECRET --}}
                <div class="mb-4">
                    <p class="text-muted small mb-1">
                        Tidak bisa scan? Masukkan kode ini secara manual:
                    </p>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control form-control-sm text-center fw-bold letter-spacing-2"
                            value="{{ $secret }}"
                            readonly
                            id="secretKey">
                        <button
                            class="btn btn-outline-secondary btn-sm"
                            type="button"
                            onclick="copySecret()">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>

                {{-- FORM VERIFIKASI --}}
                <form wire:submit.prevent="enable">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="text"
                            wire:model="otp_code"
                            class="form-control form-control-xl @error('otp_code') is-invalid @enderror"
                            placeholder="Kode 6 digit"
                            maxlength="6"
                            inputmode="numeric"
                            autocomplete="one-time-code">
                        <div class="form-control-icon"><i class="bi bi-phone"></i></div>
                        @error('otp_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="btn btn-primary btn-block btn-lg shadow-lg"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Aktifkan 2FA</span>
                        <span wire:loading>Memverifikasi...</span>
                    </button>
                </form>

                {{-- LOGOUT --}}
                <div class="text-center mt-4">
                    <a href="{{ route('pekerja.logout') }}" class="text-muted small">
                        <i class="bi bi-box-arrow-left me-1"></i> Kembali / Logout
                    </a>
                </div>

            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>

<script>
    function copySecret() {
        var el = document.getElementById('secretKey');
        navigator.clipboard.writeText(el.value).then(function() {
            alert('Secret key disalin!');
        });
    }
</script>