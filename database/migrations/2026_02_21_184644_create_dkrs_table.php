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
        Schema::create('dkrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->integer('active_members_count')->default(0);
            $table->integer('male_members_count')->default(0);
            $table->integer('female_members_count')->default(0);
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->json('social_media')->nullable();
            $table->json('routine_activities')->nullable();
            $table->json('structure')->nullable();
            $table->json('gallery')->nullable();
            $table->json('videos')->nullable();
            $table->json('achievements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dkrs');
    }
};
