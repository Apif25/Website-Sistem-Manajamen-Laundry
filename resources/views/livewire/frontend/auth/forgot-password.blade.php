<div class="login-page-container">
    <div class="login-card">

        <!-- KIRI : FORM -->
        <div class="login-left">

            @if($step == 1)

            <h2>LUPA PASSWORD</h2>

            <p class="text-muted mb-4">
                Masukkan email yang terdaftar untuk menerima kode OTP.
            </p>

            <form wire:submit.prevent="sendOtp">

                <div class="input-group">
                    <input
                        type="email"
                        placeholder="Masukkan Email"
                        wire:model.live="email">

                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    KIRIM OTP
                </button>

                <div class="login-footer">
                    Ingat password?
                    <a href="{{ route('login') }}" wire:navigate>
                        Login
                    </a>
                </div>

            </form>

            @endif

            @if($step == 2)

            <h2>VERIFIKASI OTP</h2>

            <p class="text-muted mb-4">
                Masukkan kode OTP yang telah dikirim ke email Anda.
            </p>

            <form wire:submit.prevent="verifyOtp">

                <div class="input-group">
                    <input
                        type="text"
                        maxlength="6"
                        placeholder="Masukkan OTP"
                        wire:model.live="otp">

                    @error('otp')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    VERIFIKASI OTP
                </button>

            </form>

            @endif

            @if($step == 3)

            <h2>PASSWORD BARU</h2>

            <p class="text-muted mb-4">
                Silakan buat password baru untuk akun Anda.
            </p>

            <form wire:submit.prevent="resetPassword">

                <div class="input-group">
                    <input
                        type="password"
                        placeholder="Password Baru"
                        wire:model.live="password">
                </div>

                <div class="input-group">
                    <input
                        type="password"
                        placeholder="Konfirmasi Password"
                        wire:model.live="password_confirmation">
                </div>

                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror

                <button type="submit" class="btn-submit">
                    SIMPAN PASSWORD
                </button>

            </form>

            @endif

            @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif

        </div>

        <!-- KANAN : GAMBAR -->
        <div class="login-right">
            <img
                src="{{ asset('img/login/login frontend.jpg') }}"
                alt="Forgot Password">
        </div>
    </div>
</div>