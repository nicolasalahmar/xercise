<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reports extends Model
{
    public $table='reports';

    public $fillable=['status','message','user_id','coach_id'];

    public $timestamps=true;

    use HasFactory;
}
