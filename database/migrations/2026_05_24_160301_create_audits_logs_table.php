<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Siapa yang melakukan
            $table->unsignedBigInteger('pekerja_id')->nullable();
            $table->string('nama_pekerja')->nullable();   // snapshot nama, tidak berubah jika user dihapus
            $table->string('email')->nullable();

            // Apa yang terjadi
            $table->string('event');                   // login, logout, login_failed, view, create, update, delete, access_code, 2fa
            $table->string('event_label');             // label human-readable, e.g. "Login Berhasil"

            // Pada objek apa
            $table->string('auditable_type')->nullable();   // App\Models\Pekerja
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->string('auditable_label')->nullable();  // snapshot nama objek

            // Detail perubahan
            $table->json('old_values')->nullable();    // nilai sebelum update/delete
            $table->json('new_values')->nullable();    // nilai sesudah create/update

            // Konteks teknis
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('method', 10)->nullable();

            // Keterangan tambahan
            $table->string('description')->nullable();
            $table->string('status')->default('success'); // success | failed | warning

            $table->timestamp('created_at')->useCurrent();

            // Index untuk performa query di dashboard
            $table->index(['pekerja_id', 'created_at']);
            $table->index(['event', 'created_at']);
            $table->index(['auditable_type', 'auditable_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
