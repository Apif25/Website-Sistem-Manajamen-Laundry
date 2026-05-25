<?php

namespace App\Livewire\Pekerja;

use App\Models\BackupLog;
use Livewire\Attributes\Layout;
use App\Services\BackupService;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('backend.layouts.app')]
class BackupDatabase extends Component
{
    use WithPagination;

    // ─── Form backup ──────────────────────────────────────────
    public string $encryptionCode = '';
    public bool   $showBackupModal = false;

    // ─── Form restore ─────────────────────────────────────────
    public string $restoreEncryptionCode = '';
    public ?int   $restoreId = null;
    public bool   $showRestoreModal = false;
    public string $downloadEncryptionCode = '';
    public ?int $downloadId = null;
    public bool $showDownloadModal = false;

    public string $deleteEncryptionCode = '';
    // ─── Form hapus ───────────────────────────────────────────
    public ?int  $deleteId = null;
    public bool  $showDeleteModal = false;

    // ─── Notifikasi ───────────────────────────────────────────
    public string $flashType    = '';   // success | danger | warning
    public string $flashMessage = '';

    // ─── Guard ────────────────────────────────────────────────

    public function mount(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super admin'),
            403
        );
    }

    public function boot(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super admin'),
            403
        );
    }

    // ─── Validasi ─────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'encryptionCode' => ['required', 'string', 'min:6'],
        ];
    }
    protected function restoreRules(): array
    {
        return [
            'restoreEncryptionCode' => ['required', 'string', 'min:6'],
        ];
    }

    // ─── BACKUP ───────────────────────────────────────────────

    public function openBackupModal(): void
    {
        $this->reset([
            'encryptionCode',
            'flashType',
            'flashMessage'
        ]);
        $this->showBackupModal = true;
    }

    public function closeBackupModal(): void
    {
        $this->reset([
            'encryptionCode',
            'showBackupModal'
        ]);
    }

    public function runBackup(): void
    {
        $this->validate([
            'encryptionCode' => ['required', 'string', 'min:6'],
        ], [
            'encryptionCode.required' => 'Encryption Code wajib diisi.',
            'encryptionCode.min'      => 'Encryption Code minimal 6 karakter.',
        ]);

        try {

            $log = app(BackupService::class)
                ->backup($this->encryptionCode);

            $this->flashType = 'success';

            $this->flashMessage =
                "Backup berhasil dibuat: {$log->filename}";

            $this->closeBackupModal();

            $this->resetPage();
        } catch (\Throwable $e) {

            $this->flashType = 'danger';

            $this->flashMessage =
                'Backup gagal: ' . $e->getMessage();

            $this->closeBackupModal();
        }
    }
    // ─── RESTORE ──────────────────────────────────────────────

    public function openRestoreModal(int $id): void
    {
        $this->reset([
            'restoreEncryptionCode',
            'flashType',
            'flashMessage',
        ]);

        $this->restoreId = $id;
        $this->showRestoreModal = true;
    }

    public function closeRestoreModal(): void
    {
        $this->reset([
            'restoreEncryptionCode',
            'restoreId',
            'showRestoreModal',
        ]);
    }

    public function runRestore(): void
    {
        $this->validate([
            'restoreEncryptionCode' => ['required', 'string', 'min:6'],
        ], [
            'restoreEncryptionCode.required' => 'Encryption Code wajib diisi.',
            'restoreEncryptionCode.min'      => 'Encryption Code minimal 6 karakter.',
        ]);

        $log = BackupLog::find($this->restoreId);

        if (! $log) {

            $this->flashType = 'danger';

            $this->flashMessage =
                'Data backup tidak ditemukan.';

            $this->closeRestoreModal();

            return;
        }

        try {

            app(BackupService::class)
                ->restore(
                    $log,
                    $this->restoreEncryptionCode
                );

            $this->flashType = 'warning';

            $this->flashMessage =
                "Restore dari {$log->filename} berhasil dilakukan.";

            $this->closeRestoreModal();
        } catch (\Throwable $e) {

            $this->flashType = 'danger';

            $this->flashMessage =
                $e->getMessage();

            $this->closeRestoreModal();
        }
    }
    // ─── DOWNLOAD ─────────────────────────────────────────────

    public function download(): mixed
    {
        $this->validate([
            'downloadEncryptionCode' => ['required', 'string', 'min:6'],
        ], [
            'downloadEncryptionCode.required' => 'Encryption Code wajib diisi.',
            'downloadEncryptionCode.min'      => 'Encryption Code minimal 6 karakter.',
        ]);

        $log = BackupLog::find($this->downloadId);

        if (! $log) {
            $this->flashType = 'danger';
            $this->flashMessage = 'Data backup tidak ditemukan.';
            return null;
        }

        try {
            $this->closeDownloadModal();

            return app(BackupService::class)
                ->download($log, $this->downloadEncryptionCode);
        } catch (\Throwable $e) {
            $this->flashType = 'danger';
            $this->flashMessage = $e->getMessage();
            return null;
        }
    }
    public function openDownloadModal(int $id): void
    {
        $this->reset([
            'downloadEncryptionCode',
            'flashType',
            'flashMessage',
        ]);

        $this->downloadId = $id;
        $this->showDownloadModal = true;
    }

    public function closeDownloadModal(): void
    {
        $this->reset([
            'downloadEncryptionCode',
            'downloadId',
            'showDownloadModal',
        ]);
    }
    // ─── DELETE ───────────────────────────────────────────────

    public function openDeleteModal(int $id): void
    {
        $this->reset([
            'deleteEncryptionCode',
            'flashType',
            'flashMessage',
        ]);

        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->reset([
            'deleteId',
            'deleteEncryptionCode',
            'showDeleteModal',
        ]);
    }

    public function confirmDelete(): void
    {
        $this->validate([
            'deleteEncryptionCode' => ['required', 'string', 'min:6'],
        ], [
            'deleteEncryptionCode.required' => 'Encryption Code wajib diisi.',
            'deleteEncryptionCode.min'      => 'Encryption Code minimal 6 karakter.',
        ]);

        $log = BackupLog::find($this->deleteId);

        if (! $log) {

            $this->flashType = 'danger';

            $this->flashMessage =
                'Data backup tidak ditemukan.';

            $this->closeDeleteModal();

            return;
        }

        try {

            app(BackupService::class)
                ->deleteFile(
                    $log,
                    $this->deleteEncryptionCode
                );

            $this->flashType = 'warning';

            $this->flashMessage =
                'File backup berhasil dihapus.';

            $this->closeDeleteModal();

            $this->resetPage();
        } catch (\Throwable $e) {

            $this->flashType = 'danger';

            $this->flashMessage =
                'Gagal menghapus backup: ' . $e->getMessage();
        }
    }

    // ─── Render ───────────────────────────────────────────────

    public function render()
    {
        $backups = BackupLog::orderByDesc('created_at')->paginate(10);

        return view('livewire.pekerja.backupdatabase', [
            'backups' => $backups,
        ]);
    }
}
