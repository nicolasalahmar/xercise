<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sleep_tracker extends Model
{
    public $table='sleep_trackers';

    public $fillable=['hours','user_id','date'];

    use HasFactory;
}
