<?php

namespace App\Models;

use Database\Factories\privateEnrollFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class private_enroll extends Model
{
    public $table = 'private_enrolls';

    protected $primaryKey = ['user_id', 'private_program_id'];

    protected $fillable = [
        'done',
    ];

    public $incrementing = false;

    public $timestamps = true;

    protected static function newFactory()
    {
        return privateEnrollFactory::new();
    }

    use HasFactory;
}
