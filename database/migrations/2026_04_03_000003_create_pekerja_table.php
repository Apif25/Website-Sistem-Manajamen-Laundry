<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Pekerja', function (Blueprint $table) {
            $table->bigIncrements('id_pekerja');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nama_pekerja', 50);
            $table->text('no_telepon',);
            $table->text('alamat');
            $table->string('foto')->nullable();
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Pekerja', function (Blueprint $table) {
            $table->renameColumn('no_telepon', 'no_telp');
            $table->dropColumn('foto');
        });
    }
};
