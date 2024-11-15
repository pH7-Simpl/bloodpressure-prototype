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
    Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nik')->unique();
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('agama');
        $table->string('golongan_darah');
        $table->string('no_handphone');
        $table->enum('kategori_pasien', ['Umum', 'BPJS']);
        $table->string('no_bpjs')->nullable();
        $table->text('alamat');
        $table->string('provinsi');
        $table->string('kab_kota');
        $table->string('kecamatan');
        $table->string('email')->unique();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
