<?php

namespace App\Services;

use App\Models\BackupLog;
use App\Support\AuditLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\BackupSetting;
use Illuminate\Support\Facades\Hash;

class BackupService
{
    private const CIPHER  = 'AES-256-CBC';
    private const KEY_LEN = 32;
    private const IV_LEN  = 16;

    // ─────────────────────────────────────────────
    // PUBLIC: BACKUP
    // ─────────────────────────────────────────────

    public function backup(string $encryptionCode): BackupLog
    {
        // =====================================================
        // VALIDASI ENCRYPTION CODE
        // =====================================================

        $setting = BackupSetting::first();
        $isFirstBackup = false;

        if (! $setting) {

            $setting = BackupSetting::create([
                'encryption_hash' => Hash::make($encryptionCode),
                'created_by'      => auth()->id(),
            ]);

            $isFirstBackup = true;
        } elseif (! Hash::check($encryptionCode, $setting->encryption_hash)) {

            AuditLogger::log(
                event: 'backup',
                eventLabel: 'Backup Database Gagal',
                status: 'failed',
                description: 'Encryption Code tidak valid.'
            );

            throw new \RuntimeException(
                'Encryption Code tidak valid.'
            );
        }

        // =====================================================
        // EXPORT DATABASE
        // =====================================================

        $sqlContent = $this->exportDatabase();

        // =====================================================
        // ENKRIPSI DATABASE
        // =====================================================

        $key = $this->deriveKey($encryptionCode);
        $iv  = random_bytes(self::IV_LEN);

        $encrypted = openssl_encrypt(
            $sqlContent,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encrypted === false) {
            throw new \RuntimeException(
                'Enkripsi gagal: ' . openssl_error_string()
            );
        }

        // =====================================================
        // SIMPAN FILE BACKUP
        // =====================================================

        $filename = 'backup_'
            . now()->format('Ymd_His')
            . '_'
            . Str::random(6)
            . '.sql.enc';

        $filepath = 'backups/' . $filename;

        Storage::put($filepath, $encrypted);

        // =====================================================
        // SIMPAN LOG
        // =====================================================

        $log = BackupLog::create([
            'user_id'   => auth()->id(),
            'user_name' => auth()->user()?->nama_pekerja
                ?? auth()->user()?->name,

            'filename'  => $filename,
            'filepath'  => $filepath,
            'filesize'  => strlen($encrypted),

            'iv'        => base64_encode($iv),

            'status'    => 'success',

            'notes'     => $isFirstBackup
                ? 'Backup pertama berhasil dibuat dan Encryption Code berhasil disimpan.'
                : 'Backup berhasil dibuat menggunakan Encryption Code.',
        ]);

        AuditLogger::log(
            event: 'backup',
            eventLabel: 'Backup Database',
            status: 'success',
            description: "File: {$filename}"
        );

        return $log;
    }

    // ─────────────────────────────────────────────
    // PUBLIC: RESTORE
    // ─────────────────────────────────────────────

