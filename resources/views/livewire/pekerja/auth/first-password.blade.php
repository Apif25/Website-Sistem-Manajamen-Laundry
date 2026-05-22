<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">

                    {{-- ICON --}}
                    <div class="text-center mb-4">
                        <div
                            class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                            style="width:80px;height:80px;">
                            <i class="bi bi-shield-lock fs-1 text-primary"></i>
                        </div>
                    </div>

                    {{-- TITLE --}}
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            Ganti Password Pertama
                        </h3>

                        <p class="text-muted mb-0">
                            Demi keamanan akun, Anda wajib mengganti password bawaan sebelum melanjutkan menggunakan sistem.
                        </p>
                    </div>

                    {{-- INFO --}}
                    <div class="alert alert-light-primary mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                Password harus memenuhi ketentuan berikut:
                                <ul class="mb-0 mt-2 ps-3">
                                    <li>Minimal 8 karakter</li>
                                    <li>Mengandung huruf besar</li>
                                    <li>Mengandung angka</li>
                                    <li>Mengandung simbol</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form wire:submit="save">

                        {{-- PASSWORD --}}
                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <div class="position-relative">
                                <input
                                    type="password"
                                    wire:model.defer="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password baru">

                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- PASSWORD CONFIRMATION --}}
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                wire:model.defer="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password baru">
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-grid">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg"
                                wire:loading.attr="disabled">

                                <span wire:loading.remove>
                                    <i class="bi bi-check-circle me-1"></i>
                                    Simpan Password
                                </span>

                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">
                    Setelah password berhasil diperbarui, Anda akan diarahkan ke dashboard.
                </small>
            </div>

        </div>
    </div>
</div>