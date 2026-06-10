<div>
    <link rel="stylesheet" href="{{ asset('templates/frontend/assets/compiled/css/profile.css') }}">

    <div class="top-container">
        <img src="{{ asset('img/pesanan/section1.png') }}" alt="Profil" class="bg-hero-image">
        <div class="top-container-text">
            <h1>Profil Anda</h1>
        </div>
    </div>

    <div class="main-container">
        @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form wire:submit.prevent="save" class="profile-form">
            <div class="profile-grid">

                <!-- KOLOM KIRI: DATA DIRI -->
                <div class="profile-card">
                    <h3 class="card-title">Data Diri</h3>

                    <!-- Avatar Upload -->
                    <div class="avatar-upload-group">
                        <label class="avatar-label-title">Foto Profil :</label>
                        <div class="avatar-wrapper">
                            <label for="foto_profil" class="avatar-clickable-area">
                                @if ($foto_profil && !$errors->has('foto_profil'))
                                <img src="{{ $foto_profil->temporaryUrl() }}" class="avatar-preview-img">
                                @elseif ($foto_profil_existing)
                                <img src="{{ asset('storage/pelanggan/foto-pelanggan/' . $foto_profil_existing) }}" class="avatar-preview-img">
                                @else
                                <div class="avatar-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path d="M2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4zm5.354-1.146a.5.5 0 0 0-.708 0L1.146 8.354A1.5 1.5 0 0 0 1 9.414V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.414a1.5 1.5 0 0 0-.414-1.06L9.354 2.854a.5.5 0 0 0-.708 0L5.354 6.146 7.354 2.854z" />
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
                        <label>Nama Pelanggan :</label>
                        <input type="text" wire:model="nama_pelanggan" placeholder="Nama lengkap Anda">
                        @error('nama_pelanggan') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Email :</label>
                        <input type="email" wire:model="email" placeholder="Email Anda">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Nomor Telepon :</label>
                        <input type="text" wire:model="no_telepon" placeholder="Nomor telepon Anda (Contoh: 081234xxx)">
                        @error('no_telepon') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Jenis Kelamin :</label>
                        <select wire:model="jenis_kelamin" class="select-field">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Kata Sandi Baru (Kosongkan jika tidak ingin diubah) :</label>
                        <input type="password" wire:model="password" placeholder="Masukkan kata sandi baru">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Konfirmasi Kata Sandi Baru :</label>
                        <input type="password" wire:model="password_confirmation" placeholder="Ulangi kata sandi baru">
                    </div>
                </div>

                <!-- KOLOM KANAN: ALAMAT UTAMA -->
                <div class="profile-card">
                    <h3 class="card-title">Alamat Utama Pengiriman</h3>

                    <div class="input-group">
                        <label>Label Alamat (Contoh: Rumah, Kantor, Kos) :</label>
                        <input type="text" wire:model="label_alamat" placeholder="Masukkan label alamat">
                        @error('label_alamat') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Provinsi :</label>
                        <select wire:model.live="province_id" class="select-field">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                        @error('province_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Kota/Kabupaten :</label>
                        <select wire:model.live="regency_id" class="select-field">
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                            @foreach($regencies as $reg)
                            <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                            @endforeach
                        </select>
                        @error('regency_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Kecamatan :</label>
                        <select wire:model="district_id" class="select-field">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($districts as $dist)
                            <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label>Alamat Lengkap (Jalan, RT/RW, No. Rumah) :</label>
                        <textarea wire:model="alamat_lengkap" class="textarea-field" rows="4" placeholder="Masukkan nama jalan, nomor rumah, RT/RW"></textarea>
                        @error('alamat_lengkap') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="profile-actions">
                <button type="submit" class="btn-save">
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">⏳ Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>