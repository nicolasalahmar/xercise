<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class private_enroll extends Model
{
    public $table = 'private_enrolls';

    protected $primaryKey = 'private_enroll_id';

    protected $fillable = [
        'user_id',
        'private_program_id',
        'date',
        'done',
    ];

    use HasFactory;
}
