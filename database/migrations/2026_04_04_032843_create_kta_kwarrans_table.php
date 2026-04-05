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
        Schema::create('kta_kwarrans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('tempat_tanggal_lahir');
            $table->string('pangkalan');
            $table->string('agama');
            $table->string('golongan_darah');
            $table->string('jabatan_golongan');
            $table->string('kwarran');
            $table->string('kwarcab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kta_kwarrans');
    }
};
