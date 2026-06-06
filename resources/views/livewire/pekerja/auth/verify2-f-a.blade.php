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
            opacity: .9;
            margin: 0;
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

                <p class="auth-subtitle mb-5">
                    Buka <strong>Google Authenticator</strong> dan masukkan
                    kode 6 digit untuk akun ini.
                </p>

                {{-- ERROR --}}
                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                {{-- FORM --}}
                <form wire:submit.prevent="verify">

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input
                            type="text"
                            wire:model.defer="otp_code"
                            maxlength="6"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            autofocus
                            placeholder="Kode 6 digit"
                            class="form-control form-control-xl @error('otp_code') is-invalid @enderror">

                        <div class="form-control-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        @error('otp_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary btn-block btn-lg shadow-lg mt-3"
                        wire:loading.attr="disabled"
                        wire:target="verify">

                        <span wire:loading.remove wire:target="verify">
                            <i class="bi bi-check-circle me-1"></i>
                            Verifikasi
                        </span>

                        <span wire:loading wire:target="verify">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memverifikasi...
                        </span>

                    </button>

                </form>

                {{-- LOGOUT --}}
                <div class="text-center mt-4">

                    <button
                        wire:click="logout"
                        class="btn btn-link text-muted small text-decoration-none">

                        <i class="bi bi-box-arrow-left me-1"></i>
                        Kembali / Logout

                    </button>

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

                    <h2>Verifikasi Keamanan</h2>

                    <p>
                        Masukkan kode autentikasi dari Google Authenticator
                        untuk melanjutkan akses ke sistem.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>