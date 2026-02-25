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
        Schema::create('lpks', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name')->default('Lembaga Pemeriksa Keuangan (LPK)');
            $blueprint->string('slug')->unique();
            $blueprint->string('logo')->nullable();
            $blueprint->string('hero_image')->nullable();
            $blueprint->text('vision')->nullable();
            $blueprint->text('mission')->nullable();
            $blueprint->string('whatsapp')->nullable();
            $blueprint->string('email')->nullable();
            $blueprint->text('address')->nullable();
            $blueprint->json('social_media')->nullable();
            $blueprint->json('structure')->nullable();
            $blueprint->json('videos')->nullable();
            $blueprint->text('custom_html')->nullable();
            $blueprint->boolean('is_active')->default(true);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpks');
    }
};
