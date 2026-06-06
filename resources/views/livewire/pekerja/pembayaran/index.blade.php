<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Pembayaran</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh pembayaran laundry
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pembayaran
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div
        wire:key="success-alert"
        class="alert alert-success alert-dismissible fade show mb-3"
        role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Card --}}
    <div class="card">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Pembayaran</h4>
                <small class="text-muted">Daftar seluruh data pembayaran</small>
            </div>
            @role('petugas')
            <button wire:click="openCreate" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pembayaran
            </button>
            @endrole
        </div>

        {{-- Card Body --}}
        <div class="card-body">

            {{-- Search --}}
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            wire:model.live.debounce.400ms="search"
                            class="form-control"
                            placeholder="Cari pembayaran...">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>ID Pesanan</th>
                            <th>Harga Pembayaran</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pembayarans as $pembayaran)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="badge bg-secondary">
                                    #{{ $pembayaran->id_pesanan }}
                                </span>
                            </td>

                            <td class="fw-semibold">
                                Rp {{ number_format($pembayaran->harga_pembayaran, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y, H:i') }}
                            </td>

                            {{-- Metode Pembayaran --}}
                            <td>
                                @php
                                $metodeLabel = match($pembayaran->payment_type) {
                                'qris' => 'QRIS',
                                'gopay' => 'GoPay',
                                'shopeepay' => 'ShopeePay',
                                'bank_transfer' => 'VA',
                                'echannel' => 'Mandiri VA',
                                'cstore' => 'Alfamart / Indomaret',
                                'snap' => 'Snap',
                                default => 'Manual',
                                };

                                $metodeBadge = match($pembayaran->payment_type) {
                                'qris' => 'bg-primary',
                                'gopay' => 'bg-success',
                                'shopeepay' => 'bg-warning text-dark',
                                'bank_transfer',
                                'echannel' => 'bg-info',
                                'cstore' => 'bg-dark',
                                'snap' => 'bg-primary',
                                default => 'bg-secondary',
                                };
                                @endphp
                                <span class="badge {{ $metodeBadge }}">
                                    {{ $metodeLabel }}
                                </span>
                            </td>

                            {{-- Status Pembayaran --}}
                            <td>
                                @php
                                $statusBadge = match($pembayaran->status_pembayaran ?? null) {
                                'settlement' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'expire' => 'bg-secondary',
                                'cancel' => 'bg-danger',
                                'deny' => 'bg-danger',
                                default => 'bg-info',
                                };
                                $statusLabel = match($pembayaran->status_pembayaran ?? null) {
                                'settlement' => 'Lunas',
                                'pending' => 'Pending',
                                'expire' => 'Expired',
                                'cancel' => 'Dibatalkan',
                                'deny' => 'Ditolak',
                                default => 'Manual',
                                };
                                @endphp
                                <span class="badge {{ $statusBadge }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    {{-- Detail --}}
                                    <button
                                        wire:click="openShow({{ $pembayaran->id_pembayaran }})"
                                        class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    {{-- Bayar via Midtrans — hanya tampil jika belum lunas --}}
                                    @role('petugas')
                                    @if($pembayaran->status_pembayaran !== 'settlement')

                                    <a
                                        href="{{ route('pekerja.pembayaran.proses', $pembayaran->id_pesanan) }}"
                                        class="btn btn-sm btn-success"
                                        title="Bayar Online">

                                        <i class="bi bi-credit-card me-1"></i>
                                        Bayar

                                    </a>

                                    @endif
                                    @endrole

                                    {{-- Edit --}}
                                    @role('petugas')
                                    <button
                                        wire:click="openEdit({{ $pembayaran->id_pembayaran }})"
                                        class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endrole

                                    {{-- Hapus --}}
                                    @role('petugas')
                                    <button
                                        wire:click="delete({{ $pembayaran->id_pembayaran }})"
                                        wire:confirm="Yakin ingin menghapus data pembayaran ini?"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endrole

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data pembayaran tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    @livewire('pekerja.pembayaran.form')

    {{-- Modal Detail Pembayaran --}}
    @if($detail)
    <div
        class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0,0,0,0.5)">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Detail Pembayaran
                    </h5>
                    <button class="btn-close" wire:click="$set('detail', null)"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="40%">ID Pesanan</th>
                            <td>#{{ $detail->id_pesanan }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($detail->harga_pembayaran, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($detail->tanggal_pembayaran)->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Metode</th>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ strtoupper($detail->payment_type ?? 'Manual') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                $sb = match($detail->status_pembayaran ?? null) {
                                'settlement' => 'bg-success',
                                'pending' => 'bg-warning text-dark',
                                'expire' => 'bg-secondary',
                                'cancel', 'deny' => 'bg-danger',
                                default => 'bg-info',
                                };
                                $sl = match($detail->status_pembayaran ?? null) {
                                'settlement' => 'Lunas',
                                'pending' => 'Pending',
                                'expire' => 'Expired',
                                'cancel' => 'Dibatalkan',
                                'deny' => 'Ditolak',
                                default => 'Manual',
                                };
                                @endphp
                                <span class="badge {{ $sb }}">{{ $sl }}</span>
                            </td>
                        </tr>
                        @if($detail->midtrans_order_id)
                        <tr>
                            <th>Order ID</th>
                            <td class="font-monospace small">
                                {{ $detail->midtrans_order_id }}
                            </td>
                        </tr>
                        @endif

                        @if($detail->snap_token)
                        <tr>
                            <th>Snap Token</th>
                            <td>
                                <code class="small">
                                    {{ $detail->snap_token }}
                                </code>
                            </td>
                        </tr>
                        @endif

                        @if($detail->expired_at)
                        <tr>
                            <th>Berlaku Hingga</th>
                            <td class="{{ $detail->expired_at->isPast() ? 'text-danger' : '' }}">
                                {{ $detail->expired_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @endif
                        @if($detail->expired_at)
                        <tr>
                            <th>Berlaku Hingga</th>
                            <td class="{{ $detail->expired_at->isPast() ? 'text-danger' : '' }}">
                                {{ $detail->expired_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @endif
                        @if(
                        $detail->status_pembayaran === 'pending'
                        && $detail->id_pesanan
                        )
                        <tr>
                            <th>Pembayaran</th>
                            <td>
                                <a
                                    href="{{ route('pekerja.pembayaran.proses', $detail->id_pesanan) }}"
                                    class="btn btn-success btn-sm">

                                    <i class="bi bi-credit-card me-1"></i>
                                    Lanjutkan Pembayaran

                                </a>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="closeShow">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>