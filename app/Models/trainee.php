<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trainee extends Model
{
    public $table = 'trainees';

    protected $primaryKey = 'trainee_id';

    protected $fillable = [
        'week_start',
        'times_a_week',
        'time_per_day',
        'pushups',
        'plank',
        'knee',
        'height',
        'DOB',
        'weight',
        'usr_id',
        'initial_plan',
        'active_program_id',
    ];

    public $timestamps = false;

    use HasFactory;
}
