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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokters'); // Dokter who gives the suggestion
            $table->foreignId('pasien_id')->constrained('pasiens'); // Pasien who the suggestion is for
            $table->string('title');
            $table->date('suggestion_date');
            $table->text('content'); // The content of the suggestion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
