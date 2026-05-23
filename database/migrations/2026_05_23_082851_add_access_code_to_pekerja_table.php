<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pekerja', function (Blueprint $table) {
            $table->string('access_code')
                ->nullable()
                ->after('must_change_password');
        });
    }

    public function down(): void
    {
        Schema::table('pekerja', function (Blueprint $table) {
            $table->dropColumn('access_code');
        });
    }
};
