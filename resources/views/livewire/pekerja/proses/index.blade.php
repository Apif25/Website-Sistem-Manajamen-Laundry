<div>

    {{-- PAGE TITLE --}}
    <div class="page-title mb-4">
        <div class="row align-items-center">
            <div class="col-md-6 col-12">
                <h3 class="mb-1">Manajemen Proses</h3>
                <p class="text-muted mb-0">Kelola tahapan proses laundry</p>
            </div>
            <div class="col-md-6 col-12">
                <nav class="breadcrumb-header float-lg-end">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Proses</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- CARD --}}
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Data Proses</h4>
                <small class="text-muted">Daftar seluruh proses laundry</small>
            </div>
            @role('petugas')
            <button type="button" class="btn btn-primary" wire:click="openCreateModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Proses
            </button>
            @endrole
        </div>

        {{-- BODY --}}
        <div class="card-body">

            {{-- FILTER --}}
            <div class="row mb-3 g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Cari ID Pesanan..."
                            wire:model.live.debounce.300ms="search">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filterStep">
                        <option value="">Semua Tahap</option>
                        @foreach ($steps as $step)
                        <option value="{{ $step }}">{{ $step }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>ID Pesanan</th>
                            <th class="text-center">Status Proses</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prosesList as $index => $proses)
                        @php $current = $proses->currentStepIndex(); @endphp
                        <tr>

                            {{-- NO --}}
                            <td>{{ $prosesList->firstItem() + $index }}</td>

                            {{-- ID PESANAN --}}
                            <td>
                                <span class="badge bg-secondary">#{{ $proses->id_pesanan }}</span>
                            </td>

                            {{-- STATUS PROSES --}}
                            <td>
                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-1">
                                    @foreach ($steps as $i => $step)
                                    @php
                                    $done = $i <= $current;
                                        $circleClass=$done
                                        ? 'bg-success border-success text-white'
                                        : 'bg-white border-secondary text-muted' ;
                                        $textClass=$done ? 'text-success fw-semibold' : 'text-muted' ;
                                        @endphp

                                        <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column align-items-center" style="min-width: 70px;">
                                            <div class="rounded-circle border d-flex align-items-center justify-content-center {{ $circleClass }}"
                                                style="width: 36px; height: 36px; font-size: 13px;">
                                                @if ($done)
                                                <i class="bi bi-check-lg"></i>
                                                @else
                                                {{ $i + 1 }}
                                                @endif
                                            </div>
                                            <small class="mt-1 text-center {{ $textClass }}" style="font-size: 11px;">
                                                {{ $step }}
                                            </small>
                                        </div>

                                        @if (!$loop->last)
                                        <div class="mx-1 text-muted mb-4">
                                            <i class="bi bi-chevron-right"></i>
                                        </div>
                                        @endif
                                </div>
                                @endforeach
            </div>
            </td>

            {{-- AKSI --}}
            <td class="text-center">
                <div class="d-flex justify-content-center align-items-center gap-1">

                    {{-- NEXT STEP --}}
                    @role('petugas')
                    <button
                        type="button"
                        class="btn btn-sm {{ $proses->isSelesai() ? 'btn-success' : 'btn-primary' }}"
                        wire:click="advance({{ $proses->id_proses }})"
                        wire:loading.attr="disabled"
                        wire:target="advance({{ $proses->id_proses }})"
                        {{ $proses->isSelesai() ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="advance({{ $proses->id_proses }})">
                            @if ($proses->isSelesai())
                            <i class="bi bi-check-all me-1"></i> Selesai
                            @else
                            <i class="bi bi-arrow-right-circle me-1"></i> {{ $proses->nextStep() }}
                            @endif
                        </span>
                        <span wire:loading wire:target="advance({{ $proses->id_proses }})">
                            <span class="spinner-border spinner-border-sm"></span>
                        </span>
                    </button>
                    @endrole    

                    {{-- EDIT --}}
                    @role('petugas')
                    <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        wire:click="openEditModal({{ $proses->id_proses }})">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    @endrole
                    {{-- DELETE --}}
                    @role('petugas')
                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        wire:click="confirmDelete({{ $proses->id_proses }})">
                        <i class="bi bi-trash"></i>
                    </button>
                    @endrole
                </div>
            </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                    <i class="bi bi-database-x d-block fs-1 mb-2"></i>
                    Data proses tidak ditemukan
                </td>
            </tr>
            @endforelse
            </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $prosesList->links() }}
        </div>

    </div>
</div>


{{-- MODAL CREATE --}}
@if ($showCreateModal)
<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Proses Baru</h5>
                <button type="button" class="btn-close" wire:click="$set('showCreateModal', false)"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Pilih Pesanan</label>
                    <select class="form-select" wire:model="selectedPesananId">
                        <option value="">-- Pilih Pesanan --</option>
                        @foreach ($pesananList as $pesanan)
                        <option value="{{ $pesanan->id_pesanan }}">#{{ $pesanan->id_pesanan }}</option>
                        @endforeach
                    </select>
                    @error('selectedPesananId')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showCreateModal', false)">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="store">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>

        </div>
    </div>
</div>
@endif


{{-- MODAL EDIT --}}
@if ($showEditModal)
<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Tahap Proses</h5>
                <button type="button" class="btn-close" wire:click="$set('showEditModal', false)"></button>
            </div>

            <div class="modal-body">
                @foreach ($steps as $step)
                <div class="form-check mb-2">
                    <input
                        type="radio"
                        class="form-check-input"
                        wire:model="editStep"
                        value="{{ $step }}"
                        id="step-{{ Str::slug($step) }}">
                    <label class="form-check-label" for="step-{{ Str::slug($step) }}">
                        {{ $step }}
                    </label>
                </div>
                @endforeach
                @error('editStep')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="$set('showEditModal', false)">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="update">
                    <i class="bi bi-save me-1"></i> Perbarui
                </button>
            </div>

        </div>
    </div>
</div>
@endif


{{-- MODAL DELETE --}}
@if ($showDeleteModal)
<div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.5);">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">Hapus Data?</h5>
                <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted mb-0">Data proses akan dihapus permanen.</p>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="$set('showDeleteModal', false)">Batal</button>
                <button type="button" class="btn btn-danger btn-sm" wire:click="destroy">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </div>

        </div>
    </div>
</div>
@endif

</div>