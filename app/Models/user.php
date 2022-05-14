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
        'email',
        'username',
        'gender',
        'password',
        'image',
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

    public $timestamps = true;
}
