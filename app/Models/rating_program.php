<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating_program extends Model
{
    public $table='rating_programs';

    protected $primaryKey = ['user_id', 'program_id'];

    public $fillable=['rating'];

    public $timestamps = false;

    public $incrementing = false;

    use HasFactory;
}
