<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Ibot',
            'email' => 'dokter@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'dokter',
        ]);
    
        \App\Models\User::create([
            'name' => 'Vales',
            'email' => 'kader@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'kader',
        ]);
    
        \App\Models\User::create([
            'name' => 'Yoel',
            'email' => 'pasien@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'pasien',
        ]);
    }
}
