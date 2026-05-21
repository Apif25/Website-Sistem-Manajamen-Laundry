<?php

use Dom\Text;
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
        Schema::create('Inventaris', function (Blueprint $table) {
            $table->bigIncrements('id_barang');
            $table->string('nama_barang', 50);
            $table->integer('jumlah_barang')->unsigned();
            $table->enum('status', ['Aktif', 'Tidak Aktif']);
            $table->Text('keterangan');
            $table->dateTime('tanggal');
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
