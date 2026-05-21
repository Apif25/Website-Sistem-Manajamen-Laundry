{{-- resources/views/livewire/pekerja/stock-barang/form.blade.php --}}
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
                        Edit Data Stock
                        @else
                        Tambah Data Stock
                        @endif
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nama Produk --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Nama Produk <span class="text-danger">*</span>
                            </label>

                            <input wire:model="nama_produk" type="text"
                                placeholder="Contoh: Deterjen Cair"
                                class="form-control @error('nama_produk') is-invalid @enderror">

                            @error('nama_produk')
                            <div class="invalid-feedback d-block mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div class="col-12">
                            <label class="form-label fw-medium">
                                Stock <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <input wire:model="stock_produk" type="number"
                                    min="0" step="1"
                                    placeholder="0"
                                    class="form-control @error('stock_produk') is-invalid @enderror">
                                <span class="input-group-text">unit</span>
                            </div>

                            @error('stock_produk')
                            <div class="invalid-feedback d-block mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

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