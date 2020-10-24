<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' =>[ 'checkPassword' ,'changeLang'] ] ,function () {
    Route::post('login' , [UserAuthController::class,'login']);
});
//'auth:api'
Route::group(['middleware' =>[ 'checkPassword' ,'changeLang'] ] ,function () {
    Route::apiResource('user' , UserController::class);
});


