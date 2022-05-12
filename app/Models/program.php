<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    public $table='programs';

    public $primaryKey='program_id';

    public $fillable=['name','description','rating','coach_id'];

    public $timestamps=true;

    use HasFactory;
}
