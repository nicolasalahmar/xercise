<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enroll extends Model
{
    public $table = 'enrolls';

    protected $primaryKey = ['user_id', 'program_id'];

    protected $fillable = [
        'done',
    ];

    public $incrementing = false;

    public $timestamps = true;

    use HasFactory;
}
