<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proses', function (Blueprint $table) {
            $table->bigIncrements('id_proses');

            $table->unsignedBigInteger('id_pesanan');

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->onDelete('cascade');

            $table->enum('proses', [
                'Menunggu',
                'Penjemputan',
                'Pencucian',
                'Penyetrikaan',
                'Pengantaran',
                'Selesai',
            ])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proses');
    }
};
