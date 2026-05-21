<div class="page-heading">
    <div class="page-title mb-3">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pekerja</h3>
                <p class="text-subtitle text-muted">
                    Informasi lengkap data pekerja
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb"
                    class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.index') }}">
                                Pekerja
                            </a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Detail
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    Data Pekerja
                </h4>

                <a href="{{ route('pekerja.index') }}"
                    wire:navigate
                    class="btn btn-danger">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">
                    @if ($pekerja->foto)
                    <img src="{{ Storage::url($pekerja->foto) }}"
                        alt="Foto {{ $pekerja->nama_pekerja }}"
                        class="rounded-circle shadow"
                        width="120"
                        height="120"
                        style="object-fit: cover;">
                    @else
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow"
                        style="width:120px;height:120px;">
                        <span class="text-white fw-bold fs-1">
                            {{ strtoupper(substr($pekerja->nama_pekerja, 0, 1)) }}
                        </span>
                    </div>
                    @endif
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Nama Pekerja
                            </small>

                            <strong>
                                {{ $pekerja->nama_pekerja }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Email
                            </small>

                            <strong>
                                {{ $pekerja->email }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Nomor Telepon
                            </small>

                            <strong>
                                {{ $pekerja->no_telepon ?? '-' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Jenis Kelamin
                            </small>

                            <span class="badge {{ $pekerja->jenis_kelamin === 'Pria' ? 'bg-info' : 'bg-pink' }}">
                                {{ $pekerja->jenis_kelamin }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="border rounded p-3 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Alamat
                            </small>

                            <strong>
                                {{ $pekerja->alamat ?? '-' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="border rounded p-3 bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Role
                            </small>

                            <span class="badge bg-success">
                                {{ $pekerja->roles->pluck('name')->join(', ') }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>