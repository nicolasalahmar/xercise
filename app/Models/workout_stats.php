<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workout_stats extends Model
{
    public $table = 'workout_stats';

    protected $primaryKey = 'workout_stats_id';

    protected $fillable = [
        'user_id',
        'duration',
        'Kcal',
        'dateTime',
    ];

    use HasFactory;
}
