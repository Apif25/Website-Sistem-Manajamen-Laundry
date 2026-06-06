<div id="auth">

    <style>
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
            font-size: 1rem;
            margin: 0;
            opacity: .9;
        }

        .qr-wrapper {
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            display: inline-block;
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
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

                <h1 class="auth-title">
                    Verifikasi Dua Langkah
                </h1>

                <p class="auth-subtitle mb-4">
                    Scan QR code di bawah menggunakan
                    <strong>Google Authenticator</strong>,
                    lalu masukkan kode 6 digit yang muncul.
                </p>

                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                {{-- QR CODE --}}
                <div class="text-center mb-4">

                    <div class="qr-wrapper shadow-sm">

                        @if($qrCodeSvg)
                        {!! $qrCodeSvg !!}
                        @else
                        <div class="text-danger">
                            QR Code gagal dibuat.
                        </div>
                        @endif

                    </div>

                </div>

                {{-- SECRET --}}
                <div class="mb-4">

                    <p class="text-muted small mb-1">
                        Tidak bisa scan? Masukkan kode ini secara manual:
                    </p>

                    <div class="input-group">

                        <input
                            type="text"
                            id="secretKey"
                            readonly
                            value="{{ $secret }}"
                            class="form-control form-control-sm text-center fw-bold letter-spacing-2">

                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-sm"
                            onclick="copySecret(this)">

                            <i class="bi bi-clipboard"></i>

                        </button>

                    </div>

                </div>

                {{-- FORM --}}
                <form wire:submit.prevent="enable">

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input
                            type="text"
                            wire:model="otp_code"
                            maxlength="6"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            placeholder="Kode 6 digit"
                            class="form-control form-control-xl @error('otp_code') is-invalid @enderror">

                        <div class="form-control-icon">
                            <i class="bi bi-phone"></i>
                        </div>

                        @error('otp_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-block btn-lg shadow-lg"
                        wire:loading.attr="disabled">

                        <span wire:loading.remove>
                            Aktifkan 2FA
                        </span>

                        <span wire:loading>
                            Memverifikasi...
                        </span>

                    </button>

                </form>

                {{-- LOGOUT --}}
                <div class="text-center mt-4">

                    <a
                        href="{{ route('pekerja.logout') }}"
                        class="text-muted small">

                        <i class="bi bi-box-arrow-left me-1"></i>
                        Kembali / Logout

                    </a>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

                <img
                    src="{{ asset('images/login-bg.jpg') }}"
                    alt="Background"
                    class="auth-bg-image">

                <div class="auth-overlay">
                    <h2>Keamanan Akun</h2>

                    <p>
                        Aktifkan autentikasi dua langkah untuk memberikan
                        perlindungan tambahan terhadap akun dan data sistem Anda.
                    </p>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    function copySecret(button) {

        const secret = document.getElementById('secretKey');

        navigator.clipboard.writeText(secret.value)
            .then(() => {

                button.innerHTML =
                    '<i class="bi bi-check-lg text-success"></i>';

                setTimeout(() => {
                    button.innerHTML =
                        '<i class="bi bi-clipboard"></i>';
                }, 1500);
            });
    }
</script>