<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add columns as nullable first
        Schema::table('Pemesanan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id_pemesanan');
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id_pesanan');
        });

        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id_pembayaran');
        });

        // 2. Populate existing records
        // For Pemesanan
        $pemesanans = DB::table('Pemesanan')->get();
        foreach ($pemesanans as $row) {
            DB::table('Pemesanan')->where('id_pemesanan', $row->id_pemesanan)->update([
                'uuid' => (string) Str::uuid(),
            ]);
        }

        // For Pesanan
        $pesanans = DB::table('Pesanan')->get();
        foreach ($pesanans as $row) {
            DB::table('Pesanan')->where('id_pesanan', $row->id_pesanan)->update([
                'uuid' => (string) Str::uuid(),
            ]);
        }

        // For Pembayaran
        $pembayarans = DB::table('Pembayaran')->get();
        foreach ($pembayarans as $row) {
            DB::table('Pembayaran')->where('id_pembayaran', $row->id_pembayaran)->update([
                'uuid' => (string) Str::uuid(),
            ]);
        }

        // 3. Alter columns to be non-nullable
        Schema::table('Pemesanan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('Pemesanan', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
