<div class="page-heading">

    <div class="page-title mb-3">
        <h3>Tambah Pemesanan</h3>
        <p class="text-subtitle text-muted">
            Form untuk menambahkan data pemesanan baru
        </p>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form wire:submit.prevent="save">

                    {{-- Pelanggan --}}
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>

                        <select wire:model="id_pelanggan" class="form-control">
                            <option value="">Pilih Pelanggan</option>

                            @foreach ($pelanggans as $item)
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
                        <label class="form-label">Jenis Pemesanan</label>

                        <select wire:model="jenis_pemesanan" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Kiloan">Kiloan</option>
                            <option value="Satuan">Satuan</option>
                        </select>

                        @error('jenis_pemesanan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Layanan --}}
                    <div class="mb-3">
                        <label class="form-label">Layanan Pemesanan</label>

                        <select wire:model="layanan_pemesanan" class="form-control">
                            <option value="">Pilih Layanan</option>
                            <option value="Cepat">Cepat</option>
                            <option value="Biasa">Biasa</option>
                        </select>

                        @error('layanan_pemesanan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Jumlah Barang --}}
                    <div class="mb-3">
                        <label class="form-label">Jumlah Barang</label>

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
                        <label class="form-label">Tanggal Pemesanan</label>

                        <input
                            type="date"
                            wire:model="tanggal_pemesanan"
                            class="form-control">

                        @error('tanggal_pemesanan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">

                        <a href="{{ route('pekerja.pemesanan.index') }}"
                            wire:navigate
                            class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                        <button
                            wire:click="save"
                            wire:loading.attr="disabled"
                            class="btn btn-primary">
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                            </span>
                            <span wire:loading.remove wire:target="save">
                                <i class="bi bi-save me-1"></i>
                            </span>
                            Simpan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </section>

</div>