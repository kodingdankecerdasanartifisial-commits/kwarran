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
        Schema::create('sisran_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sisran_form_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('type')->default('number'); // text, number, select
            $table->text('options')->nullable(); // JSON or CSV for select
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisran_fields');
    }
};
