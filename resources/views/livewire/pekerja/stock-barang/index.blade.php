<div>
    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Stock Barang</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh stock barang laundry
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Stock Barang
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div wire:key="success-alert"
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
                <h4 class="card-title mb-0">Data Stock Barang</h4>
                <small class="text-muted">Daftar seluruh data stock barang</small>
            </div>
            @role('petugas')
            <button wire:click="openCreate" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Stock
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
                            placeholder="Cari stock barang...">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nama Produk</th>
                            <th>Stock</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($stocks as $stock)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-medium">
                                {{ $stock->nama_produk }}
                            </td>

                            <td>
                                @if ($stock->stock_produk <= 5)
                                    <span class="badge bg-danger">
                                    {{ $stock->stock_produk }} item
                                    </span>
                                    @elseif ($stock->stock_produk <= 20)
                                        <span class="badge bg-warning text-dark">
                                        {{ $stock->stock_produk }} item
                                        </span>
                                        @else
                                        <span class="badge bg-success">
                                            {{ $stock->stock_produk }} item
                                        </span>
                                        @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button wire:click="openShow({{ $stock->id_stock }})"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @role('petugas')
                                    <button
                                        wire:click="openEdit({{ $stock->id_stock }})"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endrole
                                    @role('petugas')
                                    <button
                                        wire:click="delete({{ $stock->id_stock }})"
                                        wire:confirm="Yakin ingin menghapus data stock ini?"
                                        class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash me-1"></i>
                                    </button>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data stock barang tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- Modal Form --}}
    @livewire('pekerja.stock-barang.form')
    {{-- SHOW STOCK MODAL --}}
    @if($detail)
    <div class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0,0,0,0.5)">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Detail Stock Barang
                    </h5>

                    <button class="btn-close"
                        wire:click="closeShow">
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    <table class="table table-borderless">

                        <tr>
                            <th>Nama Produk</th>
                            <td>{{ $detail->nama_produk }}</td>
                        </tr>

                        <tr>
                            <th>Stock</th>
                            <td>
                                {{ $detail->stock_produk }} unit
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($detail->stock_produk <= 5)
                                    <span class="badge bg-danger">Stok Menipis</span>
                                    @elseif($detail->stock_produk <= 20)
                                        <span class="badge bg-warning text-dark">Stok Cukup</span>
                                        @else
                                        <span class="badge bg-success">Stok Aman</span>
                                        @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Dibuat</th>
                            <td>
                                {{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y H:i') }}
                            </td>
                        </tr>

                    </table>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button class="btn btn-secondary"
                        wire:click="closeShow">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>