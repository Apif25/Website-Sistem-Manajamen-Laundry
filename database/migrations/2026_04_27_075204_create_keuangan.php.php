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
        Schema::create('Keuangan', function (Blueprint $table) {
            $table->bigIncrements('id_keuangan');
            $table->unsignedBigInteger('id_pembayaran')->nullable();
            $table->foreign('id_pembayaran')
                ->references('id_pembayaran')
                ->on('pembayaran');
            $table->datetime('tanggal');
            $table->Enum('jenis', ['Pemasukan', 'Pengeluaran']);
            $table->Enum('kategori', ['Cucian Cepat', 'Cucian Biasa', 'Perbaikan', 'Gaji', 'Listrik', 'Air', 'Lingkungan']);
            $table->decimal('jumlah', 15, 2);
            $table->Text('keterangan');
            $table->unsignedBigInteger('id_pekerja');
            $table->foreign('id_pekerja')->references('id_pekerja')->on('Pekerja');
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
