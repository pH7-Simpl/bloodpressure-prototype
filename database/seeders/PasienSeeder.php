<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\BloodPressureReading;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or retrieve the pasien with id = 1
        $pasien = Pasien::firstOrCreate(
            ['id' => 2],
            [
                'nama' => 'John Doe',
                'nik' => '1234567890123456',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'Laki-Laki',
                'agama' => 'Christian',
                'golongan_darah' => 'O',
                'no_handphone' => '081234567890',
                'kategori_pasien' => 'Umum',
                'no_bpjs' => '987654321',
                'alamat' => 'Jl. Example No. 1',
                'provinsi' => 'DKI Jakarta',
                'kab_kota' => 'Jakarta Selatan',
                'kecamatan' => 'Kebayoran Baru',
                'email' => 'john.doe@example.com',
            ]
        );

        // Create related BloodPressureReading entries for this pasien
        BloodPressureReading::create([
            'pasien_id' => 2,
            'date' => '2024-11-11',
            'morning_value_systole' => 120,
            'morning_value_diastole' => 80,
            'afternoon_value_systole' => 125,
            'afternoon_value_diastole' => 85,
            'night_value_systole' => 115,
            'night_value_diastole' => 75,
        ]);

        BloodPressureReading::create([
            'pasien_id' => 2,
            'date' => '2024-11-10',
            'morning_value_systole' => 123,
            'morning_value_diastole' => 81,
            'afternoon_value_systole' => 130,
            'afternoon_value_diastole' => 82,
            'night_value_systole' => 111,
            'night_value_diastole' => 60,
        ]);
    }
}
