<div id="auth">
    <div class="row h-100">

        <div class="col-lg-5 col-12">
            <div id="auth-left">

                <div class="auth-logo">
                    <a href="#">
                        <img src="{{ asset('templates/backend/assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Verifikasi 2FA.</h1>

                <p class="auth-subtitle mb-5">
                    Buka <strong>Google Authenticator</strong> dan masukkan kode 6 digit
                    untuk akun ini.
                </p>

                {{-- ERROR GLOBAL --}}
                @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form wire:submit.prevent="verify">

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input
                            type="text"
                            wire:model.defer="otp_code"
                            class="form-control form-control-xl @error('otp_code') is-invalid @enderror"
                            placeholder="Kode 6 digit"
                            maxlength="6"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            autofocus>

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
                            <i class="bi bi-check-circle me-1"></i> Verifikasi
                        </span>

                        <span wire:loading wire:target="verify">
                            Memverifikasi...
                        </span>

                    </button>

                </form>

                <div class="text-center mt-4">
                    <button wire:click="logout" class="btn btn-link text-muted small">
                        <i class="bi bi-box-arrow-left me-1"></i> Kembali / Logout
                    </button>
                </div>

            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>

    </div>
</div>