<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class step_tracker extends Model
{
    public $table='water_trackers';

    public $fillable=['steps','user_id','date'];

    use HasFactory;
}
