<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_logs', function (Blueprint $table) {
            $table->id();

            // Siapa yang backup
            $table->foreignId('user_id')->nullable()->constrained('Pekerja', 'id_pekerja')->nullOnDelete();
            $table->string('user_name')->nullable();

            // Info file
            $table->string('filename');                    // nama file .sql.enc
            $table->string('filepath');                    // path relatif dari storage
            $table->unsignedBigInteger('filesize')->nullable(); // bytes

            // Enkripsi — IV disimpan terpisah dari key
            $table->string('iv');                          // Initialization Vector (base64), aman disimpan di DB
            // CATATAN: encryption key TIDAK disimpan di DB, itu adalah kode akses user

            // Status & keterangan
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->text('notes')->nullable();

            // Restore log
            $table->timestamp('restored_at')->nullable();
            $table->string('restored_by')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_logs');
    }
};
