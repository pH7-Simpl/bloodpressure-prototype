<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'golongan_darah', 'no_handphone', 'alamat', 'provinsi',
        'kab_kota', 'kecamatan', 'email', 'password'
    ];
}
