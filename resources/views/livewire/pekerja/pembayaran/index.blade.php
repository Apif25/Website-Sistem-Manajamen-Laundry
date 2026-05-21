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
                <nav
                    aria-label="breadcrumb"
                    class="breadcrumb-header float-start float-lg-end">

                    <ol class="breadcrumb mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li
                            class="breadcrumb-item active"
                            aria-current="page">

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

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif

    {{-- Card --}}
    <div class="card">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">

            <div>
                <h4 class="card-title mb-0">
                    Data Pembayaran
                </h4>

                <small class="text-muted">
                    Daftar seluruh data pembayaran
                </small>
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
                            <th width="18%" class="text-center">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($pembayarans as $pembayaran)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

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

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    <button
                                        wire:click="openShow({{ $pembayaran->id_pembayaran }})"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @role('petugas')
                                    <button
                                        wire:click="openEdit({{ $pembayaran->id_pembayaran }})"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endrole
                                    @role('petugas')
                                    <button
                                        wire:click="delete({{ $pembayaran->id_pembayaran }})"
                                        wire:confirm="Yakin ingin menghapus data pembayaran ini?"
                                        class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash me-1"></i>
                                    </button>
                                    @endrole
                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td
                                colspan="5"
                                class="text-center text-muted py-4">
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
    {{-- Modal Show Pembayaran --}}
    @if($detail)
    <div class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0,0,0,0.5)">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Detail Pembayaran
                    </h5>

                    <button class="btn-close"
                        wire:click="$set('detail', null)">
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    <table class="table table-borderless">

                        <tr>
                            <th>ID Pesanan</th>
                            <td>#{{ $detail->id_pesanan }}</td>
                        </tr>

                        <tr>
                            <th>Harga</th>
                            <td>
                                Rp {{ number_format($detail->harga_pembayaran, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tanggal</th>
                            <td>
                                {{ \Carbon\Carbon::parse($detail->tanggal_pembayaran)->format('d M Y H:i') }}
                            </td>
                        </tr>

                    </table>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary"
                        wire:click="closeShow"">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>