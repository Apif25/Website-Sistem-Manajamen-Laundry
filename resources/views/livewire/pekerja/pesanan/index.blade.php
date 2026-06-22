<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Pesanan</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh pesanan laundry
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
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
                <h4 class="card-title mb-0">Data Pesanan</h4>
                <small class="text-muted">Daftar seluruh data pesanan</small>
            </div>
            @role('petugas')
            <a href="{{ route('pekerja.pesanan.create') }}"
                wire:navigate
                class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Pesanan
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
                            <th>Nama</th>
                            <th>ID Pemesanan</th>
                            <th>Jenis</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $pesanan->pelanggan->nama_pelanggan ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    #{{ $pesanan->id_pemesanan }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $pesanan->jenis_pesanan === 'Kiloan' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                    {{ $pesanan->jenis_pesanan }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $pesanan->layanan_pesanan === 'Cepat' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $pesanan->layanan_pesanan }}
                                </span>
                            </td>

                            <td>
                                {{ $pesanan->berat }}
                                {{ $pesanan->jenis_pesanan === 'Kiloan' ? 'kg' : 'pcs' }}
                            </td>

                            <td>Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</td>

                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y, H:i') }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('pekerja.pesanan.show', $pesanan) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @role('petugas')
                                    <a href="{{ route('pekerja.pesanan.edit', $pesanan) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @endrole

                                    @role('petugas')
                                    <button
                                        wire:click="delete({{ $pesanan->id_pesanan }})"
                                        wire:confirm="Yakin ingin menghapus pesanan ini?"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data pesanan tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>