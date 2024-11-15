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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokters'); // The doctor who prescribes the medicine
            $table->foreignId('pasien_id')->constrained('pasiens'); // The patient to whom the medicine is prescribed
            $table->string('medicine_name'); // Name of the medicine
            $table->string('dosage'); // Dosage instructions
            $table->date('start_date'); // When the medicine is prescribed to start
            $table->date('end_date')->nullable(); // When the medicine is prescribed to end
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
