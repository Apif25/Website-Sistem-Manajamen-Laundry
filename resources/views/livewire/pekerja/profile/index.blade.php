<div>

    {{-- Page Title --}}
    <div class="page-title mb-4">
        <div class="row align-items-center g-3">

            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="mb-1 fw-bold">Profil Saya</h3>
                <p class="text-subtitle text-muted mb-0">
                    Kelola informasi akun pekerja Anda
                </p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb"
                    class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profil
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('success'))
    <div wire:key="success-alert"
        class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4"
        role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>

        <div class="flex-grow-1">
            {{ session('success') }}
        </div>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">

        {{-- Profile Card --}}
        <div class="col-12 col-lg-4 mb-4">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-body text-center d-flex flex-column justify-content-center py-5">

                    {{-- Avatar --}}
                    <div class="mb-4">

                        @if ($foto)
                        <img src="{{ $foto->temporaryUrl() }}"
                            alt="Preview Foto"
                            width="120"
                            height="120"
                            class="rounded-circle border border-3 border-primary object-fit-cover shadow-sm">
                        @elseif ($foto_existing)
                        <img src="{{ asset('storage/' . $foto_existing) }}"
                            alt="Foto Profil"
                            width="120"
                            height="120"
                            class="rounded-circle border border-3 border-primary object-fit-cover shadow-sm">
                        @else
                        <div class="rounded-circle bg-primary border border-3 border-primary d-inline-flex align-items-center justify-content-center shadow-sm"
                            style="width: 120px; height: 120px;">

                            <i class="bi bi-person-fill text-white"
                                style="font-size: 3rem;"></i>
                        </div>
                        @endif

                    </div>

                    {{-- Info --}}
                    <h5 class="fw-bold mb-1">
                        {{ $nama_pekerja ?: '-' }}
                    </h5>

                    <p class="text-muted small mb-3">
                        {{ $email ?: '-' }}
                    </p>

                    <div>
                        <span class="badge {{ $jenis_kelamin === 'Pria' ? 'bg-info' : 'bg-pink' }} px-3 py-2">

                            <i class="bi {{ $jenis_kelamin === 'Pria'
                                ? 'bi-gender-pria'
                                : 'bi-gender-wanita' }} me-1"></i>

                            {{ $jenis_kelamin ?: '-' }}
                        </span>
                    </div>

                    {{-- Upload --}}
                    <div class="mt-4 text-start">

                        <label class="form-label fw-semibold small">
                            Ganti Foto
                        </label>

                        <small class="d-block text-muted mb-2">
                            Format: jpg, jpeg, png — Maksimal 2MB
                        </small>

                        <input type="file"
                            accept="image/*"
                            wire:model="foto"
                            class="form-control form-control-sm @error('foto') is-invalid @enderror">

                        @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <div wire:loading
                            wire:target="foto"
                            class="small text-muted mt-2">

                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Mengupload foto...
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Form Card --}}
        <div class="col-12 col-lg-8 mb-4">

            <div class="card border-0 shadow-sm">

                {{-- Header --}}
                <div class="card-header bg-transparent py-3">
                    <h4 class="card-title fw-bold mb-1">
                        Informasi Akun
                    </h4>

                    <small class="text-muted">
                        Perbarui data diri dan keamanan akun Anda
                    </small>
                </div>

                {{-- Body --}}
                <div class="card-body">

                    <div class="row g-4">

                        {{-- Nama --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                wire:model="nama_pekerja"
                                placeholder="Masukkan nama lengkap"
                                class="form-control @error('nama_pekerja') is-invalid @enderror">

                            @error('nama_pekerja')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                Email
                                <span class="text-danger">*</span>
                            </label>

                            <input type="email"
                                wire:model="email"
                                placeholder="email@contoh.com"
                                class="form-control @error('email') is-invalid @enderror">

                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Telepon --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                No. Telepon
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>

                                <input type="text"
                                    wire:model="no_telepon"
                                    placeholder="08xxxxxxxxxx"
                                    class="form-control @error('no_telepon') is-invalid @enderror">

                                @error('no_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                Jenis Kelamin
                                <span class="text-danger">*</span>
                            </label>

                            <select wire:model="jenis_kelamin"
                                class="form-select @error('jenis_kelamin') is-invalid @enderror">

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="Pria">
                                    Pria
                                </option>

                                <option value="Wanita">
                                    Wanita
                                </option>

                            </select>

                            @error('jenis_kelamin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Alamat
                            </label>

                            <textarea rows="3"
                                wire:model="alamat"
                                placeholder="Masukkan alamat lengkap..."
                                class="form-control @error('alamat') is-invalid @enderror"></textarea>

                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Divider --}}
                        <div class="col-12">

                            <hr class="my-1">

                            <div class="d-flex align-items-center text-muted small mt-2">
                                <i class="bi bi-shield-lock me-2"></i>

                                Kosongkan password jika tidak ingin mengubahnya.
                            </div>

                        </div>

                        {{-- Password --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <input type="password"
                                wire:model="password"
                                placeholder="Minimal 8 karakter"
                                class="form-control @error('password') is-invalid @enderror">

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="col-12 col-md-6">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <input type="password"
                                wire:model="password_confirmation"
                                placeholder="Ulangi password baru"
                                class="form-control">

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer bg-transparent d-flex justify-content-end py-3">

                    <button type="button"
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="btn btn-primary px-4">

                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-check-lg me-1"></i>
                            Simpan Perubahan
                        </span>

                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Menyimpan...
                        </span>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>