<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enroll extends Model
{
    public $table = 'enrolls';

    protected $primaryKey = 'enroll_id';

    protected $fillable = [
        'user_id',
        'program_id',
        'date',
        'done',
    ];

    use HasFactory;
}
