<div>
    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1">Manajemen Pekerja</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola data seluruh pekerja laundry
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Pekerja
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
                <h4 class="card-title mb-0">Data Pekerja</h4>
                <small class="text-muted">Daftar seluruh data pekerja</small>
            </div>

            <a href="{{ route('pekerja.create') }}"
                wire:navigate
                class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Pekerja
            </a>

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
                            placeholder="Cari nama atau email...">
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
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Role</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($pekerjaDaftar as $pekerja)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if ($pekerja->foto)

                                <img src="{{ Storage::url($pekerja->foto) }}"
                                    class="rounded-circle"
                                    width="40"
                                    height="40"
                                    style="object-fit: cover;">

                                @else

                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">

                                    <span class="text-white fw-bold">
                                        {{ strtoupper(substr($pekerja->nama_pekerja, 0, 1)) }}
                                    </span>

                                </div>

                                @endif
                            </td>

                            <td class="fw-semibold">
                                {{ $pekerja->nama_pekerja }}
                            </td>

                            <td>{{ $pekerja->email }}</td>

                            <td>{{ $pekerja->no_telepon ?? '-' }}</td>

                            <td>{{ $pekerja->alamat }}</td>

                            <td>
                                <span class="badge {{ $pekerja->jenis_kelamin === 'Pria' ? 'bg-info' : 'bg-pink' }}">
                                    {{ $pekerja->jenis_kelamin }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $pekerja->roles->pluck('name')->join(', ') }}
                                </span>
                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('pekerja.show', $pekerja->id_pekerja) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('pekerja.edit', $pekerja->id_pekerja) }}"
                                        wire:navigate
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- DELETE (SAMAIN DENGAN STYLE PELANGGAN) --}}
                                    <button
                                        wire:click="delete({{ $pekerja->id_pekerja }})"
                                        wire:confirm="Yakin ingin menghapus pekerja ini?"
                                        class="btn btn-sm btn-danger">

                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-database-x fs-4 d-block mb-2"></i>
                                Data pekerja tidak ditemukan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>