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
        Schema::table('tb_register', function (Blueprint $table) {
            $table->date('tanggal_pasang')->nullable()->after('paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_register', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pasang']);
        });
    }
};
