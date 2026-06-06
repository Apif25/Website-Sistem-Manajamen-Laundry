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
                            wire:model.live="id_pesanan"
                            class="form-select @error('id_pesanan') is-invalid @enderror">

                            <option value="">-- Pilih Pesanan --</option>

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
                                step="1"
                                readonly
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

                    {{-- Informasi Snap --}}
                    @if($mode === 'create')

                    <div class="alert alert-info border-0">
                        <div class="d-flex">
                            <i class="bi bi-credit-card me-2"></i>
                            <div>
                                Setelah klik <strong>Buat Pembayaran</strong>,
                                popup Midtrans akan muncul dan pelanggan dapat
                                memilih metode pembayaran seperti QRIS,
                                GoPay, ShopeePay, Virtual Account, dan lainnya.
                            </div>
                        </div>
                    </div>

                    @endif

                    {{-- Status Pembayaran --}}
                    @if($status_pembayaran)

                    <div class="mb-3">

                        <label class="form-label fw-medium">
                            Status Pembayaran
                        </label>

                        <div>

                            @if($status_pembayaran === 'settlement')

                            <span class="badge bg-success fs-6">
                                Lunas
                            </span>

                            @elseif($status_pembayaran === 'pending')

                            <span class="badge bg-warning text-dark fs-6">
                                Menunggu Pembayaran
                            </span>

                            @elseif(in_array($status_pembayaran, ['expire', 'cancel', 'deny']))

                            <span class="badge bg-danger fs-6">
                                {{ strtoupper($status_pembayaran) }}
                            </span>

                            @else

                            <span class="badge bg-secondary fs-6">
                                {{ strtoupper($status_pembayaran) }}
                            </span>

                            @endif

                        </div>

                    </div>

                    @endif

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

                            {{ $mode === 'edit'
                                ? 'Simpan'
                                : 'Buat Pembayaran' }}

                        </span>

                        <span
                            wire:loading
                            wire:target="save">

                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...

                        </span>

                    </button>

                </div>

            </div>
        </div>
    </div>

    {{-- Midtrans Snap --}}
    @if($snap_token)

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('open-snap', (event) => {

                const token = event.token;

                if (!token) {
                    return;
                }

                snap.pay(token, {

                    onSuccess: function(result) {
                        Livewire.dispatch('refresh-payment-status');
                    },

                    onPending: function(result) {
                        Livewire.dispatch('refresh-payment-status');
                    },

                    onError: function(result) {
                        console.error(result);
                    },

                    onClose: function() {
                        Livewire.dispatch('refresh-payment-status');
                    }
                });

            });

        });
    </script>
    @endif
</div>