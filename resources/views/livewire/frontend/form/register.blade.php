<div class="register-page-container">
    <div class="register-card">
        <h2>REGISTER {{ $currentStep == 2 ? '(DATA DIRI)' : '' }}</h2>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
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

                <div class="otp-row" x-data="{ 
                        cooldown: 0, 
                        timer: null,
                        startCooldown() {
                            this.cooldown = 60;
                            if(this.timer) clearInterval(this.timer);
                            this.timer = setInterval(() => {
                                if(this.cooldown > 0) {
                                    this.cooldown--;
                                } else {
                                    clearInterval(this.timer);
                                }
                            }, 1000);
                        }
                    }">
                    <div class="otp-input-wrapper">
                        <input type="text" wire:model="otp" placeholder="Kode OTP">
                        @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
        
                        <span x-show="cooldown > 0" class="otp-cooldown-text">
                            Kirim ulang kode OTP dalam <strong x-text="cooldown"></strong> detik.
                        </span>
                    </div>

                    <button type="button" 
                            wire:click="sendOtp" 
                            @click="startCooldown()"
                            class="btn-send" 
                            x-bind:disabled="cooldown > 0"
                            wire:loading.attr="disabled"
                            x-bind:class="{ 'btn-otp-disabled': cooldown > 0 }">
                        
                        <span wire:loading.remove wire:target="sendOtp" x-show="cooldown === 0">Kirim OTP</span>
                        <span wire:loading.remove wire:target="sendOtp" x-show="cooldown > 0">Tunggu...</span>
                        <span wire:loading wire:target="sendOtp">...</span>
                    </button>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" wire:model="terms" id="terms">
                    <label for="terms">
                        Saya setuju dengan syarat & ketentuan dan kebijakan privasi <span class="required-star">*</span>
                    </label>
                    @error('terms') <br><span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-next">
                    <span wire:loading.remove wire:target="register">LANJUT</span>
                    <span wire:loading wire:target="register">PROSES...</span>
                </button>
            @endif


            @if($currentStep == 2)
                <div class="input-group avatar-upload-group">
                    <label class="avatar-label-title">Foto Profil (Opsional) :</label>

                    <div class="avatar-wrapper">               

                        <label for="foto_profil" class="avatar-clickable-area">

                            @if ($foto_profil && !$errors->has('foto_profil'))
                                <img src="{{ $foto_profil->temporaryUrl() }}" class="avatar-preview-img">
                            @else
                                <div class="avatar-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4zm5.354-1.146a.5.5 0 0 0-.708 0L1.146 8.354A1.5 1.5 0 0 0 1 9.414V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.414a1.5 1.5 0 0 0-.414-1.06L9.354 2.854a.5.5 0 0 0-.708 0L5.354 6.146 7.354 2.854z"/>
                                    </svg>
                                    <span>PILIH FOTO</span>
                                </div>
                            @endif

                            <div class="avatar-hover-overlay">
                                Ubah Foto
                            </div>
                        </label>

                        <input type="file" id="foto_profil" wire:model="foto_profil" accept="image/*" class="hidden-file-input">
                    </div>

                    <div wire:loading wire:target="foto_profil" class="avatar-loading-text">                
                        <span>⏳</span> Memproses gambar...
                    </div>
                    
                    @error('foto_profil') 
                        <span class="text-danger avatar-error-text">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="input-group">
                    <label>Nomor Telepon :</label>
                    <input type="text" wire:model="no_telp" placeholder="Masukkan Nomor Telepon (Contoh: 081234xxx)">
                    @error('no_telp') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Jenis Kelamin :</label>
                    <select wire:model="jenis_kelamin" class="select-gender">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Label Alamat (Contoh: Rumah, Kantor, Kos) :</label>
                    <input type="text" wire:model="label_alamat" placeholder="Masukkan label alamat">
                    @error('label_alamat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Provinsi :</label>
                    <select wire:model.live="province_id" class="select-gender">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Kota/Kabupaten :</label>
                    <select wire:model.live="regency_id" class="select-gender">
                        <option value="">-- Pilih Kota/Kabupaten --</option>
                        @foreach($regencies as $reg)
                            <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                        @endforeach
                    </select>
                    @error('regency_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Kecamatan :</label>
                    <select wire:model="district_id" class="select-gender">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                        @endforeach
                    </select>
                    @error('district_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label>Alamat Lengkap (Jalan, RT/RW, No. Rumah) :</label>
                    <textarea wire:model="alamat_lengkap" class="textarea-address" rows="3" placeholder="Masukkan nama jalan, nomor rumah, RT/RW"></textarea>
                    @error('alamat_lengkap') <span class="text-danger">{{ $message }}</span> @enderror
                </div>



                <div class="form-actions-group">
                    <button type="button" wire:click="backToStepOne" class="btn-back">
                        KEMBALI
                    </button>
                    
                    <button type="submit" class="btn-next btn-submit-registration">
                        <span wire:loading.remove wire:target="register">DAFTAR SEKARANG</span>
                        <span wire:loading wire:target="register">MENYIMPAN...</span>
                    </button>
                </div>
            @endif

        </form>
    </div>
</div>