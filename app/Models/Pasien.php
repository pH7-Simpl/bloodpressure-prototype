<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'golongan_darah', 'no_handphone', 'kategori_pasien',
        'no_bpjs', 'alamat', 'provinsi', 'kab_kota', 'kecamatan', 'email'
    ];

    // Define the relationship to the Kader model
    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // Define the relationship to BloodPressureReading
    public function bloodPressureReadings()
    {
        return $this->hasMany(BloodPressureReading::class);
    }
}

