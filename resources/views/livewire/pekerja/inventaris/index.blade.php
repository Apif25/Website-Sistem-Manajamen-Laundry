<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Inventaris</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh inventaris barang
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Inventaris</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Flash --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Card --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Inventaris</h4>
                <small class="text-muted">Daftar barang inventaris</small>
            </div>
            @role('petugas')
            <button wire:click="openCreate" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Inventaris
            </button>
            @endrole
        </div>

        <div class="card-body">

            {{-- Search --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                            wire:model.live.debounce.400ms="search"
                            class="form-control"
                            placeholder="Cari inventaris...">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($inventaris as $item)
                        <tr>
                            <td>{{ $item->id_barang }}</td>

                            <td class="fw-medium">
                                {{ $item->nama_barang }}
                            </td>

                            <td>
                                {{ $item->jumlah_barang }}
                            </td>

                            <td>
                                @if($item->status == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>

                            <td style="max-width: 220px;">

                                <div
                                    class="text-truncate text-muted"
                                    title="{{ $item->keterangan }}">

                                    {{ $item->keterangan }}

                                </div>

                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y H:i') }}
                            </td>

                            <td class="text-center">
                                <button wire:click="openShow({{ $item->id_barang }})"
                                    class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @role('petugas')
                                <button wire:click="openEdit({{ $item->id_barang }})"
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @endrole
                                @role('petugas')
                                <button wire:click="delete({{ $item->id_barang }})"
                                    wire:confirm="Hapus data ini?"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endrole
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- Modal --}}
    @livewire('pekerja.inventaris.form')
    {{-- SHOW INVENTARIS MODAL --}}
    @if($detail)
    <div class="modal fade show d-block"
        tabindex="-1"
        style="background-color: rgba(0,0,0,0.5)">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                {{-- Header --}}
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Detail Inventaris
                    </h5>

                    <button class="btn-close"
                        wire:click="closeShow">
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    <table class="table table-borderless">

                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $detail->nama_barang }}</td>
                        </tr>

                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $detail->jumlah_barang }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($detail->status == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $detail->keterangan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal</th>
                            <td>
                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('d M Y H:i') }}
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