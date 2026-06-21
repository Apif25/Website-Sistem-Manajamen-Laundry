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
        Schema::create('Pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id_pemesanan');
            $table->string('kode_pemesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('Pelanggan')->onDelete('cascade');
            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->foreign('id_alamat')->references('id_alamat')->on('AlamatPelanggan')->onDelete('set null');
            $table->enum('jenis_pemesanan', ['Satuan', 'Kiloan']);
            $table->enum('layanan_pemesanan', ['Kilat', 'Biasa']);
            $table->integer('jumlah_brg')->nullable();
            $table->dateTime('tanggal_pemesanan');
            $table->enum('status_pemesanan', ['Diproses', 'Selesai', 'Dibatalkan'])->default('Diproses');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pemesanan');
    }
};