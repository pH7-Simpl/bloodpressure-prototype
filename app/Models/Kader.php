<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kader extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'golongan_darah', 'no_handphone', 'alamat', 'provinsi',
        'kab_kota', 'kecamatan', 'email', 'password'
    ];

    // Define the relationship to the Pasien model
    public function pasiens()
    {
        return $this->hasMany(Pasien::class);
    }
}
