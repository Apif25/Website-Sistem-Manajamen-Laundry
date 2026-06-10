<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Pemesanan</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh pemesanan laundry
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pemesanan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Card --}}
    <div class="card">

        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Pemesanan</h4>
                <small class="text-muted">Daftar seluruh data pemesanan</small>
            </div>

            @role('petugas')
            <a href="{{ route('pekerja.pemesanan.create') }}"
                wire:navigate
                class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah
            </a>
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
                            wire:model.live="search"
                            class="form-control"
                            placeholder="Cari nama pelanggan atau jenis...">
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Pemesanan</th>
                            <th>Layanan</th>
                            <th>Jumlah Brg</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pemesanans as $pemesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $pemesanan->pelanggan->nama_pelanggan ?? '-' }}
                            </td>

                            <td>
                                <span class="badge {{ $pemesanan->jenis_pemesanan === 'Kiloan' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                    {{ $pemesanan->jenis_pemesanan }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $pemesanan->layanan_pemesanan === 'Cepat' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $pemesanan->layanan_pemesanan }}
                                </span>
                            </td>

                            <td>{{ $pemesanan->jumlah_brg }}</td>

                            <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d M Y, H:i') }}</td>

                            <td>
                                <span class="badge {{ $pemesanan->status_pemesanan === 'Diproses' ? 'bg-primary' : ($pemesanan->status_pemesanan === 'Selesai' ? 'bg-success' : 'bg-danger') }}">
                                    {{ $pemesanan->status_pemesanan }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('pekerja.pemesanan.show', $pemesanan->id_pemesanan) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @role('petugas')
                                    <a href=" {{ route('pekerja.pemesanan.edit', $pemesanan->id_pemesanan) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @endrole

                                    @role('petugas')
                                    <button
                                        wire:click="delete({{ $pemesanan->id_pemesanan }})"
                                        wire:confirm="Yakin ingin menghapus pemesanan ini?"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data pemesanan tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>