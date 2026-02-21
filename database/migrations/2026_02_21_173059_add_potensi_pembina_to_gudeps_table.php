<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gudeps', function (Blueprint $table) {
            $table->json('potensi_pembina')->nullable()->after('potensi');
        });
    }

    public function down(): void
    {
        Schema::table('gudeps', function (Blueprint $table) {
            $table->dropColumn('potensi_pembina');
        });
    }
};
