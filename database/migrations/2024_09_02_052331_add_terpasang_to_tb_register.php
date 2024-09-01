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
            $table->string('tanggal_terpasang')->nullable()->after('tanggal_pasang');
            $table->string('nama_teknisi')->nullable()->after('tanggal_terpasang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_register', function (Blueprint $table) {
            $table->dropColumn(['tanggal_terpasang', 'nama_teknisi']);
        });
    }
};
