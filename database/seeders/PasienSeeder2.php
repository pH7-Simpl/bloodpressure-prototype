<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PasienSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Set locale to Indonesia

        for ($i = 0; $i < 300; $i++) {
            Pasien::create([
                'nama' => $faker->name,
                'nik' => $faker->nik(), // Custom NIK generation
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O']),
                'no_handphone' => $faker->phoneNumber,
                'kategori_pasien' => $faker->randomElement(['Umum', 'BPJS']),
                'no_bpjs' => $faker->optional()->numerify('##########'), // 10-digit BPJS number
                'alamat' => $faker->address,
                'provinsi' => $faker->state,
                'kab_kota' => $faker->city,
                'kecamatan' => $faker->citySuffix,
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
