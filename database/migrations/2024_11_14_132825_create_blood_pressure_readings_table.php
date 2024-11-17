<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('blood_pressure_readings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pasien_id')->constrained('pasiens');
        $table->date('date');
        $table->integer('morning_value_systole')->nullable();
        $table->integer('morning_value_diastole')->nullable();
        $table->integer('afternoon_value_systole')->nullable();
        $table->integer('afternoon_value_diastole')->nullable();
        $table->integer('night_value_systole')->nullable();
        $table->integer('night_value_diastole')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_pressure_readings');
    }
};
