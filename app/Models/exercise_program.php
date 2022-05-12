<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise_program extends Model
{
    public $table='exercise_programs';

    public $fillable=['program_id','ex_id'];

    use HasFactory;
}
