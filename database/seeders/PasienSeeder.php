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
            ['id' => 1],
            [
                'nama' => 'John Doe',
                'nik' => '1234567890123456',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'Male',
                'agama' => 'Christian',
                'golongan_darah' => 'O',
                'no_handphone' => '081234567890',
                'kategori_pasien' => 'General',
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
            'pasien_id' => $pasien->id,
            'date' => '2024-11-01',
            'morning_value' => 120,
            'afternoon_value' => 125,
            'night_value' => 115,
        ]);

        BloodPressureReading::create([
            'pasien_id' => $pasien->id,
            'date' => '2024-11-02',
            'morning_value' => 118,
            'afternoon_value' => 122,
            'night_value' => 116,
        ]);
    }
}
