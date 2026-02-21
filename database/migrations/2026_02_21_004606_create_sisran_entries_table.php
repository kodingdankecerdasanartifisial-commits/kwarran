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
        Schema::create('sisran_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sisran_form_id')->constrained()->onDelete('cascade');
            $table->json('values'); // Store values as keyed JSON
            $table->string('operator_name')->nullable();
            $table->string('operator_unit')->nullable(); // Gugus depan / ranting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sisran_entries');
    }
};
