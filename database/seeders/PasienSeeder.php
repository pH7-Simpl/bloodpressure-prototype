<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        Pasien::create([
            'nama' => 'Pasien Budi',
            'nik' => '1122334455',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1980-11-12',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Buddha',
            'golongan_darah' => 'B',
            'no_handphone' => '083456789012',
            'alamat' => 'Jl. Raya No. 20, Surabaya',
            'provinsi' => 'Jawa Timur',
            'kab_kota' => 'Surabaya',
            'kecamatan' => 'Tegalsari',
            'email' => 'budi.pasien@example.com',
        ]);
    }
}

