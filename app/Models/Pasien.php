<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Authenticatable // Change this to extend Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'golongan_darah', 'no_handphone', 'kategori_pasien',
        'no_bpjs', 'alamat', 'provinsi', 'kab_kota', 'kecamatan', 'email'
    ];

    public function bloodPressureReadings()
    {
        return $this->hasMany(BloodPressureReading::class);
    }
}

