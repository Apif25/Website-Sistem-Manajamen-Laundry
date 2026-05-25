<div>

    {{-- ══════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════ --}}
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Backup & Restore Database</h3>
                    <p class="text-subtitle text-muted">
                        Kelola backup terenkripsi database — khusus Super Admin.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('pekerja.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Backup Database
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- ── Flash Message ── --}}
        @if ($flashMessage)
        <div class="alert alert-{{ $flashType }} alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            @if ($flashType === 'success')
            <i class="bi bi-check-circle-fill fs-5"></i>
            @elseif ($flashType === 'danger')
            <i class="bi bi-x-octagon-fill fs-5"></i>
            @else
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            @endif
            <span>{{ $flashMessage }}</span>
            <button type="button" class="btn-close ms-auto" wire:click="$set('flashMessage', '')" aria-label="Tutup"></button>
        </div>
        @endif

        {{-- ── Info Card ── --}}
        <div class="alert alert-light-info border-start border-info border-3 d-flex gap-2 mb-3" role="note">
            <i class="bi bi-info-circle-fill text-info mt-1 flex-shrink-0"></i>

            <div style="font-size:.875rem">
                <strong>Cara kerja backup terenkripsi:</strong>

                <ul class="mb-0 mt-2 ps-3">
                    <li>
                        <strong>Encryption Code</strong> digunakan untuk mengenkripsi file backup
                        dan memverifikasi akses saat restore maupun penghapusan backup.
                    </li>

                    <li>
                        Encryption Code yang dibuat saat backup pertama harus digunakan
                        kembali untuk backup berikutnya, restore, download, dan hapus backup.
                    </li>
                    <li>
                        Jika Encryption Code hilang, file backup tidak dapat didekripsi.
                    </li>
                </ul>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             MAIN CARD
        ══════════════════════════════════════════ --}}
        <section class="section">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-database-fill-gear text-primary me-2"></i>
                        Riwayat Backup
                    </h5>
                    <button
                        wire:click="openBackupModal"
                        class="btn btn-primary btn-sm">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i>
                        Buat Backup Baru
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Nama File</th>
                                    <th>Ukuran</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Tanggal Backup</th>
                                    <th>Terakhir Restore</th>
                                    <th>Status File</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($backups as $backup)
                                <tr>
                                    <td class="ps-3 text-muted" style="font-size:.8rem">
                                        {{ $backups->firstItem() + $loop->index }}
                                    </td>
                                    <td>
                                        <code style="font-size:.78rem">{{ $backup->filename }}</code>
                                    </td>
                                    <td class="text-muted" style="font-size:.82rem">
                                        {{ $backup->filesize_human }}
                                    </td>
                                    <td style="font-size:.85rem">
                                        {{ $backup->user_name ?? '—' }}
                                    </td>
                                    <td style="font-size:.82rem; white-space:nowrap">
                                        {{ $backup->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td style="font-size:.82rem; white-space:nowrap">
                                        @if ($backup->restored_at)
                                        <span class="text-warning">
                                            {{ $backup->restored_at->format('d/m/Y H:i') }}
                                        </span><br>
                                        <small class="text-muted">oleh {{ $backup->restored_by }}</small>
                                        @else
                                        <span class="text-muted">Belum pernah</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($backup->fileExists())
                                        <span class="badge bg-light-success text-success">
                                            <i class="bi bi-check-circle me-1"></i>Ada
                                        </span>
                                        @else
                                        <span class="badge bg-light-danger text-danger">
                                            <i class="bi bi-x-circle me-1"></i>Tidak Ada
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">

                                            {{-- Download --}}
                                            @if ($backup->fileExists())
                                            <button
                                                wire:click="openDownloadModal({{ $backup->id }})"
                                                class="btn btn-sm btn-light-primary px-2"
                                                title="Download file backup terenkripsi">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            @endif

                                            {{-- Restore --}}
                                            @if ($backup->fileExists())
                                            <button
                                                wire:click="openRestoreModal({{ $backup->id }})"
                                                class="btn btn-sm btn-light-warning px-2"
                                                title="Restore database dari backup ini">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                            @endif

                                            {{-- Hapus --}}
                                            <button
                                                wire:click="openDeleteModal({{ $backup->id }})"
                                                class="btn btn-sm btn-light-danger px-2"
                                                title="Hapus backup ini">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="bi bi-database-slash fs-3 d-block mb-2 opacity-50"></i>
                                        Belum ada backup. Klik <strong>Buat Backup Baru</strong> untuk memulai.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($backups->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Menampilkan {{ $backups->firstItem() }}–{{ $backups->lastItem() }}
                        dari {{ $backups->total() }} backup
                    </small>
                    {{ $backups->links() }}
                </div>
                @endif
            </div>
        </section>
    </div>

    {{-- ══════════════════════════════════════════
     MODAL: RESTORE DATABASE
    ══════════════════════════════════════════ --}}
    @if ($showRestoreModal)

    @php
    $restoreLog = \App\Models\BackupLog::find($restoreId);
    @endphp

    <div class="modal fade show d-block"
        tabindex="-1"
        style="background:rgba(0,0,0,.45)"
        aria-modal="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-warning bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-counterclockwise text-warning me-2"></i>
                        Restore Database
                    </h5>

                    <button
                        type="button"
                        wire:click="closeRestoreModal"
                        class="btn-close">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-danger d-flex gap-2 mb-4">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                        <div style="font-size:.85rem">
                            <strong>Peringatan!</strong><br>
                            Restore akan menimpa seluruh data saat ini.
                            Tindakan ini tidak dapat dibatalkan.
                        </div>
                    </div>

                    @if ($restoreLog)
                    <div class="bg-light border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">File</span>
                            <code>{{ $restoreLog->filename }}</code>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tanggal Backup</span>
                            <span>
                                {{ $restoreLog->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Ukuran</span>
                            <span>{{ $restoreLog->filesize_human }}</span>
                        </div>

                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Encryption Code
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>

                            <input
                                type="password"
                                wire:model="restoreEncryptionCode"
                                class="form-control @error('restoreEncryptionCode') is-invalid @enderror"
                                placeholder="Masukkan Encryption Code">
                        </div>

                        @error('restoreEncryptionCode')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror

                        <small class="text-muted">
                            Gunakan Encryption Code yang digunakan saat backup dibuat.
                        </small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        wire:click="closeRestoreModal"
                        class="btn btn-light-secondary">
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="runRestore"
                        wire:loading.attr="disabled"
                        class="btn btn-warning">

                        <span wire:loading.remove wire:target="runRestore">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Restore Database
                        </span>

                        <span wire:loading wire:target="runRestore">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...
                        </span>

                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
     MODAL: DOWNLOAD BACKUP
    ══════════════════════════════════════════ --}}
    @if ($showDownloadModal)
    <div class="modal fade show d-block"
        tabindex="-1"
        style="background:rgba(0,0,0,.45)"
        aria-modal="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bi bi-download text-primary me-2"></i>
                        Download Backup
                    </h5>

                    <button
                        type="button"
                        wire:click="closeDownloadModal"
                        class="btn-close">
                    </button>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <div class="alert alert-info d-flex gap-2 mb-3">
                        <i class="bi bi-info-circle-fill mt-1"></i>
                        <div style="font-size:.85rem">
                            Masukkan <strong>Encryption Code</strong> yang digunakan saat backup dibuat
                            untuk mendekripsi file sebelum di-download.
                        </div>
                    </div>

                    {{-- Encryption Code --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Encryption Code
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>

                            <input
                                type="password"
                                class="form-control @error('downloadEncryptionCode') is-invalid @enderror"
                                wire:model="downloadEncryptionCode"
                                placeholder="Masukkan Encryption Code"
                                autocomplete="off">
                        </div>

                        @error('downloadEncryptionCode')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button
                        type="button"
                        wire:click="closeDownloadModal"
                        class="btn btn-light-secondary">
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="download"
                        wire:loading.attr="disabled"
                        class="btn btn-primary">

                        <span wire:loading.remove wire:target="download">
                            <i class="bi bi-download me-1"></i>
                            Download
                        </span>

                        <span wire:loading wire:target="download">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...
                        </span>

                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════════
         MODAL: BUAT BACKUP
    ══════════════════════════════════════════ --}}
    @if ($showBackupModal)
    <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>
                        Buat Backup Baru
                    </h5>
                    <button type="button" wire:click="closeBackupModal" class="btn-close"></button>
                </div>
                <div class="modal-body">

                    <div class="alert alert-light-warning border-start border-warning border-3 d-flex gap-2 mb-4">
                        <i class="bi bi-shield-lock-fill text-warning mt-1"></i>

                        <div style="font-size:.85rem">
                            <strong>Penting:</strong><br>

                            Encryption Code digunakan untuk mengenkripsi file backup.

                            <br><br>

                            Encryption Code yang dibuat saat backup pertama wajib disimpan
                            karena kode yang sama diperlukan untuk restore, download,
                            menghapus backup, dan membuat backup berikutnya.
                        </div>
                    </div>

                    {{-- Encryption Code --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Encryption Code
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-key-fill"></i>
                            </span>

                            <input
                                type="password"
                                class="form-control @error('encryptionCode') is-invalid @enderror"
                                wire:model="encryptionCode"
                                placeholder="Masukkan Encryption Code"
                                autocomplete="off">

                            @error('encryptionCode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <small class="text-muted">
                            <strong>Penting:</strong>
                            Simpan Encryption Code ini dengan aman.
                            Kode yang sama akan digunakan untuk membuat backup berikutnya,
                            restore database, download file backup, dan menghapus backup.
                            Jika kode ini hilang, file backup tidak dapat didekripsi.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        wire:click="closeBackupModal"
                        class="btn btn-light-secondary">
                        Batal
                    </button>

                    <button
                        type="button"
                        wire:click="runBackup"
                        wire:loading.attr="disabled"
                        class="btn btn-primary">

                        <span wire:loading.remove wire:target="runBackup">
                            <i class="bi bi-cloud-arrow-up-fill me-1"></i>
                            Mulai Backup
                        </span>

                        <span wire:loading wire:target="runBackup">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- ══════════════════════════════════════════
         MODAL: HAPUS KONFIRMASI
    ══════════════════════════════════════════ --}}
    @if ($showDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,.45)" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash3-fill me-2"></i>Hapus Backup
                    </h5>
                    <button type="button" wire:click="closeDeleteModal" class="btn-close"></button>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger mb-3">
                        <strong>Peringatan!</strong><br>
                        Backup akan dihapus permanen dari server dan tidak dapat dipulihkan kembali.
                        Masukkan Encryption Code untuk melanjutkan.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Encryption Code Backup
                        </label>

                        <input
                            type="password"
                            class="form-control @error('deleteEncryptionCode') is-invalid @enderror"
                            wire:model="deleteEncryptionCode"
                            placeholder="Masukkan Encryption Code"
                            autocomplete="off">
                        @error('deleteEncryptionCode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" wire:click="closeDeleteModal" class="btn btn-light-secondary">
                        Batal
                    </button>
                    <button type="button" wire:click="confirmDelete" class="btn btn-danger">
                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>