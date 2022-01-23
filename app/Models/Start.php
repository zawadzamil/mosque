<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Start extends Model
{
    use HasFactory;
    protected $fillable = [
        'schedule_id',
        'fazar',
        'dhuhr',
        'asr',
        'maghrib',
        'isha',
        'jummah',
    ];
}
