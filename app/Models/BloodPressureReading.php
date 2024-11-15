<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodPressureReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id', 'date', 'morning_value_systole', 'morning_value_diastole', 'afternoon_value_systole', 'afternoon_value_diastole', 'night_value_systole', 'night_value_diastole'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
