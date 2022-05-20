<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class user extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'FirstName',
        'LastName',
        'username',
        'email',
        'password',
        'gender',
        'image',
        'DOB',
        'week_start',
        'times_a_week',
        'time_per_day',
        'initial_plan',
        'pushups',
        'plank',
        'knee',
        'height',
        'weight',
        'active_program_id',
        'steps',
        'step_update'
    ];

    protected $hidden = ['password'];

    public $timestamps = true;
}
