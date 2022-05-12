<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class water_tracker extends Model
{
    public $table='water_trackers';

    public $fillable=['amount','trainee_id','date'];

    use HasFactory;
}
