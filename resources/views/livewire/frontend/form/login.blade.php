<div class="login-page-container">
    <div class="login-box">
        <h2>LOGIN PELANGGAN</h2>

        <div class="login-body">
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
                        <input
                            type="checkbox"
                            wire:model="remember">
                        <span>Ingat saya</span>
                    </label>

                    <a href="#" class="forgot-password">Lupa Password</a>
                </div>

                <button type="submit" class="btn-submit">MASUK</button>

            </form>

            <div class="login-footer">
                <p>
                    Belum punya akun?
                    <a href="#">Buat akun</a>
                </p>
            </div>
        </div>
    </div>
</div>