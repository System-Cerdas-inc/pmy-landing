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
        Schema::table('tb_paket', function (Blueprint $table) {
            $table->boolean('nama_visible')->default(true)->after('nama');
            $table->boolean('kecepatan_visible')->default(true)->after('kecepatan');
            $table->boolean('device_visible')->default(true)->after('device');
            $table->boolean('harga_visible')->default(true)->after('harga');
            $table->boolean('registrasi_visible')->default(true)->after('registrasi');
            $table->boolean('jenis_visible')->default(true)->after('jenis');
            $table->boolean('popular_visible')->default(true)->after('popular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_paket', function (Blueprint $table) {
            $table->dropColumn('nama_visible');
            $table->dropColumn('kecepatan_visible');
            $table->dropColumn('device_visible');
            $table->dropColumn('harga_visible');
            $table->dropColumn('registrasi_visible');
            $table->dropColumn('jenis_visible');
            $table->dropColumn('popular_visible');
        });
    }
};
