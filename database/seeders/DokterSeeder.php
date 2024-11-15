<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run()
    {
        Dokter::create([
            'nama' => 'Dr. Andi Susanto',
            'nik' => '1234567890',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1985-03-15',
            'jenis_kelamin' => 'Laki-laki',
            'agama' => 'Islam',
            'golongan_darah' => 'O',
            'no_handphone' => '081234567890',
            'alamat' => 'Jl. Kebon Jeruk No. 15, Jakarta',
            'provinsi' => 'DKI Jakarta',
            'kab_kota' => 'Jakarta Barat',
            'kecamatan' => 'Kebon Jeruk',
            'email' => 'dr.andi@example.com',
            'password' => bcrypt('pass123'),  // Example password
        ]);
    }
}

