<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class constants extends Model
{
    //this model is for storing constant values related to the project environment
    use HasFactory;

    const image_path = 'D:/Laravel Projects/git project/Xercise/storage/app/Images/';

}
