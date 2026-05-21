<div class="container">

    <h3>Edit Pemesanan</h3>

    @if (session()->has('success'))
    <div class="alert bg-success text-white">
        {{ session('success') }}
    </div>
    @endif

    <div class="card p-4">

        {{-- Pelanggan --}}
        <div class="mb-3">
            <label>Pelanggan</label>

            <select wire:model="id_pelanggan" class="form-control">
                <option value="">-- pilih pelanggan --</option>

                @foreach ($pelanggan as $item)
                <option value="{{ $item->id_pelanggan }}">
                    {{ $item->nama_pelanggan }}
                </option>
                @endforeach
            </select>

            @error('id_pelanggan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Jenis Pemesanan --}}
        <div class="mb-3">
            <label>Jenis Pemesanan</label>

            <select wire:model="jenis_pemesanan" class="form-control">
                <option value="">-- pilih jenis --</option>
                <option value="Kiloan">Kiloan</option>
                <option value="Satuan">Satuan</option>
            </select>

            @error('jenis_pemesanan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Layanan --}}
        <div class="mb-3">
            <label>Layanan Pemesanan</label>

            <select wire:model="layanan_pemesanan" class="form-control">
                <option value="">-- pilih layanan --</option>
                <option value="Cepat">Cepat</option>
                <option value="Biasa">Biasa</option>
            </select>

            @error('layanan_pemesanan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Jumlah Barang --}}
        <div class="mb-3">
            <label>Jumlah Barang</label>

            <input
                type="number"
                wire:model="jumlah_brg"
                class="form-control">

            @error('jumlah_brg')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tanggal Pemesanan --}}
        <div class="mb-3">
            <label>Tanggal Pemesanan</label>

            <input
                type="date"
                wire:model="tanggal_pemesanan"
                class="form-control">

            @error('tanggal_pemesanan')
            <small class="text-danger">{{ $message }}</small>
            @enderror
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
            <a href="{{ route('pekerja.pemesanan.index') }}"
                wire:navigate
                class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

    </div>
</div>