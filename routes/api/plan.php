<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\planController;
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
    Route::get('viewuserplans','planController@viewUserPlans');
    Route::get('returnactiveplan','planController@viewActivePlan');
    Route::post('activateplan','planController@activatePlan');
    Route::post('resetplanprogress','planController@resetPlanProgress');
    Route::post('deleteuserplan','planController@deletePlan');
    Route::get('viewcustomplans','planController@viewCustomPlans');
    Route::get('viewactiveplan', 'planController@viewActivePlan');
    Route::post('viewcurrentworkout','planController@currentWorkoutDetails');
    Route::post('saveworkoutstats','planController@saveWorkoutStats');
    Route::post('createcustomplan','planController@createCustomPlan');


    

    

});
