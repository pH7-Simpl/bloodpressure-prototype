<?php

// database/seeders/PatientsTableSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        // Add sample patients
        Patient::create([
            'nama' => 'John Doe',
            'kader_id' => 1, // You can adjust this to the appropriate kader_id
        ]);
    }
}