<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise_program extends Model
{
    public $table='exercise_programs';

    public $primaryKey = 'ex_prg_id';

    public $fillable=['program_id','ex_id','reps','duration'];

    use HasFactory;
}
