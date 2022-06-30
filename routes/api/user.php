<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\AuthController;
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

Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    Route::get('showprofile','userController@showUserProfile');
    Route::get('deleteaccount','userController@deleteUserAccount');
    Route::post('editprofile','userController@editUserProfile');
    Route::post('ratecoach/{coach_id}','userController@rateCoach');
    Route::get('viewuserdashboard','userController@viewUserDashboard');
    Route::get('viewcoachdashboard','userController@viewCoachDashboard');
    Route::post('enroll','userController@enroll');
    Route::get('resetallprogress','userController@resetAllProgress');
    Route::post('calculatesteps', 'userController@calculateSteps');
    Route::post('resetsteps', 'userController@resetSteps');
    Route::get('viewsteps', 'userController@viewSteps');
});
