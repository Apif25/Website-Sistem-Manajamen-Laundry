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
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('Pelanggan')->onDelete('cascade');
            $table->enum('jenis_pemesanan', ['Satuan', 'Kiloan']);
            $table->enum('layanan_pemesanan', ['Cepat', 'Biasa']);
            $table->integer('jumlah_brg');
            $table->dateTime('tanggal_pemesanan');
            
            // Kolom baru untuk status pemesanan (Otomatis bernilai 'diproses' saat order dibuat)
            $table->enum('status_pemesanan', ['diproses', 'selesai', 'dibatalkan'])->default('diproses');
            
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