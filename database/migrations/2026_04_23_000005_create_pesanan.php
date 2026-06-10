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
        schema::create('Pesanan', function (Blueprint $table) {
            $table->bigIncrements('id_pesanan');
            $table->unsignedBigInteger('id_pemesanan');
            $table->foreign('id_pemesanan')->references('id_pemesanan')->on('Pemesanan');
            $table->unsignedBigInteger('id_pelanggan');
            $table->foreign('id_pelanggan')
                ->references('id_pelanggan')
                ->on('Pelanggan');
            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->foreign('id_alamat')->references('id_alamat')->on('AlamatPelanggan')->onDelete('set null');
            $table->enum('jenis_pesanan', ['Satuan', 'Kiloan']);
            $table->enum('layanan_pesanan', ['Biasa', 'Cepat']);
            $table->integer('berat');
            $table->decimal('harga', 15, 2);
            $table->dateTime('tanggal_pesanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
