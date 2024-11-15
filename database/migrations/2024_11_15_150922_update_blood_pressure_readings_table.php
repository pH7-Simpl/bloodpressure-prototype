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
        Schema::table('blood_pressure_readings', function (Blueprint $table) {
            // Add separate systole and diastole columns for morning, afternoon, and night
            $table->integer('morning_value_systole')->nullable();
            $table->integer('morning_value_diastole')->nullable();
            $table->integer('afternoon_value_systole')->nullable();
            $table->integer('afternoon_value_diastole')->nullable();
            $table->integer('night_value_systole')->nullable();
            $table->integer('night_value_diastole')->nullable();

            // Optionally drop old columns if they are no longer needed
            $table->dropColumn(['morning_value', 'afternoon_value', 'night_value']);
        });
    }

    public function down()
    {
        Schema::table('blood_pressure_readings', function (Blueprint $table) {
            // Rollback changes
            $table->dropColumn([
                'morning_value_systole',
                'morning_value_diastole',
                'afternoon_value_systole',
                'afternoon_value_diastole',
                'night_value_systole',
                'night_value_diastole',
            ]);

            // Optionally re-add old columns
            $table->integer('morning_value')->nullable();
            $table->integer('afternoon_value')->nullable();
            $table->integer('night_value')->nullable();
        });
    }
};
