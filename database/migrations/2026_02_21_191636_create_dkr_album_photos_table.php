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
        Schema::create('dkr_album_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dkr_album_id')->constrained('dkr_albums')->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dkr_album_photos');
    }
};
