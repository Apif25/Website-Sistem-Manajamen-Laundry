<div>
    <div class="modal fade @if($showModal) show d-block @endif"
        tabindex="-1"
        @if($showModal) style="background-color: rgba(0,0,0,0.5)" @endif>

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-box-seam me-2"></i>
                        @if($mode === 'edit')
                        Edit Data Inventaris
                        @else
                        Tambah Data Inventaris
                        @endif
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nama Barang --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Nama Barang <span class="text-danger">*</span>
                            </label>

                            <input wire:model="nama_barang" type="text"
                                placeholder="Contoh: Mesin Cuci"
                                class="form-control @error('nama_barang') is-invalid @enderror">

                            @error('nama_barang')
                            <div class="invalid-feedback d-block mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        {{-- Jumlah Barang --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Jumlah Barang <span class="text-danger">*</span>
                            </label>

                            <input wire:model="jumlah_barang" type="number" placeholder="Contoh : 2"
                                class="form-control @error('jumlah_barang') is-invalid @enderror">

                            @error('jumlah_barang')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select wire:model="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>

                            @error('status')
                            <div class="invalid-feedback d-block mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Tanggal <span class="text-danger">*</span>
                            </label>

                            <input wire:model="tanggal" type="datetime-local"
                                class="form-control @error('tanggal') is-invalid @enderror">

                            @error('tanggal')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Kategori <span class="text-danger">*</span>
                            </label>

                            <input wire:model="kategori" type="text"
                                placeholder="Contoh: Elektronik"
                                class="form-control @error('kategori') is-invalid @enderror">

                            @error('kategori')
                            <div class="invalid-feedback d-block mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="col-12">

                            <label class="form-label fw-medium">
                                Keterangan
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                wire:model="keterangan"
                                rows="3"
                                placeholder="Masukkan keterangan..."
                                class="form-control @error('keterangan') is-invalid @enderror"></textarea>

                            @error('keterangan')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            Batal
                        </button>

                        <button type="button" class="btn btn-primary"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            wire:target="save">

                            <span wire:loading.remove wire:target="save">
                                @if($mode === 'edit')
                                Simpan Perubahan
                                @else
                                Tambah
                                @endif
                            </span>

                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Menyimpan...
                            </span>

                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>