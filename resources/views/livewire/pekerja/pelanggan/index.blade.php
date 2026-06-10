<div>
    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Pelanggan</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh pelanggan laundry
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

                            Pelanggan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div
        class="alert alert-success alert-dismissible fade show"
        role="alert">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    @if (session()->has('error'))
    <div
        class="alert alert-danger alert-dismissible fade show"
        role="alert">

        {{ session('error') }}

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
                    Data Pelanggan
                </h4>

                <small class="text-muted">
                    Daftar seluruh data pelanggan
                </small>
            </div>

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
                            placeholder="Cari pelanggan...">

                    </div>

                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telepon</th>
                            <th>Jenis Kelamin</th>
                            <th> Alamat </th>
                            <th width="20%" class="text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pelanggans as $index => $pelanggan)

                        <tr>

                            {{-- ID --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            {{-- Foto --}}
                            <td>
                                @if ($pelanggan->foto_profil)

                                <img src="{{ asset('storage/pelanggan/foto-pelanggan/' . $pelanggan->foto_profil) }}"
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    style="object-fit: cover;">

                                @else

                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <span class="text-white fw-bold">
                                        {{ strtoupper(substr($pelanggan->nama_pelanggan, 0, 1)) }}
                                    </span>
                                </div>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $pelanggan->nama_pelanggan }}
                                </div>
                            </td>

                            {{-- Email --}}
                            <td>
                                {{ $pelanggan->email }}
                            </td>

                            {{-- Telepon --}}
                            <td>
                                {{ $pelanggan->no_telepon }}
                            </td>

                            {{-- Jenis Kelamin --}}
                            <td>

                                @if ($pelanggan->jenis_kelamin == 'Pria')

                                <span class="badge bg-info">
                                    Pria
                                </span>

                                @else

                                <span class="badge bg-pink">
                                    Wanita
                                </span>

                                @endif

                            </td>

                            {{-- Alamat --}}
                            {{-- Alamat --}}
                            <td>
                                @php
                                $alamat = collect([
                                $pelanggan->alamat,
                                $pelanggan->village?->name,
                                $pelanggan->district?->name,
                                $pelanggan->city?->name,
                                $pelanggan->province?->name,
                                ])->filter()->implode(', ');
                                @endphp

                                {{ $alamat ?: '-' }}
                            </td>



                            {{-- Aksi --}}
                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('pekerja.pelanggan.show', $pelanggan->id_pelanggan) }}"
                                        class="btn btn-sm btn-info">

                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('pekerja.pelanggan.edit', $pelanggan->id_pelanggan) }}"
                                        class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <button
                                        wire:click="delete({{ $pelanggan->id_pelanggan }})"
                                        wire:confirm="Yakin ingin menghapus pelanggan ini?"
                                        class="btn btn-sm btn-danger">

                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">

                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>

                                Data pelanggan tidak ditemukan

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>