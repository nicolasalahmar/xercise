<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'admins';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'FirstName',
        'LastName',
        'email',
        'username',
        'gender',
        'password',
    ];

    public $timestamps = true;
}
