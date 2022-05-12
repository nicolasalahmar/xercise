<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating_coach extends Model
{
    public $table='rating_coaches';

    public $fillable=['trainee_id','rating','coach_id'];

    use HasFactory;
}
