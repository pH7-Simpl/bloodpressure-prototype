<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id', 'pasien_id', 'suggestion_date', 'content'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
