<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login' , [UserAuthController::class,'login']);

Route::group(['middleware' =>['checkPassword' ,'changeLang','auth:api'] ] ,function () {
    Route::post('users',[Controller::class,'getAllUsers']);
    Route::post('userByID',[Controller::class,'GetUserByID']);
});


