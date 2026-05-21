{{-- resources/views/livewire/pekerja/pembayaran/form.blade.php --}}

<div>

    {{-- Modal --}}
    <div
        class="modal fade {{ $showModal ? 'show d-block' : '' }}"
        tabindex="-1"
        @if($showModal)
        style="background-color: rgba(0,0,0,0.5);"
        @endif>

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        {{ $mode === 'edit' ? 'Edit Pembayaran' : 'Tambah Pembayaran' }}
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        wire:click="closeModal">
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    {{-- Pesanan --}}
                    <div class="mb-3">

                        <label class="form-label fw-medium">
                            Pesanan
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            wire:model="id_pesanan"
                            class="form-select @error('id_pesanan') is-invalid @enderror">

                            <option value="">
                                -- Pilih Pesanan --
                            </option>

                            @foreach ($pesananList as $pesanan)
                            <option value="{{ $pesanan->id_pesanan }}">
                                Pesanan #{{ $pesanan->id_pesanan }}
                            </option>
                            @endforeach

                        </select>

                        @error('id_pesanan')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Harga Pembayaran --}}
                    <div class="mb-3">

                        <label class="form-label fw-medium">
                            Harga Pembayaran
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                wire:model="harga_pembayaran"
                                min="0"
                                step="0.01"
                                placeholder="0"
                                class="form-control @error('harga_pembayaran') is-invalid @enderror">

                        </div>

                        @error('harga_pembayaran')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Tanggal Pembayaran --}}
                    <div class="mb-3">

                        <label class="form-label fw-medium">
                            Tanggal Pembayaran
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="datetime-local"
                            wire:model="tanggal_pembayaran"
                            class="form-control @error('tanggal_pembayaran') is-invalid @enderror">

                        @error('tanggal_pembayaran')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        wire:click="closeModal">

                        Batal
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="save">

                        <span
                            wire:loading.remove
                            wire:target="save">

                            {{ $mode === 'edit' ? 'Simpan' : 'Tambah' }}
                        </span>

                        <span
                            wire:loading
                            wire:target="save">

                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Menyimpan...
                        </span>

                    </button>

                </div>

            </div>
        </div>
    </div>

</div>