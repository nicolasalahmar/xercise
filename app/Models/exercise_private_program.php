<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise_private_program extends Model
{
    public $table='exercise_private_programs';

    public $primaryKey = ['program_id','ex_id','day'];

    public $fillable=['sets','reps','duration'];

    public $incrementing = false;

    public $timestamps = false;

    use HasFactory;
}
