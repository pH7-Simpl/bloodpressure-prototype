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
    Schema::table('suggestions', function (Blueprint $table) {
        $table->string('title')->after('pasien_id'); // Adds the title column after pasien_id
    });
}

public function down()
{
    Schema::table('suggestions', function (Blueprint $table) {
        $table->dropColumn('title'); // Drops the title column if the migration is rolled back
    });
}
};
