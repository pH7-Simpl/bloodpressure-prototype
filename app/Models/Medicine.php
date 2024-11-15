<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id', 'pasien_id', 'medicine_name', 'dosage', 'start_date', 'end_date'
    ];

    // Define the relationship to the Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    // Define the relationship to the Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}