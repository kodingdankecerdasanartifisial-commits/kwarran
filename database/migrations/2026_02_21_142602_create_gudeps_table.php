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
        Schema::create('gudeps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->integer('active_members_count')->default(0);
            $table->json('social_media')->nullable(); // facebook, instagram, youtube, tiktok, x
            $table->json('routine_activities')->nullable(); // title, day, time, description
            $table->json('structure')->nullable(); // name, position, photo
            $table->json('gallery')->nullable(); // image_path, caption
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudeps');
    }
};
