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
            $table->integer('male_members_count')->default(0)->after('active_members_count');
            $table->integer('female_members_count')->default(0)->after('male_members_count');
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
