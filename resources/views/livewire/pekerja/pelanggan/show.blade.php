<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h3 class="fw-bold mb-1">Detail Pelanggan</h3>
                <p class="text-muted mb-0">
                    Informasi lengkap data pelanggan
                </p>
            </div>

            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.pelanggan.index') }}">Pelanggan</a>
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

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Data Pelanggan
                </h5>

                <a href="{{ route('pekerja.pelanggan.index') }}"
                    wire:navigate
                    class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <!-- Nama -->
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Nama Pelanggan
                            </small>
                            <div class="fw-bold fs-6">
                                {{ $pelanggan->nama_pelanggan }}
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Email
                            </small>
                            <div class="fw-bold fs-6">
                                {{ $pelanggan->email }}
                            </div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Nomor Telepon
                            </small>
                            <div class="fw-bold fs-6">
                                {{ $pelanggan->no_telepon ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Jenis Kelamin
                            </small>

                            <span class="badge {{ $pelanggan->jenis_kelamin === 'Pria' ? 'bg-primary' : 'bg-danger' }}">
                                {{ $pelanggan->jenis_kelamin }}
                            </span>
                        </div>
                    </div>

                    <!-- Alamat full -->
                    <div class="col-12">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">
                            <small class="text-muted d-block mb-1">
                                Alamat
                            </small>
                            <div class="fw-semibold">
                                {{ $pelanggan->alamat ?? '-' }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>
</div>