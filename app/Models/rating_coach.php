<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating_coach extends Model
{
    public $table='rating_coaches';

    protected $primaryKey = ['user_id', 'coach_id'];

    public $fillable=['rating'];

    public $timestamps = false;

    public $incrementing = false;

    use HasFactory;
}