    public function restore(
        BackupLog $log,
        string $encryptionCode
    ): void {

        // =====================================================
        // VALIDASI FILE
        // =====================================================

        if (! Storage::exists($log->filepath)) {

            AuditLogger::log(
                event: 'restore',
                eventLabel: 'Restore Database Gagal',
                status: 'failed',
                description: "File backup tidak ditemukan. File: {$log->filename}"
            );

            throw new \RuntimeException(
                'File backup tidak ditemukan di storage.'
            );
        }

        // =====================================================
        // VALIDASI ENCRYPTION CODE
        // =====================================================

        $setting = BackupSetting::first();

        if (! $setting) {

            AuditLogger::log(
                event: 'restore',
                eventLabel: 'Restore Database Gagal',
                status: 'failed',
                description: 'Encryption Code belum pernah dibuat.'
            );

            throw new \RuntimeException(
                'Encryption Code belum pernah dibuat.'
            );
        }

        if (! Hash::check(
            $encryptionCode,
            $setting->encryption_hash
        )) {

            AuditLogger::log(
                event: 'restore',
                eventLabel: 'Restore Database Gagal',
                status: 'failed',
                description: "Encryption Code salah. File: {$log->filename}"
            );

            throw new \RuntimeException(
                'Encryption Code tidak valid.'
            );
        }

        // =====================================================
        // AMBIL FILE BACKUP
        // =====================================================

        $encrypted = Storage::get($log->filepath);

        // =====================================================
        // DEKRIPSI FILE
        // =====================================================

        $key = $this->deriveKey($encryptionCode);
        $iv  = base64_decode($log->iv);

        $sql = openssl_decrypt(
            $encrypted,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($sql === false) {

            AuditLogger::log(
                event: 'restore',
                eventLabel: 'Restore Database Gagal',
                status: 'failed',
                description: "Dekripsi gagal. File: {$log->filename}"
            );

            throw new \RuntimeException(
                'Dekripsi gagal. Encryption Code tidak sesuai atau file backup rusak.'
            );
        }

        // =====================================================
        // RESTORE DATABASE
        // =====================================================

        $this->importDatabase($sql);

        // =====================================================
        // UPDATE LOG
        // =====================================================

        $log->update([
            'restored_at' => now(),
            'restored_by' => auth()->user()?->nama_pekerja
                ?? auth()->user()?->name,
        ]);

        // =====================================================
        // AUDIT LOG
        // =====================================================

        AuditLogger::log(
            event: 'restore',
            eventLabel: 'Restore Database',
            status: 'warning',
            description: "Restore dari file: {$log->filename}"
        );
    }
    // ─────────────────────────────────────────────
    // PUBLIC: DOWNLOAD
    // ─────────────────────────────────────────────

    public function download(
        BackupLog $log,
        string $encryptionCode
    ): \Symfony\Component\HttpFoundation\StreamedResponse {

        $encryptionCode = trim($encryptionCode);

        // =====================================================
        // VALIDASI FILE
        // =====================================================
        if (! Storage::exists($log->filepath)) {

            AuditLogger::log(
                event: 'backup_download',
                eventLabel: 'Download File Backup Gagal',
                status: 'failed',
                description: "File tidak ditemukan. File: {$log->filename}"
            );

            throw new \RuntimeException('File backup tidak ditemukan.');
        }

        // =====================================================
        // VALIDASI ENCRYPTION CODE
        // =====================================================
        $setting = BackupSetting::first();

        if (! $setting) {
            throw new \RuntimeException('Encryption Code belum pernah dibuat.');
        }

        if (! Hash::check($encryptionCode, $setting->encryption_hash)) {

            AuditLogger::log(
                event: 'backup_download',
                eventLabel: 'Download File Backup Gagal',
                status: 'failed',
                description: "Encryption Code salah. File: {$log->filename}"
            );

            throw new \RuntimeException('Encryption Code tidak valid.');
        }

        // =====================================================
        // AUDIT LOG
        // =====================================================
        AuditLogger::log(
            event: 'backup_download',
            eventLabel: 'Download File Backup',
            status: 'success',
            description: "File: {$log->filename}"
        );

        return Storage::download(
            $log->filepath,
            $log->filename
        );
    }
    // ─────────────────────────────────────────────
    // PUBLIC: DELETE
    // ─────────────────────────────────────────────

    public function deleteFile(
        BackupLog $log,
        string $encryptionCode
    ): void {

        // =====================================================
        // VALIDASI ENCRYPTION CODE
        // =====================================================

        $setting = BackupSetting::first();

        if (! $setting) {

            throw new \RuntimeException(
                'Encryption Code belum pernah dibuat.'
            );
        }

        if (! Hash::check(
            $encryptionCode,
            $setting->encryption_hash
        )) {

            AuditLogger::log(
                event: 'backup_delete',
                eventLabel: 'Hapus File Backup Gagal',
                status: 'failed',
                description: "Encryption Code salah. File: {$log->filename}"
            );

            throw new \RuntimeException(
                'Encryption Code tidak valid.'
            );
        }

        // =====================================================
        // HAPUS FILE
        // =====================================================

        if (Storage::exists($log->filepath)) {
            Storage::delete($log->filepath);
        }

        // =====================================================
        // HAPUS LOG
        // =====================================================

        $log->delete();

        // =====================================================
        // AUDIT LOG
        // =====================================================

        AuditLogger::log(
            event: 'backup_delete',
            eventLabel: 'Hapus File Backup',
            status: 'warning',
            description: "File: {$log->filename}"
        );
    }
    // =====================================================
    // PRIVATE: VERIFY ENCRYPTION CODE
    // =====================================================

    private function verifyEncryptionCode(string $encryptionCode): void
    {
        $setting = BackupSetting::first();

        if (! $setting) {

            throw new \RuntimeException(
                'Encryption Code belum pernah dibuat.'
            );
        }

        if (! Hash::check(
            $encryptionCode,
            $setting->encryption_hash
        )) {

            throw new \RuntimeException(
                'Encryption Code tidak valid.'
            );
        }
    }
    // ─────────────────────────────────────────────
    // PRIVATE: EXPORT via PDO (tanpa mysqldump)
    // ─────────────────────────────────────────────

    private function exportDatabase(): string
    {
        $dbName = config('database.connections.mysql.database');
        $sql    = "";

        // Header
        $sql .= "-- Database Backup\n";
        $sql .= "-- Dibuat: " . now()->toDateTimeString() . "\n";
        $sql .= "-- Database: {$dbName}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n\n";

        // Ambil semua tabel
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $dbName;

        foreach ($tables as $tableRow) {
            $table = $tableRow->$tableKey;

            // DROP + CREATE TABLE
            $sql .= "-- \n-- Tabel: `{$table}`\n-- \n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";

            $createResult = DB::select("SHOW CREATE TABLE `{$table}`");
            $createSql    = $createResult[0]->{'Create Table'} ?? null;
            if ($createSql) {
                $sql .= $createSql . ";\n\n";
            }

            // Data
            $rows = DB::table($table)->get();
            if ($rows->isEmpty()) {
                $sql .= "-- (tidak ada data)\n\n";
                continue;
            }

            $columns = array_keys((array) $rows->first());
            $colList = implode(', ', array_map(fn($c) => "`{$c}`", $columns));

            // Insert per 100 baris
            $chunks = $rows->chunk(100);
            foreach ($chunks as $chunk) {
                $values = [];
                foreach ($chunk as $row) {
                    $rowArr  = (array) $row;
                    $escaped = array_map(function ($val) {
                        if ($val === null) return 'NULL';
                        return "'" . addslashes((string) $val) . "'";
                    }, $rowArr);
                    $values[] = '(' . implode(', ', $escaped) . ')';
                }
                $sql .= "INSERT INTO `{$table}` ({$colList}) VALUES\n";
                $sql .= implode(",\n", $values) . ";\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $sql;
    }

    // ─────────────────────────────────────────────
    // PRIVATE: IMPORT via PDO
    // ─────────────────────────────────────────────

    private function importDatabase(string $sql): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Hapus komentar
            $sql = preg_replace('/\/\\*.*?\\*\//s', '', $sql);
            $sql = preg_replace('/^--.*$/m', '', $sql);
            $sql = preg_replace('/^SET SQL_MODE.*$/m', '', $sql);
            $sql = preg_replace('/^SET FOREIGN_KEY_CHECKS.*$/m', '', $sql);

            // Split per statement
            $statements = array_filter(
                array_map('trim', explode(";\n", $sql)),
                fn($s) => $s !== ''
            );

            foreach ($statements as $statement) {
                if (trim($statement) === '') continue;
                DB::unprepared($statement . ';');
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    // ─────────────────────────────────────────────
    // PRIVATE: ENKRIPSI HELPERS
    // ─────────────────────────────────────────────

    private function deriveKey(string $encryptionCode): string
    {
        $appKey = config('app.key');

        if (str_starts_with($appKey, 'base64:')) {
            $appKey = base64_decode(substr($appKey, 7));
        }

        $salt = substr($appKey, 0, 16);

        return hash_pbkdf2(
            'sha256',
            $encryptionCode,
            $salt,
            100000,
            self::KEY_LEN,
            true
        );
    }
}
