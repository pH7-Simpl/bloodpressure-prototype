<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function bloodPressureReadings()
{
    return $this->hasMany(BloodPressureReading::class);
}
    public function kader()
    {
        return $this->belongsTo(Kader::class); // Assuming you have a Kader model
    }
}