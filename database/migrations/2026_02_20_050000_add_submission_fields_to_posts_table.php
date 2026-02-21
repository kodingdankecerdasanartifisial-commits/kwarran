<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('is_published');
            $table->string('submitted_via')->nullable()->after('is_approved');
            $table->string('submitter_name')->nullable()->after('submitted_via');
            $table->string('submitter_email')->nullable()->after('submitter_name');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'submitted_via', 'submitter_name', 'submitter_email']);
        });
    }
};
