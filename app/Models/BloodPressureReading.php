<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodPressureReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id', 'date', 'morning_value', 'afternoon_value', 'night_value'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
