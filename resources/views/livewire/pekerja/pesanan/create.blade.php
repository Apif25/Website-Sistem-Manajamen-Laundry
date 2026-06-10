<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Tambah Pesanan</h3>
                <p class="text-subtitle text-muted mb-0">Buat data pesanan baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.pesanan.index') }}" wire:navigate>Pesanan</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Form Tambah Pesanan</h4>
        </div>
        <div class="card-body">

            <div class="row">

                {{-- Pemesanan --}}
                <div class="col-12 col-md-6 mb-3">
                    <label for="id_pemesanan" class="form-label">
                        Pemesanan <span class="text-danger">*</span>
                    </label>
                    <select
                        wire:model.live="id_pemesanan"
                        id="id_pemesanan"
                        class="form-select @error('id_pemesanan') is-invalid @enderror">
                        <option value="">-- Pilih Pemesanan --</option>
                        @foreach ($pemesanans as $pemesanan)
                        <option value="{{ $pemesanan->id_pemesanan }}">
                            #{{ $pemesanan->id_pemesanan }} - {{ $pemesanan->pelanggan->nama_pelanggan ?? '-' }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_pemesanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pelanggan (auto-fill) --}}
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">
                        Pelanggan <span class="text-danger">*</span>
                    </label>

                    <div class="form-control bg-light">
                        @if($id_pelanggan)
                        {{ $pelanggans->firstWhere('id_pelanggan', $id_pelanggan)?->nama_pelanggan }}
                        ({{ $pelanggans->firstWhere('id_pelanggan', $id_pelanggan)?->email }})
                        @else
                        Belum ada pelanggan dipilih
                        @endif
                    </div>

                    @error('id_pelanggan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if ($id_pelanggan)
                    <small class="text-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Pelanggan otomatis terisi dari pemesanan
                    </small>
                    @endif
                </div>
                {{-- Jenis Pesanan --}}
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">
                        Jenis Pesanan <span class="text-danger">*</span>
                    </label>

                    <div class="form-control bg-light">
                        {{ $jenis_pesanan ?: 'Belum dipilih' }}
                    </div>

                    <input type="hidden" wire:model="jenis_pesanan">

                    @error('jenis_pesanan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Layanan Pesanan --}}
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label">
                        Layanan Pesanan <span class="text-danger">*</span>
                    </label>

                    <div class="form-control bg-light">
                        {{ $layanan_pesanan ?: 'Belum dipilih' }}
                    </div>

                    <input type="hidden" wire:model="layanan_pesanan">

                    @error('layanan_pesanan')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Berat --}}
                <div class="col-12 col-md-6 mb-3">
                    <label for="berat" class="form-label">
                        Berat <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input
                            type="number"
                            wire:model="berat"
                            id="berat"
                            step="0.1"
                            min="0.1"
                            class="form-control @error('berat') is-invalid @enderror"
                            placeholder="Contoh: 2.5">
                        <span class="input-group-text">
                            {{ $jenis_pesanan === 'Kiloan' ? 'kg' : 'pcs' }}
                        </span>
                        @error('berat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Harga --}}
                <div class="col-12 col-md-6 mb-3">
                    <label for="harga" class="form-label">
                        Harga <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input
                            type="number"
                            wire:model="harga"
                            id="harga"
                            step="0.01"
                            min="0"
                            class="form-control @error('harga') is-invalid @enderror"
                            placeholder="Contoh: 15000">
                        @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tanggal Pesanan --}}
                <div class="col-12 col-md-6 mb-3">
                    <label for="tanggal_pesanan" class="form-label">
                        Tanggal Pesanan <span class="text-danger">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        wire:model="tanggal_pesanan"
                        id="tanggal_pesanan"
                        class="form-control @error('tanggal_pesanan') is-invalid @enderror">
                    @error('tanggal_pesanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            {{-- Buttons --}}
            <div class="d-flex justify-content-between align-items-center mt-2">

                <a href="{{ route('pekerja.pesanan.index') }}"
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

        </div>
    </div>

</div>