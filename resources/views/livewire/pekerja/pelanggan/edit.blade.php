<div class="container">
    <h3>Edit Pelanggan</h3>

    @if (session()->has('success'))
    <div class="alert bg-success text-white">
        {{ session('success') }}
    </div>
    @endif

    <div class="card p-4">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" wire:model="nama" class="form-control">
            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" wire:model="no_telepon" class="form-control">
            @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Label Alamat</label>
                <input type="text" wire:model="label_alamat" class="form-control" placeholder="Contoh: Rumah, Kantor, Kos">
                @error('label_alamat') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label>Provinsi</label>
                <select wire:model.live="province_id" class="form-control">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                    @endforeach
                </select>
                @error('province_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kota / Kabupaten</label>
                <select wire:model.live="regency_id" class="form-control" @disabled(empty($province_id))>
                    <option value="">-- Pilih Kota / Kabupaten --</option>
                    @foreach($regencies as $reg)
                        <option value="{{ $reg->id }}">{{ $reg->name }}</option>
                    @endforeach
                </select>
                @error('regency_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Kecamatan</label>
                <select wire:model="district_id" class="form-control" @disabled(empty($regency_id))>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
                @error('district_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat Lengkap (Jalan, RT/RW, No. Rumah)</label>
            <textarea wire:model="alamat_lengkap" class="form-control" rows="3" placeholder="Masukkan nama jalan, nomor rumah, RT/RW"></textarea>
            @error('alamat_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3 form-check ms-3">
            <input type="checkbox" wire:model="is_utama" id="is_utama" class="form-check-input" value="1">
            <label class="form-check-label ms-1" for="is_utama">Jadikan Alamat Utama</label>
            @error('is_utama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select wire:model="jenis_kelamin" class="form-control">
                <option value="">-- pilih --</option>
                <option value="Pria">Pria</option>
                <option value="Wanita">Wanita</option>
            </select>
            @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2 mt-2">
            <button
                wire:click="update"
                wire:loading.attr="disabled"
                class="btn btn-primary">
                <span wire:loading wire:target="update">
                    <span class="spinner-border spinner-border-sm me-1"></span>
                </span>
                <span wire:loading.remove wire:target="update">
                    <i class="bi bi-save me-1"></i>
                </span>
                Update
            </button>
            <a href="{{ route('pekerja.pelanggan.index') }}"
                wire:navigate
                class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

    </div>
</div>