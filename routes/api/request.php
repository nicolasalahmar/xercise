<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\coachController;
use App\Http\Controllers\requestController;
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
    Route::get('viewrequest','requestController@viewRequestUser');
    Route::get('showcurrentrequests','requestController@showCurrentRequestsUser');
    Route::get('deleterequest','requestController@deleteRequest');
    Route::post('createrequest', 'requestController@requestPlan');
});


Route::group( ['prefix' => 'coach','middleware' => ['auth:coach-api','scopes:coach'] ],function(){
    Route::get('viewrequest','requestController@viewRequestCoach');
    Route::get('showcurrentrequests','requestController@showCurrentRequestsCoach');
    Route::get('declinerequest','requestController@declineRequest');
});
