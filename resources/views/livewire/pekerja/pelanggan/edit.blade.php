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

        <div class="mb-3">
            <label>Alamat</label>
            <textarea wire:model="alamat" class="form-control"></textarea>
            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
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