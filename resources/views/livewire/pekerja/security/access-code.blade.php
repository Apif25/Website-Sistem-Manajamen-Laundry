<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7 col-12">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">

                {{-- ICON --}}
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                        style="width:80px;height:80px;">
                        <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
                    </div>
                </div>

                {{-- TITLE --}}
                <div class="text-center mb-3">
                    <h4 class="fw-bold mb-1">Buat Kode Akses</h4>
                    <p class="text-muted small mb-0">
                        Keamanan tambahan untuk mengakses data sensitif
                    </p>
                </div>

                <hr>

                {{-- FORM --}}
                <form wire:submit="save">

                    {{-- ACCESS CODE --}}
                    <div class="mb-3">
                        <label class="form-label">Kode Akses</label>

                        <input
                            type="password"
                            class="form-control form-control-lg"
                            wire:model="access_code"
                            placeholder="Masukkan 6 digit kode">

                        @error('access_code')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- CONFIRM --}}
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Kode Akses</label>

                        <input
                            type="password"
                            class="form-control form-control-lg"
                            wire:model="access_code_confirmation"
                            placeholder="Ulangi kode akses">
                    </div>

                    {{-- INFO BOX --}}
                    <div class="alert alert-warning small">
                        <i class="bi bi-info-circle me-1"></i>
                        Kode ini akan digunakan setiap kali mengakses Data Pekerja & Pelanggan.
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-shield-check me-1"></i>
                        Simpan Kode Akses
                    </button>

                </form>

            </div>
        </div>

        {{-- FOOTER TEXT --}}
        <div class="text-center mt-3">
            <small class="text-muted">
                Sistem keamanan tambahan untuk melindungi data
            </small>
        </div>

    </div>
</div>