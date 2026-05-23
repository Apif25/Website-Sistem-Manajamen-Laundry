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
                    <h4 class="fw-bold mb-1">Verifikasi Kode Akses</h4>
                    <p class="text-muted small mb-0">
                        Masukkan kode akses untuk melanjutkan ke data sensitif
                    </p>
                </div>

                <hr>

                {{-- FORM --}}
                <form wire:submit="verify">

                    <div class="mb-3">
                        <label class="form-label">Kode Akses</label>

                        <input
                            type="password"
                            class="form-control form-control-lg text-center tracking-wide"
                            wire:model="access_code"
                            placeholder="••••••">

                        @error('access_code')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- INFO --}}
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i>
                        Kode ini digunakan untuk mengamankan akses Data Pekerja & Pelanggan.
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-shield-lock"></i>
                        Verifikasi & Lanjutkan
                    </button>

                </form>

            </div>
        </div>

        {{-- FOOTER --}}
        <div class="text-center mt-3">
            <small class="text-muted">
                Sistem keamanan tambahan aktif
            </small>
        </div>

    </div>
</div>