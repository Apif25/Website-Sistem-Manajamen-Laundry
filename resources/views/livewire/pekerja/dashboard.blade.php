<div class="container-fluid">

    {{-- Greeting --}}
    <div class="mb-4">
        <h4 class="fw-bold">
            Halo, {{ $user->nama_pekerja }} 
        </h4>

        <small class="text-muted">
            Role:
            <span class="badge bg-primary">
                {{ ucfirst($role) }}
            </span>
        </small>
    </div>

    {{-- Cards --}}
    <div class="row g-3">

        {{-- Total Pekerja --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Total Pekerja
                        </h6>

                        <h3 class="fw-bold mb-0">
                            {{ $totalPekerja }}
                        </h3>
                    </div>

                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-people-fill text-primary fs-3"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Total Pelanggan
                        </h6>

                        <h3 class="fw-bold mb-0">
                            {{ $totalPelanggan }}
                        </h3>
                    </div>

                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-person-badge-fill text-success fs-3"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center justify-content-between">

                    <div>
                        <h6 class="text-muted mb-2">
                            Status Sistem
                        </h6>

                        <h5 class="fw-bold text-success mb-0">
                            Aktif
                        </h5>
                    </div>

                    <div class="bg-warning bg-opacity-10 p-3 rounded">
                        <i class="bi bi-shield-check text-warning fs-3"></i>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>