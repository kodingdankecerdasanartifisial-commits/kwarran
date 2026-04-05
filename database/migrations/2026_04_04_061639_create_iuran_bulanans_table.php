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
        Schema::create('iuran_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('asal_pangkalan');
            $table->string('no_wa');
            $table->decimal('nominal', 15, 2);
            $table->string('bukti_setoran');
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('finance_id')->nullable()->constrained('finances')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_bulanans');
    }
};
