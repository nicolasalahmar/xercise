<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating_program extends Model
{
    public $table='rating_programs';

    public $fillable=['program_id','rating','trainee_id'];

    use HasFactory;
}
