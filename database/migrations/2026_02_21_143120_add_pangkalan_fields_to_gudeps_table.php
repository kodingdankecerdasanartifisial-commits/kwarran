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
        Schema::table('gudeps', function (Blueprint $table) {
            $table->string('pangkalan_name')->after('name')->nullable();
            $table->string('gudep_number')->after('pangkalan_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gudeps', function (Blueprint $table) {
            //
        });
    }
};
