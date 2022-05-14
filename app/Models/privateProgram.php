<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class privateProgram extends Model
{
    use HasFactory;

    public $table='privateProgram';

    public $primaryKey='program_id';

    public $fillable=['name','description','coach_id','user_id'];

    public $timestamps=true;
}
