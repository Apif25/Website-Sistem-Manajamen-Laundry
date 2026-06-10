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
        Schema::create('AlamatPelanggan', function (Blueprint $table) {
            $table->bigIncrements('id_alamat');
            $table->unsignedBigInteger('id_pelanggan');
            $table->string('label_alamat', 50)->default('Rumah');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->text('alamat_lengkap'); // Nama jalan, RT/RW, nomor rumah (terenkripsi)
            $table->boolean('is_utama')->default(true);
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('Pelanggan')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on(config('laravolt.indonesia.table_prefix', 'indonesia_') . 'provinces')->onDelete('restrict');
            $table->foreign('regency_id')->references('id')->on(config('laravolt.indonesia.table_prefix', 'indonesia_') . 'cities')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on(config('laravolt.indonesia.table_prefix', 'indonesia_') . 'districts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AlamatPelanggan');
    }
};
