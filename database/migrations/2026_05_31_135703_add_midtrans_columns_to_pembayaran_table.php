<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {

            $table->string('midtrans_order_id')
                ->unique()
                ->nullable()
                ->after('tanggal_pembayaran');

            $table->string('midtrans_transaction_id')
                ->nullable()
                ->after('midtrans_order_id');

            $table->string('payment_type')
                ->nullable()
                ->after('midtrans_transaction_id');

            $table->string('snap_token')
                ->nullable()
                ->after('payment_type');

            $table->string('status_pembayaran')
                ->default('pending')
                ->after('snap_token');

            $table->dateTime('expired_at')
                ->nullable()
                ->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {

            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'payment_type',
                'snap_token',
                'status_pembayaran',
                'expired_at',
            ]);
        });
    }
};
