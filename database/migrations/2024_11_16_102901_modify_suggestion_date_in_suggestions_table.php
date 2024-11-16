<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            // Change suggestion_date from dateTime to date
            $table->date('suggestion_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suggestions', function (Blueprint $table) {
            // Revert suggestion_date back to dateTime
            $table->dateTime('suggestion_date')->change();
        });
    }
};
