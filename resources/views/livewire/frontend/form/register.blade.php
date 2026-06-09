<div class="register-page-container">
        <div class="register-card">
            <h2>REGISTER</h2>

            <form wire:submit.prevent="register">
                <div class="input-group">
                    <label>Username :</label>
                    <input type="text" wire:model="username" placeholder="Masukkan Username">
                    @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Password :</label>
                    <input type="password" wire:model="password" placeholder="Masukkan Password">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Konfirmasi Password :</label>
                    <input type="password" wire:model="password_confirmation" placeholder="Masukkan Ulang Password">
                </div>

                <div class="input-group">
                    <label>Email :</label>
                    <input type="email" wire:model="email" placeholder="Masukkan Email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="otp-row">
                    <div style="flex: 1; display: flex; flex-direction: column;">
                        <input type="text" wire:model="otp" placeholder="Kode OTP">
                        @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="button" wire:click="sendOtp" class="btn-kirim" wire:loading.attr="disabled">
                        <span wire:loading.remove>Kirim</span>
                        <span wire:loading>...</span>
                    </button>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" wire:model="terms" id="terms">
                    <label for="terms" style="font-size: 12px; color: #4682b4;">
                        Saya setuju dengan syarat & ketentuan dan kebijakan privasi <span style="color:red">*</span>
                    </label>
                    @error('terms') <br><span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-lanjut">
                    <span wire:loading.remove>LANJUT</span>
                    <span wire:loading>PROSES...</span>
                </button>
            </form>
        </div>
    </div>
</div>