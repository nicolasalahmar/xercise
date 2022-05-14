<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_program extends Model
{
    public $table = 'user_programs';

    protected $primaryKey = 'user_program _id';

    protected $fillable = [
        'user_id',
        'program_id',
        'date'
    ];

    use HasFactory;
}
