<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->middleware('auth:api')->group(function(){
    Route::post('logout','AuthController@logOut');
    Route::get('splash','AuthController@splashScreen');
});

Route::prefix('auth')->group(function(){
    Route::post('coach/sign-up','AuthController@createCoach');
    Route::post('user/sign-up','AuthController@createUser');
    Route::post('login','AuthController@logIn');

});

//Route::post('login',[AuthController::class, 'LogIn'])->name('LogIn');
