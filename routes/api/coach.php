<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\coachController;
use App\Http\Controllers\userController;
use App\Http\Controllers\requestController;
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

Route::group( ['prefix' => 'coach','middleware' => ['auth:coach-api','scopes:coach'] ],function(){

    Route::get('showprofile','coachController@showCoachProfile');
    Route::get('deleteaccount','coachController@deleteCoachAccount');
    Route::post('editprofile','coachController@editCoachProfile');
    Route::get('viewuserdashboard','coachController@viewUserDashboard');
    Route::get('viewcoachdashboard','coachController@viewCoachDashboard');
    Route::post('deletecoachplan','coachController@deletePlan');
    Route::get('viewcoachplans','coachController@viewPlans');
});
