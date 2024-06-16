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
        Schema::create('tb_postingan', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->longText('keterangan')->nullable();
            $table->longText('link_video')->nullable();
            $table->longText('jenis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_postingan');
    }
};
