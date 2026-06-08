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
            <img src="{{ asset('img/login/login frontend.jpg') }}"
                 alt="Login Illustration">
        </div>

    </div>
</div>