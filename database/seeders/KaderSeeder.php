<?php

namespace Database\Seeders;

use App\Models\Kader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaderSeeder extends Seeder
{
    public function run()
    {
        Kader::create([
            'nama' => 'Kader Aulia',
            'nik' => '0987654321',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-07-20',
            'jenis_kelamin' => 'Perempuan',
            'agama' => 'Kristen',
            'golongan_darah' => 'A',
            'no_handphone' => '082345678901',
            'alamat' => 'Jl. Merdeka No. 30, Bandung',
            'provinsi' => 'Jawa Barat',
            'kab_kota' => 'Bandung',
            'kecamatan' => 'Sumur Bandung',
            'email' => 'kader.aulia@example.com',
            'password' => Hash::make('password123'),  // Example password
        ]);
    }
}

