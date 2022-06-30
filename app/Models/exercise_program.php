<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise_program extends Model
{
    public $table='exercise_programs';

    public $primaryKey = ['program_id','ex_id'];

    public $fillable=['reps','duration','day_num'];

    public $incrementing = false;

    public $timestamps = true;

    use HasFactory;
}
