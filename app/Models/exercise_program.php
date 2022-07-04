<?php

namespace App\Models;

use Database\Factories\exerciseProgramFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise_program extends Model
{
    public $table='exercise_programs';

    public $primaryKey = ['program_id','ex_id','day'];

    public $fillable=['sets','reps','duration'];

    public $incrementing = false;

    public $timestamps = false;

    protected static function newFactory()
    {
        return exerciseProgramFactory::new();
    }

    use HasFactory;
}
