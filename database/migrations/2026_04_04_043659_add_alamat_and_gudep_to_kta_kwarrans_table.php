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
        Schema::table('kta_kwarrans', function (Blueprint $table) {
            $table->text('alamat_lengkap')->nullable()->after('pas_foto');
            $table->string('nomor_gudep')->nullable()->after('pangkalan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kta_kwarrans', function (Blueprint $table) {
            $table->dropColumn(['alamat_lengkap', 'nomor_gudep']);
        });
    }
};
