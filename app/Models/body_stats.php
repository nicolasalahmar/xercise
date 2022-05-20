<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class body_stats extends Model
{
    public $table = 'body_stats';

    protected $primaryKey = 'body_stats_id';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'dateTime',
    ];

    use HasFactory;
}
