<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class private_program extends Model
{
    use HasFactory;

    public $table='private_programs';

    public $primaryKey='private_program_id';

    public $fillable=['name','description','coach_id','user_id','duration'];

    public $timestamps=true;
}
