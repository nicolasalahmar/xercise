<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class coach extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public $table='coaches';

    public $primaryKey='coach_id';

    public $fillable=['description','rating','phone','coach_num',
    'FirstName',
    'LastName',
    'email',
    'username',
    'gender',
    'password',
    'image',];

    public $timestamps = true;

    public function getAuthPassword()
    {
        return $this->password;
    }
}
