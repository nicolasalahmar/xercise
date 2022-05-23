<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requests extends Model
{
    public $table='requests';

    public $primaryKey='request_id';

    public $fillable=['coach_id','user_id','name','time_per_day','message','objective','status','days'];

    public $timestamps=true;

    use HasFactory;
}
