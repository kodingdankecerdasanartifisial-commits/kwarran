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
        Schema::create('lpk_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpk_id')->constrained('lpks')->onDelete('cascade');
            $table->string('title');
            $table->date('date');
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpk_agendas');
    }
};
