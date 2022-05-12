<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coach extends Model
{
    public $table='coaches';

    public $primaryKey='coach_id';

    public $fillable=['description','rating','usr_id','phone','coach_num'];

    public $timestamps = false;

    use HasFactory;
}
