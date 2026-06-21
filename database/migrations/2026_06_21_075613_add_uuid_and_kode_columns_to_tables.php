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
        Schema::table('Pelanggan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id_pelanggan');
            $table->string('kode_pelanggan')->nullable()->unique()->after('uuid');
        });

        Schema::table('Pekerja', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id_pekerja');
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->string('kode_pesanan')->nullable()->unique()->after('id_pesanan');
        });

        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->string('kode_pembayaran')->nullable()->unique()->after('id_pembayaran');
        });

        // 2. Populate existing records
        // For Pelanggan
        $pelanggans = DB::table('Pelanggan')->get();
        foreach ($pelanggans as $index => $row) {
            $datePart = now()->format('ym');
            $seq = str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT);
            $kode = "{$datePart}{$seq}";
            DB::table('Pelanggan')->where('id_pelanggan', $row->id_pelanggan)->update([
                'uuid' => (string) Str::uuid(),
                'kode_pelanggan' => $kode,
            ]);
        }

        // For Pekerja
        $pekerjas = DB::table('Pekerja')->get();
        foreach ($pekerjas as $index => $row) {
            DB::table('Pekerja')->where('id_pekerja', $row->id_pekerja)->update([
                'uuid' => (string) Str::uuid(),
            ]);
        }

        // For Pesanan
        $pesanans = DB::table('Pesanan')->get();
        foreach ($pesanans as $index => $row) {
            $datePart = now()->format('ym');
            $seq = str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT);
            $kode = "PES-{$datePart}-{$seq}";
            DB::table('Pesanan')->where('id_pesanan', $row->id_pesanan)->update([
                'kode_pesanan' => $kode,
            ]);
        }

        // For Pembayaran
        $pembayarans = DB::table('Pembayaran')->get();
        foreach ($pembayarans as $index => $row) {
            $datePart = now()->format('ym');
            $seq = str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT);
            $kode = "PMB-{$datePart}-{$seq}";
            DB::table('Pembayaran')->where('id_pembayaran', $row->id_pembayaran)->update([
                'kode_pembayaran' => $kode,
            ]);
        }

        // 3. Alter columns to be non-nullable
        Schema::table('Pelanggan', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
            $table->string('kode_pelanggan')->nullable(false)->change();
        });

        Schema::table('Pekerja', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->string('kode_pesanan')->nullable(false)->change();
        });

        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->string('kode_pembayaran')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Pembayaran', function (Blueprint $table) {
            $table->dropColumn('kode_pembayaran');
        });

        Schema::table('Pesanan', function (Blueprint $table) {
            $table->dropColumn('kode_pesanan');
        });

        Schema::table('Pekerja', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('Pelanggan', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'kode_pelanggan']);
        });
    }
};
