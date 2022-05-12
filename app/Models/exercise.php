<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercise extends Model
{
    public $table = 'exercises';

    protected $primaryKey = 'ex_id';

    protected $fillable = [
        'name',
        'knee'
    ];

    use HasFactory;
}
