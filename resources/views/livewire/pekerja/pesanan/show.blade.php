<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row align-items-center">

            <div class="col-12 col-md-6">
                <h3 class="fw-bold mb-1">Detail Pesanan</h3>

                <p class="text-muted mb-0">
                    Informasi lengkap data pesanan pelanggan
                </p>
            </div>

            <div class="col-12 col-md-6">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

                    <ol class="breadcrumb mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.pesanan.index') }}">
                                Pesanan
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

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-semibold">
                    Data Pesanan
                </h5>

                <a href="{{ route('pekerja.pesanan.index') }}"
                    wire:navigate
                    class="btn btn-sm btn-outline-danger">

                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali

                </a>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    {{-- ID Pesanan --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">

                            <small class="text-muted d-block mb-1">
                                ID Pesanan
                            </small>

                            <div class="fw-bold fs-6">
                                {{ $pesanan->id_pesanan ?? '-' }}
                            </div>

                        </div>
                    </div>

                    {{-- Nama Pelanggan --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">

                            <small class="text-muted d-block mb-1">
                                Nama Pelanggan
                            </small>

                            <div class="fw-bold fs-6">
                                {{ $pesanan->pelanggan->nama_pelanggan ?? '-' }}
                            </div>

                        </div>
                    </div>

                    {{-- Berat --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">

                            <small class="text-muted d-block mb-1">
                                Berat
                            </small>

                            <span class="badge bg-primary">
                                {{ $pesanan->berat ?? '-' }} Kg
                            </span>

                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">

                            <small class="text-muted d-block mb-1">
                                Harga
                            </small>

                            <div class="fw-bold fs-6">
                                Rp {{ number_format($pesanan->harga ?? 0, 0, ',', '.') }}
                            </div>

                        </div>
                    </div>

                    {{-- Tanggal Pesanan --}}
                    <div class="col-12">
                        <div class="p-3 rounded border bg-body-tertiary shadow-sm">

                            <small class="text-muted d-block mb-1">
                                Tanggal Pesanan
                            </small>

                            <div class="fw-semibold">
                                {{ $pesanan->tanggal_pesanan ?? '-' }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>