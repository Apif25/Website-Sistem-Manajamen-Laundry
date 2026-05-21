<div class="page-heading">

    <div class="page-title mb-3">
        <h3>Tambah Pekerja</h3>
        <p class="text-subtitle text-muted">Form untuk menambahkan data pekerja baru</p>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form wire:submit.prevent="simpan">

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Pekerja</label>
                        <input type="text" wire:model="nama_pekerja" class="form-control">
                        @error('nama_pekerja') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" wire:model="no_telepon" class="form-control">
                        @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea wire:model="alamat" class="form-control"></textarea>
                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select wire:model="jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" wire:model="foto" class="form-control">

                        {{-- Preview --}}
                        @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}" class="mt-2 rounded" width="100">
                        @endif

                        @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
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
                        <a href="{{ route('pekerja.index') }}"
                            wire:navigate
                            class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>