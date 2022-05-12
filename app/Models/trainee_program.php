<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trainee_program extends Model
{
    public $table = 'trainee_programs';

    protected $primaryKey = 'trainee_program _id';

    protected $fillable = [
        'trainee_id',
        'program_id',
        'date'
    ];

    use HasFactory;
}
