<div class="container">
    <h3>Edit Pekerja</h3>

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
            <label>Email</label>
            <input type="email" wire:model="email" class="form-control">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
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

        <div class="d-flex gap-2">
            <button wire:click="update" class="btn btn-primary">Update</button>
            <a href="{{ route('pekerja.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

    </div>
</div>