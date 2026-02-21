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
        Schema::table('sidebar_widgets', function (Blueprint $table) {
            $table->string('type')->default('html')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sidebar_widgets', function (Blueprint $table) {
            $table->enum('type', ['agenda', 'popular', 'html'])->default('html')->change();
        });
    }
};
