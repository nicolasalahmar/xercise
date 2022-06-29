<?php

namespace App\Models;

use Database\Factories\workoutStatsFactory;

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
        'program_id',
        'private_program_id',
    ];

    protected static function newFactory()
    {
        return workoutStatsFactory::new();
    }

    public $timestamps = true;

    use HasFactory;
}
