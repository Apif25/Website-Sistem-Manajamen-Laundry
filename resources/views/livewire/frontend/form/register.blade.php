<div class="register-page-container">
    <div class="register-card">
        <h2>REGISTER {{ $currentStep == 2 ? '(DATA DIRI)' : '' }}</h2>

        @if (session()->has('message'))
            <div class="alert alert-success" style="color: green; margin-bottom: 15px; font-size: 14px;">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger" style="color: red; margin-bottom: 15px; font-size: 14px;">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="register">
            
            @if($currentStep == 1)
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
                        <span wire:loading.remove wire:target="sendOtp">Kirim OTP</span>
                        <span wire:loading wire:target="sendOtp">...</span>
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
                    <span wire:loading.remove wire:target="register">LANJUT</span>
                    <span wire:loading wire:target="register">PROSES...</span>
                </button>
            @endif


            @if($currentStep == 2)
                <div class="input-group">
                    <label>Nomor Telepon :</label>
                    <input type="text" wire:model="no_telp" placeholder="Masukkan Nomor Telepon (Contoh: 081234xxx)">
                    @error('no_telp') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Jenis Kelamin :</label>
                    <select wire:model="jenis_kelamin" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; box-sizing: border-box; background-color: white;">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Alamat Lengkap :</label>
                    <textarea wire:model="alamat" placeholder="Masukkan Alamat Lengkap" rows="4" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; box-sizing: border-box;"></textarea>
                    @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="button" wire:click="backToStepOne" class="btn-kembali" style="flex: 1; background-color: #6c757d; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        KEMBALI
                    </button>
                    
                    <button type="submit" class="btn-lanjut" style="flex: 2; margin-top: 0;">
                        <span wire:loading.remove wire:target="register">DAFTAR SEKARANG</span>
                        <span wire:loading wire:target="register">MENYIMPAN...</span>
                    </button>
                </div>
            @endif

        </form>
    </div>
</div>