<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update existing lowercase data to capitalized values first
        DB::table('Pemesanan')->where('status_pemesanan', 'diproses')->update(['status_pemesanan' => 'Diproses']);
        DB::table('Pemesanan')->where('status_pemesanan', 'selesai')->update(['status_pemesanan' => 'Selesai']);
        DB::table('Pemesanan')->where('status_pemesanan', 'dibatalkan')->update(['status_pemesanan' => 'Dibatalkan']);

        // 2. Modify enum column definition to be capitalized
        DB::statement("ALTER TABLE Pemesanan MODIFY COLUMN status_pemesanan ENUM('Diproses', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Diproses'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Modify enum column definition back to lowercase
        DB::statement("ALTER TABLE Pemesanan MODIFY COLUMN status_pemesanan ENUM('diproses', 'selesai', 'dibatalkan') NOT NULL DEFAULT 'diproses'");

        // 2. Revert capitalized data back to lowercase
        DB::table('Pemesanan')->where('status_pemesanan', 'Diproses')->update(['status_pemesanan' => 'diproses']);
        DB::table('Pemesanan')->where('status_pemesanan', 'Selesai')->update(['status_pemesanan' => 'selesai']);
        DB::table('Pemesanan')->where('status_pemesanan', 'Dibatalkan')->update(['status_pemesanan' => 'dibatalkan']);
    }
};
