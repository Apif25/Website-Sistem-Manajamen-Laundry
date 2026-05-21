{{-- resources/views/livewire/pekerja/keuangan/form.blade.php --}}
<div>

    {{-- Modal --}}
    <div
        class="modal fade @if($showModal) show d-block @endif"
        tabindex="-1"
        @if($showModal)
        style="background-color: rgba(0,0,0,0.5);"
        @endif>

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">

                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-wallet2 me-2"></i>

                        {{ $mode === 'edit'
                            ? 'Edit Data Keuangan'
                            : 'Tambah Data Keuangan'
                        }}
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        wire:click="closeModal">
                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body">

                    <div class="row g-3">

                        {{-- Pembayaran --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Pembayaran
                            </label>

                            <select
                                wire:model.live="id_pembayaran"
                                class="form-select @error('id_pembayaran') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Pembayaran --
                                </option>

                                @forelse ($pembayaranList as $pembayaran)

                                <option value="{{ $pembayaran->id_pembayaran }}">
                                    Pembayaran #{{ $pembayaran->id_pembayaran }}
                                </option>

                                @empty

                                <option disabled>
                                    Data pembayaran tidak tersedia
                                </option>

                                @endforelse

                            </select>

                            @error('id_pembayaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Tanggal --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Tanggal
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                wire:model.live="tanggal"
                                type="datetime-local"
                                class="form-control @error('tanggal') is-invalid @enderror">

                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Jenis --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Jenis
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                wire:model.live="jenis"
                                class="form-select @error('jenis') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Jenis --
                                </option>

                                @foreach ($jenisList as $item)

                                <option value="{{ $item }}">
                                    {{ $item }}
                                </option>

                                @endforeach

                            </select>

                            @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Kategori --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Kategori
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                wire:model.live="kategori"
                                class="form-select @error('kategori') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($kategoriList as $item)

                                <option value="{{ $item }}">
                                    {{ $item }}
                                </option>

                                @endforeach

                            </select>

                            @error('kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Jumlah --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Jumlah
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    wire:model.live="jumlah"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    placeholder="0"
                                    class="form-control @error('jumlah') is-invalid @enderror">

                                @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Pekerja --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-medium">
                                Pekerja
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                wire:model.live="id_pekerja"
                                class="form-select @error('id_pekerja') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Pekerja --
                                </option>

                                @forelse ($pekerjaList as $pekerja)

                                <option value="{{ $pekerja->id_pekerja }}">
                                    {{ $pekerja->nama_pekerja}}
                                </option>

                                @empty

                                <option disabled>
                                    Data pekerja tidak tersedia
                                </option>

                                @endforelse

                            </select>

                            @error('id_pekerja')
                            <div class="invalid-feedback">
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
                                wire:model.live="keterangan"
                                rows="3"
                                placeholder="Masukkan keterangan..."
                                class="form-control @error('keterangan') is-invalid @enderror"></textarea>

                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

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

                        <span wire:loading.remove wire:target="save">

                            {{ $mode === 'edit'
                                ? 'Simpan Perubahan'
                                : 'Tambah'
                            }}

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