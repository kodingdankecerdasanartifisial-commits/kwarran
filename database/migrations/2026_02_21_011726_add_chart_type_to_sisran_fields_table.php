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
        Schema::table('sisran_fields', function (Blueprint $table) {
            $table->string('chart_type')->default('bar')->after('type'); // bar, pie, doughnut, line
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sisran_fields', function (Blueprint $table) {
            $table->dropColumn('chart_type');
        });
    }
};
