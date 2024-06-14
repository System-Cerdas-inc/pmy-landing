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
        Schema::create('tb_paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('kecepatan')->nullable();
            $table->string('harga')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('jenis')->nullable();
            $table->string('popular')->nullable();
            $table->string('registrasi')->nullable();
            $table->string('device')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
