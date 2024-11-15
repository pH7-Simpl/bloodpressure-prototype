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
    Schema::table('pasiens', function (Blueprint $table) {
        // If kader_id should be nullable
        $table->foreignId('kader_id')->nullable()->constrained()->onDelete('cascade');
    });
}

    
    public function down()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['kader_id']);
        });
    }
};
