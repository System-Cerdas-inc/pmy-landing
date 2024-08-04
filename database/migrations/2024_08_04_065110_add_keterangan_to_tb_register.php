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
            $table->text('keterangan')->nullable()->after('tanggal_pasang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_register', function (Blueprint $table) {
            $table->dropColumn(['keterangan']);
        });
    }
};
